<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Board\PageBoardRequest;
use App\Http\Requests\Board\CreateBoardRequest;
use App\Http\Requests\Board\UpdateBoardRequest;
use App\Modules\Board\Interfaces\BoardServiceInterface;

class BoardController extends Controller
{
    /**
     * service
     *
     * @var BoardServiceInterface
     */
    private BoardServiceInterface $service;

    /**
     * Constructor
     *
     * @param BoardServiceInterface $service
     */
    public function __construct(BoardServiceInterface $service)
    {
        $this->middleware("auth.basic")->only(["store", "update", "destroy"]);

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PageBoardRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PageBoardRequest $request)
    {
        $q = (object) $request->all();

        $ret = is_null($q->query)
            ? $this->service->paginate($q->page, $q->rows)
            : $this->service->find($q->query, $q->page, $q->rows);

        return response()->json($ret);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBoardRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBoardRequest $request)
    {
        $post = $this->service->create($request->toDto());

        return response()->noContent(Response::HTTP_CREATED, [
            "Location" => [
                action([get_class(), "show"], ["boardName" => $post->name]),
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $boardName
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $boardName)
    {
        $ret = $this->service->findOne($boardName);

        return response()->json($ret);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBoardRequest  $request
     * @param  string  $boardName
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBoardRequest $request, string $boardName)
    {
        $this->service->update($request->toDto(), $boardName);

        return response()->noContent(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $boardName
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $boardName)
    {
        $this->service->delete($boardName);

        return response()->noContent();
    }
}
