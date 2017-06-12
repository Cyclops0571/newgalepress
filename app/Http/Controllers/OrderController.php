<?php

namespace App\Http\Controllers;

use App\Library\MyResponse;
use App\Library\Uploader;
use App\Library\UploadHandler;
use App\Mail\ApplicationFormRequestMailler;
use App\Mail\ApplicationRequestMailler;
use App\Models\Order;
use DateTime;
use eProcessTypes;
use eStatus;
use File;
use Illuminate\Http\Request;
use Redirect;
use URL;
use Validator;
use View;

class OrderController extends Controller {


    public $restful = true;
    public $page = '';
    public $route = '';
    public $table = '';
    public $pk = '';
    public $caption = '';
    public $detailcaption = '';
    public $fields;

    public function __construct()
    {
        $this->page = 'orders';
        $this->route = __('route.' . $this->page);
        $this->table = 'Order';
        $this->pk = 'OrderID';
        $this->caption = __('common.orders_caption');
        $this->detailcaption = __('common.orders_caption_detail');
        $this->fields = [
            0 => ['55px', __('common.orders_list_column1'), 'OrderNo'],
            1 => ['', __('common.orders_list_column2'), 'Name'],
            2 => ['150px', __('common.orders_list_column3'), 'Website'],
            3 => ['150px', __('common.orders_list_column4'), 'Email'],
            4 => ['75px', __('common.orders_list_column5'), 'OrderID'],
        ];
    }

    public function index(Request $request)
    {

        $applicationID = (int)$request->get('applicationID', 0);
        $search = $request->get('search', '');
        $sort = $request->get('sort', $this->pk);
        $sort_dir = $request->get('sort_dir', 'DESC');

        $data = [
            'page'     => $this->page,
            'route'    => $this->route,
            'caption'  => $this->caption,
            'pk'       => $this->pk,
            'fields'   => $this->fields,
            'search'   => $search,
            'sort'     => $sort,
            'sort_dir' => $sort_dir,
            'rows'     => Order::orderList($applicationID, $search, $sort, $sort_dir),
        ];

        return View::make('pages.orderlist', $data);

    }

    public function appForm()
    {
        $lastorderno = Order::orderBy('OrderID', 'DESC')->first();

        return View::make('pages.applicationformcreate')->with('lastorderno', $lastorderno);
    }

    public function create()
    {

        $data = [
            'page'          => $this->page,
            'route'         => $this->route,
            'caption'       => $this->caption,
            'detailcaption' => $this->detailcaption,
        ];

        return View::make('pages.orderdetail', $data);

    }

    public function show(Order $order)
    {

        $data = [
            'page'          => $this->page,
            'route'         => $this->route,
            'caption'       => $this->caption,
            'detailcaption' => $this->detailcaption,
            'row'           => $order,
        ];

        return View::make('pages.orderdetail', $data);

    }

    public function save(Request $request, MyResponse $myResponse)
    {
        $userID = 0;
        $currentUser = \Auth::user();

        if ($currentUser !== null)
        {
            $userID = (int)$currentUser->UserID;
        }

        $id = (int)$request->get($this->pk, '0');

        if ($userID == 0)
        {
            $id = 0;
        }
        // Description alanında javascript ile alınan text uzunluğu ile sunucudan okunan text uzunluğu aynı olmadığı için aşağıdaki kontoller yapılmıştır.
        //Javascript 4000 karaktere olumlu cevap döndürürken sunucu daha fazla karakter okuduğu için formu post etmiyordu. \n\r sebebiyle iki karakter fazla çıkartıyordu.
        $tempDescription = $request->get('Description');
        if (mb_strlen(str_replace(["\n", "\r"], "", $tempDescription), 'utf8') < 4000)
        {
            $rules = [
                'OrderNo'               => 'required',
                'Name'                  => 'required|max:14',
                'Description'           => 'required',
                'Keywords'              => 'required|max:100',
                'hdnPdfName'            => 'required',
                'hdnImage1024x1024Name' => 'required',
            ];
            $v = Validator::make($request->all(), $rules);
        } else
        {
            return $myResponse->error(trans('common.orders_warning_maxdesc'));
        }
        $Description = $request->get('Description');
        $Description = preg_replace('/(?:(?:\r\n|\r|\n)\s*){2}/s', "\n\n", $Description);

        $appName = $request->get('Name');

        if ($v->fails())
        {
            return $myResponse->error(trans('common.detailpage_validation'));
        }

        $orderNo = $request->get('OrderNo');
        $lastorderno = Order::orderBy('OrderID', 'DESC')->first();
        if ($orderNo == $lastorderno->OrderNo)
        {
            $orderNo = 'm000' . ($lastorderno->OrderID + 1);
        }
        //hdnPdfName
        $sourcePdfFileName = $request->get('hdnPdfName');
        $sourcePdfRealPath = public_path('files/temp');
        $sourcePdfFileNameFull = $sourcePdfRealPath . '/' . $sourcePdfFileName;

        //hdnImage1024x1024Name
        $sourceImage1024x1024FileName = $request->get('hdnImage1024x1024Name');
        $sourceImage1024x1024RealPath = public_path('files/temp');
        $sourceImage1024x1024FileNameFull = $sourceImage1024x1024RealPath . '/' . $sourceImage1024x1024FileName;

        //hdnImage640x960Name
        $sourceImage640x960FileName = $request->get('hdnImage640x960Name');
        $sourceImage640x960RealPath = public_path('files/temp');
        $sourceImage640x960FileNameFull = $sourceImage640x960RealPath . '/' . $sourceImage640x960FileName;

        //hdnImage640x1136Name
        $sourceImage640x1136FileName = $request->get('hdnImage640x1136Name');
        $sourceImage640x1136RealPath = public_path('files/temp');
        $sourceImage640x1136FileNameFull = $sourceImage640x1136RealPath . '/' . $sourceImage640x1136FileName;

        //hdnImage1536x2048Name
        $sourceImage1536x2048FileName = $request->get('hdnImage1536x2048Name');
        $sourceImage1536x2048RealPath = public_path('files/temp');
        $sourceImage1536x2048FileNameFull = $sourceImage1536x2048RealPath . '/' . $sourceImage1536x2048FileName;

        //hdnImage2048x1536Name
        $sourceImage2048x1536FileName = $request->get('hdnImage2048x1536Name');
        $sourceImage2048x1536RealPath = public_path('files/temp');
        $sourceImage2048x1536FileNameFull = $sourceImage2048x1536RealPath . '/' . $sourceImage2048x1536FileName;

        if ($id == 0)
        {
            $s = new Order();
        } else
        {
            $s = Order::find($id);
        }

        $s->ApplicationID = (int)$request->get('ApplicationID');
        $s->OrderNo = $orderNo;
        $s->Name = $request->get('Name');
        $s->Description = $Description;
        $s->Keywords = $request->get('Keywords');
        $s->Product = $request->get('Product', '');
        $s->Qty = (int)$request->get('Qty', '0');
        $s->Website = $request->get('Website', '');
        $s->Email = $request->get('Email', '');
        $s->Facebook = $request->get('Facebook', '');
        $s->Twitter = $request->get('Twitter', '');

        //hdnPdfName
        if ((int)$request->get('hdnPdfSelected', 0) == 1 && File::exists($sourcePdfFileNameFull))
        {
            $targetPdfFileName = 'file.pdf';
            $targetPdfRealPath = public_path('files/orders/order_' . $orderNo);
            $targetPdfFileNameFull = $targetPdfRealPath . '/' . $targetPdfFileName;

            if (!File::exists($targetPdfRealPath))
            {
                File::makeDirectory($targetPdfRealPath);
            }

            File::move($sourcePdfFileNameFull, $targetPdfFileNameFull);

            $s->Pdf = $targetPdfFileName;
        }

        //hdnImage1024x1024Name
        if ((int)$request->get('hdnImage1024x1024Selected', 0) == 1 && File::exists($sourceImage1024x1024FileNameFull))
        {
            $targetImage1024x1024FileName = '1024x1024.png';
            $targetImage1024x1024RealPath = public_path('files/orders/order_' . $orderNo);
            $targetImage1024x1024FileNameFull = $targetImage1024x1024RealPath . '/' . $targetImage1024x1024FileName;

            if (!File::exists($targetImage1024x1024RealPath))
            {
                File::makeDirectory($targetImage1024x1024RealPath);
            }

            File::move($sourceImage1024x1024FileNameFull, $targetImage1024x1024FileNameFull);

            $s->Image1024x1024 = $targetImage1024x1024FileName;
        }

        //hdnImage640x960Name
        if ((int)$request->get('hdnImage640x960Selected', 0) == 1 && File::exists($sourceImage640x960FileNameFull))
        {
            $targetImage640x960FileName = '640x960.png';
            $targetImage640x960RealPath = public_path('files/orders/order_' . $orderNo);
            $targetImage640x960FileNameFull = $targetImage640x960RealPath . '/' . $targetImage640x960FileName;

            if (!File::exists($targetImage640x960RealPath))
            {
                File::makeDirectory($targetImage640x960RealPath);
            }

            File::move($sourceImage640x960FileNameFull, $targetImage640x960FileNameFull);

            $s->Image640x960 = $targetImage640x960FileName;
        }

        //hdnImage640x1136Name
        if ((int)$request->get('hdnImage640x1136Selected', 0) == 1 && File::exists($sourceImage640x1136FileNameFull))
        {
            $targetImage640x1136FileName = '640x1136.png';
            $targetImage640x1136RealPath = public_path('files/orders/order_' . $orderNo);
            $targetImage640x1136FileNameFull = $targetImage640x1136RealPath . '/' . $targetImage640x1136FileName;

            if (!File::exists($targetImage640x1136RealPath))
            {
                File::makeDirectory($targetImage640x1136RealPath);
            }

            File::move($sourceImage640x1136FileNameFull, $targetImage640x1136FileNameFull);

            $s->Image640x1136 = $targetImage640x1136FileName;
        }

        //hdnImage1536x2048Name
        if ((int)$request->get('hdnImage1536x2048Selected', 0) == 1 && File::exists($sourceImage1536x2048FileNameFull))
        {
            $targetImage1536x2048FileName = '1536x2048.png';
            $targetImage1536x2048RealPath = public_path('files/orders/order_' . $orderNo);
            $targetImage1536x2048FileNameFull = $targetImage1536x2048RealPath . '/' . $targetImage1536x2048FileName;

            if (!File::exists($targetImage1536x2048RealPath))
            {
                File::makeDirectory($targetImage1536x2048RealPath);
            }

            File::move($sourceImage1536x2048FileNameFull, $targetImage1536x2048FileNameFull);

            $s->Image1536x2048 = $targetImage1536x2048FileName;
        }

        //hdnImage2048x1536Name
        if ((int)$request->get('hdnImage2048x1536Selected', 0) == 1 && File::exists($sourceImage2048x1536FileNameFull))
        {
            $targetImage2048x1536FileName = '2048x1536.png';
            $targetImage2048x1536RealPath = public_path('files/orders/order_' . $orderNo);
            $targetImage2048x1536FileNameFull = $targetImage2048x1536RealPath . '/' . $targetImage2048x1536FileName;

            if (!File::exists($targetImage2048x1536RealPath))
            {
                File::makeDirectory($targetImage2048x1536RealPath);
            }

            File::move($sourceImage2048x1536FileNameFull, $targetImage2048x1536FileNameFull);

            $s->Image2048x1536 = $targetImage2048x1536FileName;
        }

        if ($id == 0)
        {
            $s->StatusID = eStatus::Active;
            $s->CreatorUserID = $userID;
            $s->DateCreated = new DateTime();
        }
        $s->ProcessUserID = $userID;
        $s->ProcessDate = new DateTime();
        if ($id == 0)
        {
            $s->ProcessTypeID = eProcessTypes::Insert;
        } else
        {
            $s->ProcessTypeID = eProcessTypes::Update;
        }
        $s->save();

        \Mail::queue(new ApplicationFormRequestMailler($appName, $orderNo));

        return $myResponse->success();

    }

    public function delete(Request $request, MyResponse $myResponse)
    {

        $id = (int)$request->get($this->pk, '0');

        $s = Order::find($id);
        if ($s)
        {
            $s->StatusID = eStatus::Deleted;
            $s->ProcessUserID = \Auth::user()->UserID;
            $s->ProcessDate = new DateTime();
            $s->ProcessTypeID = eProcessTypes::Update;
            $s->save();
        }

        return $myResponse->success();

    }

    public function uploadfile(Request $request, MyResponse $myResponse)
    {
        ob_start();

        $type = $request->get('type');
        $element = $request->get('element');

        $options = [];
        if ($type == 'uploadpdf')
        {
            $options = [
                'upload_dir'        => public_path('files/temp/'),
                'upload_url'        => URL::to('/files/temp/'),
                'param_name'        => $element,
                'accept_file_types' => '/\.(pdf)$/i',
            ];
        } else if ($type == 'uploadpng1024x1024' || $type == 'uploadpng640x960' || $type == 'uploadpng640x1136' || $type == 'uploadpng1536x2048' || $type == 'uploadpng2048x1536')
        {
            $options = [
                'upload_dir'        => public_path('files/temp/'),
                'upload_url'        => URL::to('/files/temp/'),
                'param_name'        => $element,
                'accept_file_types' => '/\.(gif|jpe?g|png|tiff)$/i',
            ];
        }

        $upload_handler = new UploadHandler($options);

        if (!$request->ajax())
        {
            return $myResponse->error(trans('error.unauthorized_user_attempt'));
        }

        $upload_handler->post(false);
        $ob = ob_get_contents();
        ob_end_clean();
        $json = get_object_vars(json_decode($ob));
        $arr = $json[$element];
        $obj = $arr[0];
        $tempFile = $obj->name;
        //var_dump($obj->name);

        Uploader::OrdersUploadFile($tempFile, $type);

        return [
            'fileName'  => $tempFile,
            'success' => true,
        ];
    }


}
