<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
