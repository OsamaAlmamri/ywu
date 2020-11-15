<?php


namespace App\Models\Shop;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Kyslik\ColumnSortable\Sortable;

class ProductQuestion extends Model
{
    //

    use Sortable;

    protected $table = 'product_questions';
    protected $fillable = [
        'product_id', 'customers_id', 'text',
        'question_read', 'sort', 'status',
    ];
    protected $appends = ['user_name', 'published', 'replaies', 'products_name'];

    public function getPublishedAttribute()
    {
        return Carbon::createFromTimestamp(strtotime($this->attributes['created_at']))->diffForHumans();
    }

    function getReplaiesAttribute()
    {
        return $this->question_replaiess()->get()->count();
    }

    function getProductsNameAttribute()
    {
        $im = $this->product()->get()->first();
        return ($im != null) ? $im->name : null;
    }

    function getUserNameAttribute()
    {
        $im = $this->user()->get()->first();
        return ($im != null) ? $im->name : null;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'customers_id', 'id');
    }

    public function question_replaiess()
    {
        return $this->hasMany(QuestionReplay::class, 'product_question_id', 'id');
    }

    function replies()
    {
        return $this->hasMany(QuestionReplay::class, 'product_question_id', 'id')->orderByDesc('id');
    }
}
