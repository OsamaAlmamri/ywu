<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LastPosts extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */

    protected $type;

    public function type($value)
    {
        $this->type = $value;
        return $this;
    }

    public function toArray($request)
    {
        if ($this->type == 'trainings')
            return [
                'id' => $this->id,
                'title' => $this->name,
                'body' => $this->description,
                'image' => $this->thumbnail,
            ];
        if ($this->type == 'posts')
            return [
                'id' => $this->id,
                'title' => $this->title,
                'body' => $this->body,
                'category' => $this->category->name,
            ];
        else {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'body' => $this->body,
                'image' => $this->image,
            ];
        }

    }

    public static function collection($resource)
    {
        return new LastPostsCollection($resource);
    }


}
