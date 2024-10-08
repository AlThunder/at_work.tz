<?php

namespace App\Services;

use App\Services\Api\CommentService;
use App\Services\Api\CompanyService;
use App\Services\Api\UserService;

class Service
{
    public UserService $userService;
    public CompanyService $companyService;
    public CommentService $commentService;

    public function __construct(
        UserService $userService,
        CompanyService $companyService,
        CommentService $commentService,
    )
    {
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->commentService = $commentService;
    }

}
