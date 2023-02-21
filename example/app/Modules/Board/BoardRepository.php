<?php

namespace App\Modules\Board;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Inium\Mvcs\Common\Traits\PageResolverTrait;
use App\Modules\Board\Interfaces\BoardRepositoryInterface;
use App\Models\Board;

class BoardRepository implements BoardRepositoryInterface
{
    use PageResolverTrait;

    /**
     * Board Model
     *
     * @var \App\Models\Board
     */
    private Board $model;

    /**
     * Constructor
     *
     * @param \App\Models\Board
     */
    public function __construct(Board $model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function count(): int
    {
        return $this->model->count();
    }

    /**
     * {@inheritDoc}
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * {@inheritDoc}
     */
    public function paginate(
        int $page,
        int $rows,
        bool $desc = true
    ): LengthAwarePaginator {
        $this->setPageNum($page);

        return $this->model
            ->orderBy($this->model->getKeyName(), $desc ? "DESC" : "ASC")
            ->paginate($rows);
    }

    /**
     * {@inheritDoc}
     */
    public function find(
        string $query,
        int $page,
        int $rows,
        bool $desc = false
    ): LengthAwarePaginator {
        $this->setPageNum($page);

        return $this->model
            ->where(
                fn($q) => $q
                    ->where("name", "LIKE", "%{$query}%")
                    ->orWhere("name_ko", "LIKE", "%{$query}%")
            )
            ->orderBy($this->model->getKeyName(), $desc ? "DESC" : "ASC")
            ->paginate($rows);
    }

    /**
     * {@inheritDoc}
     */
    public function findOne(string $boardName): array
    {
        return $this->model
            ->where("name", $boardName)
            ->firstOrFail()
            ->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): array
    {
        return $this->model->create($data)->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function update(array $data, string $boardName): int
    {
        return $this->model
            ->where("name", $boardName)
            ->firstOrFail()
            ->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(string $boardName): int
    {
        return $this->model
            ->where("name", $boardName)
            ->firstOrFail()
            ->delete();
    }
}
