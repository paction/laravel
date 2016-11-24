<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }
    
    public function options()
    {
        return $this->hasMany(ProductOptions::class);
    }

    public function getPrice()
    {
        return ($this->discount > 0) ? round(($this->price - $this->price * $this->discount / 100), 2) : $this->price;
    }
}
