<?php

namespace App\Http\Resources\Consultant;

use App\Http\Resources\General\UserSelectResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentForewordConsultantResource extends JsonResource
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
                "body" => $this->body,
                "date" => $this->date,
                'user' => new UserSelectResource($this->user),
                'published' => Carbon::createFromTimestamp(strtotime($this->created_at))->diffForHumans(),

            ];
    }
}
