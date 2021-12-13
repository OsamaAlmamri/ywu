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
                "solve" => $this->solve,
                'post' => new ConsultantPostResource($this->post),
                'foreword_by' => new UserSelectResource($this->foreword_by_user),
                'foreword_to' => new UserSelectResource($this->foreword_to_user),
                'published' => Carbon::createFromTimestamp(strtotime($this->created_at))->diffForHumans(),

            ];
    }
}
