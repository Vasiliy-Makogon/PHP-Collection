<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class PopTest extends TestCase
{
    /**
     * Tests the pop() method (array_pop equivalent).
     *
     * This test verifies that the pop() method correctly removes
     * and returns the last element of the CoverArray, shortening
     * the array by one element, mirroring PHP's array_pop() function.
     *
     *
     * Тестирование метода pop() (эквивалент array_pop).
     *
     * Этот тест проверяет, что метод pop() корректно удаляет
     * и возвращает последний элемент CoverArray, уменьшая
     * массив на один элемент, отражая поведение функции array_pop() PHP.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopMethod(): void
    {
        // Test popping from a sequential array
        // Тест извлечения из последовательного массива
        $data1 = [1, 2, 3];
        $expectedArray1 = $data1;
        $expectedValue1 = array_pop($expectedArray1);

        $cover1 = new CoverArray($data1);
        $actualValue1 = $cover1->pop();

        $this->assertSame($expectedValue1, $actualValue1);
        $this->assertSame($expectedArray1, $cover1->getDataAsArray());

        // Test popping from an associative array
        // Тест извлечения из ассоциативного массива
        $data2 = ['a' => 1, 'b' => 2, 'c' => 3];
        $expectedArray2 = $data2;
        $expectedValue2 = array_pop($expectedArray2);

        $cover2 = new CoverArray($data2);
        $actualValue2 = $cover2->pop();

        $this->assertSame($expectedValue2, $actualValue2);
        $this->assertSame($expectedArray2, $cover2->getDataAsArray());

        // Test popping from an empty array (should return null)
        // Тест извлечения из пустого массива (должен вернуть null)
        $data3 = [];
        $expectedArray3 = $data3;
        $expectedValue3 = array_pop($expectedArray3);

        $cover3 = new CoverArray($data3);
        $actualValue3 = $cover3->pop();

        $this->assertSame($expectedValue3, $actualValue3);
        $this->assertSame($expectedArray3, $cover3->getDataAsArray());

        // Test popping from an array with one element
        // Тест извлечения из массива с одним элементом
        $data4 = ['single'];
        $expectedArray4 = $data4;
        $expectedValue4 = array_pop($expectedArray4);

        $cover4 = new CoverArray($data4);
        $actualValue4 = $cover4->pop();

        // original function
        // оригинальная функция
        $this->assertSame($expectedValue4, $actualValue4);
        $this->assertSame($expectedArray4, $cover4->getDataAsArray());

        // Test popping with mixed value types
        // Тест извлечения со смешанными типами значений
        $data5 = ['string', 123, null, false];
        $expectedArray5 = $data5;
        $expectedValue5 = array_pop($expectedArray5);

        $cover5 = new CoverArray($data5);
        $actualValue5 = $cover5->pop();

        $this->assertSame($expectedValue5, $actualValue5);
        $this->assertSame($expectedArray5, $cover5->getDataAsArray());

        // Test popping array value (CoverArray should convert it to CoverArray)
        // Тест извлечения значения-массива (CoverArray должен преобразовать его в CoverArray)
        $data6 = [1, 2, ['nested' => 'value']];
        $expectedArray6 = $data6;
        $expectedValue6 = array_pop($expectedArray6);

        $cover6 = new CoverArray($data6);
        $actualValue6 = $cover6->pop();

        // Проверяем, что возвращенный объект является CoverArray и содержит правильные данные
        $this->assertInstanceOf(CoverArray::class, $actualValue6);
        $this->assertSame($expectedValue6, $actualValue6->getDataAsArray());
        $this->assertSame($expectedArray6, $cover6->getDataAsArray());

        // Test that pop() modifies the original array
        // Тест, что pop() изменяет исходный массив
        $data7 = [10, 20, 30, 40];
        $cover7 = new CoverArray($data7);

        // Первый pop
        $firstPop = $cover7->pop();
        $this->assertSame(40, $firstPop);
        $this->assertSame([10, 20, 30], $cover7->getDataAsArray());

        // Второй pop
        $secondPop = $cover7->pop();
        $this->assertSame(30, $secondPop);
        $this->assertSame([10, 20], $cover7->getDataAsArray());

        // Третий pop
        $thirdPop = $cover7->pop();
        $this->assertSame(20, $thirdPop);
        $this->assertSame([10], $cover7->getDataAsArray());

        // Четвертый pop
        $fourthPop = $cover7->pop();
        $this->assertSame(10, $fourthPop);
        $this->assertSame([], $cover7->getDataAsArray());

        // Пятый pop (из пустого массива)
        $fifthPop = $cover7->pop();
        $this->assertNull($fifthPop);
        $this->assertSame([], $cover7->getDataAsArray());

        // Test popping from array with numeric string keys
        // Тест извлечения из массива с числовыми строковыми ключами
        $data8 = ['0' => 'a', '1' => 'b', '2' => 'c'];
        $expectedArray8 = $data8;
        $expectedValue8 = array_pop($expectedArray8);

        $cover8 = new CoverArray($data8);
        $actualValue8 = $cover8->pop();

        $this->assertSame($expectedValue8, $actualValue8);
        $this->assertSame($expectedArray8, $cover8->getDataAsArray());
    }
}