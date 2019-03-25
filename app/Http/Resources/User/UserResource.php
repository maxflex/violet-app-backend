<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Photo\PhotoResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return extractFields($this, [
            'id', 'name', 'email', 'gender', 'birthdate'
        ], [
            'photos' => PhotoResource::collection($this->photos),
        ]);
    }
}
