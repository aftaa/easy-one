<?php

namespace app\controllers;

use easy\MVC\Controller;

class ErrorController extends Controller
{
    public \Throwable $exception;

    public function httpInternalServerError()
    {
        $this->render('errors/500', ['exception' => $this->exception]);
    }
}