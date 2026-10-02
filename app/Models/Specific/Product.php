<?php

namespace App\Models\Specific;

use App\Models\Base\Comment;
use App\Traits\AttachmentTrait;
use App\Traits\HasReports;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Rutorika\Sortable\SortableTrait;

class Product extends Model
{
    use SortableTrait,AttachmentTrait,VisibilityTrait,SoftDeletes,HasReports;
    protected $with=['comments','shop'];
    protected $dates=['deleted_at'];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'shop_id',
        'brand_id',
        'title',
        'sell_count',
        'views',
        'description',
        'position',
        'display',
        'deleted_at',
    ];

    public static function boot()
    {
        parent::boot();
        static ::deleting(function (self $product) {
            $product->details->each(function (ProductDetail $productDetail) {
                $productDetail->delete();
            });
        });
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    /**:::::::::::::::**| Product categories |**:::::::::::::::**/
    public function productCategories()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    /**:::::::::::::::**| Shop |**:::::::::::::::**/
    public function shop()
    {
        return $this->belongsTo(Shop::class)->withTrashed();
    }

    /**:::::::::::::::**| brand |**:::::::::::::::**/
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**:::::::::::::::**| Comments |**:::::::::::::::**/
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**:::::::::::::::**| Properties: For example size for clothes is a property and xl is a property detail |**:::::::::::::::**/
    public function properties()
    {
        return $this->hasMany(ProductProperty::class);
    }

    /**:::::::::::::::**| Product Details: every product have many product details with different colors and prices etc |**:::::::::::::::**/
    public function details()
    {
        return $this->hasMany(ProductDetail::class);
    }

    /**:::::::::::::::**| Technical Specifications |**:::::::::::::::**/
    public function productCategoryTechnicalSpecifications()
    {
        return $this->belongsToMany(ProductCategoryTechnicalSpecification::class)
        ->join('technical_specifications', 'technical_specifications.id', '=', 'product_category_technical_specifications.technical_specification_id')
        ->withPivot('value')->select(\DB::raw('product_category_technical_specifications.*,technical_specifications.position as t_position,technical_specifications.title as t_title'))->orderBy('t_position');
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Scopes
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function scopeConfirmed(Builder $builder)
    {
        return $builder->where('status', 'confirmed');
    }

    public function scopeNotDeleted(Builder $builder)
    {
        return $builder->whereNull('deleted_at');
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Mutations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function getRateAttribute()
    {
        return (int)ceil($this->comments()->parents()->confirmed()->avg('rate'));
    }

    public function getCreatedAtDiffAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getLatestCategoryAttribute()
    {
        return $this->productCategories->where('level', 3)->first();
    }

    public function getIndexedProductAttribute()
    {
        return $this->details()->index()->first()?:$this->details()->first();
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function path()
    {
        return $this->indexed_product->path();
    }

    public function getPersianName()
    {
        return [
           'name'=>'محصول',
           'title'=>$this->title,
           'url'=>$this->path()
       ];
    }
}
