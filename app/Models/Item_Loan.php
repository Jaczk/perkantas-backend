<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item_Loan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_loan',
        'id_good',
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
