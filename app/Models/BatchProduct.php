<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BatchProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['id'];


    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function batch()
    {
        return $this->belongsTo('App\Models\Batch', 'batch_id');
    }
}
