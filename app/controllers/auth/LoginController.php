<?php

namespace app\controllers\auth;

use easy\auth\Authenticate;
use easy\basic\router\Route;
use easy\http\Request;
use easy\MVC\Controller;

class LoginController extends Controller
{
    /**
     * @throws \Throwable
     */
    #[Route('/login', name: 'login')]
    public function login(Request $request, Authenticate $authenticate)
    {
        $email = $request->query('email');
        $password = $request->query('password');

        if ($request->isPost() && $authenticate->login($email, $password)) {
            $this->back();
        }

        $this->render('auth/login', [
            'email' => $email,
            'password' => $password,
        ]);
    }
}