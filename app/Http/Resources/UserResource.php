<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request) {
        $hashed_email = md5($this->email);
        $default_avatar = config('app.logos.light');
        $default_avatar_dark = config('app.logos.dark');

        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'role'       => $this->role,
            'role_id'    => $this->role_id,
            'avatar'     => "https://www.gravatar.com/avatar/$hashed_email?d=$default_avatar",
            'avatarDark' => "https://www.gravatar.com/avatar/$hashed_email?d=$default_avatar_dark",
        ];
    }

}
