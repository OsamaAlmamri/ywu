<?php

namespace App\Http\Resources\Consultant;

use App\Http\Resources\General\UserSelectResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsConsultantPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return
            [
                "id" => $this->id,
                "is_consonant" => $this->is_consonant,
                'user' => new UserSelectResource($this->user),
                "body" => $this->body,
                "status" => $this->status,
                'published' => Carbon::createFromTimestamp(strtotime($this->created_at))->diffForHumans(),

            ];
    }
}
