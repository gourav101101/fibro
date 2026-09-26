<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Enquiry extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'company', 'type', 'material', 'message', 'locale', 'read_at'];

    protected function casts(): array
    {
        return ['read_at' => 'datetime'];
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
