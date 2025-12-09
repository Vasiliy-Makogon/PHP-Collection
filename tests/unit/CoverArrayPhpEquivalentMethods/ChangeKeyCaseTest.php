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
     * Tests the changeKeyCase() method (array_change_key_case equivalent).
     *
     * This test verifies that the changeKeyCase() method correctly changes
     * the case of all keys in the CoverArray to either uppercase or lowercase,
     * mirroring the behavior of PHP's array_change_key_case() function.
     *
     *
     * Тестирование метода changeKeyCase() (эквивалент array_change_key_case).
     *
     * Этот тест проверяет, что метод changeKeyCase() корректно изменяет
     * регистр всех ключей в CoverArray в верхний или нижний регистр,
     * отражая поведение функции array_change_key_case() PHP.
     *
     * @see CoverArray::changeKeyCase()
     * @see array_change_key_case()
     */
    public function testChangeKeyCaseMethod(): void
    {
        // Test changing keys to lowercase (default)
        // Тест изменения ключей в нижний регистр (по умолчанию)
        $data1 = ['Apple' => 1, 'Banana' => 2, 'Cherry' => 3];

        $expected1 = array_change_key_case($data1, CASE_LOWER);

        $cover1 = new CoverArray($data1);
        $this->assertSame(
            $expected1,
            $cover1->changeKeyCase(CASE_LOWER)->getDataAsArray()
        );

        // Test changing keys to uppercase
        // Тест изменения ключей в верхний регистр
        $data2 = ['apple' => 1, 'banana' => 2, 'cherry' => 3];

        $expected2 = array_change_key_case($data2, CASE_UPPER);

        $cover2 = new CoverArray($data2);
        $this->assertSame(
            $expected2,
            $cover2->changeKeyCase(CASE_UPPER)->getDataAsArray()
        );

        // Test with mixed case keys to lowercase
        // Тест с ключами в смешанном регистре в нижний регистр
        $data3 = ['Apple' => 1, 'BANANA' => 2, 'cherry' => 3];

        $expected3 = array_change_key_case($data3, CASE_LOWER);

        $cover3 = new CoverArray($data3);
        $this->assertSame(
            $expected3,
            $cover3->changeKeyCase(CASE_LOWER)->getDataAsArray()
        );

        // Test with numeric keys (should remain unchanged)
        // Тест с числовыми ключами (должны остаться без изменений)
        $data4 = [0 => 'zero', 'Apple' => 1, 1 => 'one'];

        $expected4 = array_change_key_case($data4, CASE_UPPER);

        $cover4 = new CoverArray($data4);
        $this->assertSame(
            $expected4,
            $cover4->changeKeyCase(CASE_UPPER)->getDataAsArray()
        );

        // Test with special characters in keys
        // Тест со специальными символами в ключах
        $data5 = ['foo-bar' => 1, 'test_key' => 2, 'привет' => 3];

        $expected5 = array_change_key_case($data5, CASE_UPPER);

        $cover5 = new CoverArray($data5);
        $this->assertSame(
            $expected5,
            $cover5->changeKeyCase(CASE_UPPER)->getDataAsArray()
        );
    }
}