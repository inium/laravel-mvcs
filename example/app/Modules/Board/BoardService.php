<?php

namespace App\Modules\Board;

use Inium\Mvcs\Common\Mapper\ModelMapper;
use Inium\Mvcs\Common\Traits\ArrayTrait;
use App\Modules\Board\Interfaces\BoardRepositoryInterface;
use App\Modules\Board\Interfaces\BoardServiceInterface;
use App\Modules\Board\Dto\BoardDto;
use App\Modules\Board\Dto\PageBoardDto;
use App\Modules\Board\Dto\CreateBoardDto;
use App\Modules\Board\Dto\UpdateBoardDto;

class BoardService implements BoardServiceInterface
{
    use ArrayTrait;

    /**
     * Repository
     *
     * @var BoardRepositoryInterface
     */
    private BoardRepositoryInterface $repository;

    /**
     * Model Mapper
     *
     * @var ModelMapper
     */
    private ModelMapper $mapper;

    /**
     * Constructor
     *
     * @param BoardRepositoryInterface $repository
     */
    public function __construct(
        BoardRepositoryInterface $repository,
        ModelMapper $mapper
    ) {
        $this->repository = $repository;
        $this->mapper = $mapper;
    }

    /**
     * {@inheritDoc}
     */
    public function paginate(int $page, int $rows): PageBoardDto
    {
        $coll = $this->repository->paginate($page, $rows);

        $items = $coll->map(function ($item) {
            return $this->mapper->map(
                $this->keysToCamel($item->toArray()),
                BoardDto::class
            );
        });

        return new PageBoardDto(
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
    public function find(string $query, int $page, int $rows): PageBoardDto
    {
        $coll = $this->repository->find($query, $page, $rows);

        $items = $coll->map(function ($item) {
            return $this->mapper->map(
                $this->keysToCamel($item->toArray()),
                BoardDto::class
            );
        });

        return new PageBoardDto(
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
    public function findOne(string $boardName): BoardDto
    {
        $ret = $this->repository->findOne($boardName);

        return $this->mapper->map($this->keysToCamel($ret), BoardDto::class);
    }

    /**
     * {@inheritDoc}
     */
    public function create(CreateBoardDto $dto): BoardDto
    {
        $params = [
            "name" => strip_tags($dto->name),
            "nameKo" => strip_tags($dto->nameKo),
            "description" => strip_tags($dto->description),
        ];

        $ret = $this->repository->create($this->keysToSnake($params));

        return $this->mapper->map($this->keysToCamel($ret), BoardDto::class);
    }

    /**
     * {@inheritDoc}
     */
    public function update(UpdateBoardDto $dto, string $boardName): int
    {
        $params = [
            "name" => strip_tags($dto->name),
            "nameKo" => strip_tags($dto->nameKo),
            "description" => strip_tags($dto->description),
        ];

        return $this->repository->update(
            $this->keysToSnake($params),
            $boardName
        );
    }

    /**
     * {@inheritDoc}
     */
    public function delete(string $boardName): int
    {
        return $this->repository->delete($boardName);
    }
}
