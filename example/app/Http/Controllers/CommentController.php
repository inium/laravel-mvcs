<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\PageCommentRequest;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Modules\Comment\Interfaces\CommentServiceInterface;

class CommentController extends Controller
{
    /**
     * service
     *
     * @var CommentServiceInterface
     */
    private CommentServiceInterface $service;

    /**
     * Constructor
     *
     * @param CommentServiceInterface $service
     */
    public function __construct(CommentServiceInterface $service)
    {
        $this->middleware("auth.basic")->only(["store", "update", "destroy"]);

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PageCommentRequest  $request
     * @param string $boardName 게시판 이름
     * @param int $postId       게시글 ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(
        PageCommentRequest $request,
        string $boardName,
        int $postId
    ) {
        $q = (object) $request->all();

        $ret = is_null($q->query)
            ? $this->service->paginate(
                $boardName,
                $postId,
                $q->page,
                $q->rows,
                $q->parent
            )
            : $this->service->find(
                $boardName,
                $postId,
                $q->query,
                $q->page,
                $q->rows,
                $q->parent
            );

        return response()->json($ret);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCommentRequest  $request
     * @param string $boardName 게시판 이름
     * @param int $postId       게시글 ID
     * @return \Illuminate\Http\Response
     */
    public function store(
        CreateCommentRequest $request,
        string $boardName,
        int $postId
    ) {
        $ret = $this->service->create($request->toDto(), $boardName, $postId);
        return response()->noContent(Response::HTTP_CREATED, [
            "Location" => [
                action(
                    [get_class(), "show"],
                    [
                        "boardName" => $boardName,
                        "postId" => $postId,
                        "commentId" => $ret->id,
                    ]
                ),
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $boardName 게시판 이름
     * @param int $postId       게시글 ID
     * @param int $commentId    댓글 ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $boardName, int $postId, int $commentId)
    {
        $ret = $this->service->findOne($boardName, $postId, $commentId);

        return response()->json($ret);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCommentRequest  $request
     * @param string $boardName 게시판 이름
     * @param int $postId       게시글 ID
     * @param int $commentId    댓글 ID
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdateCommentRequest $request,
        string $boardName,
        int $postId,
        int $commentId
    ) {
        $this->service->update(
            $request->toDto(),
            $boardName,
            $postId,
            $commentId
        );

        return response()->noContent(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $boardName 게시판 이름
     * @param int $postId       게시글 ID
     * @param int $commentId    댓글 ID
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $boardName, int $postId, int $commentId)
    {
        $this->service->delete($boardName, $postId, $commentId);

        return response()->noContent();
    }
}
