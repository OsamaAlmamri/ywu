<?php namespace App\Models\Rateable;

use App\Customer;
use App\User;
use Carbon\Carbon;
use Config;
use Illuminate\Database\Eloquent\Model;


/**
 * Class Rating
 * @package App\Models\Rateable
 *
 * @property integer user_id
 * @property integer rating
 * @property string message
 */
class Rating extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['rating', 'message'];
    protected $appends = ['published', 'user_name'];
    protected $with = ['userRater:id,name,type,created_at'];


    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    public function getUserNameAttribute()
    {
        $user = $this->userRater()->get()->first();
        return $user->name;//
        ;
    }

    /**
     * @return mixed
     */
    public function rateable()
    {
        return $this->morphTo();
    }

    public function userRater()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    /**
     * Rating belongs to a user.
     *
     * @return User
     */
    public function user()
    {
        $userClassName = Config::get('auth.model');
        if (is_null($userClassName)) {
            $userClassName = Config::get('auth.providers.users.model');
        }
        return $this->belongsTo($userClassName);
    }
}
