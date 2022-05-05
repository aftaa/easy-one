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
     * @return string
     */
    public function get(string $name): string
    {
        return new Cookie($name, $_COOKIE[$name]);
    }

    /**
     * @param Cookie $cookie
     * @return bool
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
