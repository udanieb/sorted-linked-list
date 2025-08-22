<?php
declare(strict_types=1);

namespace App;

use Countable;
use IteratorAggregate;
use ArrayIterator;
use InvalidArgumentException;

/**
 * Class SortedLinkedList
 *
 * A linked list implementation that maintains sorted order.
 * Supports only int or string values (not both in the same list).
 */
class SortedLinkedList implements Countable, IteratorAggregate
{
    /**
     * @var array|null Head of the list use null if empty
     */
    private ?array $head = null;

    /**
     * @var int Number of elements in the list
     */
    private int $count = 0;

    /**
     * @var string Data type enforced for all values 'int' or 'string'
     */
    private string $type;

    /**
     * Constructor
     *
     * @param string $type The type of values allowed 'int' or 'string'
     *
     * @throws InvalidArgumentException if an unsupported type is passed
     */
    public function __construct(string $type)
    {
        if (!in_array($type, ['int', 'string'])) {
            throw new InvalidArgumentException("Only 'int' or 'string' supported.");
        }
        $this->type = $type;
    }

    /**
     * Insert a value into the list while keeping it sorted.
     *
     * @param int|string $value
     *
     * @return void
     * @throws InvalidArgumentException if value type does not match list type
     */
    public function insert(int|string $value): void
    {
        $this->validateType($value);
        $newNode = ['value' => $value, 'next' => null];

        if ($this->head === null || $this->head['value'] > $value) {
            $newNode['next'] = $this->head;
            $this->head = $newNode;
        } else {
            $current = &$this->head;
            while ($current['next'] !== null && $current['next']['value'] <= $value) {
                $current = &$current['next'];
            }
            $newNode['next'] = $current['next'];
            $current['next'] = $newNode;
        }

        $this->count++;
    }

    /**
     * Remove a value from the list.
     *
     * @param int|string $value
     *
     * @return bool True if value was removed, false otherwise
     * @throws InvalidArgumentException if value type does not match list type
     */
    public function remove(int|string $value): bool
    {
        $this->validateType($value);

        if ($this->head === null) {
            return false;
        }

        if ($this->head['value'] === $value) {
            $this->head = $this->head['next'];
            $this->count--;
            return true;
        }

        $current = &$this->head;
        while ($current['next'] !== null && $current['next']['value'] !== $value) {
            $current = &$current['next'];
        }

        if ($current['next'] === null) {
            return false;
        }

        $current['next'] = $current['next']['next'];
        $this->count--;
        return true;
    }

    /**
     * Check if a value exists in the list.
     *
     * @param int|string $value
     *
     * @return bool True if value is found, false otherwise
     * @throws InvalidArgumentException if value type does not match list type
     */
    public function contains(int|string $value): bool
    {
        $this->validateType($value);
        $current = $this->head;
        while ($current !== null) {
            if ($current['value'] === $value) {
                return true;
            }
            $current = $current['next'];
        }
        return false;
    }

    /**
     * Convert the list into an array.
     *
     * @return array<int|string> Ordered list of values
     */
    public function toArray(): array
    {
        $result = [];
        $current = $this->head;
        while ($current !== null) {
            $result[] = $current['value'];
            $current = $current['next'];
        }
        return $result;
    }

    /**
     * Get number of elements in the list.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->count;
    }

    /**
     * Get an iterator for traversing the list.
     *
     * @return ArrayIterator<int|string>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->toArray());
    }

    /**
     * Validate that a value matches the list's type (int or string).
     *
     * @param mixed $value
     *
     * @return void
     * @throws InvalidArgumentException if type does not match
     */
    private function validateType(mixed $value): void
    {
        $givenType = gettype($value); // returns "integer" or "string"
       
        if ($givenType === 'integer') {
            $givenType = 'int';
        }

        if ($givenType !== $this->type) {
            throw new InvalidArgumentException("Expected {$this->type}, got {$givenType}.");
        }
    }
}
?>
