<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $guarded = [];

    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }
}
