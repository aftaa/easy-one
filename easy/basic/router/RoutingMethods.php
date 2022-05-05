<?php

namespace easy\basic\router;

use function in_array;
use function implode;

class RoutingMethods implements \Stringable
{
    /**
     * @param array|null $methods
     */
    public function __construct(
        public readonly ?array $methods = null,
    )
    {
    }

    /**
     * @return bool
     */
    public function applicable(): bool
    {
        if (!$this->methods) {
            return true;
        }
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        return in_array($requestMethod, $this->methods);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (!$this->methods) {
            return '';
        }
        return '[' . implode(', ', $this->methods) . ']';
    }
}