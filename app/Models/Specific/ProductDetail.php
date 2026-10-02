<?php

namespace App\Models\Specific;

use App\Models\Base\Color;
use App\Traits\HasFilter;
use App\Traits\PurePriceTrait;
use App\Traits\VisibilityTrait;
use function foo\func;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\JoinClause;
use Rutorika\Sortable\SortableTrait;

class ProductDetail extends Model
{
    use SortableTrait, VisibilityTrait, PurePriceTrait, SoftDeletes, HasFilter;


    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable = [
        'product_id',
        'color_id',
        'feature',
        'price',
        'discount',
        'index',
        'count',
        'weight',
        'position',
        'display'
    ];
    protected $filters = [
        'shop',
        'state',
        'city',
        'brand',
        'plan',
        'hasDiscount',
        'category',
        'orderByPrice',
        'orderByRate',
        'search'
    ];
    protected $with = [
        'product', 'color'
    ];

    public static function boot()
    {
        parent::boot();
        static::deleting(function (self $productDetail){
            $productDetail->specialSell()->delete();
            $productDetail->specialSuggestion()->delete();
        });
        static::deleted(function (self $productDetail) {
            if ($productDetail->brothers()->count()) {
                $productDetail->brothers()->first()->update(['index' => 1]);
            }
        });
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function brothers()
    {
        return ProductDetail::where('product_id',$this->product_id)->where('id','!=',$this->id);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function shop()
    {
        return $this->product->shop();
    }

    public function user()
    {
        return $this->product->shop->user();
    }

    public function specialSuggestion()
    {
        return $this->hasOne(SpecialSuggestion::class);
    }

    public function specialSell()
    {
        return $this->hasOne(SpecialSell::class);
    }

    public function notifyLists()
    {
        return $this->morphMany(NotifyList::class, 'notifiable');
    }

    public function userSuggestions()
    {
        return $this->hasMany(UserSuggestion::class);
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Mutator
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function getPurePriceAttribute()
    {
        $price = subPercent($this->price, $this->discount, true);
        return roundPrice($price);
    }

    public function getBreadcrumbsAttribute()
    {
        $breadcrumbs = [
            $this->product->latestCategory
        ];
        foreach ($this->product->latestCategory->ancestors as $ancestor) {
            $breadcrumbs[] = $ancestor;
        }
        $breadcrumbs = array_reverse($breadcrumbs);
        $breadcrumbs[] = $this->product->brand;
        return collect($breadcrumbs);
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Scopes
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function scopeIndex(Builder $builder)
    {
        return $builder->where('index', 1);
    }

    public function scopeNotDeleted(Builder $builder)
    {
        return $builder->whereNull('deleted_at');
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function path()
    {
        return route('front.product.show', [$this, str_slug($this->product->title)]);
    }

    public function isConfirmed()
    {
        return (bool)$this->product->display;
    }

    public function relatedProducts()
    {


        return ProductDetail::index()->visible()->where('id', '!=', $this->id)->whereHas('product', function (Builder $builder) {
            $builder->visible()->whereHas('shop', function (Builder $builder) {
                $builder->visible();
            })->whereHas('productCategories', function (Builder $builder) {
                $cat = $this->product->latestCategory;
                $builder->where('id', $cat->id);
            });
        });
    }

    public function inFirstPage($relation)
    {
        return $this->$relation && $this->$relation->inFirstPage();
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Filters
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected function filterByState(Builder $builder, $value)
    {
        $builder->whereHas('product', function (Builder $builder) use ($value) {
            $builder->visible()->whereHas('shop', function (Builder $builder) use ($value) {
                $builder->visible()->whereHas('city', function (Builder $builder) use ($value) {
                    $builder->where('state_id', $value);
                });
            });
        });
    }

    protected function filterByCity(Builder $builder, $value)
    {
        $builder->whereHas('product', function (Builder $builder) use ($value) {
            $builder->visible()->whereHas('shop', function (Builder $builder) use ($value) {
                $builder->visible()->where('city_id', $value);
            });
        });
    }

    protected function filterByCategory(Builder $builder, $value)
    {
        $builder->whereHas('product', function (Builder $builder) use ($value) {
            $builder->visible()->whereHas('productCategories', function (Builder $builder) use ($value) {
                $builder->visible()->where('id', $value);
            });
        });
    }

    protected function filterByShop(Builder $builder, $value)
    {
        $builder->whereHas('product', function (Builder $builder) use ($value) {
            $builder->visible()->whereHas('shop', function (Builder $builder) use ($value) {
                $builder->visible()->where('id', $value);
            });
        });
    }

    protected function filterByOrderByPrice(Builder $builder, $value)
    {
        if (in_array($value, ['asc', 'desc'])) {
            $builder->addSelect('product_details.*', \DB::raw('
            case when discount > 0
                then price-((price*discount)/100)
                else
                price 
                end as pure_price
        '))->orderBy('pure_price', $value);
        }
    }

    protected function filterByHasDiscount(Builder $builder, $value)
    {
        if ($value == "yes") {
            $builder->where('discount', '>', 0);
        } elseif ($value == 'no') {
            $builder->where(function (Builder $builder) {
                $builder->where('discount', 0)
                    ->orWhere('discount', null);
            });
        }
    }

    protected function filterBySearch(Builder $builder, $value)
    {
        $builder->where(function (Builder $builder) use ($value) {
            $builder->whereHas('product', function (Builder $builder) use ($value) {
                $builder->visible()->where('title', 'like', "%$value%")
                    ->orWhereHas('productCategories', function (Builder $builder) use ($value) {
                        $builder->visible()->where('title', 'like', "%$value%");
                    });
            });
        });
    }

    protected function filterByOrderByRate(Builder $builder, $value)
    {
        if (in_array($value, ['asc', 'desc'])) {
            $builder->join('products', function (JoinClause $join) {
                $join->on('products.id', '=', 'product_details.product_id')
                    ->where('products.display', '=', 1);
            })->leftJoin('comments', function (JoinClause $joinClause) {
                $joinClause->on('comments.commentable_id', '=', 'products.id')
                    ->where('comments.commentable_type', Product::class)
                    ->where('comments.parent_id', null)
                    ->where('comments.status', 'confirmed');
            })->addSelect('product_details.*', \DB::raw('avg(comments.rate) as product_rate'))
                ->groupBy('product_details.id')
                ->orderBy('product_rate', $value);
        }
    }

    protected function filterByBrand(Builder $builder, $value)
    {
        return $builder->whereHas('product', function (Builder $builder) use ($value) {
            $builder->visible()->where('brand_id', $value);
        });
    }

    /*  protected function filterByPlan(Builder $builder, $value)
      {
          $builder->whereHas(request()->get('suggesstionType'), function (Builder $builder) use ($value) {
              $relation = 'firstPage' . ucfirst(request()->get('suggesstionType'));
              $builder->whereHas($relation, function (Builder $builder) use ($value) {
                  $builder->where('plan_id', $value);
              });
          });
      }*/
}
