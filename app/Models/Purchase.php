<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';

    protected $fillable = [
        'uuid',
        'id_products',
        'id_providers',
        'quantity',
        'price',
        'price',
        'purcharse_date',
        'updated_at'
    ];

    protected $hidden = [];

    protected $casts = [];

    public $incrementing = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public function products()
    {
        return $this->belongsTo(Product::class, 'id_products');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'id_provider');
    }
}
