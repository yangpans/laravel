<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Http\Requests\StoreBlogPost;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return response()->success(['data' => 'data'], 'Data retrieved successfully');
    }

    public function update()
    {
        try {
            User::where('names','张三')->get();
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage(),CustomException::mysqlError);
        }
    }

    public function content(Request $request )
    {
        return response()->success([ $request->all() ], 'Data retrieved successfully');
    }

    public function validation(StoreBlogPost $request )
    {
        return response()->success([ $request->all() ], 'Data retrieved successfully');
    }

    public function unexpected()
    {
        try {
            User::where('names','张三')->get();
        } catch (\Exception $e) {
            throw new CustomException($e->getMessage(),CustomException::mysqlError);
        }
    }

}
