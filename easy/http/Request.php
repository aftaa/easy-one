<?php

namespace easy\http;

class Request
{
    private const POST = 'POST';

    /**
     * @param string $name
     * @return string|array|null
     */
    public function get(string $name): null|string|array
    {
        return $_GET[$name] ?? null;
    }

    /**
     * @param string $name
     * @return string|array|null
     */
    public function post(string $name): null|string|array
    {
        return $_POST[$name] ?? null;
    }

    /**
     * @param string $name
     * @return string|array|null
     */
    public function query(string $name): null|string|array
    {
        return $_REQUEST[$name] ?? null;
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return self::POST === $_SERVER['REQUEST_METHOD'];
    }
}
