<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Branch\BranchResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => new RoleResource($this->role),
            'branch' => new BranchResource($this->branch),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
