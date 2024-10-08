<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Service;

class BaseController extends Controller
{
    public Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }
}
