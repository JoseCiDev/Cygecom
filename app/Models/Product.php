<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function categorie()
    {
        return $this->belongsTo(ProductCategorie::class, 'product_categorie_id');
    }

    public function updaterUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected $fillable = [
        'name',
        'description',
        'unit_price',
        'product_categorie_id',
        'updated_by',
    ];
}
