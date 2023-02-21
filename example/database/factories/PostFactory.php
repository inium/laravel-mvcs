<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Board;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * 게시글 본문 허용할 태그 목록 (XSS 방지)
     *
     * @var array
     */
    private array $allowTags = [
        "p",
        "br",
        "div",
        "span",
        "hr",
        "a",
        "img",
        "blockquote",
        "ul",
        "ol",
        "li",
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $subject = $this->getRandomSubject(
            $this->faker->numberBetween(20, 100)
        );
        $content = $this->getRandomContent($this->faker->numberBetween(10, 20));

        $board = $this->getRandomBoard();
        $user = $this->getRandomUser();

        return [
            "notice" => 0,
            "subject" => strip_tags($subject),
            "content" => htmlspecialchars(
                strip_tags($content, $this->allowTags)
            ),
            "stripped_content" => strip_tags($content),
            "view_count" => $this->faker->numberBetween(0, 5000),
            "board_id" => $board,
            "wrote_user_id" => $user,
        ];
    }

    /**
     * 공지 게시글을 뱐환한다.
     *
     * @return static
     */
    public function notice(): static
    {
        return $this->state(
            fn(array $attributes) => [
                "notice" => 1,
            ]
        );
    }

    /**
     * Random User 정보를 가져온다.
     * users 테이블에 사용자 정보가 존재하지 않을 경우 팩토리 생성 후 반환한다.
     *
     * @return mixed
     */
    private function getRandomUser(): mixed
    {
        if ($user = User::inRandomOrder()->first()) {
            return $user;
        }

        return User::factory()->create();
    }

    /**
     * 게시판 정보를 반환한다.
     * lb_boards 테이블에 정보가 존재하지 않을 경우 팩토리 생성 후 반환한다.
     *
     * @return mixed
     */
    private function getRandomBoard(): mixed
    {
        if ($board = Board::inRandomOrder()->first()) {
            return $board;
        }

        return Board::factory()->create();
    }

    /**
     * 게시글 제목 생성
     *
     * @param integer $count    제목 글자 수
     * @return string
     */
    private function getRandomSubject(int $count): string
    {
        $fakerKo = \Faker\Factory::create("ko_KR");
        return $fakerKo->realText($count, 1);
    }

    /**
     * 게시글 본문 생성
     *
     * @param integer $paragraphCount 단락 개수
     * @return string
     */
    private function getRandomContent(int $paragraphCount): string
    {
        $fakerKo = \Faker\Factory::create("ko_KR");
        $content = "";
        for ($i = 0; $i < $paragraphCount; $i++) {
            $paragraph = $fakerKo->realText(200, 1);
            $content .= "<p>{$paragraph}</p>";
        }

        return $content;
    }
}
