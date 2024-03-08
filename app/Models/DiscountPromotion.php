<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountPromotion extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'discount_promotion';
    protected $fillable = [
        'id',
        'name',
        'amount',
        'percentage',
        'start_date',
        'end_date',
        'description',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    // Discount model
    public function getPromotion(): HasMany
    {
        return $this->hasMany(DiscountItem::class, 'discount_id', 'id');
    }

}
