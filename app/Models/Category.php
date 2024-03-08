<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'category';
    protected $fillable = [
        'id',
        'name',
        'parent_id',
        'status',
        'image',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

   // Category model
    public function getItems(): HasMany
    {
        return $this->hasMany(Item::class, 'category_id', 'id');
    }

}
