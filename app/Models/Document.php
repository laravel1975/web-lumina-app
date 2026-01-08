<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = ['product_id', 'title', 'file_path', 'type'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
