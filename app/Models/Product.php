<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $guarded = [];
    protected $casts = [
        'considerations' => 'array',
        'is_active' => 'boolean',
    ];
}
