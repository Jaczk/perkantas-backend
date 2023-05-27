<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item_Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'loan_id',
        'good_id',
        'user_id',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function good()
    {
        return $this->belongsTo(Good::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
