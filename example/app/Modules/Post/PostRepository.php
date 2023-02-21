<?php

namespace App\Modules\Post;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Inium\Mvcs\Common\Traits\PageResolverTrait;
use App\Modules\Post\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{
    use PageResolverTrait;

    /**
     * Model
     *
     * @var \App\Models\Post
     */
    private Post $model;

    /**
     * Constructor
     *
     * @param \App\Models\Post
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function count(string $boardName): int
    {
        return $this->model->count();
    }

    /**
     * {@inheritDoc}
     */
    public function all(string $boardName): Collection
    {
        return $this->model->all();
    }

    /**
     * {@inheritDoc}
     */
    public function paginate(
        string $boardName,
        bool $notice,
        int $page,
        int $rows,
        bool $desc = true
    ): LengthAwarePaginator {
        $this->setPageNum($page);

        return $this->model
            ->with(["board:id,name,name_ko", "user:id,name"])
            ->withCount("comment")
            ->whereHas("board", fn($q) => $q->where("name", $boardName))
            ->where("notice", $notice)
            ->orderBy($this->model->getKeyName(), $desc ? "DESC" : "ASC")
            ->paginate($rows);
    }

    /**
     * {@inheritDoc}
     */
    public function find(
        string $boardName,
        bool $notice,
        string $query,
        int $page,
        int $rows,
        bool $desc = true
    ): LengthAwarePaginator {
        $this->setPageNum($page);

        // TODO: Add $query search column name
        $searchColumns = ["subject", "stripped_content"];

        return $this->model
            ->with(["board:id,name,name_ko", "user:id,name"])
            ->withCount("comment")
            ->where(function ($q) use ($searchColumns, $query) {
                foreach ($searchColumns as $column) {
                    $q->orWhere($column, "LIKE", "%{$query}%");
                }
            })
            ->where("notice", $notice)
            ->orderBy($this->model->getKeyName(), $desc ? "DESC" : "ASC")
            ->paginate($rows);
    }

    /**
     * {@inheritDoc}
     */
    public function findOne(string $boardName, int $id): array
    {
        return $this->model
            ->with(["board:id,name,name_ko", "user:id,name"])
            ->withCount("comment")
            ->whereHas("board", fn($q) => $q->where("name", $boardName))
            ->findOrFail($id)
            ->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data, int $boardId, int $userId): array
    {
        $this->model->board()->associate($boardId);
        $this->model->user()->associate($userId);
        $this->model->fill($data)->save();

        return $this->model->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function update(array $data, int $boardId, int $userId, int $id): int
    {
        $model = $this->model->where("id", $id)->firstOrFail();

        $model->board()->associate($boardId);
        $model->user()->associate($userId);

        return $model->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(string $boardName, int $id): int
    {
        return $this->model
            ->with("board")
            ->where("id", $id)
            ->whereHas("board", fn($q) => $q->where("name", $boardName))
            ->firstOrFail()
            ->delete();
    }

    /**
     * {@inheritDoc}
     */

    public function incrementViewCount(string $boardName, int $id): int
    {
        $post = $this->findOne($boardName, $id);

        return $this->model
            ->where("id", $id)
            ->firstOrFail()
            ->update(["view_count" => $post["view_count"] + 1]);
    }
}
