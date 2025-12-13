<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class KeyFirstTest extends TestCase
{
    /**
     * Tests the keyFirst() method with associative array.
     *
     * This test verifies that the keyFirst() method correctly returns
     * the first key of an associative CoverArray, mirroring PHP's
     * array_key_first() function behavior.
     *
     *
     * Тестирование метода keyFirst() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод keyFirst() корректно возвращает
     * первый ключ ассоциативного CoverArray, отражая поведение
     * функции array_key_first() PHP.
     *
     * @see CoverArray::keyFirst()
     * @see array_key_first()
     */
    public function testKeyFirstWithAssociativeArray(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $expected = array_key_first($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyFirst());
    }

    /**
     * Tests the keyFirst() method with sequential numeric array.
     *
     * This test verifies that the keyFirst() method correctly returns
     * the first key (0) of a sequential numeric CoverArray, mirroring PHP's
     * array_key_first() function behavior.
     *
     *
     * Тестирование метода keyFirst() с последовательным числовым массивом.
     *
     * Этот тест проверяет, что метод keyFirst() корректно возвращает
     * первый ключ (0) последовательного числового CoverArray, отражая поведение
     * функции array_key_first() PHP.
     *
     * @see CoverArray::keyFirst()
     * @see array_key_first()
     */
    public function testKeyFirstWithSequentialNumericArray(): void
    {
        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data = [18, 8, 1982];

        $expected = array_key_first($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyFirst());
    }

    /**
     * Tests the keyFirst() method with empty array.
     *
     * This test verifies that the keyFirst() method correctly returns
     * null for empty CoverArrays, mirroring PHP's array_key_first()
     * function behavior.
     *
     *
     * Тестирование метода keyFirst() с пустым массивом.
     *
     * Этот тест проверяет, что метод keyFirst() корректно возвращает
     * null для пустых CoverArray, отражая поведение функции array_key_first() PHP.
     *
     * @see CoverArray::keyFirst()
     * @see array_key_first()
     */
    public function testKeyFirstWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];

        $expected = array_key_first($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyFirst());
    }

    /**
     * Tests the keyFirst() method with mixed keys array.
     *
     * This test verifies that the keyFirst() method correctly returns
     * the first key of a CoverArray with mixed keys (numeric and string),
     * mirroring PHP's array_key_first() function behavior.
     *
     *
     * Тестирование метода keyFirst() с массивом со смешанными ключами.
     *
     * Этот тест проверяет, что метод keyFirst() корректно возвращает
     * первый ключ CoverArray со смешанными ключами (числовыми и строковыми),
     * отражая поведение функции array_key_first() PHP.
     *
     * @see CoverArray::keyFirst()
     * @see array_key_first()
     */
    public function testKeyFirstWithMixedKeysArray(): void
    {
        // Test with mixed keys array
        // Тест с массивом со смешанными ключами
        $data = [0 => 'zero', 'a' => 'apple', 1 => 'one', 'b' => 'banana'];

        $expected = array_key_first($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyFirst());
    }

    /**
     * Tests the keyFirst() method with single element array.
     *
     * This test verifies that the keyFirst() method correctly returns
     * the key of the single element in a CoverArray, mirroring PHP's
     * array_key_first() function behavior.
     *
     *
     * Тестирование метода keyFirst() с массивом из одного элемента.
     *
     * Этот тест проверяет, что метод keyFirst() корректно возвращает
     * ключ единственного элемента в CoverArray, отражая поведение
     * функции array_key_first() PHP.
     *
     * @see CoverArray::keyFirst()
     * @see array_key_first()
     */
    public function testKeyFirstWithSingleElementArray(): void
    {
        // Test with single element array
        // Тест с массивом из одного элемента
        $data = ['single' => 'element'];

        $expected = array_key_first($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyFirst());
    }

    /**
     * Tests the keyFirst() method with associative array containing CoverArray values.
     *
     * This test verifies that the keyFirst() method correctly returns
     * the first key even when the array contains CoverArray objects as values,
     * mirroring PHP's array_key_first() function behavior.
     *
     *
     * Тестирование метода keyFirst() с ассоциативным массивом, содержащим значения типа CoverArray.
     *
     * Этот тест проверяет, что метод keyFirst() корректно возвращает
     * первый ключ даже когда массив содержит объекты CoverArray как значения,
     * отражая поведение функции array_key_first() PHP.
     *
     * @see CoverArray::keyFirst()
     * @see array_key_first()
     */
    public function testKeyFirstWithCoverArrayValues(): void
    {
        // Test with associative array containing CoverArray values
        // Тест с ассоциативным массивом, содержащим значения типа CoverArray
        $coverValue = new CoverArray(['nested' => 'value']);
        $data = [
            'first' => $coverValue,
            'second' => 'string',
            'third' => new CoverArray(['another' => 'nested'])
        ];

        $expected = array_key_first($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyFirst());
    }

    /**
     * Tests the keyFirst() method with array containing only CoverArray values.
     *
     * This test verifies that the keyFirst() method correctly returns
     * the first key when all values are CoverArray objects,
     * mirroring PHP's array_key_first() function behavior.
     *
     *
     * Тестирование метода keyFirst() с массивом, содержащим только значения типа CoverArray.
     *
     * Этот тест проверяет, что метод keyFirst() корректно возвращает
     * первый ключ, когда все значения являются объектами CoverArray,
     * отражая поведение функции array_key_first() PHP.
     *
     * @see CoverArray::keyFirst()
     * @see array_key_first()
     */
    public function testKeyFirstWithOnlyCoverArrayValues(): void
    {
        // Test with array containing only CoverArray values
        // Тест с массивом, содержащим только значения типа CoverArray
        $data = [
            new CoverArray(['a' => 1]),
            new CoverArray(['b' => 2]),
            new CoverArray(['c' => 3])
        ];

        $expected = array_key_first($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyFirst());
    }
}