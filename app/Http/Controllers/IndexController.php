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

    public function logical(Request $request)
    {
        $s = $request->query('s');
        $length = strlen($s);
        if ($length < 1 || $length > 10000) dd(false);

        $stack = [];
        $openBrackets = ['(', '{', '['];
        $closeBrackets = [')', '}', ']'];
        $characters = str_split($s);

        foreach ($characters as $char) {
            if (in_array($char, $openBrackets)) {
                array_push($stack, $char);
            } elseif (in_array($char, $closeBrackets)) {
                $lastBracket = array_pop($stack);
                if ($lastBracket === null || array_search($lastBracket, $openBrackets) !== array_search($char, $closeBrackets)) {
                    dd(false);
                }
            }
        }

        return empty($stack) ? dd(true) : dd(false);
    }

}
