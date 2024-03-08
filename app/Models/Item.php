<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'item';
    protected $fillable = [
        'id',
        'name',
        'category_id',
        'price',
        'quantity',
        'code_no',
        'image',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    public function getCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function getPromotionItem(): HasMany
    {
        return $this->hasMany(DiscountItem::class,'item_id','id');
    }
    
    public function getOrderDetail(): BelongsTo
    {
        return $this->belongsTo(OrderDetail::class,'item_id','id');
    }

}
