<?php

namespace App\Http\Resources\Consultant;

use App\Http\Resources\General\UserSelectResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultantPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'category_id' => $this->category_id,
            'status' => $this->status,
//            'favorite' => $this->favorite,
            'published' => Carbon::createFromTimestamp(strtotime($this->created_at))->diffForHumans(),
            'user' => new UserSelectResource($this->user),
            'category' => $this->category,
            'comments' => CommentsConsultantPostResource::collection($this->comments),
            'comments_count' => $this->comments->count(),
            'likes_count' => $this->likes->count(),
            "user_like" => ($this->user_like != null) ? 1 : 0,
        ];

//        'published', 'comments_count', 'likes_count'
    }
}
