<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //count registered user and check actual odds of winning
        $allusercount = User::count();
        $default = 100;
        $winningOdd = number_format(($default/$allusercount),2);
        return view('home', compact('winningOdd'));
        
    }
}
