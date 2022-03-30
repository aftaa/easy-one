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
        $errorMessage = '';
        $email = $request->query('email');
        $password = $request->query('password');

        try {
            if ($request->isPost()) {
                if ($authenticate->login($email, $password)) {
                    $this->back();
                } else {
                    $errorMessage = "Wrong email or password";
                }
            }
        } catch (ActivateException $e) {
            $errorMessage = 'User is not activated, check email';
        }

        $this->render('auth/login', [
            'email' => $email,
            'password' => $password,
            'errorMessage' => $errorMessage,
        ]);
    }
}