<?php

namespace App\Modules\Post;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Inium\Mvcs\Common\Mapper\ModelMapper;
use Inium\Mvcs\Common\Traits\ArrayTrait;
use App\Modules\Board\Interfaces\BoardRepositoryInterface;
use App\Modules\Post\Interfaces\PostRepositoryInterface;
use App\Modules\Post\Interfaces\PostServiceInterface;
use App\Modules\Post\Dto\PostDto;
use App\Modules\Post\Dto\PagePostDto;
use App\Modules\Post\Dto\CreatePostDto;
use App\Modules\Post\Dto\UpdatePostDto;

class PostService implements PostServiceInterface
{
    use ArrayTrait;

    /**
     * Board Repository
     *
     * @var BoardRepositoryInterface
     */
    private BoardRepositoryInterface $boardRepository;

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
     * @param BoardRepositoryInterface $boardRepository
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(
        BoardRepositoryInterface $boardRepository,
        PostRepositoryInterface $postRepository,
        ModelMapper $mapper
    ) {
        $this->boardRepository = $boardRepository;
        $this->postRepository = $postRepository;
        $this->mapper = $mapper;
    }

    /**
     * {@inheritDoc}
     */
    public function paginate(
        string $boardName,
        bool $notice,
        int $page,
        int $rows
    ): PagePostDto {
        $coll = $this->postRepository->paginate(
            $boardName,
            $notice,
            $page,
            $rows
        );

        $items = $coll->map(function ($item) {
            return $this->mapper->map(
                $this->keysToCamel($item->toArray()),
                PostDto::class
            );
        });

        return new PagePostDto(
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
        bool $notice,
        string $query,
        int $page,
        int $rows
    ): PagePostDto {
        $coll = $this->postRepository->find(
            $boardName,
            $notice,
            $query,
            $page,
            $rows
        );

        $items = $coll->map(function ($item) {
            return $this->mapper->map(
                $this->keysToCamel($item->toArray()),
                PostDto::class
            );
        });

        return new PagePostDto(
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
    public function findOne(string $boardName, int $id): PostDto
    {
        // 조회수 1 증가
        $this->postRepository->incrementViewCount($boardName, $id);

        $ret = $this->postRepository->findOne($boardName, $id);

        return $this->mapper->map($this->keysToCamel($ret), PostDto::class);
    }

    /**
     * {@inheritDoc}
     */
    public function create(CreatePostDto $dto, string $boardName): PostDto
    {
        // 게시판 정보
        $board = $this->toObject(
            $this->keysToCamel($this->boardRepository->findOne($boardName))
        );

        $params = array_merge($dto->jsonSerialize(), [
            "subject" => strip_tags($dto->subject),
            "content" => htmlspecialchars(
                strip_tags($dto->content, config("sanitize.board.allow_tags"))
            ),
            "strippedContent" => strip_tags($dto->content),
        ]);

        $ret = $this->postRepository->create(
            $this->keysToSnake($params),
            $board->id,
            Auth::user()->id
        );

        return $this->mapper->map($this->keysToCamel($ret), PostDto::class);
    }

    /**
     * {@inheritDoc}
     */
    public function update(UpdatePostDto $dto, string $boardName, int $id): int
    {
        // 게시판 정보
        $post = $this->toObject(
            $this->keysToCamel($this->postRepository->findOne($boardName, $id))
        );

        // 작성자 본인 글만 수정 가능
        if ($post->user->id != Auth::user()->id) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        $params = array_merge($dto->jsonSerialize(), [
            "subject" => strip_tags($dto->subject),
            "content" => htmlspecialchars(
                strip_tags($dto->content, config("sanitize.board.allow_tags"))
            ),
            "strippedContent" => strip_tags($dto->content),
        ]);

        return $this->postRepository->update(
            $this->keysToSnake($params),
            $post->board->id,
            Auth::user()->id,
            $id
        );
    }

    /**
     * {@inheritDoc}
     */
    public function delete(string $boardName, int $id): int
    {
        // 게시판 정보
        $post = $this->toObject(
            $this->keysToCamel($this->postRepository->findOne($boardName, $id))
        );

        // 작성자 본인 글만 삭제 가능
        if ($post->user->id != Auth::user()->id) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        if ($post->commentCount > 0) {
            $msg = "댓글이 있는 글은 삭제할 수 없습니다.";
            abort(Response::HTTP_CONFLICT, $msg);
        }

        return $this->postRepository->delete($boardName, $id);
    }
}
