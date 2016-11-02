<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }
}
