<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class KeyLastTest extends TestCase
{
    /**
     * Tests the keyLast() method with associative array.
     *
     * This test verifies that the keyLast() method correctly returns
     * the last key of an associative CoverArray, mirroring PHP's
     * array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * последний ключ ассоциативного CoverArray, отражая поведение
     * функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastWithAssociativeArray(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $expected = array_key_last($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyLast());
    }

    /**
     * Tests the keyLast() method with sequential numeric array.
     *
     * This test verifies that the keyLast() method correctly returns
     * the last key of a sequential numeric CoverArray, mirroring PHP's
     * array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() с последовательным числовым массивом.
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * последний ключ последовательного числового CoverArray, отражая поведение
     * функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastWithSequentialNumericArray(): void
    {
        // Test with sequential numeric array
        // Тест с последовательным числовым массивом
        $data = [18, 8, 1982];

        $expected = array_key_last($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyLast());
    }

    /**
     * Tests the keyLast() method with empty array.
     *
     * This test verifies that the keyLast() method correctly returns
     * null for empty CoverArrays, mirroring PHP's array_key_last()
     * function behavior.
     *
     *
     * Тестирование метода keyLast() с пустым массивом.
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * null для пустых CoverArray, отражая поведение функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];

        $expected = array_key_last($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyLast());
    }

    /**
     * Tests the keyLast() method with mixed keys array.
     *
     * This test verifies that the keyLast() method correctly returns
     * the last key of a CoverArray with mixed keys (numeric and string),
     * mirroring PHP's array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() с массивом со смешанными ключами.
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * последний ключ CoverArray со смешанными ключами (числовыми и строковыми),
     * отражая поведение функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastWithMixedKeysArray(): void
    {
        // Test with mixed keys array
        // Тест с массивом со смешанными ключами
        $data = [0 => 'zero', 'a' => 'apple', 1 => 'one', 'b' => 'banana'];

        $expected = array_key_last($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyLast());
    }

    /**
     * Tests the keyLast() method with single element array.
     *
     * This test verifies that the keyLast() method correctly returns
     * the key of the single element in a CoverArray, mirroring PHP's
     * array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() с массивом из одного элемента.
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * ключ единственного элемента в CoverArray, отражая поведение
     * функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastWithSingleElementArray(): void
    {
        // Test with single element array
        // Тест с массивом из одного элемента
        $data = ['single' => 'element'];

        $expected = array_key_last($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyLast());
    }

    /**
     * Tests the keyLast() method with numeric keys not starting from 0.
     *
     * This test verifies that the keyLast() method correctly returns
     * the last numeric key when keys don't start from 0, mirroring PHP's
     * array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() с числовыми ключами, не начинающимися с 0.
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * последний числовой ключ, когда ключи не начинаются с 0, отражая поведение
     * функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastWithNumericKeysNotStartingFromZero(): void
    {
        // Test with numeric keys not starting from 0
        // Тест с числовыми ключами, не начинающимися с 0
        $data = [5 => 'five', 10 => 'ten', 15 => 'fifteen'];

        $expected = array_key_last($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyLast());
    }

    /**
     * Tests the keyLast() method with reordered array.
     *
     * This test verifies that the keyLast() method correctly returns
     * the last key in the current array order, not insertion order,
     * mirroring PHP's array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() с переупорядоченным массивом.
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * последний ключ в текущем порядке массива, а не в порядке вставки,
     * отражая поведение функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastWithReorderedArray(): void
    {
        // Test with reordered array (should return last key in current order, not insertion order)
        // Тест с переупорядоченным массивом (должен вернуть последний ключ в текущем порядке, а не порядке вставки)
        $data = ['z' => 'last', 'a' => 'first', 'm' => 'middle'];

        $expected = array_key_last($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyLast());
    }

    /**
     * Tests the keyLast() method with associative array containing CoverArray values.
     *
     * This test verifies that the keyLast() method correctly returns
     * the last key even when the array contains CoverArray objects as values,
     * mirroring PHP's array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() с ассоциативным массивом, содержащим значения типа CoverArray.
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * последний ключ даже когда массив содержит объекты CoverArray как значения,
     * отражая поведение функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastWithCoverArrayValues(): void
    {
        // Test with associative array containing CoverArray values
        // Тест с ассоциативным массивом, содержащим значения типа CoverArray
        $coverValue = new CoverArray(['nested' => 'value']);
        $data = [
            'first' => 'string',
            'second' => $coverValue,
            'third' => new CoverArray(['another' => 'nested'])
        ];

        $expected = array_key_last($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyLast());
    }

    /**
     * Tests the keyLast() method with array containing only CoverArray values.
     *
     * This test verifies that the keyLast() method correctly returns
     * the last key when all values are CoverArray objects,
     * mirroring PHP's array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() с массивом, содержащим только значения типа CoverArray.
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * последний ключ, когда все значения являются объектами CoverArray,
     * отражая поведение функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastWithOnlyCoverArrayValues(): void
    {
        // Test with array containing only CoverArray values
        // Тест с массивом, содержащим только значения типа CoverArray
        $data = [
            new CoverArray(['a' => 1]),
            new CoverArray(['b' => 2]),
            new CoverArray(['c' => 3])
        ];

        $expected = array_key_last($data);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->keyLast());
    }

    /**
     * Tests the keyLast() method with array after modification.
     *
     * This test verifies that the keyLast() method correctly returns
     * the last key after array modification, reflecting current state,
     * mirroring PHP's array_key_last() function behavior.
     *
     *
     * Тестирование метода keyLast() с массивом после модификации.
     *
     * Этот тест проверяет, что метод keyLast() корректно возвращает
     * последний ключ после модификации массива, отражая текущее состояние,
     * отражая поведение функции array_key_last() PHP.
     *
     * @see CoverArray::keyLast()
     * @see array_key_last()
     */
    public function testKeyLastAfterArrayModification(): void
    {
        $data = ['a' => 1, 'b' => 2];
        $cover = new CoverArray($data);

        // Check initial last key
        // Проверяем начальный последний ключ
        $this->assertSame('b', $cover->keyLast());

        // Add new element
        // Добавляем новый элемент
        $cover['c'] = 3;
        $this->assertSame('c', $cover->keyLast());

        // Remove last element
        // Удаляем последний элемент
        unset($cover['c']);
        $this->assertSame('b', $cover->keyLast());

        // Add element with numeric key
        // Добавляем элемент с числовым ключом
        $cover[] = 'new';
        $this->assertSame(0, $cover->keyLast());
    }
}