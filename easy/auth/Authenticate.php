<?php

namespace easy\auth;

use app\entities\User;
use app\storages\UserStorage;
use easy\http\Session;

class Authenticate
{
    public function __construct(
        private UserStorage $storage,
        private Session $session,
        private PasswordHash $passwordHash,
    )
    {
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool
     * @throws \Exception
     */
    public function login(string $email, string $password): bool
    {
        $passwordHash = $this->passwordHash->makeHash($password);
        $authenticate = $this->storage->authenticate($email, $passwordHash);

        if ($authenticate) {
            $this->session->set($this::class, $authenticate);
            return true;
        }
        return false;
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->session->del($this::class);
    }

    /**
     * @return bool
     */
    public function isLogin(): bool
    {
        return $this->session->has($this::class);
    }

    /**
     * @return User|false
     */
    public function user(): User|false
    {
        if ($this->isLogin()) {
            return $this->session->get($this::class);
        }
        return false;
    }
}
