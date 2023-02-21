<?php

namespace App\Http\Controllers;

use App\Modules\Board\Interfaces\BoardServiceInterface;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PagePostRequest;
use App\Http\Requests\Post\CreatePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Modules\Post\Interfaces\PostServiceInterface;

class PostController extends Controller
{
    /**
     * Post service
     *
     * @var PostServiceInterface
     */
    private PostServiceInterface $service;

    /**
     * Constructor
     *
     * @param PostServiceInterface $service
     */
    public function __construct(PostServiceInterface $service)
    {
        $this->middleware("auth.basic")->only(["store", "update", "destroy"]);

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PagePostRequest  $request
     * @param string  $boardName
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PagePostRequest $request, string $boardName)
    {
        $q = (object) $request->all();

        // 공지사항 string -> bool 로 변환 (true / false)
        $notice = $q->notice == "true" ? true : false;

        // prettier-ignore
        $ret = is_null($q->query)
            ? $this->service->paginate($boardName, $notice, $q->page, $q->rows)
            : $this->service->find($boardName, $notice, $q->query, $q->page, $q->rows);

        return response()->json($ret);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePostRequest  $request
     * @param  string $boardName
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request, string $boardName)
    {
        $ret = $this->service->create($request->toDto(), $boardName);

        return response()->noContent(Response::HTTP_CREATED, [
            "Location" => [
                action(
                    [get_class(), "show"],
                    ["boardName" => $boardName, "postId" => $ret->id]
                ),
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $boardName
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $boardName, int $id)
    {
        $ret = $this->service->findOne($boardName, $id);

        return response()->json($ret);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePostRequest  $request
     * @param  string $boardName
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(
        UpdatePostRequest $request,
        string $boardName,
        int $id
    ) {
        $this->service->update($request->toDto(), $boardName, $id);

        return response()->noContent(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $boardName
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $boardName, int $id)
    {
        $this->service->delete($boardName, $id);

        return response()->noContent();
    }
}
