<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class KeysTest extends TestCase
{
    /**
     * Tests the keys() method (array_keys equivalent).
     *
     * This test verifies that the keys() method correctly returns
     * all or a subset of keys from the CoverArray, optionally filtered
     * by value, mirroring PHP's array_keys() function behavior.
     *
     *
     * Тестирование метода keys() (эквивалент array_keys).
     *
     * Этот тест проверяет, что метод keys() корректно возвращает
     * все или подмножество ключей из CoverArray, опционально фильтруя
     * по значению, отражая поведение функции array_keys() PHP.
     *
     * @see CoverArray::keys()
     * @see array_keys()
     */
    public function testKeysMethod(): void
    {
        // Test getting all keys from associative array
        // Тест получения всех ключей из ассоциативного массива
        $data1 = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk', 'street' => 'Kirov st.'];

        $expected1 = array_keys($data1);

        // CoverArray method
        // метод CoverArray
        $cover1 = new CoverArray($data1);
        $this->assertSame($expected1, $cover1->keys()->getDataAsArray());

        // Test getting all keys from nested array structure
        // Тест получения всех ключей из вложенной структуры массива
        $data2 = [
            'backend' => ['PHP', 'MySql'],
            'frontend' => ['HTML', 'CSS', 'JavaScript']
        ];

        $expected2 = array_keys($data2);

        // CoverArray method
        // метод CoverArray
        $cover2 = new CoverArray($data2);
        $this->assertSame($expected2, $cover2->keys()->getDataAsArray());

        // Test getting keys filtered by value with strict comparison
        // Тест получения ключей, отфильтрованных по значению с строгим сравнением
        $data3 = ['PHP', 'MySql'];

        $expected3 = array_keys($data3, 'PHP', true);

        // CoverArray method
        // метод CoverArray
        $cover3 = new CoverArray($data3);
        $this->assertSame($expected3, $cover3->keys('PHP', true)->getDataAsArray());

        // Test getting keys filtered by value with loose comparison
        // Тест получения ключей, отфильтрованных по значению с нестрогим сравнением
        $data4 = [0 => '0', 1 => 0, 2 => false, 3 => null, 4 => ''];

        $expected4 = array_keys($data4, '0', false);

        // CoverArray method
        // метод CoverArray
        $cover4 = new CoverArray($data4);
        $this->assertSame($expected4, $cover4->keys('0', false)->getDataAsArray());

        $expected5 = array_keys($data4, '0', true);
        $this->assertSame($expected5, $cover4->keys('0', true)->getDataAsArray());

        // Test with empty array
        // Тест с пустым массивом
        $data5 = [];

        $expected6 = array_keys($data5);
        $expected7 = array_keys($data5, 'value', true);

        // CoverArray method
        // метод CoverArray
        $cover5 = new CoverArray($data5);
        $this->assertSame($expected6, $cover5->keys()->getDataAsArray());
        $this->assertSame($expected7, $cover5->keys('value', true)->getDataAsArray());

        // Test with duplicate values
        // Тест с дублирующимися значениями
        $data6 = ['a' => 'apple', 'b' => 'banana', 'c' => 'apple', 'd' => 'cherry', 'e' => 'apple'];

        $expected8 = array_keys($data6, 'apple', true);

        // CoverArray method
        // метод CoverArray
        $cover6 = new CoverArray($data6);
        $this->assertSame($expected8, $cover6->keys('apple', true)->getDataAsArray());

        // Test with numeric keys
        // Тест с числовыми ключами
        $data7 = [10 => 'ten', 20 => 'twenty', 30 => 'thirty', 40 => 'forty'];

        $expected9 = array_keys($data7);
        $expected10 = array_keys($data7, 'thirty', true);

        // CoverArray method
        // метод CoverArray
        $cover7 = new CoverArray($data7);
        $this->assertSame($expected9, $cover7->keys()->getDataAsArray());
        $this->assertSame($expected10, $cover7->keys('thirty', true)->getDataAsArray());

        // Test with mixed key types
        // Тест со смешанными типами ключей
        $data8 = ['a' => 1, 0 => 2, 'c' => 1, 1 => 2];

        $expected11 = array_keys($data8, 1, true);
        $expected12 = array_keys($data8, 2, true);

        // CoverArray method
        // метод CoverArray
        $cover8 = new CoverArray($data8);
        $this->assertSame($expected11, $cover8->keys(1, true)->getDataAsArray());
        $this->assertSame($expected12, $cover8->keys(2, true)->getDataAsArray());
    }
}