<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = "sales";
    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(SalesDetail::class);
    }

    public function salesman()
    {
        return $this->hasMany(Cashier::class, 'sales_by');
    }
}
