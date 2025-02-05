<?php

namespace App;


use App\Models\Shop\OrderSeller;
use App\Models\Shop\Product;
use App\Models\Shop\Zone;
use App\Models\TrainingContents\Training;
use App\Models\UserContents\Comment;
use App\Models\UserContents\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $appends = ['published', 'district', 'gov',];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'email_verified_at' => 'datetime',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $fillable = ['name', 'gender', 'phone', 'email', 'status',
        'type', 'password', 'gov_id', 'district_id', 'more_address_info'];


    function getGovAttribute()
    {
        $im = $this->gov()->get()->first();
        return ($im != null) ? $im->name_ar : null;
    }

    public function district()
    {
        return $this->belongsTo(Zone::class, 'district_id', 'id');
    }


    function getDistrictAttribute()
    {
        $im = $this->district()->get()->first();
        return ($im != null) ? $im->name_ar : null;
    }




    public function products()
    {
        return $this->hasMany(Product::class, 'admin_id', 'id');

    }

    public function order_products()
    {
        return $this->hasMany(OrderSeller::class, 'seller_id', 'id');

    }
    public function seller()
    {
        return $this->hasOne(Seller::class, 'admin_id', 'id');
    }

    public function gov()
    {
        return $this->belongsTo(Zone::class, 'gov_id', 'id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }

    public function share_user()
    {
        return $this->hasOne(ShareUser::class, 'user_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    public function accepted_training()
    {
        return $this->belongsToMany(Training::class, 'user_trainings', 'user_id', 'training_id')->where('status', 1);
    }

    public function training()
    {
        return $this->belongsToMany(Training::class, 'user_trainings', 'user_id', 'training_id');
    }

    public function not_accepty_training()
    {
        return $this->belongsToMany(Training::class, 'user_trainings', 'user_id', 'training_id')->where('status', 1);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeOfPermission($query, $permissions)
    {


        return $query->whereIn('id', function ($q) use ($permissions) {
            $q->select('model_id')
                ->from("model_has_roles")
                ->where('role_id','>',1)
                ->whereIn('role_id', function ($q) use ($permissions) {
                    $q->select('role_id')
                        ->from("role_has_permissions")
                        ->whereIn('permission_id', function ($q) use ($permissions) {
                            $q->select('id')
                                ->from("permissions")
                                ->whereIn('name', $permissions);

                        });

                });
        });

    }

    public function scopeOfHasPermission($query, $permissions,$user_id)
    {


        return $query->whereIn('id', function ($q) use ($permissions,$user_id) {
            $q->select('model_id')
                ->from("model_has_roles")
                ->where('model_id',$user_id)
                ->whereIn('role_id', function ($q) use ($permissions) {
                    $q->select('role_id')
                        ->from("role_has_permissions")
                        ->whereIn('permission_id', function ($q) use ($permissions) {
                            $q->select('id')
                                ->from("permissions")
                                ->whereIn('name', $permissions);

                        });

                });
        });

    }


}
