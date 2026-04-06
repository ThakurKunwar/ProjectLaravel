<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForgetPassword extends Model
{
    //
    protected $fillable =
    [
        'email',
        'token',
        'user_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
