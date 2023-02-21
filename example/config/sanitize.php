<?php

return [
    // 게시판 콘텐츠 (게시글, 댓글)에 허용할 태그 목록 (XSS 방지)
    "board" => [
        "allow_tags" => [
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
        ],
    ],
];
