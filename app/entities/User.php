<?php

namespace app\entities;

class User
{
    public int $id;
    public string $username;
    public string $email;
    public bool $is_verified;
    public string $roles;
    public string $password;
    public int $group_id;
}
