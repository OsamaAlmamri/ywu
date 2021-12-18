<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [

            "permissions" => [
                "replay_social_consultants" => $this->ofHasPermission(['show categories'],$this->id)->count(),
                "replay_social_consultant" => $this->ofHasPermission(['replay social consultant'],$this->id)->count(),
                "replay_legal_consultant" => $this->ofHasPermission(['replay legal consultant'],$this->id)->count(),
                "edit_public_consultant" => $this->ofHasPermission(['edit public consultant'],$this->id)->count(),

                //        $permission = Permission::create(['name' => 'replay social consultant']);
//        $permission = Permission::create(['name' => 'replay legal consultant']);
//        $permission = Permission::create(['name' => 'foreword consultant']);
//        $permission = Permission::create(['name' => 'edit public consultant']);
            ]
        ]);

    }
}
