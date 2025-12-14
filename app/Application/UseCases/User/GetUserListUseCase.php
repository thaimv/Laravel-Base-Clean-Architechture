<?php

namespace App\Application\UseCases\User;

use App\Application\DTOs\User\ListUserDTO;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\ValueObjects\PaginatedResult;

class GetUserListUseCase
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {
    }

    /**
     * Execute get user list use case
     *
     * @param ListUserDTO $dto
     * @return PaginatedResult
     */
    public function execute(ListUserDTO $dto): PaginatedResult
    {
        return $this->userRepository->list($dto->toArray());
    }
}
