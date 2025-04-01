<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'uuid',
        'title',
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
        return $this->hasMany(Product::class, 'id_category');
    }
}
