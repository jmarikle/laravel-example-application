<?php

namespace App\Models;

use App\Mail\AccountCreated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($account) {
            // create an initial location for the account
            $location = new Location([
                'name' => 'First Location',
            ]);
            $location->account()->associate($account);
            $location->save();

            Mail::to(env('MAIL_TO_ADDRESS', 'xxxxxx@xxxxxxxxxxx.com'))->send(new AccountCreated($account));
        });
    }
}
