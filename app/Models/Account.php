<?php

namespace App\Models;

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
        });
    }
}
