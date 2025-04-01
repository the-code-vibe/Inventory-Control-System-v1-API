<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'providers';

    protected $fillable = [
        'uuid',
        'name',
        'contact',
        'email',
        'cnpj',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [];

    protected $casts = [];

    public $incrementing = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public function products()
    {
        return $this->hasMany(Product::class, 'provider_id');
    }
}
