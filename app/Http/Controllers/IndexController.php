<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\User;

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
}
