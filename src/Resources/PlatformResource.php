<?php

namespace Platform\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlatformResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'avatar' => $this->when($this->avatar, $this->imageUrl('avatar')),
            $this->mergeWhen($this->whenLoaded('roles'), [
                'roleId' => optional($this->roles->first())->id,
                'roleName' => optional($this->roles->first())->title,
            ]),
            'state' => $this->state,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
