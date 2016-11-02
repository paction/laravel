<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    public function order()
    {
        return $this->belongsTo(Orders::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
