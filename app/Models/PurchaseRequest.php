<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    // Definindo explicitamente a tabela
    protected $table = 'purchase_requests';

    protected $fillable = [
        'uuid',
        'id_products',
        'quantity',
        'requested_date',
        'created_at'
    ];

    protected $hidden = [];

    protected $casts = [
        'requested_date' => 'datetime',
    ];

    public $incrementing = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_products');
    }
}
