<?php

namespace App\Http\Managers;

use Illuminate\Support\Facades\Mail;

class EmailsManager
{

    public static function onSaveUser($user)
    {
        Mail::send('emails.on_save_user', [
            "user" => $user,
        ], function ($m) use ($user) {
            $m->from('info@laravel-test.com', 'Your account has been activated');
            $m->to($user->email, "User")
                ->subject('Your account has been activated!');
            $m->cc("support@laravel-test.com");
        });
    }

}