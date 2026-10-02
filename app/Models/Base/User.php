<?php

namespace App\Models\Base;


use App\Models\ModelTrait\Mutator\UserMutator;
use App\Models\ModelTrait\Relation\UserRelation;
use App\Models\ModelTrait\Scope\UserScope;
use App\Models\Specific\Announcement;

use App\Models\Specific\Article;
use App\Models\Specific\BankCart;
use App\Models\Specific\Follower;
use App\Models\Specific\Message;
use App\Models\Specific\Order;
use App\Models\Specific\Product;
use App\Models\Specific\ProductCategory;
use App\Models\Specific\ProductDetail;
use App\Models\Specific\Shop;
use App\Models\Specific\UserSuggestion;
use App\Models\Specific\ViolationReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomPasswordReset;
use App\Traits\AttachmentTrait;
use Kodeine\Acl\Models\Eloquent\Role;
use Kodeine\Acl\Traits\HasRole;

/**
 * App\Models\Base\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $family
 * @property string|null $email
 * @property string $uid
 * @property string $password
 * @property string|null $mobile
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $description
 * @property int $credit
 * @property int $confirm
 * @property string|null $hashed
 * @property string|null $national_code
 * @property int $status
 * @property string|null $session_id
 * @property int $role_id
 * @property \Carbon\Carbon|null $birth_date
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Address[] $addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Address[] $admin_addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\Announcement[] $announcements
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\Article[] $articles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Attachment[] $attachments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\User[] $blockers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\User[] $blockings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\ProductCategory[] $favoriteCategories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\Follower[] $followers
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\Follower[] $following
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\Kodeine\Acl\Models\Eloquent\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\Message[] $receivedMessages
 * @property-read \Illuminate\Database\Eloquent\Collection|\Kodeine\Acl\Models\Eloquent\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\Message[] $sentMessages
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\Shop[] $shops
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\UserSuggestion[] $userSuggestions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Specific\ViolationReport[] $violationReports
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User role($role, $column = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereConfirm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereHashed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereNationalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereUid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, HasRole, AttachmentTrait,UserRelation,UserScope,UserMutator;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'family',
        'email',
        'uid',
        'mobile',
        'phone',
        'address',
        'password',
        'confirm',
        'confirmed_by_admin',
        'description',
        'credit',
        'national_code',
        'hashed',
        'status',
        'show_info',
        'session_id',
        'role_id',
        'session_id',
        'birth_date'
    ];
    protected $dates = ['birth_date'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $appends = ['username','full_name'];

    protected $withCount = [/*'followers',*/ /*'following',*/ 'shops'];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    /**:::::::::::::::**| Addresses |**:::::::::::::::**/
    public function addresses()
    {
        return $this->hasMany(Address::class)->orderBy('created_at', 'desc');
    }

    /**:::::::::::::::**| Admin addresses |**:::::::::::::::**/
    public function admin_addresses()
    {
        return $this->hasMany(Address::class)->orderBy('created_at', 'desc');
    }

    /**:::::::::::::::**| Comments |**:::::::::::::::**/
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**:::::::::::::::**| Favorite categories: user chooses these categories after registration |**:::::::::::::::**/
    public function favoriteCategories()
    {
        return $this->belongsToMany(ProductCategory::class, 'favorite_categories');
    }

    /**:::::::::::::::**| Favorite products: users favorites products that associated with categories they choose while registration |**:::::::::::::::**/
    public function favoriteProducts()
    {
        $userShops = $this->shops()->pluck('id')->toArray();
        $userFavoriteCategories = $this->favoriteCategories()->pluck('product_category_id')->toArray();
        return ProductDetail::visible()->index()->whereHas('product', function (Builder $builder) use ($userFavoriteCategories, $userShops) {
            $builder->visible()->where(function (Builder $builder) use ($userFavoriteCategories, $userShops) {
                $builder->whereNotIn('shop_id', $userShops);
                $builder->whereHas('productCategories', function (Builder $builder) use ($userFavoriteCategories) {
                    $builder->whereIn('id', $userFavoriteCategories);
                });
            });
        });
    }

    /**:::::::::::::::**| Announcements |**:::::::::::::::**/
    public function announcements()
    {
        return $this->hasMany(Announcement::class)->where('seen', 0)->latest('id');
    }

    /**:::::::::::::::**| User suggestions |**:::::::::::::::**/
    public function userSuggestions()
    {
        return $this->hasMany(UserSuggestion::class);
    }

    /**:::::::::::::::**| Blockings: The users who are blocked by this user |**:::::::::::::::**/
    public function blockings()
    {
        return $this->belongsToMany(self::class, 'block_lists', 'user_id', 'blocked_user_id');
    }

    /**:::::::::::::::**| Blockers: The users who blocked this user |**:::::::::::::::**/
    public function blockers()
    {
        return $this->belongsToMany(self::class, 'block_lists', 'blocked_user_id', 'user_id');
    }

    /**:::::::::::::::**| Violation Reports |**:::::::::::::::**/
    public function violationReports()
    {
        return $this->hasMany(ViolationReport::class);
    }

    /**:::::::::::::::**| Followers |**:::::::::::::::**/
    public function followers()
    {
        return $this->morphMany(Follower::class, 'followable')->whereHas('user');
    }

    /**:::::::::::::::**| Following |**:::::::::::::::**/
    public function following()
    {
        return $this->hasMany(Follower::class);
    }

    /**:::::::::::::::**| Sent Messages |**:::::::::::::::**/
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    /**:::::::::::::::**| Received Messages |**:::::::::::::::**/
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'received_id');
    }

    /**:::::::::::::::**| Articles |**:::::::::::::::**/
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**:::::::::::::::**| Shops |**:::::::::::::::**/
    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    /**:::::::::::::::**| Orders |**:::::::::::::::**/
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**:::::::::::::::**| BankCarts |**:::::::::::::::**/
    public function bankCarts()
    {
        return $this->hasMany(BankCart::class);
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomPasswordReset($token));
    }

    public function fullName()
    {
        return getUsersFullName($this);
    }

    public function path($page = 'personal')
    {
        return route("front.user-page.{$page}", [$this, str_slug(getUsersFullName($this))]);
    }

    public function hasCommentedTo($object)
    {
        return $object->comments()->parents()->where('user_id', auth()->id())->exists();
    }

    public function hasAnnouncement($message)
    {
        return $this->announcements()->where('message', $message);
    }

    public function hasItInNotifyLists($object)
    {
        $allowedModels = [ProductDetail::class, Shop::class];
        return !in_array(get_class($object), $allowedModels) ? false : $object->notifyLists()->where('user_id', $this->id)->exists();
    }

    public function hasUserSuggestion($productDetailId)
    {
        return $this->userSuggestions()->where([
            'product_detail_id' => $productDetailId,
            'offerer_id' => auth()->id()])
            ->exists();
    }

    public function hasCommunicatedBefore(self $user=null)
    {
        $authUserId=in_array($this->role_id,[1,2])?null:$this->id;
        $userId=$user?$user->id:null;
        return  Message::parents()->where(function (Builder $builder) use ($userId, $authUserId, $user) {
            $builder->where(['user_id'=>$authUserId,'receiver_id'=>$userId])
                ->orWhere(function (Builder $builder) use ($userId, $authUserId, $user) {
                        $builder->where(['receiver_id'=>$authUserId,'user_id'=>$userId]);
                });
        })->first();
    }

    public function tickets()
    {
        return  Message::where(function (Builder $builder) {
            $builder->where(['user_id'=>$this->id,'receiver_id'=>null])
                ->orWhere(function (Builder $builder) {
                    $builder->where(['receiver_id'=>$this->id,'user_id'=>null]);
                });
        });
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Mutations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function getUsernameAttribute()
    {
        return '@' . $this->uid;
    }

    public function getTitleAttribute()
    {
        return getUsersFullName($this);
    }

    /**:::::::::::::::**| products |**:::::::::::::::**/

    public function getProductsAttribute()
    {
        $shops = $this->shops->pluck('id')->toArray();
        return Product::whereIn('shop_id', $shops);
    }

}
