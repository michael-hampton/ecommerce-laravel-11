<?php

declare(strict_types=1);

namespace App\Models;

use App\Mail\ContactMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Contact extends Model
{
    public $fillable = ['name', 'email', 'phone', 'subject', 'message'];

    /**
     * Write code on Method
     *
     *
     *
     * @return response()
     */
    public static function boot()
    {

        parent::boot();

        static::created(function ($item) {

            $adminEmail = 'your_admin_email@gmail.com';

            Mail::to($adminEmail)->send(new ContactMail($item));

        });

    }
}
