<?php

namespace App\Models\Specific;

use App\Models\Base\User;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Route;
use Rutorika\Sortable\SortableTrait;

class ProductCategory extends Model
{
    use VisibilityTrait, SortableTrait, SoftDeletes;

    /*protected $appends = ['level'];*/
    protected $dates = ['deleted_at'];
    protected $with = ['children'];

    public static function boot()
    {
        parent::boot();
        static::created(function ($category) {
            $category->level = $category->getLevel();
            $category->save();
        });
        static::updated(function ($category){
            $currentLevel=$category->fresh()->getLevel();
            if($currentLevel!=$category->level){
                $category->level=$currentLevel;
                $category->save();
            }
        });
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable = [
        'parent_id',
        'title',
        'icon',
        'level',
        'display',
        'position'
    ];


    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    /**:::::::::::::::**| Shops: every category belongs to many shops |**:::::::::::::::**/
    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }

    /**:::::::::::::::**| Technical Specifications: only the third level categories can have technical specifications |**:::::::::::::::**/
    public function technicalSpecifications()
    {
        return $this->belongsToMany(TechnicalSpecification::class, 'product_category_technical_specifications')->withTimestamps();
    }

    /**:::::::::::::::**| User favorite categories: a user may select some categories as them favorites |**:::::::::::::::**/
    public function users()
    {
        return $this->belongsToMany(User::class, 'favorite_categories');
    }

    /**:::::::::::::::**| Children: every category may have other categories as its children |**:::::::::::::::**/
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**:::::::::::::::**| Parent: every category may have a parent if its a child |**:::::::::::::::**/
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function getLevel($level = 1)
    {
        if ($level >= 4) {
            return $level;
        }
        if ($this->parent_id && $this->parent) {
            $level++;
            return $this->parent->getLevel($level);
        }
        return $level;
    }

    public function getAncestor(&$data = [])
    {
        if ($this->parent) {
            $data[] = $this->parent;
            $this->parent->getAncestor($data);
        }
        return collect($data);
    }

    public function path()
    {
        if (\Route::getCurrentRoute()->getName() == 'front.shop.index') {
            return route('front.shop.index', ['category' => $this->id]);
        } else {
            return route('front.product.index', ['category' => $this->id]);
        }
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Mutations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    /*public function getLevelAttribute()
    {
        return $this->getLevel();
    }*/

    public function getAncestorsAttribute()
    {
        return $this->getAncestor();
    }

    public function getFirstPageSpecialSellsAttribute()
    {
        return FirstPageSpecialSell::remaining()->whereHas('specialSell', function (Builder $builder) {
            $builder->whereHas('productDetail', function (Builder $builder) {
                $builder->visible()->whereHas('product', function (Builder $builder) {
                    $builder->visible()->whereHas('productCategories', function (Builder $builder) {
                        $builder->visible()->where('id', $this->id);
                    });
                });
            });
        });
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Scopes
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function scopeParents(Builder $builder)
    {
        return $builder->where('parent_id', null);
    }


}
