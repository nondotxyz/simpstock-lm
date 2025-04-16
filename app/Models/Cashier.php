<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Cashier extends Authenticatable
{
    use HasRoles;
    protected $table = "cashier";
    protected $guarded = [];
}
