<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class Productos2 extends Component
{
    use WithPagination;

    public $search;
    public $selectedCategory;
    public $selectedBrand;
    public $selectedPrice;
    public $selectedDate;

    public $selectedColor = true;

    public $selectedSize = true;


    public $pagination = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';


    public $showImage = true;
    public $showName = true;
    public $showCategory = true;
    public $showStatus = true;
    public $showPrice = true;
    public $showEdit = true;
    public $showBrand = true;
    public $showSold = true;
    public $showStock = true;
    public $showCreated = true;

    public $showColor = true;
    public $showSize = true;


    public function updatingSearch() {
        $this->resetPage();
    }

    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            if ($field === 'subcategory.category.name') {
                $this->sortField = 'subcategory_id';
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
            } else if ($field === 'brand_id.name') {
                $this->sortField = 'brand_id';
                $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

            } else {
                $this->sortField = $field;
            }

        }


    }


    public function render() {
        /*
               $query = Product::query();
               if ($this->selectedCategory) {
                   $query->whereHas('subcategory.category', function ($query) {
                       $query->where('id', $this->selectedCategory);
                   });
               }
               if ($this->selectedBrand) {
                   $query->whereHas('brand', function ($query) {
                       $query->where('brand_id', $this->selectedBrand);
                   });
               }
               if ($this->selectedPrice) {
                   $query->where('price', $this->selectedPrice);
               }
               if ($this->selectedDate) {
                   $query->whereDate('created_at', $this->selectedDate);
               }
              $products = $query
                   ->where('name', 'LIKE', "%{$this->search}%")*/
        $query = Product::query();
        if ($this->selectedColor == 0) {
            $query->whereHas('subcategory', function ($query) {
                $query->where('color', true);
            });
        }
        if ($this->selectedSize == 0) {
            $query->whereHas('subcategory', function ($query) {
                $query->where('size', true);
            });
        }
        $products = $query
            /* $products = Product::query()->applyFilters([
                 'search' => $this->search,
                 'selectedCategory' => $this->selectedCategory,
                 'selectedBrand' => $this->selectedBrand,
                 'selectedPrice' => $this->selectedPrice,
                 'selectedDate' => $this->selectedDate,
             ])*/
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->pagination);
        return view('livewire.admin.productos2', compact('products'), [
                'showImage' => $this->showImage,
                'showName' => $this->showName,
                'showCategory' => $this->showCategory,
                'showStatus' => $this->showStatus,
                'showPrice' => $this->showPrice,
                'showEdit' => $this->showEdit,
                'showBrand' => $this->showBrand,
                'showSold' => $this->showSold,
                'showStock' => $this->showStock,
                'showCreated' => $this->showCreated,
                'showColor' => $this->showColor,
                'showSize' => $this->showSize,
                'selectedColor' => $this->selectedColor,
                'categories' => Category::all(),
                'brands' => Brand::all(),
            ]
        )
            ->layout('layouts.admin');


    }


}





