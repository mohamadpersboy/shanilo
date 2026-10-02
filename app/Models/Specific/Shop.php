<?php

namespace App\Models\Specific;

use App\Models\Base\City;
use App\Models\Base\Comment;
use App\Models\Base\SendType;
use App\Models\Base\State;
use App\Models\Base\User;
use App\Traits\AttachmentTrait;
use App\Traits\HasFilter;
use App\Traits\HasReports;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function MongoDB\BSON\toJSON;
use Rutorika\Sortable\SortableTrait;
use function Symfony\Component\Debug\Tests\testHeader;

class Shop extends Model
{
    use AttachmentTrait, VisibilityTrait, SortableTrait, SoftDeletes, HasReports, HasFilter;
    protected $appends = ['username'];
    protected $filters = [
        'category',
        'brand',
        'state',
        'city',
        'orderByRate',
        'orderByFollower',
        'search'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable = [
        'title',
        'user_id',
        'uid',
        'phone',
        'address',
        'zip_code',
        'work_time',
        'email',
        'description',
        'city_id',
        'display',
        'position',
        'deleted_at'
    ];
    protected $dates = ['deleted_at'];

    protected $withCount = [/*'followers',*/
        'articles'];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Boot
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public static function boot()
    {
        parent::boot();
        static::created(function (self $shop) {
            $shop->wallet()->create();
        });
        static::deleting(function (self $shop) {
            $shop->products->each(function (Product $product) {
                $product->delete();
            });
        });
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    /**:::::::::::::::**| Products: every shop has many products |**:::::::::::::::**/
    public function products()
    {
        return $this->hasMany(Product::class)->visible();
    }

    /**:::::::::::::::**| User: every shop belongs to a user |**:::::::::::::::**/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**:::::::::::::::**| Product categories: every shop belongs to many product categories in level priority  |**:::::::::::::::**/
    public function productCategories()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    /**:::::::::::::::**| City: every shop belongs to a city geographically  |**:::::::::::::::**/
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**:::::::::::::::**| Cities: every shop may choose cities to send products |**:::::::::::::::**/
    public function cities()
    {
        return $this->belongsToMany(City::class)->withPivot('price');
    }

    /**:::::::::::::::**| Comments |**:::::::::::::::**/
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**:::::::::::::::**| Orders |**:::::::::::::::**/
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**:::::::::::::::**| Articles |**:::::::::::::::**/
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**:::::::::::::::**| Followers |**:::::::::::::::**/
    public function followers()
    {
        return $this->morphMany(Follower::class, 'followable');
    }

    /**:::::::::::::::**| Messages |**:::::::::::::::**/
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**:::::::::::::::**| Wallet |**:::::::::::::::**/
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    /**:::::::::::::::**| NotifyLists |**:::::::::::::::**/

    public function notifyLists()
    {
        return $this->morphMany(NotifyList::class, 'notifiable');
    }

    /**:::::::::::::::**| SendTypes |**:::::::::::::::**/
    public function sendTypes()
    {
        return $this->belongsToMany(SendType::class);
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Mutations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function getRateAttribute()
    {
        return (int)ceil($this->comments()->parents()->confirmed()->avg('rate'));
    }

    public function getUsernameAttribute()
    {
        return '@' . $this->uid;
    }

    public function getCustomersAttribute()
    {
        return $this->customers()->get();
    }

    public function getFollowersCountAttribute()
    {
        return $this->followers()->count();
    }

    public function getCityListAttribute()
    {
        $stateCount = State::count();
        $cityStates = $this->cities->groupBy('state_id');
        if ($stateCount == $cityStates->count()) {
            return 'به تمام نقاط کشور';
        } else if ($cityStates->count() > 1) {
            return implode('/', State::whereHas('cities', function (Builder $builder) {
                $builder->whereIn('id', $this->cities()->pluck('id')->toArray());
            })->get()->pluck('name')->toArray());
        } else {
            return implode(' / ', $this->cities()->pluck('name')->toArray());
        }
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Scopes
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function scopeNotDeleted(Builder $builder)
    {
        return $builder->whereNull('deleted_at');
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function path($page = 'index')
    {
        return route("front.shop-page.{$page}", [$this, str_slug($this->title)]);
    }

    public function otherProductDetails(ProductDetail $productDetail)
    {
        return ProductDetail::visible()->index()->where('id', '!=', $productDetail->id)->whereHas('product', function (Builder $builder) {
            $builder->visible()->whereHas('shop', function (Builder $builder) {
                $builder->visible()->where('id', $this->id);
            });
        })->latest()->limit(4)->get();
    }

    /**:::::::::::::::**| Returns customers as an Eloquent query builder |**:::::::::::::::**/
    public function customers()
    {
        return User::whereHas('orders', function (Builder $builder) {
            $builder->where(['shop_id' => $this->id, 'show_as_customer' => 1]);
        });
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Filter
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function filterByCategory(Builder $builder, $value)
    {
        $builder->whereHas('products', function (Builder $builder) use ($value) {
            $builder->visible()->whereHas('productCategories', function (Builder $builder) use ($value) {
                $builder->where('id', $value);
            });
        });
    }

    public function filterByBrand(Builder $builder, $value)
    {
        $builder->whereHas('products', function (Builder $builder) use ($value) {
            $builder->visible()->whereHas('brand', function (Builder $builder) use ($value) {
                $builder->where('id', $value);
            });
        });
    }

    public function filterByState(Builder $builder, $value)
    {
        $builder->whereHas('city', function (Builder $builder) use ($value) {
            $builder->where('state_id', $value);
        });
    }

    public function filterByCity(Builder $builder, $value)
    {
        $builder->where('city_id', $value);
    }

    public function filterByOrderByRate(Builder $builder, $value)
    {
        if (in_array($value, ['asc', 'desc'])) {
            $builder->leftJoin('comments', function ($join) {
                $join->on('comments.commentable_id', '=', 'shops.id')
                    ->where('comments.commentable_type', self::class)
                    ->where('comments.parent_id', null)
                    ->where('comments.status', 'confirmed');
            })->addSelect(\DB::raw('avg(comments.rate) as shop_rate'))
                ->groupBy('shops.id')
                ->orderBy('shop_rate', $value);
        }
        return $builder;
    }

    public function filterByOrderByFollower(Builder $builder, $value)
    {
        if (in_array($value, ['asc', 'desc'])) {
            $builder->withCount('followers')->orderBy('followers_count', $value);
        }
        return $builder;
    }

    /**
     * @param Builder $builder
     * @param $value
     */
    protected function filterBySearch(Builder $builder, $value)
    {
        $builder->where('title', 'like', '%' . $value . '%');
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Scopes
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function scopeOrderByFollowers(Builder $builder, $value)
    {
        return $this->filterByOrderByFollower($builder, $value);
    }

    public function scopeOrderByRate(Builder $builder, $value)
    {
        return $this->filterByOrderByRate($builder, $value);
    }


    public function getPersianName()
    {
        return [
            'name' => 'فروشگاه',
            'title' => $this->title,
            'url' => $this->path()
        ];
    }
}
