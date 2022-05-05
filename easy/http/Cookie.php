<?php

namespace easy\http;

class Cookie implements \Stringable
{
    /**
     * @param string $name
     * @param string $value
     * @param int $expires
     * @param string $path
     * @param string $domain
     * @param bool $security
     * @param bool $httponly
     */
    public function __construct(
        public string $name,
        public string $value,
        public int    $expires = 0,
        public string $path = '',
        public string $domain = '',
        public bool   $security = false,
        public bool   $httponly = false,
    )
    {
    }

    /**
     * @return bool
     */
    public function set(): bool
    {
        return setcookie($this->name, $this->value, $this->expires, $this->path, $this->domain, $this->security, $this->httponly);
    }
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
