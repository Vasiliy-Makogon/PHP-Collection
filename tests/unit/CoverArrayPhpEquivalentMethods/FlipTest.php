<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FlipTest extends TestCase
{
    /**
     * Tests the flip() method with simple associative array.
     *
     * This test verifies that the flip() method correctly exchanges
     * all keys with their associated values in a simple associative array,
     * mirroring PHP's array_flip() function behavior.
     *
     *
     * Тестирование метода flip() с простым ассоциативным массивом.
     *
     * Этот тест проверяет, что метод flip() корректно меняет местами
     * все ключи с их связанными значениями в простом ассоциативном массиве,
     * отражая поведение функции array_flip() PHP.
     *
     * @see CoverArray::flip()
     * @see array_flip()
     */
    public function testFlipWithSimpleAssociativeArray(): void
    {
        // Test with simple associative array
        // Тест с простым ассоциативным массивом
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];

        $expected = array_flip($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->flip()->getDataAsArray()
        );
    }

    /**
     * Tests the flip() method with numeric keys.
     *
     * This test verifies that the flip() method correctly handles
     * arrays with numeric keys, converting them to values,
     * mirroring PHP's array_flip() function behavior.
     *
     *
     * Тестирование метода flip() с числовыми ключами.
     *
     * Этот тест проверяет, что метод flip() корректно обрабатывает
     * массивы с числовыми ключами, преобразуя их в значения,
     * отражая поведение функции array_flip() PHP.
     *
     * @see CoverArray::flip()
     * @see array_flip()
     */
    public function testFlipWithNumericKeys(): void
    {
        // Test with numeric keys (will become values)
        // Тест с числовыми ключами (станут значениями)
        $data = [0 => 'zero', 1 => 'one', 2 => 'two'];

        $expected = array_flip($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->flip()->getDataAsArray()
        );
    }

    /**
     * Tests the flip() method with mixed key types.
     *
     * This test verifies that the flip() method correctly handles
     * arrays with mixed key types, exchanging keys and values properly,
     * mirroring PHP's array_flip() function behavior.
     *
     *
     * Тестирование метода flip() со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод flip() корректно обрабатывает
     * массивы со смешанными типами ключей, правильно меняя ключи и значения местами,
     * отражая поведение функции array_flip() PHP.
     *
     * @see CoverArray::flip()
     * @see array_flip()
     */
    public function testFlipWithMixedKeyTypes(): void
    {
        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data = ['a' => 1, 'b' => 2, 'c' => 3];

        $expected = array_flip($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->flip()->getDataAsArray()
        );
    }

    /**
     * Tests the flip() method with duplicate values.
     *
     * This test verifies that the flip() method correctly handles
     * arrays with duplicate values, keeping only the last occurrence
     * (since keys must be unique), mirroring PHP's array_flip() function behavior.
     *
     *
     * Тестирование метода flip() с дублирующимися значениями.
     *
     * Этот тест проверяет, что метод flip() корректно обрабатывает
     * массивы с дублирующимися значениями, сохраняя только последнее вхождение
     * (поскольку ключи должны быть уникальными), отражая поведение функции array_flip() PHP.
     *
     * @see CoverArray::flip()
     * @see array_flip()
     */
    public function testFlipWithDuplicateValues(): void
    {
        // Test with duplicate values (only last duplicate will be kept)
        // Тест с дублирующимися значениями (сохранится только последний дубликат)
        $data = ['x' => 'fruit', 'y' => 'fruit', 'z' => 'vegetable'];

        $expected = array_flip($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->flip()->getDataAsArray()
        );
    }

    /**
     * Tests the flip() method with empty array.
     *
     * This test verifies that the flip() method correctly handles
     * empty arrays, returning an empty array, mirroring PHP's array_flip()
     * function behavior.
     *
     *
     * Тестирование метода flip() с пустым массивом.
     *
     * Этот тест проверяет, что метод flip() корректно обрабатывает
     * пустые массивы, возвращая пустой массив, отражая поведение
     * функции array_flip() PHP.
     *
     * @see CoverArray::flip()
     * @see array_flip()
     */
    public function testFlipWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];

        $expected = array_flip($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->flip()->getDataAsArray()
        );
    }

    /**
     * Tests the flip() method with numeric string values.
     *
     * This test verifies that the flip() method correctly handles
     * arrays with numeric string values, which become integer keys
     * after flipping, mirroring PHP's array_flip() function behavior.
     *
     *
     * Тестирование метода flip() с числовыми строковыми значениями.
     *
     * Этот тест проверяет, что метод flip() корректно обрабатывает
     * массивы с числовыми строковыми значениями, которые становятся целочисленными ключами
     * после переворота, отражая поведение функции array_flip() PHP.
     *
     * @see CoverArray::flip()
     * @see array_flip()
     */
    public function testFlipWithNumericStringValues(): void
    {
        // Test with numeric string values that become integer keys
        // Тест с числовыми строковыми значениями, которые становятся целочисленными ключами
        $data = ['one' => '1', 'two' => '2', 'three' => '3'];

        $expected = array_flip($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->flip()->getDataAsArray()
        );
    }

    /**
     * Tests the flip() method with values of valid string and integer types.
     *
     * This test verifies that the flip() method correctly handles
     * arrays with values that are both strings and integers, converting
     * them appropriately to keys, mirroring PHP's array_flip() function behavior.
     *
     *
     * Тестирование метода flip() со значениями допустимых строковых и целочисленных типов.
     *
     * Этот тест проверяет, что метод flip() корректно обрабатывает
     * массивы со значениями, которые являются одновременно строками и целыми числами,
     * преобразуя их соответствующим образом в ключи, отражая поведение функции array_flip() PHP.
     *
     * @see CoverArray::flip()
     * @see array_flip()
     */
    public function testFlipWithValuesOfStringAndIntegerTypes(): void
    {
        // Test with values that are valid string and integer types
        // Тест со значениями, которые являются допустимыми строковыми и целочисленными типами
        $data = ['a' => 'apple', 'b' => 2, 'c' => '3'];

        $expected = array_flip($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->flip()->getDataAsArray()
        );
    }
}