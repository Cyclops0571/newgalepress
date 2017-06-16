<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index()
    {
        if (\Auth::user()->UserTypeID == \eUserTypes::Manager)
        return phpinfo();

        return [];
    }
}
