<?php

namespace App\Http\Controllers;

use App\Http\Managers\UsersManager;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUsernameRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{


    public function api_save(StoreUserRequest $request)
    {
        return UsersManager::save($request);
    }

    public function api_update(UpdateUsernameRequest $request)
    {
        return UsersManager::update($request);
    }

    public function api_all(Request $request)
    {
        return UsersManager::getList($request);
    }

}
