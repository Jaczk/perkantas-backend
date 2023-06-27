<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procurement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'goods_name',
        'goods_amount',
        'description',
        'period',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
