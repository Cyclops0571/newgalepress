<?php

namespace App\Http\Controllers;

use App\Library\MyResponse;
use App\Library\UploadHandler;
use App\Models\Application;
use App\Models\GoogleMap;
use Auth;
use Common;
use DB;
use eStatus;
use eUserTypes;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Readers\LaravelExcelReader;
use URL;
use Validator;

class MapController extends Controller
{


    public $restful = true;
    public $table = 'GoogleMap';
    public $pk = 'GoogleMapID';
    public $page = 'maps';
    public $route = '';
    public $fields = '';
    public $caption = '';


    private function init() {
        $this->route = __('route.' . $this->page);
        $this->caption = __('common.maps_caption');
        $this->detailCaption = __('common.maps_caption_detail');
        $this->fields = array();
        $this->fields[] = array(__('common.maps_list_name'), 'Name');
        $this->fields[] = array(__('common.maps_list_address'), 'Address');
        $this->fields[] = array(__('common.maps_list_description'), 'Description');
        $this->fields[] = array(__('common.maps_list_latitude'), 'Latitude');
        $this->fields[] = array(__('common.maps_list_longitude'), 'Longitude');
        $this->fields[] = array(__('common.maps_list_google_map_id'), 'GoogleMapID');
        if (Auth::user() && (int)Auth::user()->UserTypeID == eUserTypes::Manager) {
            $this->fields = array();
            $this->fields[] = array(__('common.maps_list_customer'), 'CustomerName');
            $this->fields[] = array(__('common.maps_list_application'), 'ApplicationName');
            $this->fields[] = array(__('common.maps_list_name'), 'Name');
            $this->fields[] = array(__('common.maps_list_latitude'), 'Latitude');
            $this->fields[] = array(__('common.maps_list_longitude'), 'Longitude');
            $this->fields[] = array(__('common.maps_list_google_map_id'), 'GoogleMapID');
        }
    }

    public function index(Request $request)
    {
        $this->init();
        $search = trim($request->get('search', ''));
        $applicationID = $request->get("applicationID", 0);
        $sort = $request->get('sort', $this->pk);
        $sort_dir = $request->get('sort_dir', 'DESC');
        if (!Common::CheckApplicationOwnership($applicationID)) {
            return redirect()->route('home');
        }

        $markerSetQuery = DB::table('GoogleMap')
            ->where('StatusID', '=', eStatus::Active);
        if (!empty($search)) {
            $markerSetQuery->where(function (Builder $query) use ($search) {
                $searchWord = '%' . $search . '%';
                $query->where('Name', 'LIKE', $searchWord);
                $query->orWhere('Address', 'LIKE', $searchWord);
                $query->orWhere('Description', 'LIKE', $searchWord);
            });
        }
        if (Auth::user()->UserTypeID != eUserTypes::Manager) {
            $markerSetQuery->where('ApplicationID', '=', $applicationID);
        } else {
            $markerSetQuery->join('Application as a', function (JoinClause $join) {
                $join->on('a.ApplicationID', '=', 'GoogleMap.ApplicationID');
                $join->on('a.StatusID', '=', eStatus::Active);
            });

            $markerSetQuery->join('Customer AS c', function (JoinClause $join) {
                $join->on('a.CustomerID', '=', 'c.CustomerID');
                $join->on('c.StatusID', '=', eStatus::Active);
            });
        }

        $rows = $markerSetQuery->orderBy($sort, $sort_dir)->paginate(config('custom.rowcount'));

        $data = array();
        $data['route'] = $this->route;
        $data['caption'] = $this->caption;
        $data['pk'] = $this->pk;
        $data['search'] = $search;
        $data['sort'] = $sort;
        $data['sort_dir'] = $sort_dir;
        $data['page'] = $this->page;
        $data['fields'] = $this->fields;
        $data['applicationID'] = $applicationID;
        $data['rows'] = $rows;
        $data['sampleXmlUrl'] = GoogleMap::getSampleXmlUrl();
        return view("pages.googlemaplist", $data);
    }

    public function show($id)
    {
        $googleMap = GoogleMap::find($id);
        if (!$googleMap) {
            return redirect()->route('maps_list');
        }

        $data = array();
        $applicationID = $googleMap->ApplicationID;
        $application = Application::find($applicationID);
        $initialLocation = $application->initialLocation();
        $data["applicationID"] = $application;
        $data["googleMap"] = $googleMap;
        $data['route'] = $this->route = __('route.' . $this->page) . '?applicationID=' . $googleMap->ApplicationID;
        $data['caption'] = $this->caption;
        $data["initialLocation"] = $initialLocation;
        return view("pages.googlemapdetail", $data);
    }

    public function create(Request $request)
    {
        $applicationID = $request->get('applicationID', '0');
        $application = Application::find($applicationID);
        $initialLocation = $application->initialLocation();
        $data = array();
        $data["ApplicationID"] = $applicationID;
        $data["googleMap"] = FALSE;
        $data['route'] = $this->route = __('route.' . $this->page) . '?applicationID=' . $data["ApplicationID"];
        $data['caption'] = $this->caption;
        $data['detailCaption'] = $this->detailCaption;
        $data["initialLocation"] = $initialLocation;
        return view('pages.googlemapdetail', $data);
    }

    public function save(Request $request, MyResponse $myResponse)
    {
        $applicationID = $request->get('applicationID', '0');
        $GoogleMapID = $request->get($this->pk, '0');
        $name = $request->get('name', '');
        $address = $request->get('address', '');
        $description = $request->get('description', '');
        $latitude = $request->get('latitude', '');
        $longitude = $request->get('longitude', '');
        $chk = Common::CheckApplicationOwnership($applicationID);
        $rules = array(
            'applicationID' => 'required|integer|min:1',
            'latitude' => 'required',
            'longitude' => 'required',
            'name' => 'required'
        );
        $v = Validator::make($request->all(), $rules);
        if (!$v->passes()) {
            return $myResponse->error(__('common.detailpage_incorrect_input'));
        }
        if (!$chk) {
            return $myResponse->error(__('common.detailpage_validation'));
        }

        if ($GoogleMapID == 0) {
            $googleMap = new GoogleMap();
            $googleMap->ApplicationID = $applicationID; //after first create appID can not be changed;
        } else {
            $googleMap = GoogleMap::find($GoogleMapID);
            if (!$googleMap->CheckOwnership($applicationID)) {
                throw new Exception("Unauthorized user attempt");
            }
        }

        $googleMap->Name = $name;
        $googleMap->Address = $address;
        $googleMap->Description = $description;
        $googleMap->Latitude = $latitude;
        $googleMap->Longitude = $longitude;
        $googleMap->StatusID = eStatus::Active;
        $googleMap->save();
        return $myResponse->success();
    }


    public function webView(Application $application)
    {
        $data = array();
        $data["googleMapSet"] = $application->GoogleMap;
        $data["initialLocation"] = $application->initialLocation();
        return view("pages.googlemapwebview", $data);
    }

    public function excelupload(Request $request, Application $application)
    {
        if(!$application->checkUserAccess()) {
            throw new Exception(__('error.unauthorized_user_attempt'));
        }
        ob_start();
        $element = $request->get('element');
        $options = array(
            'upload_dir' => public_path('files/temp/'),
            'upload_url' => URL::to('/files/temp/'),
            'param_name' => $element,
            'accept_file_types' => '/\.(xls)$/i'
        );
        $upload_handler = new UploadHandler($options);

        $upload_handler->post(false);

        $ob = ob_get_contents();
        ob_end_clean();
        $object = json_decode($ob);
        $json = get_object_vars($object);
        $arr = $json[$element];
        $obj = $arr[0];
        $obj->status = 'Failed';
        $filePath = public_path('files/temp/' . $object->File[0]->name);
        $excelColumnNames = ['name', 'latitude', 'longitude', 'address', 'description'];
        \Excel::load($filePath, function(LaravelExcelReader $reader) use ($obj, $excelColumnNames, $application)
        {
            $invalidExcelRows = [];
            $addedCount = 0;
            $updatedCount = 0;
            $excelRows = $reader->setSelectedSheetIndices([0])->all();
            if ($excelRows->count() == 0)
            {
                $obj->responseMsg = __("error.invalid_excel_file");
            }
            $rowNo = -1;
            foreach ($excelRows as $excelRow)
            {
                ++$rowNo;
                if ($excelRow->count() != 5)
                {
                    $obj->responseMsg = __("error.invalid_excel_file");
                }

                $tmp = [];
                $i = 0;
                foreach ($excelRow as $cellName => $cellValue)
                {
                    $columnName = $excelColumnNames[$i++];
                    $tmp[$columnName] = $cellValue;

                }

                if (!$tmp['name'] || !$tmp['latitude'] || !$tmp['longitude'])
                {
                    $invalidExcelRows[] = $rowNo;
                }

                $googleMap = GoogleMap::where('ApplicationID', '=', $application->ApplicationID)
                    ->where('Latitude', '=', $tmp['latitude'])
                    ->where("Longitude", "=", $tmp['longitude'])
                    ->first();
                if (!$googleMap)
                {
                    $googleMap = new GoogleMap();
                    $addedCount++;
                } else
                {
                    $updatedCount++;
                }

                $googleMap->Name = $tmp['name'];
                $googleMap->ApplicationID = $application->ApplicationID;
                $googleMap->Latitude = $tmp['latitude'];
                $googleMap->Longitude = $tmp['longitude'];
                $googleMap->Address = $tmp['address'];
                $googleMap->Description = $tmp['description'];
                $googleMap->StatusID = eStatus::Active;
                $googleMap->save();
            }

            $responseMsg = __('maplang.inserted_location_count') . $addedCount . " " . __('maplang.updated_location_count') . $updatedCount;
            if(!empty($invalidExcelRows)) {
                $responseMsg .= " " . trans('error.invalid_excel_row', ['rows' => implode(', ', $invalidExcelRows)]);
            }
            $obj->status = 'success';
            $obj->responseMsg = $responseMsg;
        });
        return response()->json($obj);
    }

    public function delete(Request $request, MyResponse $myResponse)
    {
        $googleMap = GoogleMap::find((int)$request->get('id'));
        if (!$googleMap) {
            return $myResponse->error(__('common.detailpage_validation'));
        }
        $application = Application::find($googleMap->ApplicationID);
        if (!$application || !$application->CheckOwnership()) {
            return $myResponse->error(__('common.detailpage_validation'));
        }

        $googleMap->StatusID = eStatus::Deleted;
        $googleMap->save();
        return $myResponse->success();
    }

}
