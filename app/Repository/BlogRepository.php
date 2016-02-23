<?php

namespace BiboBlog\Repository;

use BiboBlog\Eloquent\Blog;
use BiboBlog\Repository\AbstractRepository;

class BlogRepository extends AbstractRepository
{
    protected $model;

    public function __construct(Blog $blog)
    {
        $this->model = $blog;
    }
}