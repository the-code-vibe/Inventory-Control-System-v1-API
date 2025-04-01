<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'uuid',
        'title',
        'description',
        'price',
        'quantity',
        'unit_type',
        'id_category',
        'id_provider',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [];

    protected $casts = [];

    public $incrementing = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'id_provider');
    }
}
