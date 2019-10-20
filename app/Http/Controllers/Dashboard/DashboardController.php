<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Client;
use App\Product;
use App\User;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $categories_count = Category::all()->count();
        $products_count = Product::all()->count();
        $clients_count = Client::all()->count();
        $users_count = User::whereRoleIs('admin')->count();


        return view('dashboard.index',
            compact('categories_count', 'products_count', 'clients_count', 'users_count'));

    }//end of index

}//end of controller
