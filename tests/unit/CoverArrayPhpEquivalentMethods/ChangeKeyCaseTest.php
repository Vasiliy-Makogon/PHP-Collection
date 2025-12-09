<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class ChangeKeyCaseTest extends TestCase
{
    /**
     * Tests the changeKeyCase() method changing keys to lowercase.
     *
     * This test verifies that the changeKeyCase() method correctly changes
     * the case of all string keys in the CoverArray to lowercase,
     * mirroring the behavior of PHP's array_change_key_case() function
     * with CASE_LOWER flag.
     *
     *
     * Тестирование метода changeKeyCase() с изменением ключей в нижний регистр.
     *
     * Этот тест проверяет, что метод changeKeyCase() корректно изменяет
     * регистр всех строковых ключей в CoverArray в нижний регистр,
     * отражая поведение функции array_change_key_case() PHP
     * с флагом CASE_LOWER.
     *
     * @see CoverArray::changeKeyCase()
     * @see array_change_key_case()
     */
    public function testChangeKeyCaseToLowercase(): void
    {
        // Test changing keys to lowercase (default)
        // Тест изменения ключей в нижний регистр (по умолчанию)
        $data = ['Apple' => 1, 'Banana' => 2, 'Cherry' => 3];

        $expected = array_change_key_case($data, CASE_LOWER);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->changeKeyCase(CASE_LOWER)->getDataAsArray()
        );
    }

    /**
     * Tests the changeKeyCase() method changing keys to uppercase.
     *
     * This test verifies that the changeKeyCase() method correctly changes
     * the case of all string keys in the CoverArray to uppercase,
     * mirroring the behavior of PHP's array_change_key_case() function
     * with CASE_UPPER flag.
     *
     *
     * Тестирование метода changeKeyCase() с изменением ключей в верхний регистр.
     *
     * Этот тест проверяет, что метод changeKeyCase() корректно изменяет
     * регистр всех строковых ключей в CoverArray в верхний регистр,
     * отражая поведение функции array_change_key_case() PHP
     * с флагом CASE_UPPER.
     *
     * @see CoverArray::changeKeyCase()
     * @see array_change_key_case()
     */
    public function testChangeKeyCaseToUppercase(): void
    {
        // Test changing keys to uppercase
        // Тест изменения ключей в верхний регистр
        $data = ['apple' => 1, 'banana' => 2, 'cherry' => 3];

        $expected = array_change_key_case($data, CASE_UPPER);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->changeKeyCase(CASE_UPPER)->getDataAsArray()
        );
    }

    /**
     * Tests the changeKeyCase() method with mixed case keys.
     *
     * This test verifies that the changeKeyCase() method correctly handles
     * keys with mixed case, converting them consistently to lowercase,
     * mirroring the behavior of PHP's array_change_key_case() function.
     *
     *
     * Тестирование метода changeKeyCase() с ключами в смешанном регистре.
     *
     * Этот тест проверяет, что метод changeKeyCase() корректно обрабатывает
     * ключи в смешанном регистре, преобразуя их последовательно в нижний регистр,
     * отражая поведение функции array_change_key_case() PHP.
     *
     * @see CoverArray::changeKeyCase()
     * @see array_change_key_case()
     */
    public function testChangeKeyCaseWithMixedCaseKeys(): void
    {
        // Test with mixed case keys to lowercase
        // Тест с ключами в смешанном регистре в нижний регистр
        $data = ['Apple' => 1, 'BANANA' => 2, 'cherry' => 3];

        $expected = array_change_key_case($data, CASE_LOWER);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->changeKeyCase(CASE_LOWER)->getDataAsArray()
        );
    }

    /**
     * Tests the changeKeyCase() method with numeric keys.
     *
     * This test verifies that the changeKeyCase() method correctly leaves
     * numeric keys unchanged, as PHP's array_change_key_case() function
     * only affects string keys.
     *
     *
     * Тестирование метода changeKeyCase() с числовыми ключами.
     *
     * Этот тест проверяет, что метод changeKeyCase() корректно оставляет
     * числовые ключи без изменений, так как функция array_change_key_case() PHP
     * воздействует только на строковые ключи.
     *
     * @see CoverArray::changeKeyCase()
     * @see array_change_key_case()
     */
    public function testChangeKeyCaseWithNumericKeys(): void
    {
        // Test with numeric keys (should remain unchanged)
        // Тест с числовыми ключами (должны остаться без изменений)
        $data = [0 => 'zero', 'Apple' => 1, 1 => 'one'];

        $expected = array_change_key_case($data, CASE_UPPER);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->changeKeyCase(CASE_UPPER)->getDataAsArray()
        );
    }

    /**
     * Tests the changeKeyCase() method with special characters in keys.
     *
     * This test verifies that the changeKeyCase() method correctly handles
     * keys containing special characters, hyphens, underscores, and non-ASCII
     * characters, mirroring the behavior of PHP's array_change_key_case() function.
     *
     *
     * Тестирование метода changeKeyCase() со специальными символами в ключах.
     *
     * Этот тест проверяет, что метод changeKeyCase() корректно обрабатывает
     * ключи, содержащие специальные символы, дефисы, подчеркивания и не-ASCII
     * символы, отражая поведение функции array_change_key_case() PHP.
     *
     * @see CoverArray::changeKeyCase()
     * @see array_change_key_case()
     */
    public function testChangeKeyCaseWithSpecialCharacters(): void
    {
        // Test with special characters in keys
        // Тест со специальными символами в ключах
        $data = ['foo-bar' => 1, 'test_key' => 2, 'привет' => 3];

        $expected = array_change_key_case($data, CASE_UPPER);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->changeKeyCase(CASE_UPPER)->getDataAsArray()
        );
    }

    /**
     * Tests the changeKeyCase() method with empty array.
     *
     * This test verifies that the changeKeyCase() method correctly handles
     * empty arrays, returning an empty array without errors, mirroring
     * the behavior of PHP's array_change_key_case() function.
     *
     *
     * Тестирование метода changeKeyCase() с пустым массивом.
     *
     * Этот тест проверяет, что метод changeKeyCase() корректно обрабатывает
     * пустые массивы, возвращая пустой массив без ошибок, отражая
     * поведение функции array_change_key_case() PHP.
     *
     * @see CoverArray::changeKeyCase()
     * @see array_change_key_case()
     */
    public function testChangeKeyCaseWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];

        $expected = array_change_key_case($data, CASE_LOWER);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->changeKeyCase(CASE_LOWER)->getDataAsArray()
        );
    }

    /**
     * Tests the changeKeyCase() method with associative array containing various key types.
     *
     * This test verifies that the changeKeyCase() method correctly handles
     * associative arrays with various key types, converting only string keys
     * while preserving numeric and other key types, mirroring the behavior
     * of PHP's array_change_key_case() function.
     *
     *
     * Тестирование метода changeKeyCase() с ассоциативным массивом, содержащим различные типы ключей.
     *
     * Этот тест проверяет, что метод changeKeyCase() корректно обрабатывает
     * ассоциативные массивы с различными типами ключей, преобразуя только строковые ключи
     * и сохраняя числовые и другие типы ключей, отражая поведение
     * функции array_change_key_case() PHP.
     *
     * @see CoverArray::changeKeyCase()
     * @see array_change_key_case()
     */
    public function testChangeKeyCaseWithVariousKeyTypes(): void
    {
        // Test with various key types
        // Тест с различными типами ключей
        $data = [
            'StringKey' => 1,
            42 => 2,
            'ANOTHER_KEY' => 3,
            'camelCaseKey' => 4,
            0 => 5,
            'PascalCaseKey' => 6
        ];

        $expected = array_change_key_case($data, CASE_LOWER);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->changeKeyCase(CASE_LOWER)->getDataAsArray()
        );
    }
}