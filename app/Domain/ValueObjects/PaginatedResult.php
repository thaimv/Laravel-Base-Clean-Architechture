<?php

namespace App\Domain\ValueObjects;

/**
 * Paginated Result - Pure PHP pagination wrapper
 */
readonly class PaginatedResult
{
    public function __construct(
        public array $items,
        public int $total,
        public int $perPage,
        public int $currentPage,
        public int $lastPage,
    ) {
    }

    /**
     * Check if there are more pages
     */
    public function hasMorePages(): bool
    {
        return $this->currentPage < $this->lastPage;
    }

    /**
     * Get pagination meta data
     */
    public function getMeta(): array
    {
        return [
            'total' => $this->total,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'last_page' => $this->lastPage,
            'has_more_pages' => $this->hasMorePages(),
        ];
    }

    /**
     * Convert to array (useful for CLI, internal services, or when items don't need Resource transformation)
     */
    public function toArray(): array
    {
        return [
            'data' => $this->items,
            'meta' => $this->getMeta(),
        ];
    }
}
