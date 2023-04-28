<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'return_date',
        'due_date',
        'period',
        'is_returned',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item_loan()
    {
        return $this->hasMany(Item_Loan::class);
    }
}
