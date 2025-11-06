<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    use HasFactory;

    protected $guarded   = [];    // permite atribuição em massa
    public $incrementing = false; // porque a chave primária é UUID
    protected $keyType   = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
