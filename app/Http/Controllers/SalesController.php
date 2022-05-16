<?php

namespace App\Http\Controllers;

use \Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coffee_sales');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }
}