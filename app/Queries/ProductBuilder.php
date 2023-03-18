<?php

namespace App\Queries;
class ProductBuilder extends QueryBuilder
{
    public function selectedColor($selectedColor) {
        $this->whereHas('subcategory', function ($query) {
            $query->where('color', true);
        });
    }

    public function selectedSize($selectedSize) {
        $this->whereHas('subcategory', function ($query) {
            $query->where('size', true);
        });
    }
}
