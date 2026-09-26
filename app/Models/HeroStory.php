<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class HeroStory extends Model
{
    protected $guarded = [];
    protected $casts = [
        'is_dark' => 'boolean',
        'is_active' => 'boolean',
    ];
}
