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
     * Tests the keyExists() method (array_key_exists equivalent).
     *
     * This test verifies that the keyExists() method correctly checks
     * whether a given key or index exists in the CoverArray,
     * mirroring PHP's array_key_exists() function behavior.
     *
     *
     * Тестирование метода keyExists() (эквивалент array_key_exists).
     *
     * Этот тест проверяет, что метод keyExists() корректно проверяет,
     * существует ли заданный ключ или индекс в CoverArray,
     * отражая поведение функции array_key_exists() PHP.
     *
     * @see CoverArray::keyExists()
     * @see array_key_exists()
     */
    public function testKeyExistsMethod(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data1 = ['name' => 'John', 'age' => 30, 'city' => 'New York'];

        $expected1 = array_key_exists('name', $data1);
        $expected2 = array_key_exists('country', $data1);

        $cover1 = new CoverArray($data1);

        $this->assertSame($expected1, $cover1->keyExists('name'));
        $this->assertSame($expected2, $cover1->keyExists('country'));

        // Test with numeric keys
        // Тест с числовыми ключами
        $data2 = [0 => 'zero', 1 => 'one', 2 => 'two'];

        $expected3 = array_key_exists(0, $data2);
        $expected4 = array_key_exists(3, $data2);

        $cover2 = new CoverArray($data2);

        $this->assertSame($expected3, $cover2->keyExists(0));
        $this->assertSame($expected4, $cover2->keyExists(3));

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data3 = ['a' => 'apple', 0 => 'zero', '1' => 'one'];

        $expected5 = array_key_exists('a', $data3);
        $expected6 = array_key_exists(0, $data3);
        $expected7 = array_key_exists('1', $data3);
        $expected8 = array_key_exists(1, $data3);

        $cover3 = new CoverArray($data3);

        $this->assertSame($expected5, $cover3->keyExists('a'));
        $this->assertSame($expected6, $cover3->keyExists(0));
        $this->assertSame($expected7, $cover3->keyExists('1'));
        $this->assertSame($expected8, $cover3->keyExists(1));

        // Test with empty array
        // Тест с пустым массивом
        $data4 = [];

        $expected9 = array_key_exists('any', $data4);

        $cover4 = new CoverArray($data4);

        $this->assertSame($expected9, $cover4->keyExists('any'));

        // Test with boolean and null keys
        // Тест с булевыми и null ключами
        $data5 = ['' => 'empty', 0 => 'zero', 1 => 'one'];

        $expected10 = array_key_exists(false, $data5);
        $expected11 = array_key_exists(true, $data5);
        $expected12 = array_key_exists(null, $data5);

        $cover5 = new CoverArray($data5);

        $this->assertSame($expected10, $cover5->keyExists(false));
        $this->assertSame($expected11, $cover5->keyExists(true));
        $this->assertSame($expected12, $cover5->keyExists(null));
    }
}