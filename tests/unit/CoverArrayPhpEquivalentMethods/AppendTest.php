<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class AppendTest extends TestCase
{
    /**
     * Tests the append() method (array_push equivalent).
     *
     * This test verifies that the append() method correctly adds
     * one or more elements to the end of the CoverArray, mirroring
     * PHP's array_push() function behavior.
     *
     *
     * Тестирование метода append() (эквивалент array_push).
     *
     * Этот тест проверяет, что метод append() корректно добавляет
     * один или несколько элементов в конец CoverArray, отражая
     * поведение функции array_push() PHP.
     *
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testAppendMethod(): void
    {
        // Test appending single element
        // Тест добавления одного элемента
        $data1 = [1, 2, 3];
        $expected1 = $data1;
        array_push($expected1, 4);

        $cover1 = new CoverArray($data1);
        $cover1->append(4);

        $this->assertSame($expected1, $cover1->getDataAsArray());

        // Test appending multiple elements
        // Тест добавления нескольких элементов
        $data2 = [1, 2, 3];
        $expected2 = $data2;
        array_push($expected2, 4, 5, 6);

        $cover2 = new CoverArray($data2);
        $cover2->append(4, 5, 6);

        $this->assertSame($expected2, $cover2->getDataAsArray());

        // Test appending with different types
        // Тест добавления с разными типами
        $data3 = ['a', 'b'];
        $expected3 = $data3;
        array_push($expected3, 'c', 1, true, null);

        $cover3 = new CoverArray($data3);
        $cover3->append('c', 1, true, null);

        $this->assertSame($expected3, $cover3->getDataAsArray());

        // Test appending array (should be converted to CoverArray)
        // Тест добавления массива (должен быть преобразован в CoverArray)
        $data4 = [1, 2];
        $arrayValue = ['nested' => 'value'];

        // Используем array_push для получения ожидаемого результата
        // но будем проверять поэлементно, так как array_push не преобразует вложенные массивы
        $expected4 = $data4;
        array_push($expected4, $arrayValue);

        $cover4 = new CoverArray($data4);
        $cover4->append($arrayValue);

        // Проверяем первые два элемента
        $this->assertSame($expected4[0], $cover4->item(0));
        $this->assertSame($expected4[1], $cover4->item(1));

        // Проверяем, что третий элемент является CoverArray и содержит правильные данные
        $thirdElement = $cover4->item(2);
        $this->assertInstanceOf(CoverArray::class, $thirdElement);
        $this->assertSame($arrayValue, $thirdElement->getDataAsArray());

        // Test appending to empty array
        // Тест добавления в пустой массив
        $data5 = [];
        $expected5 = $data5;
        array_push($expected5, 'first', 'second');

        $cover5 = new CoverArray($data5);
        $cover5->append('first', 'second');

        $this->assertSame($expected5, $cover5->getDataAsArray());

        // Test appending with numeric string keys
        // Тест добавления с числовыми строковыми ключами
        $data6 = [0 => 'zero', 1 => 'one'];
        $expected6 = $data6;
        array_push($expected6, 'two', 'three');

        $cover6 = new CoverArray($data6);
        $cover6->append('two', 'three');

        $this->assertSame($expected6, $cover6->getDataAsArray());

        // Test that method returns same instance (for chaining)
        // Тест, что метод возвращает тот же экземпляр (для цепочки вызовов)
        $data7 = [1, 2];
        $cover7 = new CoverArray($data7);

        $returned = $cover7->append(3);
        $this->assertSame($cover7, $returned);

        // Test chaining append calls
        // Тест цепочки вызовов append
        $data8 = [1];
        $expected8 = $data8;
        array_push($expected8, 2, 3, 4, 5);

        $cover8 = new CoverArray($data8);
        $cover8->append(2)->append(3, 4)->append(5);

        $this->assertSame($expected8, $cover8->getDataAsArray());

        // Test appending with associative array (push reindexes numeric keys)
        // Тест добавления с ассоциативным массивом (push переиндексирует числовые ключи)
        $data9 = ['a' => 1, 'b' => 2];
        $expected9 = $data9;
        array_push($expected9, 3, 4);

        $cover9 = new CoverArray($data9);
        $cover9->append(3, 4);

        $this->assertSame($expected9, $cover9->getDataAsArray());

        // Test appending with false, 0, empty string
        // Тест добавления с false, 0, пустой строкой
        $data10 = ['first'];
        $expected10 = $data10;
        array_push($expected10, false, 0, '');

        $cover10 = new CoverArray($data10);
        $cover10->append(false, 0, '');

        $this->assertSame($expected10, $cover10->getDataAsArray());
    }
}