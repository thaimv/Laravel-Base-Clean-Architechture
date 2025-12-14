<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JwtAuthResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'access_token' => $this['access_token'],
            'expires_in' => $this['expires_in'],
            'user'=> UserResource::make(Auth::user()),
        ];
    }
}
