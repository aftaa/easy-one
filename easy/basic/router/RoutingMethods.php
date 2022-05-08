<?php

namespace easy\basic\router;

use function in_array;
use function implode;

class RoutingMethods implements \Stringable
{
    public string $requestedMethod;

    /**
     * @param array|null $methods
     */
    public function __construct(
        public readonly ?array $methods = null,
    )
    {
        $this->requestedMethod = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return bool
     */
    public function isApplicable(): bool
    {
        if (!$this->methods) {
            return true;
        }
        return in_array($this->requestedMethod, $this->methods);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (!$this->methods) {
            return '';
        }
        return '[' . implode(separator: ', ', array: $this->methods) . ']';
    }
}
