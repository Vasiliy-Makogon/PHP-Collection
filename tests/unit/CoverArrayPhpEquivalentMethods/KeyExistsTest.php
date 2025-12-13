<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class KeyExistsTest extends TestCase
{
    /**
     * Tests the keyExists() method with associative array.
     *
     * This test verifies that the keyExists() method correctly checks
     * whether a given string key exists in an associative array,
     * mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод keyExists() корректно проверяет,
     * существует ли заданный строковый ключ в ассоциативном массиве,
     * отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsWithAssociativeArray(): void
    {
        $data = ['name' => 'John', 'age' => 30, 'city' => 'New York'];

        $expected = array_key_exists('name', $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->keyExists('name'));
    }

    /**
     * Tests the keyExists() method with non-existent key in associative array.
     *
     * This test verifies that the keyExists() method correctly returns false
     * for non-existent keys in an associative array, mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() с отсутствующим ключом в ассоциативном массиве.
     *
     * Этот тест проверяет, что метод keyExists() корректно возвращает false
     * для отсутствующих ключей в ассоциативном массиве, отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsWithNonExistentKeyInAssociativeArray(): void
    {
        $data = ['name' => 'John', 'age' => 30, 'city' => 'New York'];

        $expected = array_key_exists('country', $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->keyExists('country'));
    }

    /**
     * Tests the keyExists() method with numeric key.
     *
     * This test verifies that the keyExists() method correctly checks
     * whether a given numeric key exists in an array, mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() с числовым ключом.
     *
     * Этот тест проверяет, что метод keyExists() корректно проверяет,
     * существует ли заданный числовой ключ в массиве, отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsWithNumericKey(): void
    {
        $data = [0 => 'zero', 1 => 'one', 2 => 'two'];

        $expected = array_key_exists(0, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->keyExists(0));
    }

    /**
     * Tests the keyExists() method with non-existent numeric key.
     *
     * This test verifies that the keyExists() method correctly returns false
     * for non-existent numeric keys, mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() с отсутствующим числовым ключом.
     *
     * Этот тест проверяет, что метод keyExists() корректно возвращает false
     * для отсутствующих числовых ключей, отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsWithNonExistentNumericKey(): void
    {
        $data = [0 => 'zero', 1 => 'one', 2 => 'two'];

        $expected = array_key_exists(3, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->keyExists(3));
    }

    /**
     * Tests the keyExists() method with string numeric key.
     *
     * This test verifies that the keyExists() method correctly handles
     * string numeric keys, checking if they exist as string keys,
     * mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() со строковым числовым ключом.
     *
     * Этот тест проверяет, что метод keyExists() корректно обрабатывает
     * строковые числовые ключи, проверяя их существование как строковых ключей,
     * отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsWithStringNumericKey(): void
    {
        $data = ['a' => 'apple', 0 => 'zero', '1' => 'one'];

        $expected = array_key_exists('1', $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->keyExists('1'));
    }

    /**
     * Tests the keyExists() method with integer numeric key when string exists.
     *
     * This test verifies that the keyExists() method correctly distinguishes
     * between integer and string numeric keys, as PHP's array_key_exists() does.
     *
     *
     * Тестирование метода keyExists() с целочисленным ключом, когда существует строковый.
     *
     * Этот тест проверяет, что метод keyExists() корректно различает
     * целочисленные и строковые числовые ключи, как это делает функция array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsWithIntegerNumericKeyWhenStringExists(): void
    {
        $data = ['a' => 'apple', 0 => 'zero', '1' => 'one'];

        $expected = array_key_exists(1, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->keyExists(1));
    }

    /**
     * Tests the keyExists() method with empty array.
     *
     * This test verifies that the keyExists() method correctly returns false
     * for any key in an empty array, mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() с пустым массивом.
     *
     * Этот тест проверяет, что метод keyExists() корректно возвращает false
     * для любого ключа в пустом массиве, отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsWithEmptyArray(): void
    {
        $data = [];

        $expected = array_key_exists('any', $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->keyExists('any'));
    }

    /**
     * Tests the keyExists() method with boolean false key.
     *
     * This test verifies that the keyExists() method correctly handles
     * boolean false as a key (which gets cast to 0), mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() с булевым ключом false.
     *
     * Этот тест проверяет, что метод keyExists() корректно обрабатывает
     * булево значение false в качестве ключа (которое преобразуется в 0), отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsWithBooleanFalseKey(): void
    {
        $data = ['' => 'empty', 0 => 'zero', 1 => 'one'];

        $expected = array_key_exists(false, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->keyExists(false));
    }

    /**
     * Tests the keyExists() method with boolean true key.
     *
     * This test verifies that the keyExists() method correctly handles
     * boolean true as a key (which gets cast to 1), mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() с булевым ключом true.
     *
     * Этот тест проверяет, что метод keyExists() корректно обрабатывает
     * булево значение true в качестве ключа (которое преобразуется в 1), отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsWithBooleanTrueKey(): void
    {
        $data = ['' => 'empty', 0 => 'zero', 1 => 'one'];

        $expected = array_key_exists(true, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->keyExists(true));
    }

    /**
     * Tests the keyExists() method with null key.
     *
     * This test verifies that the keyExists() method correctly handles
     * null as a key (which gets cast to an empty string), mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() с ключом null.
     *
     * Этот тест проверяет, что метод keyExists() корректно обрабатывает
     * null в качестве ключа (которое преобразуется в пустую строку), отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsWithNullKey(): void
    {
        $data = ['' => 'empty', 0 => 'zero', 1 => 'one'];

        $expected = array_key_exists(null, $data);

        $cover = new CoverArray($data);

        $this->assertSame($expected, $cover->keyExists(null));
    }
}