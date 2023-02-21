<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 댓글 생성
        Comment::factory(100)->create();

        // 자식 댓글 생성
        $coll = Comment::all();
        foreach ($coll as $v) {
            Comment::factory(rand(1, 8))
                ->children($v->id, $v->post_id)
                ->create();
        }
    }
}
