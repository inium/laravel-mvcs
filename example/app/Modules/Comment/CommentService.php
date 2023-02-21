<?php

namespace App\Modules\Comment;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inium\Mvcs\Common\Mapper\ModelMapper;
use Inium\Mvcs\Common\Traits\ArrayTrait;
use App\Modules\Post\Interfaces\PostRepositoryInterface;
use App\Modules\Comment\Interfaces\CommentRepositoryInterface;
use App\Modules\Comment\Interfaces\CommentServiceInterface;
use App\Modules\Comment\Dto\CommentDto;
use App\Modules\Comment\Dto\PageCommentDto;
use App\Modules\Comment\Dto\CreateCommentDto;
use App\Modules\Comment\Dto\UpdateCommentDto;

class CommentService implements CommentServiceInterface
{
    use ArrayTrait;

    /**
     * Comment Repository
     *
     * @var CommentRepositoryInterface
     */
    private CommentRepositoryInterface $commentRepository;

    /**
     * Post Repository
     *
     * @var PostRepositoryInterface
     */
    private PostRepositoryInterface $postRepository;

    /**
     * Model Mapper
     *
     * @var ModelMapper
     */
    private ModelMapper $mapper;

    /**
     * Constructor
     *
     * @param CommentRepositoryInterface $repository
     */
    public function __construct(
        PostRepositoryInterface $postRepository,
        CommentRepositoryInterface $commentRepository,
        ModelMapper $mapper
    ) {
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
        $this->mapper = $mapper;
    }

    /**
     * {@inheritDoc}
     */
    public function paginate(
        string $boardName,
        int $postId,
        int $page,
        int $rows,
        ?int $parentCommentId = null
    ): PageCommentDto {
        $coll = $this->commentRepository->paginate(
            $boardName,
            $postId,
            $page,
            $rows,
            $parentCommentId
        );

        $items = $coll->map(function ($item) {
            return $this->mapper->map(
                $this->keysToCamel($item->toArray()),
                CommentDto::class
            );
        });

        return new PageCommentDto(
            $items->toArray(),
            $coll->total(),
            $coll->currentPage(),
            $coll->lastPage(),
            $coll->perPage()
        );
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
        ?int $parentCommentId = null
    ): PageCommentDto {
        $coll = $this->commentRepository->find(
            $boardName,
            $postId,
            $query,
            $page,
            $rows,
            $parentCommentId
        );

        $items = $coll->map(function ($item) {
            return $this->mapper->map(
                $this->keysToCamel($item->toArray()),
                CommentDto::class
            );
        });

        return new PageCommentDto(
            $items->toArray(),
            $coll->total(),
            $coll->currentPage(),
            $coll->lastPage(),
            $coll->perPage()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function findOne(string $boardName, int $postId, int $id): CommentDto
    {
        $ret = $this->commentRepository->findOne($boardName, $postId, $id);

        return $this->mapper->map($this->keysToCamel($ret), CommentDto::class);
    }

    /**
     * {@inheritDoc}
     */
    public function create(
        CreateCommentDto $dto,
        string $boardName,
        int $postId
    ): CommentDto {
        // 게시글 정보
        $post = $this->toObject(
            $this->keysToCamel(
                $this->postRepository->findOne($boardName, $postId)
            )
        );

        $params = array_merge($dto->jsonSerialize(), [
            "content" => htmlspecialchars(
                strip_tags($dto->content, config("sanitize.board.allow_tags"))
            ),
            "strippedContent" => strip_tags($dto->content),
        ]);

        $ret = $this->commentRepository->create(
            $this->keysToSnake($params),
            $post->board->id,
            $post->id,
            Auth::user()->id
        );

        return $this->mapper->map($this->keysToCamel($ret), CommentDto::class);
    }

    /**
     * {@inheritDoc}
     */
    public function update(
        UpdateCommentDto $dto,
        string $boardName,
        int $postId,
        int $id
    ): int {
        // 댓글 정보
        $comment = $this->toObject(
            $this->keysToCamel(
                $this->commentRepository->findOne($boardName, $postId, $id)
            )
        );

        // 작성자 본인 글만 수정 가능
        if ($comment->user->id != Auth::user()->id) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        $params = array_merge($dto->jsonSerialize(), [
            "content" => htmlspecialchars(
                strip_tags($dto->content, config("sanitize.board.allow_tags"))
            ),
            "strippedContent" => strip_tags($dto->content),
            "parentCommentId" => is_null($comment->parent)
                ? null
                : $comment->parent->id,
        ]);

        return $this->commentRepository->update(
            $this->keysToSnake($params),
            $comment->board->id,
            $comment->post->id,
            Auth::user()->id,
            $id
        );
    }

    /**
     * {@inheritDoc}
     */
    public function delete(string $boardName, int $postId, int $id): int
    {
        // 댓글 정보
        $comment = $this->toObject(
            $this->keysToCamel(
                $this->commentRepository->findOne($boardName, $postId, $id)
            )
        );

        // 작성자 본인 글만 삭제 가능
        $userId = Auth::user()->id;
        if ($comment->user->id != $userId) {
            abort(Response::HTTP_UNAUTHORIZED);
        }
        // 대댓글이 있는 댓글 삭제 불가
        if ($comment->childrenCount > 0) {
            $msg = "대댓글이 있는 댓글은 삭제할 수 없습니다.";
            abort(Response::HTTP_CONFLICT, $msg);
        }

        return $this->commentRepository->delete($boardName, $postId, $id);
    }
}
