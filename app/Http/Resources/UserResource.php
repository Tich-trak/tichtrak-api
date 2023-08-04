<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'phone_number' => $this->phone_number,
            'is_active' => $this->is_active,
            'address' => $this->whenNotNull($this->address),
            'city' => $this->whenNotNull($this->city),
            'institution' => $this->whenNotNull($this->institution),
            'details' => $this->whenNotNull($this->admin ?: $this->student),
            $this->mergeWhen(count($this->child) > 0 && $request->user()->isSystemAdmin() || $request->user()->isAdmin(), [
                'child' => $this->child,
                'total_child' => count($this->child),
            ]),
        ];
    }
}
