<?php

namespace app\storages;

use app\entities\User;
use easy\db\ORM\Entity;
use easy\db\Storage;

class UserStorage extends Storage
{
    /**
     * @param string $email
     * @param string $passwordHash
     * @return Entity|null
     * @throws \Exception
     */
    public function authenticate(string $email, string $passwordHash): ?User
    {
        return $this->createQueryBuilder()
            ->where('`email` = :email AND `password` = :passwordHash')
            ->param(':email', $email)
            ->param(':passwordHash', $passwordHash)
            ->getQuery()
            ->getResult()
            ?->asEntity();
    }

    /**
     * @param string $email
     * @return bool|null
     */
    public function emailExists(string $email): ?bool
    {
        return $this->createQueryBuilder()
            ->where('`email` = :email')
            ->param(':email', $email)
            ->getQuery()
            ->getResult()
            ?->exists();

    }

    /**
     * @param string $email
     * @param string $recovery
     * @return void
     */
    public function insertRecovery(string $email, string $recovery): void
    {
        $this->createUpgradeBuilder()
            ->set('`recovery` = :recovery')
            ->where('`email` = :email')
            ->param(':recovery', $recovery)
            ->param(':email', $email)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $code
     * @param string $passwordHash
     * @return void
     */
    public function updatePassword(string $code, string $passwordHash): void
    {
        $this->createUpgradeBuilder()
            ->set('recovery = "", password = :password ')
            ->where('recovery = :code')
            ->param(':code', $code)
            ->param(':password', $passwordHash)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $username
     * @return bool
     */
    public function usernameExists(string $username): bool
    {
        return $this->createQueryBuilder()
            ->where('`username` = :username')
            ->param(':username', $username)
            ->getQuery()
            ->getResult()
            ->exists();
    }

    public function activateUser(mixed $registerCode)
    {
        $this->createUpgradeBuilder()
            ->set('is_verified = TRUE, `register` = ""')
            ->where('`register` = :register')
            ->param(':register', $registerCode)
            ->getQuery()
            ->getResult();
    }
}
