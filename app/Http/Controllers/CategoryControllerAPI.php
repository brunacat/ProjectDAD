<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;
use App\Category;

class CategoryControllerAPI extends Controller
{
    public function list()
    {

        if (Auth::user() &&  Auth::user()->type == "u") {
            return CategoryResource::collection(Category::all());
        } else {
            return response()->json(['msg' => 'Unauthorized'], 401);
        }
    }
}
