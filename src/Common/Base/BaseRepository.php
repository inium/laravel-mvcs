<?php

namespace Inium\Multier\Common\Base;

use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Inium\Multier\Common\Base\Interfaces\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * Column names to be used for searching
     *
     * @var array
     */
    protected array $searchColumns = [];

    /**
     * Relations (Assocations) that defined in the model
     *
     * @var array
     */
    protected array $relations = [];

    /**
     * Count of relations (assocations) that defined in the model
     *
     * @var array
     */
    protected array $countRelations = [];

    /**
     * Model
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    private Model $model;

    /**
     * Constructor
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
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
            ->with($this->relations)
            ->withCount($this->countRelations)
            ->orderby($this->model->getkeyname(), $desc ? "DESC" : "ASC")
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
            ->with($this->relations)
            ->withCount($this->countRelations)
            ->where(function ($q) use ($query) {
                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, "LIKE", "%{$query}%");
                }
            })
            ->orderby($this->model->getkeyname(), $desc ? "DESC" : "ASC")
            ->paginate($rows);
    }

    /**
     * {@inheritDoc}
     */
    public function findById(int $id): Model
    {
        return $this->model
            ->with($this->relations)
            ->withCount($this->countRelations)
            ->findOrFail($id);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
     * {@inheritDoc}
     */
    public function update(array $data, int $id): int
    {
        return $this->model->where("id", $id)->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function deleteById(int $id): int
    {
        return $this->model->where("id", $id)->delete();
    }

    /**
     * Explicit paginator page number
     *
     * @param integer $pageNum
     * @return void
     */
    protected function setPageNum(int $pageNum): void
    {
        Paginator::currentPageResolver(function () use ($pageNum) {
            return $pageNum;
        });
    }

    /**
     * Get model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function model(): Model
    {
        return $this->model;
    }
}
