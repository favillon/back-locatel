<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type_id',
        'account_id',
        'value'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
