<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Category as CategoryResource;
use App\Category;

class CategoryControllerAPI extends Controller
{
    public function list()
    {
       return CategoryResource::collection(Category::all());    
    }
}