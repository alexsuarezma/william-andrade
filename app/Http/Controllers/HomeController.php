<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class HomeController extends Controller
{
    public function dashboard() {

        return view('dashboard');
    }
}
