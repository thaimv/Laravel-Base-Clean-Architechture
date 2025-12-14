<?php

namespace App\Application\DTOs\User;

readonly class ListUserDTO
{
    public function __construct(
        public ?string $keyword = null,
        public int $page = 1,
        public int $perPage = 15,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            keyword: $data['keyword'] ?? null,
            page: $data['page'] ?? 1,
            perPage: $data['per_page'] ?? 15,
        );
    }

    public function toArray(): array
    {
        return [
            'keyword' => $this->keyword,
            'page' => $this->page,
            'per_page' => $this->perPage,
        ];
    }
}
