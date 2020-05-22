<?php

declare(strict_types=1);

namespace JustSteveKing\ParameterBag;

class ParameterBag
{
    /**
     * The parameters in our bag
     *
     * @var array
     */
    protected array $parameters;

    /**
     * The Parameter Bag Constructor
     *
     * @param array $parameters
     * @return void
     */
    public function __construct(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * Check to see if our bad contains a parameter
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
     * @return  string
     */
    public function get(string $key): string
    {
        return $this->parameters[$key];
    }

    /**
     * Set an item in our bag (this will over write the current value)
     *
     * @param   string  $key
     * @param   string  $value
     * @return  self
     */
    public function set(string $key, string $value): self
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
                explode($delimitter, $attributes),
                function (string $keyValue) {
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
            function (array $assoc, $item) use ($callback) {
                [$key, $value] = $callback($item);
                $assoc[$key] = $value;

                return $assoc;
            },
            []
        );
    }
}
