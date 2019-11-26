<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use App\User as UserResource;

class UserControllerAPI extends Controller
{
    public function show($id)
    {
        return new UserResource(User::find($id));
    }
}
