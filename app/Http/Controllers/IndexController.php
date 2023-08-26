<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        return response()->success(['data' => 'data'], 'Data retrieved successfully');
    }
}
