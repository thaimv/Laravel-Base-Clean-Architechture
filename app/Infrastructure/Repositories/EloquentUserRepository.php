<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\ValueObjects\PaginatedResult;
use App\Infrastructure\Persistence\Eloquent\Mappers\UserMapper;
use App\Infrastructure\Persistence\Eloquent\Models\UserModel;
use App\Shared\Helpers\Helper;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function __construct(
        protected UserModel $model,
    ) {
    }

    /**
     * Get paginated list of users
     *
     * @param array $params
     * @return PaginatedResult
     */
    public function list(array $params): PaginatedResult
    {
        Helper::pageAndPerPage($params);

        $paginator = $this->model->query()
            ->when(isset($params['keyword']), function ($query) use ($params) {
                $query->where(function ($query) use ($params) {
                    $likes = [
                        [
                            ['name', 'email'],
                            'keyword'
                        ]
                    ];
                    $query->whereLike($likes, $params);
                });
            })
            ->paginate($params['per_page'], ['*'], 'page', $params['page']);

        return new PaginatedResult(
            items: UserMapper::toEntityCollection($paginator->items()),
            total: $paginator->total(),
            perPage: $paginator->perPage(),
            currentPage: $paginator->currentPage(),
            lastPage: $paginator->lastPage(),
        );
    }

    /**
     * Find user by field
     *
     * @param string $field
     * @param mixed $value
     * @return User|null
     */
    public function findByField(string $field, mixed $value): ?User
    {
        $model = $this->model->query()
            ->where($field, $value)
            ->first();

        return $model ? UserMapper::toEntity($model) : null;
    }

    /**
     * Find user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        $model = $this->model->query()->find($id);

        return $model ? UserMapper::toEntity($model) : null;
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        $model = $this->model->query()->create($data);

        return UserMapper::toEntity($model);
    }

    /**
     * Update user by ID
     *
     * @param array $data
     * @param int $id
     * @return User
     */
    public function update(array $data, int $id): User
    {
        $model = $this->model->query()->findOrFail($id);
        $model->update($data);

        return UserMapper::toEntity($model->fresh());
    }

    /**
     * Delete user by ID
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->query()
            ->where('id', $id)
            ->delete() > 0;
    }
}
