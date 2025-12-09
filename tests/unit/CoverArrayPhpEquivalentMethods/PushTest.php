<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class PushTest extends TestCase
{
    /**
     * Tests the push() method (array_push equivalent, alias for append()).
     *
     * This test verifies that the push() method correctly adds
     * one or more elements to the end of the CoverArray, mirroring
     * PHP's array_push() function behavior. This is an alias for append().
     *
     *
     * Тестирование метода push() (эквивалент array_push, псевдоним для append()).
     *
     * Этот тест проверяет, что метод push() корректно добавляет
     * один или несколько элементов в конец CoverArray, отражая
     * поведение функции array_push() PHP. Это псевдоним для append().
     *
     * @see CoverArray::push()
     * @see CoverArray::append()
     * @see array_push()
     */
    public function testPushMethod(): void
    {
        // Test pushing single element
        // Тест добавления одного элемента
        $data1 = [1, 2, 3];
        $expected1 = $data1;
        array_push($expected1, 4);

        $cover1 = new CoverArray($data1);
        $cover1->push(4);

        $this->assertSame($expected1, $cover1->getDataAsArray());

        // Test pushing multiple elements
        // Тест добавления нескольких элементов
        $data2 = [1, 2, 3];
        $expected2 = $data2;
        array_push($expected2, 4, 5, 6);

        $cover2 = new CoverArray($data2);
        $cover2->push(4, 5, 6);

        $this->assertSame($expected2, $cover2->getDataAsArray());

        // Test that push is an alias for append (same behavior)
        // Тест, что push является псевдонимом для append (одинаковое поведение)
        $data3 = ['a', 'b', 'c'];
        $expected3 = $data3;
        array_push($expected3, 'd', 'e');

        $cover3a = new CoverArray($data3);
        $cover3b = new CoverArray($data3);

        $cover3a->append('d', 'e');
        $cover3b->push('d', 'e');

        $this->assertSame($expected3, $cover3a->getDataAsArray());
        $this->assertSame($expected3, $cover3b->getDataAsArray());
        $this->assertSame($cover3a->getDataAsArray(), $cover3b->getDataAsArray());

        // Test pushing with different types
        // Тест добавления с разными типами
        $data4 = [1];
        $expected4 = $data4;
        array_push($expected4, 'string', 2.5, null, false);

        $cover4 = new CoverArray($data4);
        $cover4->push('string', 2.5, null, false);

        $this->assertSame($expected4, $cover4->getDataAsArray());

        // Test pushing array (should be converted to CoverArray)
        // Тест добавления массива (должен быть преобразован в CoverArray)
        $data5 = ['first'];
        $arrayValue = ['nested' => ['key' => 'value']];

        // Используем array_push для получения ожидаемого результата
        $expected5 = $data5;
        array_push($expected5, $arrayValue);

        $cover5 = new CoverArray($data5);
        $cover5->push($arrayValue);

        // Проверяем первый элемент
        $this->assertSame($expected5[0], $cover5->item(0));

        // Проверяем, что второй элемент является CoverArray и содержит правильные данные
        $secondElement = $cover5->item(1);
        $this->assertInstanceOf(CoverArray::class, $secondElement);
        $this->assertSame($arrayValue, $secondElement->getDataAsArray());

        // Test pushing to empty array
        // Тест добавления в пустой массив
        $data6 = [];
        $expected6 = $data6;
        array_push($expected6, 'apple', 'banana', 'cherry');

        $cover6 = new CoverArray($data6);
        $cover6->push('apple', 'banana', 'cherry');

        $this->assertSame($expected6, $cover6->getDataAsArray());

        // Test that method returns same instance (for chaining)
        // Тест, что метод возвращает тот же экземпляр (для цепочки вызовов)
        $data7 = [10, 20];
        $cover7 = new CoverArray($data7);

        $returned = $cover7->push(30);
        $this->assertSame($cover7, $returned);

        // Test chaining push calls
        // Тест цепочки вызовов push
        $data8 = ['start'];
        $expected8 = $data8;
        array_push($expected8, 'middle1', 'middle2', 'end1', 'end2');

        $cover8 = new CoverArray($data8);
        $cover8->push('middle1', 'middle2')->push('end1', 'end2');

        $this->assertSame($expected8, $cover8->getDataAsArray());

        // Test pushing with associative array (keys are preserved for string keys, numeric reindexed)
        // Тест добавления с ассоциативным массивом (строковые ключи сохраняются, числовые переиндексируются)
        $data9 = ['a' => 'apple', 'b' => 'banana'];
        $expected9 = $data9;
        array_push($expected9, 'cherry', 'date');

        $cover9 = new CoverArray($data9);
        $cover9->push('cherry', 'date');

        $this->assertSame($expected9, $cover9->getDataAsArray());
    }
}