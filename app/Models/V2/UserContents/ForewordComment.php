<?php

namespace App;namespace App\Models\V2\UserContents;
use App\User;
use Illuminate\Database\Eloquent\Model;

class ForewordComment extends Model
{
    // $table->foreignId('foreword_id')->constrained('foreword_consultants')->onDelete('cascade');
    //            $table->text('body');
    //            $table->date('date');
    protected $fillable = ['user_id', 'foreword_id', 'body', 'date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
