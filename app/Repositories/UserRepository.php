<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    protected function applyFilters(array $searchParams = []): Builder
    {
        $builder = $this->getQuery();

        if (empty($searchParams['ignore_active'])) {
            $builder->where('active', true);
        }

        $builder->when(! empty($searchParams['name']), function (Builder $builder) use ($searchParams): void {
            $builder->where('name', 'like', sprintf('%%%s%%', $searchParams['name']));
        });

        return $builder;
    }
}
