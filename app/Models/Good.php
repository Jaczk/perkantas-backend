<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Good extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'goods_name',
        'condition',
        'is_available',
        'description',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function item_loan()
    {
        return $this->hasMany(Item_Loan::class);
    }
}
