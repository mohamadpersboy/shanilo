<?php

namespace App\Models\Base;


use App\Models\Specific\Cart;
use App\Models\Specific\CartDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Base\Address
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string|null $tel
 * @property string $address
 * @property string|null $latlong
 * @property string $postal_code
 * @property string $address_type
 * @property int $selected
 * @property int $deleted
 * @property int $city_id
 * @property int $state_id
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Base\City $city
 * @property-read \App\Models\Base\State $state
 * @property-read \App\Models\Base\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereAddressType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereLatlong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereSelected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereStateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereUserId($value)
 * @mixin \Eloquent
 * @property string $family
 * @property string $phone
 * @property string $zip_code
 * @property string $place_type
 * @property-read mixed $full_name
 * @property-read mixed $place_type_persian
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address exist()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address wherePlaceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\Address whereZipCode($value)
 */
class Address extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'state_id',
        'city_id',
        'name',
        'email',
        'mobile',
        'phone',
        'daytime_phone',
        'evening_phone',
        'address',
        'zip_code',
        'deleted_at'
    ];
    protected $appends=['place_type_persian','full_name'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }



}
