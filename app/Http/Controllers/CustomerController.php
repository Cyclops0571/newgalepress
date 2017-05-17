<?php

namespace App\Http\Controllers;

use App\Library\MyResponse;
use App\Models\Customer;
use DateTime;
use eProcessTypes;
use eStatus;
use Illuminate\Http\Request;
use Validator;

class CustomerController extends Controller {

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
        $this->page = 'customers';
        $this->route = __('route.' . $this->page);
        $this->table = 'Customer';
        $this->pk = 'CustomerID';
        $this->caption = __('common.customers_caption');
        $this->detailcaption = __('common.customers_caption_detail');
        $this->fields = [
            0 => ['55px', __('common.customers_list_column2'), 'ApplicationCount'],
            1 => ['55px', __('common.customers_list_column3'), 'UserCount'],
            2 => ['125px', __('common.customers_list_column4'), 'CustomerNo'],
            3 => ['', __('common.customers_list_column5'), 'CustomerName'],
            4 => ['125px', __('common.customers_list_column6'), 'Phone1'],
            5 => ['175px', __('common.customers_list_column7'), 'Email'],
            6 => ['75px', __('common.customers_list_column8'), 'CustomerID'],
        ];
    }

    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $sort = $request->get('sort', 'CustomerID');
        $sort_dir = $request->get('sort_dir', 'DESC');

        if ($request->get('option', 0) == 1)
        {
            $data = [
                'rows' => Customer::orderBy('CustomerID')->get(),
            ];

            return view('pages.customeroptionlist', $data);
        }

        $rows = Customer::customerList($search, $sort, $sort_dir);

        $data = [
            'page'     => $this->page,
            'route'    => $this->route,
            'caption'  => $this->caption,
            'pk'       => $this->pk,
            'fields'   => $this->fields,
            'search'   => $search,
            'sort'     => $sort,
            'sort_dir' => $sort_dir,
            'rows'     => $rows,
        ];

        return view('pages.customerlist', $data);

    }

    public function create()
    {

        $data = [
            'page'          => $this->page,
            'route'         => $this->route,
            'caption'       => $this->caption,
            'detailcaption' => $this->detailcaption,
        ];

        return view('pages.customerdetail', $data);

    }

    public function show(Customer $customer)
    {
        $data = [
            'page'          => $this->page,
            'route'         => $this->route,
            'caption'       => $this->caption,
            'detailcaption' => $this->detailcaption,
            'row'           => $customer,
        ];

        return view('pages.customerdetail', $data);

    }

    public function save(Request $request, MyResponse $myResponse)
    {

        $id = (int)$request->get($this->pk, '0');

        $rules = [
            'CustomerNo'   => 'required',
            'CustomerName' => 'required',
        ];
        $v = Validator::make($request->all(), $rules);
        if ($v->fails())
        {
            $myResponse->error(trans('common.detailpage_validation'));
        }

        if ($id == 0)
        {
            $s = new Customer();
        } else
        {
            $s = Customer::find($id);
        }
        $s->CustomerNo = $request->get('CustomerNo');
        $s->CustomerName = $request->get('CustomerName');
        $s->Address = $request->get('Address');
        $s->City = $request->get('City');
        $s->Country = $request->get('Country');
        $s->Phone1 = $request->get('Phone1');
        $s->Phone2 = $request->get('Phone2');
        $s->Email = $request->get('Email');
        $s->BillName = $request->get('BillName');
        $s->BillAddress = $request->get('BillAddress');
        $s->BillTaxOffice = $request->get('BillTaxOffice');
        $s->BillTaxNumber = $request->get('BillTaxNumber');
        if ($id == 0)
        {
            $s->StatusID = eStatus::Active;
            $s->CreatorUserID = \Auth::user()->UserID;
            $s->DateCreated = new DateTime();
        }
        $s->ProcessUserID = \Auth::user()->UserID;
        $s->ProcessDate = new DateTime();
        if ($id == 0)
        {
            $s->ProcessTypeID = eProcessTypes::Insert;
        } else
        {
            $s->ProcessTypeID = eProcessTypes::Update;
        }
        $s->save();

        return $myResponse->success();


    }

    public function delete(Request $request, MyResponse $myResponse)
    {

        $id = (int)$request->get($this->pk, '0');

        $s = Customer::find($id);
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

}
