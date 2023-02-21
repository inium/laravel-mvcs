<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 게시글 테이블
        Schema::create("lb_board_posts", function (Blueprint $table) {
            $table->id();
            $table->boolean("notice")->comment("공지글 여부");
            $table->string("subject")->comment("게시글 제목");
            $table->text("content")->comment("게시글 본문");
            $table
                ->text("stripped_content")
                ->comment("tag제외 게시글 본문 - 검색용");
            $table
                ->integer("view_count")
                ->default(0) // 기본 조회수 0
                ->comment("조회수");
            $table->unsignedBigInteger("board_id")->comment("게시판 ID");
            $table->unsignedBigInteger("wrote_user_id")->comment("작성자 ID");
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key 설정
            $table
                ->foreign("board_id")
                ->references("id")
                ->on("lb_boards");
            $table
                ->foreign("wrote_user_id")
                ->references("id")
                ->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("lb_board_posts");
    }
};
