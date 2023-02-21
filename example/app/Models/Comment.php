<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "lb_board_post_comments";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "content",
        "stripped_content",
        "post_id",
        "board_id",
        "wrote_user_id",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "parent_comment_id",
        "post_id",
        "board_id",
        "wrote_user_id",
        "deleted_at",
    ];

    /**
     * 댓글 소속 게시판 정보를 가져오기 위한 관계 정의
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function board()
    {
        return $this->belongsTo(Board::class, "board_id");
    }

    /**
     * 댓글 작성 사용자 정보를 가져오기 위한 관계 정의
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, "wrote_user_id");
    }

    /**
     * 댓글의 게시글 정보를 가져오기 위한 관계 정의
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, "post_id");
    }

    /**
     * 부모 댓글 정보 가져오기 위한 관계 정의
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, "parent_comment_id");
    }

    /**
     * 자식 댓글 정보 가져오기 위한 관계 정의
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Comment::class, "parent_comment_id", "id");
    }
}
