<?php

namespace App\Http\Resources\Consultant;

use App\Http\Resources\General\UserSelectResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ForewordConsultantResource extends JsonResource
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
                "note" => $this->note,
                "solve" => $this->solve,
                "foreword_to" => $this->foreword_to,
                'post' => new ConsultantPostResource($this->post),
                'foreword_by_user' => new UserSelectResource($this->foreword_by_user),
                'foreword_to_user' => new UserSelectResource($this->foreword_to_user),
                'comments' => CommentsConsultantPostResource::collection($this->comments),
                'published' => Carbon::createFromTimestamp(strtotime($this->created_at))->diffForHumans(),

            ];
    }
}
