<?php

namespace App\Http\Controllers;

use App\Index;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {


//        name('playlist')->where("public_time between '$start_date' and '$end_date'")->order('play desc')->limit(8)->select();
        return view('index.index.index');
    }
    public function main()
    {

        $start_date = date("Y-m-d h:m:s", strtotime('-30 days'));
        $end_date = date("Y-m-d h:m:s");


        $playlist = DB::table('playlist')->whereBetween('uid',[$start_date,$end_date])->get();
        $banners = DB::table('banner')->orderBy('sort')->get();

//        name('playlist')->where("public_time between '$start_date' and '$end_date'")->order('play desc')->limit(8)->select();
        return view('index.index.main',['banners'=>$banners]);
    }
}
