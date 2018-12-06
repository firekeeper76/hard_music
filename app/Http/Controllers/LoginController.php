<?php

namespace App\Http\Controllers;

use App\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{

    public function login()
    {

        return 1;
    }


    public function admin_login()
    {
        return view('admin.login.login');
    }

}
