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
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function good()
    {
        return $this->belongsTo(Good::class);
    }
}
