<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ValueError;

#[CoversClass(CoverArray::class)]
class RandTest extends TestCase
{
    /**
     * Tests the rand() method (array_rand equivalent).
     *
     * This test verifies that the rand() method correctly returns
     * random key(s) from the CoverArray, with optional number of
     * entries to pick, mirroring PHP's array_rand() function behavior.
     *
     *
     * Тестирование метода rand() (эквивалент array_rand).
     *
     * Этот тест проверяет, что метод rand() корректно возвращает
     * случайный(ые) ключ(и) из CoverArray, с опциональным количеством
     * выбираемых записей, отражая поведение функции array_rand() PHP.
     *
     * @see CoverArray::rand()
     * @see array_rand()
     */
    public function testRandMethod(): void
    {
        // Test with single random element (default behavior)
        // Тест с одним случайным элементом (поведение по умолчанию)
        $data1 = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];
        $cover1 = new CoverArray($data1);
        $result1 = $cover1->rand();
        $this->assertContains($result1, array_keys($data1));

        // Test with multiple random elements
        // Тест с несколькими случайными элементами
        $data2 = ['PHP', 'MySql', 'HTML', 'CSS', 'JavaScript'];
        $num2 = 3;
        $cover2 = new CoverArray($data2);
        $result2 = $cover2->rand($num2);

        // Verify we got a CoverArray with the correct number of elements
        // Проверяем, что получили CoverArray с правильным количеством элементов
        $this->assertInstanceOf(CoverArray::class, $result2);
        $this->assertCount($num2, $result2);

        // Verify all returned keys are valid and unique
        // Проверяем, что все возвращенные ключи валидны и уникальны
        $resultArray = $result2->getDataAsArray();
        foreach ($resultArray as $key) {
            $this->assertArrayHasKey($key, $data2);
        }
        $this->assertCount($num2, array_unique($resultArray));

        // Test with all elements requested (should return all keys shuffled)
        // Тест с запросом всех элементов (должен вернуть все ключи в перемешанном порядке)
        $data3 = ['x' => 1, 'y' => 2, 'z' => 3];
        $num3 = 3;
        $cover3 = new CoverArray($data3);
        $result3 = $cover3->rand($num3);

        $this->assertInstanceOf(CoverArray::class, $result3);
        $this->assertCount($num3, $result3);

        // Verify all keys are present
        // Проверяем, что все ключи присутствуют
        $resultArray3 = $result3->getDataAsArray();
        $this->assertEqualsCanonicalizing(array_keys($data3), $resultArray3);

        // Test with associative array
        // Тест с ассоциативным массивом
        $data4 = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk'];
        $expected4 = array_rand($data4, 2);

        $cover4 = new CoverArray($data4);
        $result4 = $cover4->rand(2);

        $this->assertInstanceOf(CoverArray::class, $result4);
        $this->assertCount(2, $result4);

        $resultArray4 = $result4->getDataAsArray();
        foreach ($resultArray4 as $key) {
            $this->assertArrayHasKey($key, $data4);
        }

        // Test with numeric indexed array
        // Тест с числовым индексированным массивом
        $data5 = ['PHP', 'MySql', 'HTML', 'CSS', 'JavaScript'];
        $num5 = 1;

        $cover5 = new CoverArray($data5);
        $result5 = $cover5->rand($num5);

        // When num=1, array_rand returns a single value, not an array
        // Когда num=1, array_rand возвращает одиночное значение, а не массив
        $this->assertIsInt($result5);
        $this->assertArrayHasKey($result5, $data5);

        // Test with empty array
        // Тест с пустым массивом
        $data6 = [];
        $cover6 = new CoverArray($data6);

        // With empty array and num=1
        // С пустым массивом и num=1
        $this->expectException(ValueError::class);
        $cover6->rand(1);

        // Test that original array is not modified
        // Тест, что исходный массив не изменяется
        $data7 = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $cover7 = new CoverArray($data7);

        $before = $cover7->getDataAsArray();
        $cover7->rand(2);
        $after = $cover7->getDataAsArray();

        $this->assertSame($before, $after, 'Original array should not be modified');

        // Test with single element array
        // Тест с массивом из одного элемента
        $data8 = ['only' => 'element'];
        $cover8 = new CoverArray($data8);
        $result8 = $cover8->rand();

        $this->assertSame('only', $result8);
    }
}