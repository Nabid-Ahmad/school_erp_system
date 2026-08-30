<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParentPortalController extends Controller
{
    public function profile()
    {
        return view('parents.profile');
    }

    public function attendance()
    {
        return view('parents.attendance');
    }

    public function results()
    {
        return view('parents.results');
    }

    public function fees()
    {
        return view('parents.fees');
    }
}
