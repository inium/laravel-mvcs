<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "v1", "as" => "v1."], function () {
    // Board
    Route::apiResource("board", BoardController::class)->parameters([
        "board" => "boardName",
    ]);

    // Post
    Route::apiResource("board.post", PostController::class)->parameters([
        "board" => "boardName",
        "post" => "postId",
    ]);

    // Comment
    Route::apiResource(
        "board.post.comment",
        CommentController::class
    )->parameters([
        "board" => "boardName",
        "post" => "postId",
        "comment" => "commentId",
    ]);
});
