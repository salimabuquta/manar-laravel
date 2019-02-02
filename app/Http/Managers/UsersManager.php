<?php

namespace App\Http\Managers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UsersManager
{

    public static function save(Request $request)
    {
        $data = $request->all();
        $data["password"] = Hash::make($data["password"]);
        $total = User::where("age", ">=", "15")->get()->reduce(function ($carry, $item) {
            return $carry + $item->age;
        });
        $count = User::where("age", ">=", "15")->count();
        $average = 0;
        if ($count > 0) {
            $average = $total / $count;
        }
        if ($request->hasFile("image")) {
            // read image from temporary file
            $img = Image::make($_FILES['image']['tmp_name']);
            // resize image
            $img->fit(256, 256);
            // the following code if we want to alter the image based on the average,
            // but this will be permanent.
//            if ($average > 0 and $request->age > $average) {
//                $img->greyscale();
//            }
            // save image
            $photoName = time() . '.' . $request->image->getClientOriginalExtension();
            $img->save(public_path('uploads') . "/$photoName");
            $data["image"] = "/uploads/" . $photoName;
        }

        $model = User::updateOrCreate([
            "id" => $request->id
        ], $data);
        if ($model) {
            return response($model, Response::HTTP_CREATED);
        }
        return response([
            "message" => "could not save user"
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function update(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->username = $request->username;
            if ($user->save()) {
                return \response([
                    "message" => "updated"
                ], Response::HTTP_OK);
            }
        }
        return \response([
            "message" => "could not update"
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    public static function getList(Request $request)
    {
        if ($request->filled("sort_type")) {
            $data = User::orderBy("id", $request->sort_type)->get();
        } else {
            $data = User::orderBy("id", "DESC")->get();
        }
        $total = $data->reduce(function ($carry, $item) {
            return $carry + $item->age;
        });
        $count = $data->filter(function ($item){
            return $item->age > 10;
        })->count();
        $average = 0;
        if ($count > 0) {
            $average = $total / $count;
        }
        return $data->map(function ($item) use ($average) {
            $item->average = $average;
            $item->is_grey = false;
            if($average > 0 and $item->age > $average){
                $item->is_grey = true;
            }
            return $item;
        });
    }

}