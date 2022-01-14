<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationAppResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        Carbon::setLocale('ar');
        return
            array_merge(
                $this->data,
                [
                    'is_read' => !empty($this->read_at) ? 1 : 0,
                    "created_at" => Carbon::createFromTimestamp(strtotime($this->created_at))->diffForHumans(),

                ]);
    }


    public function with($request)
    {
        Carbon::setLocale('ar');
        return [
            'meta' => [
                'unread_count' => auth()->user()->notifications()
                    ->whereNull('read_at')
                    ->count(),
            ],
        ];
    }
}
