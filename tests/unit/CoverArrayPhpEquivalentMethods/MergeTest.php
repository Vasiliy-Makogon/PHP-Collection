<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class MergeTest extends TestCase
{
    /**
     * Tests the merge() method with numeric arrays.
     *
     * This test verifies that the merge() method correctly merges
     * numeric arrays by reindexing keys, mirroring PHP's array_merge() function
     * behavior for numerically indexed arrays.
     *
     *
     * Тестирование метода merge() с числовыми массивами.
     *
     * Этот тест проверяет, что метод merge() корректно объединяет
     * числовые массивы, переиндексируя ключи, отражая поведение
     * функции array_merge() PHP для числовых индексных массивов.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeWithNumericArrays(): void
    {
        $data = ['PHP', 'MySql'];
        $merge = ['HTML', 'CSS', 'JavaScript'];

        $expected = array_merge($data, $merge);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->merge($merge)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->merge(new CoverArray($merge))->getDataAsArray()
        );
    }

    /**
     * Tests the merge() method with associative arrays.
     *
     * This test verifies that the merge() method correctly merges
     * associative arrays by overwriting string keys, mirroring
     * PHP's array_merge() function behavior for associative arrays.
     *
     *
     * Тестирование метода merge() с ассоциативными массивами.
     *
     * Этот тест проверяет, что метод merge() корректно объединяет
     * ассоциативные массивы, перезаписывая строковые ключи, отражая
     * поведение функции array_merge() PHP для ассоциативных массивов.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeWithAssociativeArrays(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana'];
        $merge = ['b' => 'blueberry', 'c' => 'cherry'];

        $expected = array_merge($data, $merge);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->merge($merge)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->merge(new CoverArray($merge))->getDataAsArray()
        );
    }

    /**
     * Tests the merge() method with multiple arrays.
     *
     * This test verifies that the merge() method correctly merges
     * multiple arrays, applying merging rules sequentially,
     * mirroring PHP's array_merge() function behavior.
     *
     *
     * Тестирование метода merge() с несколькими массивами.
     *
     * Этот тест проверяет, что метод merge() корректно объединяет
     * несколько массивов, применяя правила слияния последовательно,
     * отражая поведение функции array_merge() PHP.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeWithMultipleArrays(): void
    {
        $data = ['x' => 1, 'y' => 2];
        $merge1 = ['y' => 20, 'z' => 3];
        $merge2 = ['z' => 30, 'w' => 4];

        $expected = array_merge($data, $merge1, $merge2);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->merge($merge1, $merge2)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->merge(new CoverArray($merge1), new CoverArray($merge2))->getDataAsArray()
        );
    }

    /**
     * Tests the merge() method with mixed numeric and string keys.
     *
     * This test verifies that the merge() method correctly handles
     * arrays with both numeric and string keys, reindexing numeric keys
     * and overwriting string keys, mirroring PHP's array_merge() function behavior.
     *
     *
     * Тестирование метода merge() со смешанными числовыми и строковыми ключами.
     *
     * Этот тест проверяет, что метод merge() корректно обрабатывает
     * массивы с числовыми и строковыми ключами, переиндексируя числовые ключи
     * и перезаписывая строковые ключи, отражая поведение функции array_merge() PHP.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeWithMixedNumericAndStringKeys(): void
    {
        $data = [0 => 'zero', 'a' => 'apple', 1 => 'one'];
        $merge = [1 => 'ONE', 'b' => 'banana', 2 => 'two'];

        $expected = array_merge($data, $merge);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->merge($merge)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->merge(new CoverArray($merge))->getDataAsArray()
        );
    }

    /**
     * Tests the merge() method with empty array.
     *
     * This test verifies that the merge() method correctly handles
     * merging with an empty array, returning the original array unchanged,
     * mirroring PHP's array_merge() function behavior.
     *
     *
     * Тестирование метода merge() с пустым массивом.
     *
     * Этот тест проверяет, что метод merge() корректно обрабатывает
     * слияние с пустым массивом, возвращая исходный массив без изменений,
     * отражая поведение функции array_merge() PHP.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeWithEmptyArray(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $merge = [];

        $expected = array_merge($data, $merge);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->merge($merge)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->merge(new CoverArray($merge))->getDataAsArray()
        );
    }

    /**
     * Tests the merge() method with all empty arrays.
     *
     * This test verifies that the merge() method correctly handles
     * merging empty arrays, returning an empty array,
     * mirroring PHP's array_merge() function behavior.
     *
     *
     * Тестирование метода merge() со всеми пустыми массивами.
     *
     * Этот тест проверяет, что метод merge() корректно обрабатывает
     * слияние пустых массивов, возвращая пустой массив,
     * отражая поведение функции array_merge() PHP.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeWithAllEmptyArrays(): void
    {
        $data = [];
        $merge = [];

        $expected = array_merge($data, $merge);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->merge($merge)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->merge(new CoverArray($merge))->getDataAsArray()
        );
    }

    /**
     * Tests the merge() method with integer keys.
     *
     * This test verifies that the merge() method correctly reindexes
     * integer keys during merging, mirroring PHP's array_merge() function behavior.
     *
     *
     * Тестирование метода merge() с целочисленными ключами.
     *
     * Этот тест проверяет, что метод merge() корректно переиндексирует
     * целочисленные ключи при слиянии, отражая поведение функции array_merge() PHP.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeWithIntegerKeys(): void
    {
        $data = [10 => 'ten', 20 => 'twenty'];
        $merge = [30 => 'thirty', 40 => 'forty'];

        $expected = array_merge($data, $merge);

        $cover = new CoverArray($data);

        // arguments as array
        // аргументы как массив
        $this->assertSame(
            $expected,
            $cover->merge($merge)->getDataAsArray()
        );

        // arguments as CoverArray
        // аргументы как CoverArray
        $this->assertSame(
            $expected,
            $cover->merge(new CoverArray($merge))->getDataAsArray()
        );
    }

    /**
     * Tests the merge() method with nested arrays.
     *
     * This test verifies that the merge() method correctly merges
     * arrays containing nested arrays, converting them to CoverArray instances,
     * mirroring PHP's array_merge() function behavior for nested arrays.
     *
     *
     * Тестирование метода merge() с вложенными массивами.
     *
     * Этот тест проверяет, что метод merge() корректно объединяет
     * массивы, содержащие вложенные массивы, преобразуя их в экземпляры CoverArray,
     * отражая поведение функции array_merge() PHP для вложенных массивов.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeWithNestedArrays(): void
    {
        $data = ['a' => [1, 2], 'b' => 'test'];
        $merge = ['a' => [3, 4], 'c' => 'new'];

        $expected = array_merge($data, $merge);

        $cover = new CoverArray($data);
        $result = $cover->merge($merge);

        $this->assertSame($expected, $result->getDataAsArray());

        // Проверяем, что вложенный массив преобразован в CoverArray
        $this->assertInstanceOf(CoverArray::class, $result['a']);
        $this->assertSame([3, 4], $result['a']->getDataAsArray());
    }

    /**
     * Tests the merge() method with mixed arguments (array and CoverArray).
     *
     * This test verifies that the merge() method correctly handles
     * mixed argument types (array and CoverArray) in the same call.
     *
     *
     * Тестирование метода merge() со смешанными аргументами (массив и CoverArray).
     *
     * Этот тест проверяет, что метод merge() корректно обрабатывает
     * смешанные типы аргументов (массив и CoverArray) в одном вызове.
     *
     * @see CoverArray::merge()
     * @see array_merge()
     */
    public function testMergeWithMixedArguments(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $merge1 = ['b' => 20, 'c' => 3];
        $merge2 = ['c' => 30, 'd' => 4];

        $expected = array_merge($data, $merge1, $merge2);

        $cover = new CoverArray($data);

        // Mix of array and CoverArray arguments
        // Смесь аргументов массив и CoverArray
        $result = $cover->merge($merge1, new CoverArray($merge2));

        $this->assertSame($expected, $result->getDataAsArray());
    }
}