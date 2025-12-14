<?php

namespace App\Http\Resources;

use App\Domain\Entities\User;
use App\Shared\Constants\DateFormat;
use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Handle both Entity object and array
        if ($this->resource instanceof User) {
            return [
                'id' => $this->resource->id,
                'name' => $this->resource->name,
                'email' => $this->resource->email,
                'email_verified_at' => $this->resource->emailVerifiedAt?->format(DateFormat::DATETIME_YMD_HIS),
                'created_at' => $this->resource->createdAt?->format(DateFormat::DATETIME_YMD_HIS),
                'updated_at' => $this->resource->updatedAt?->format(DateFormat::DATETIME_YMD_HIS),
            ];
        }

        // Handle array (from toArray())
        return [
            'id' => $this['id'] ?? null,
            'name' => $this['name'] ?? null,
            'email' => $this['email'] ?? null,
            'email_verified_at' => $this['email_verified_at'] ?? null,
            'created_at' => $this['created_at'] ?? null,
            'updated_at' => $this['updated_at'] ?? null,
        ];
    }
}
