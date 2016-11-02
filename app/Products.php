<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }
}
