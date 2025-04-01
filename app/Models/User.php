<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'uuid',
        'avatar',
        'name',
        'email',
        'password_hash',
        'phone',
        'role',
        'status',
        'code_verification_account'
    ];

    protected $hidden = [];

    protected $casts = [];

    public $incrementing = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = Hash::make($value);
    }
}
