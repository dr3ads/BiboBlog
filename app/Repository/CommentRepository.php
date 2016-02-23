<?php

namespace BiboBlog\Repository;

use BiboBlog\Eloquent\Comment;
use BiboBlog\Repository\AbstractRepository;

class CommentRepository extends AbstractRepository
{
    protected $model;

    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
}