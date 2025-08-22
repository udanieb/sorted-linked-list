<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\SortedLinkedList;
use InvalidArgumentException;

/**
 * Class SortedLinkedListTest
 *
 * PHPUnit test cases for the SortedLinkedList class.
 */
class SortedLinkedListTest extends TestCase
{
    /**
     * Test that elements are inserted in sorted order.
     *
     * Inserts multiple integers into the list and verifies
     * that the internal order is ascending.
     *
     * @return void
     */
    public function testInsertAndOrder(): void
    {
        $list = new SortedLinkedList('int');
        $list->insert(3);
        $list->insert(1);
        $list->insert(2);
        $this->assertSame([1, 2, 3], $list->toArray());
    }

    /**
     * Test removal of elements from the list.
     *
     * Checks that removing existing elements returns true,
     * removing non-existent elements returns false,
     * and verifies the resulting list contents.
     *
     * @return void
     */
    public function testRemove(): void
    {
        $list = new SortedLinkedList('int');
        $list->insert(5);
        $list->insert(10);
        $this->assertTrue($list->remove(5));
        $this->assertFalse($list->remove(100));
        $this->assertSame([10], $list->toArray());
    }

    /**
     * Test the contains() method.
     *
     * Verifies that the list correctly identifies whether
     * a value exists within it or not.
     *
     * @return void
     */
    public function testContains(): void
    {
        $list = new SortedLinkedList('string');
        $list->insert("apple");
        $list->insert("banana");
        $this->assertTrue($list->contains("apple"));
        $this->assertFalse($list->contains("cherry"));
    }

    /**
     * Test the count() method and Countable interface.
     *
     * Ensures that the list accurately counts the number of
     * elements after insertions.
     *
     * @return void
     */
    public function testCount(): void
    {
        $list = new SortedLinkedList('int');
        $list->insert(1);
        $list->insert(2);
        $this->assertCount(2, $list);
    }
}
