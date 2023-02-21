<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Board;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "lb_board_posts";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "notice",
        "subject",
        "content",
        "stripped_subject",
        "stripped_content",
        "view_count",
        "board_id",
        "wrote_user_id",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "stripped_subject",
        "stripped_content",
        "board_id",
        "wrote_user_id",
        "deleted_at",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        "notice" => "boolean",
        "created_at" => "datetime: c", // The ISO-8601 date (e.g. 2013-05-05T16:34:42+00:00)
        "updated_at" => "datetime: c", // The ISO-8601 date (e.g. 2013-05-05T16:34:42+00:00)
    ];

    /**
     * 게시판 정보를 가져오기 위한 관계 정의
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class, "board_id");
    }

    /**
     * 게시글의 댓글 정보를 가져오기 위한 관계 정의
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment()
    {
        return $this->hasMany(Comment::class, "post_id");
    }

    /**
     * 게시글 작성한 사용자 정보를 가져오기 위한 관계 정의
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, "wrote_user_id");
    }
}
