<?php

namespace BiboBlog\Repository;

use BiboBlog\Eloquent\User;
use BiboBlog\Repository\AbstractRepository;

class UserRepository extends AbstractRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }
}