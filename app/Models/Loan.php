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
        'fine',
        'period',
        'is_returned',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item_loan()
    {
        return $this->hasMany(Item_Loan::class);
    }
    
    public function good()
    {
        return $this->belongsToThrough(Item_Loan::class, Good::class);
    }
}
