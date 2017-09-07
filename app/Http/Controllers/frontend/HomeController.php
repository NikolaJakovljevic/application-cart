<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\Category;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get tables form table tables
        $tables = Table::Active()->get();

        // load view from frontend/home and send $tables to view
        return view('frontend.home', compact('tables'));
    }


   public function getTableDetails()
   {
       $categories = Category::nested()->get();
       dd($categories);
   }
}
