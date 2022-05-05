<?php

namespace easy\http;

class Cookies
{
    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * @param string $name
     * @return Cookie
     */
    public function get(string $name): Cookie
    {
        return new Cookie($name, $_COOKIE[$name]);
    }

    /**
     * @param Cookie $cookie
     * @return bool
     * @throws \Exception
     */
    public function add(Cookie $cookie): bool
    {
        return $cookie->set();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function del(string $name): bool
    {
        return setcookie($name, '', time() - 3600);
    }
}
