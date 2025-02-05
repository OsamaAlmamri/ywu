<?php namespace App\Models\Rateable;

use Illuminate\Support\Facades\Auth;

trait Rateable
{
    /**
     * This model has many ratings.
     *
     * @return Rating
     */
    public function ratings()
    {
        return $this->morphMany(Rating::class, 'rateable');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
    public function oneRating()
    {
        return ($this->ratings()->where('rating',1)->count()/($this->sumRating()==0?1:$this->sumRating()))*100*1;
    }
    public function towRating()
    {
        return ($this->ratings()->where('rating',2)->count()/($this->sumRating()==0?1:$this->sumRating()))*100*2;
    }
    public function threeRating()
    {
        return ($this->ratings()->where('rating',3)->count()/($this->sumRating()==0?1:$this->sumRating()))*100*3;
    }
    public function fourRating()
    {
        return ($this->ratings()->where('rating',4)->count()/($this->sumRating()==0?1:$this->sumRating()))*100*4;
    }
    public function fiveRating()
    {
        return ($this->ratings()->where('rating',5)->count()/($this->sumRating()==0?1:$this->sumRating()))*100*5;
    }

    public function sumRating()
    {
        return $this->ratings()->sum('rating');
    }
    public function countRating()
    {
        return $this->ratings()->count('id');
    }

//    public function countRating()
//    {
//        return $this->ratings()->count();
//    }

    public function userAverageRating()
    {
        return $this->ratings()->where('user_id', Auth::id())->avg('rating');
    }

    public function userSumRating()
    {
        return $this->ratings()->where('user_id', Auth::id())->sum('rating');
    }

    public function ratingPercent($max = 5)
    {
        $quantity = $this->ratings()->count();
        $total = $this->sumRating();

        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }

    public function getAverageRatingAttribute()
    {
        return $this->averageRating();
    }

    public function getSumRatingAttribute()
    {
        return $this->sumRating();
    }

    public function getUserAverageRatingAttribute()
    {
        return $this->userAverageRating();
    }

    public function getUserSumRatingAttribute()
    {
        return $this->userSumRating();
    }
}
