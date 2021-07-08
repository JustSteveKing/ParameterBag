<?php

declare(strict_types=1);

namespace JustSteveKing\ParameterBag;

class ParameterBag
{
    /**
     * The Parameter Bag Constructor
     *
     * @param array $parameters
     * @return void
     */
    public function __construct(
        protected array $parameters = [],
    ) {}

    /**
     * Check to see if our bag contains a parameter
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->parameters);
    }

    /**
     * Get an item out of our bag
     *
     * @param   string  $key
     * @return  mixed
     */
    public function get(string $key): mixed
    {
        return $this->parameters[$key];
    }

    /**
     * Set an item in our bag (this will over write the current value)
     *
     * @param   string  $key
     * @param   mixed  $value
     * @return  self
     */
    public function set(string $key, mixed $value): self
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    /**
     * Remove an item from our bag
     *
     * @param   string  $key
     * @return  self
     */
    public function remove(string $key): self
    {
        unset($this->parameters[$key]);

        return $this;
    }

    /**
     * Get all items from our bag
     *
     * @return  array
     */
    public function all(): array
    {
        return $this->parameters;
    }

    /**
     * Create a new bag from a string
     *
     * @param   string  $attributes
     * @param   string  $delimitter
     *
     * @return  self
     */
    public static function fromString(string $attributes, string $delimitter = '&'): self
    {
        return new self(
            self::mapToAssoc(
                items: explode($delimitter, $attributes),
                callback: function (string $keyValue) {
                    $parts = explode('=', $keyValue, 2);

                    return count($parts) === 2 ? $parts : [$parts[0], null];
                }
            )
        );
    }

    /**
     * @codeCoverageIgnore
     */
    private static function mapToAssoc(array $items, callable $callback): array
    {
        return array_reduce(
            $items,
            function (array $assoc, mixed $item) use ($callback): array {
                [$key, $value] = $callback($item);
                $assoc[$key] = $value;

                return $assoc;
            },
            []
        );
    }
}
