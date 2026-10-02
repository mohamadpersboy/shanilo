<?php

namespace App\Http\Controllers\Front\Specific;

use App\Models\Base\State;
use App\Models\Specific\Brand;
use App\Models\Specific\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductShopArchiveController extends Controller
{
    /**
     * @param $selectedCategory
     * @return array
     */
    protected function getSelectedCategories($selectedCategory = null)
    {
        $selectedCategories = [];
        if ($selectedCategory) {
            $selectedCategories = $selectedCategory->ancestors->pluck('id')->toArray();
            $selectedCategories[] = $selectedCategory->id;
        }
        return $selectedCategories;
    }

    protected function getBreadcrumbs($selectedCategory = null)
    {
        $breadcrumbs = [];
        if ($selectedCategory) {
            $breadcrumbs[] = $selectedCategory;
            foreach ($selectedCategory->ancestors as $ancestor) {
                $breadcrumbs[] = $ancestor;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            if ($brand = \request()->get('brand')) {
                $brand = Brand::findOrFail($brand);
                $breadcrumbs[] = $brand;
            }
        }
        return collect($breadcrumbs);
    }

    /**
     * @param $selectedCategory
     * @return array
     */
    protected function getFilterItems($selectedCategory)
    {
        if (!$selectedCategory) {
            return [];
        } elseif ($selectedCategory->children()->count()) {
            return $selectedCategory->children()->orderBy('title')->get();
        } else {
            return Brand::visible()->whereHas('products', function (Builder $builder) use ($selectedCategory) {
                $builder->visible()->whereHas('productCategories', function (Builder $builder) use ($selectedCategory) {
                    $builder->visible()->where('id', $selectedCategory->id);
                });
            })->orderBy('title')->get();
        }
    }

    protected function setData($extraData=[])
    {
        $selectedCategory = \request()->get('category') ? ProductCategory::findOrFail(\request()->get('category')) : null;
        $selectedCategories = $this->getSelectedCategories($selectedCategory);
        $breadcrumbs = $this->getBreadcrumbs($selectedCategory);

        return array_merge($extraData,[
            'selectedCategories' => $selectedCategories,
            'selectedCategory' => $selectedCategory,
            'selectedBrand' => \request()->get('brand'),
            'filterLevel' => filterLevel($breadcrumbs),
            'filterItems' => $this->getFilterItems($selectedCategory),
            'breadcrumbs' => $breadcrumbs,
            'states'=>State::orderBy('name')->get(),
            'cities' => \request()->get('state')?State::findOrFail(\request()->get('state'))->cities()->orderBy('name')->get():[],
            'parentCategories' => ProductCategory::parents()->orderBy('title')->get(),
            'selectedCity' => \request()->get('city'),
            'selectedState'=>\request()->get('state'),
            'selectedOrderByRate' => \request()->get('orderByRate'),
            'selectedOrderByFollower' => \request()->get('orderByFollower'),
            'search'=>\request()->get('search')
        ]);
    }
}
