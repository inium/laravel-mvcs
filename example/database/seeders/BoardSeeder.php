<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Board;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 게시판 1개 생성
        Board::factory(1)->create([
            "name" => "free",
            "name_ko" => "자유게시판",
            "description" => "자유게시판",
        ]);
    }
}
