<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountItem extends Model
{
    use HasFactory;
    protected $table = 'discount_item';
    protected $fillable = [
        'id',
        'discount_id',
        'item_id',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    // Discount model
    public function getPromotionItems(): BelongsTo
    {
        return $this->belongsTo(DiscountPromotion::class, 'discount_id', 'id');
    }

    public function getPromotionByItem(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
