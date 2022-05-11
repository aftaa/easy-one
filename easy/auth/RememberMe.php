<?php

namespace easy\auth;

use app\config\auth\rememberMe\Config;
use easy\http\Cookie;
use easy\http\Cookies;

class RememberMe
{
    const REMEMBER_ME_EMAIL = 'remember_me_email';
    const REMEMBER_ME_PASSWORD = 'remember_me_password';

    public function __construct(
        private readonly Config $config,
        private readonly Cookies $cookies,
        private readonly Authenticate $authenticate,
    )
    {
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function remember(string $email, string $password): bool
    {
        $expires = $this->config->expires;
        $cookieEmail = new Cookie(self::REMEMBER_ME_EMAIL, $email, $expires);
        $cookiePassword = new Cookie(self::REMEMBER_ME_PASSWORD, $password, $expires);
        return $this->cookies->add($cookieEmail) && $this->cookies->add($cookiePassword);
    }

    /**
     * @return bool
     */
    public function authenticate(): bool
    {
        if (!$this->cookies->has(self::REMEMBER_ME_EMAIL)) return false;

        $email = (string)$this->cookies->get(self::REMEMBER_ME_EMAIL);
        $password = (string)$this->cookies->get(self::REMEMBER_ME_PASSWORD);
        try {
            return $this->authenticate->login($email, $password);
        } catch (\Exception) {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function forget(): bool
    {
        return $this->cookies->del(self::REMEMBER_ME_EMAIL)
            && $this->cookies->del(self::REMEMBER_ME_PASSWORD);
    }
}
