<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            "role"=>$this->roles,
            "permissions"=>$this->permissions,
            "permissions" => [
                "c" => $this->can('show coupons'),
                "pc" => $this->can('show permissions'),
                "replay_social_consultantss" => $this->can('show categories'),
                "replay_social_consultant" => $this->can('replay social consultant'),
                "replay_legal_consultant" => $this->can('replay legal consultant'),
                "edit_public_consultant" => $this->can('edit public consultant'),

                //        $permission = Permission::create(['name' => 'replay social consultant']);
//        $permission = Permission::create(['name' => 'replay legal consultant']);
//        $permission = Permission::create(['name' => 'foreword consultant']);
//        $permission = Permission::create(['name' => 'edit public consultant']);
            ]
        ]);

    }
}
