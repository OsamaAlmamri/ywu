<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class LastPostsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected $type;

    public function type($value){
        $this->type = $value;
        return $this;
    }
    public function toArray($request)
    {
        $this->collection->each->type($this->type);
        return parent::toArray($request);
    }
}
