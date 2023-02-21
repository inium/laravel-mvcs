<?php

namespace App\Modules\Comment;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Inium\Mvcs\Common\Traits\PageResolverTrait;
use App\Modules\Comment\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;

class CommentRepository implements CommentRepositoryInterface
{
    use PageResolverTrait;

    /**
     * Model
     *
     * @var \App\Models\Comment
     */
    private Comment $model;

    /**
     * Constructor
     *
     * @param \App\Models\Comment
     */
    public function __construct(Comment $model)
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
        string $boardName,
        int $postId,
        int $page,
        int $rows,
        ?int $parentCommentId = null,
        bool $desc = true
    ): LengthAwarePaginator {
        $this->setPageNum($page);

        return $this->model
            ->with([
                "board:id,name,name_ko",
                "post:id,subject",
                "user:id,name",
                "parent:id",
            ])
            ->withCount("children")
            ->whereHas("board", fn($q) => $q->where("name", $boardName))
            ->whereHas("post", fn($q) => $q->where("id", $postId))
            ->where("parent_comment_id", $parentCommentId)
            ->orderBy($this->model->getKeyName(), $desc ? "DESC" : "ASC")
            ->paginate($rows);
    }

    /**
     * {@inheritDoc}
     */
    public function find(
        string $boardName,
        int $postId,
        string $query,
        int $page,
        int $rows,
        ?int $parentCommentId = null,
        bool $desc = true
    ): LengthAwarePaginator {
        $this->setPageNum($page);

        // TODO: Add column names for searching $query
        $searchColumns = ["stripped_content"];

        return $this->model
            ->with([
                "post:id,subject",
                "board:id,name,name_ko",
                "user:id,name",
                "parent:id",
            ])
            ->withCount("children")
            ->whereHas("board", fn($q) => $q->where("name", $boardName))
            ->whereHas("post", fn($q) => $q->where("id", $postId))
            ->where("parent_comment_id", $parentCommentId)
            ->where(function ($q) use ($searchColumns, $query) {
                foreach ($searchColumns as $column) {
                    $q->orWhere($column, "LIKE", "%{$query}%");
                }
            })
            ->orderBy($this->model->getKeyName(), $desc ? "DESC" : "ASC")
            ->paginate($rows);
    }

    /**
     * {@inheritDoc}
     */
    public function findOne(string $boardName, int $postId, int $id): array
    {
        return $this->model
            ->with([
                "post:id,subject",
                "board:id,name,name_ko",
                "user:id,name",
                "parent:id",
            ])
            ->withCount("children")
            ->whereHas("board", fn($q) => $q->where("name", $boardName))
            ->whereHas("post", fn($q) => $q->where("id", $postId))
            ->findOrFail($id)
            ->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function create(
        array $data,
        int $boardId,
        int $postId,
        int $userId,
        int|null $parentCommentId = null
    ): array {
        $this->model->board()->associate($boardId);
        $this->model->post()->associate($postId);
        $this->model->user()->associate($userId);
        $this->model->parent()->associate($parentCommentId);
        $this->model->fill($data)->save();

        return $this->model->toArray();
    }

    /**
     * {@inheritDoc}
     */
    public function update(
        array $data,
        int $boardId,
        int $postId,
        int $userId,
        int $id,
        int|null $parentCommentId = null
    ): int {
        $model = $this->model->where("id", $id)->firstOrFail();

        $model->board()->associate($boardId);
        $model->post()->associate($postId);
        $model->user()->associate($userId);

        return $model->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(string $boardName, int $postId, int $id): int
    {
        return $this->model
            ->with(["board", "post"])
            ->where("id", $id)
            ->whereHas("board", fn($q) => $q->where("name", $boardName))
            ->whereHas("post", fn($q) => $q->where("id", $postId))
            ->firstOrFail()
            ->delete();
    }
}
