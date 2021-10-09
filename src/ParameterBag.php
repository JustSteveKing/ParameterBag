<?php

declare(strict_types=1);

namespace JustSteveKing\ParameterBag;

/**
 * @template TKey of array-key
 * @template TValue
 */
class ParameterBag
{
    /**
     * The Parameter Bag Constructor
     *
     * @param array<TKey, TValue> $parameters
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
     * @param   string $key
     * @param   mixed  $value
     * @return  self<TKey, TValue>
     */
    public function set(string $key, mixed $value): self
    {
        $this->parameters = array_merge($this->parameters, [$key => $value]);

        return $this;
    }

    /**
     * Remove an item from our bag
     *
     * @param   string  $key
     * @return  self<TKey, TValue>
     */
    public function remove(string $key): self
    {
        unset($this->parameters[$key]);

        return $this;
    }

    /**
     * Get all items from our bag
     *
     * @return  array<TKey, TValue>
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
     * @return  self<TKey, TValue>
     */
    public static function fromString(string $attributes, string $delimitter = '&'): self
    {
        return new self(
            self::mapToAssoc(
                /** @phpstan-ignore-next-line */
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
     *
     * @template TMapValue
     *
     * @param array<TKey, TValue> $items
     * @param callable $callback
     * @return array
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
