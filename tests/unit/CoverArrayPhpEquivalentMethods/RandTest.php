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
     * Tests the rand() method with single random element (default behavior).
     *
     * This test verifies that the rand() method correctly returns a single
     * random key from an associative array when called without specifying
     * the number of elements, mirroring PHP's array_rand() function behavior.
     *
     *
     * Тестирование метода rand() с одним случайным элементом (поведение по умолчанию).
     *
     * Этот тест проверяет, что метод rand() корректно возвращает один
     * случайный ключ из ассоциативного массива при вызове без указания
     * количества элементов, отражая поведение функции array_rand() PHP.
     *
     * @see CoverArray::rand()
     * @see array_rand()
     */
    public function testRandSingleElementDefault(): void
    {
        // Test with single random element (default behavior)
        // Тест с одним случайным элементом (поведение по умолчанию)
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry', 'd' => 'date'];

        $expected = array_rand($data);

        $cover = new CoverArray($data);
        $result = $cover->rand();

        $this->assertContains($result, array_keys($data));
    }

    /**
     * Tests the rand() method with multiple random elements.
     *
     * This test verifies that the rand() method correctly returns a
     * CoverArray containing multiple random keys when requested,
     * mirroring PHP's array_rand() function behavior.
     *
     *
     * Тестирование метода rand() с несколькими случайными элементами.
     *
     * Этот тест проверяет, что метод rand() корректно возвращает
     * CoverArray, содержащий несколько случайных ключей, когда запрошено,
     * отражая поведение функции array_rand() PHP.
     *
     * @see CoverArray::rand()
     * @see array_rand()
     */
    public function testRandMultipleElements(): void
    {
        // Test with multiple random elements
        // Тест с несколькими случайными элементами
        $data = ['PHP', 'MySql', 'HTML', 'CSS', 'JavaScript'];
        $num = 3;

        $expected = array_rand($data, $num);

        $cover = new CoverArray($data);
        $result = $cover->rand($num);

        // Verify we got a CoverArray with the correct number of elements
        // Проверяем, что получили CoverArray с правильным количеством элементов
        $this->assertInstanceOf(CoverArray::class, $result);
        $this->assertCount($num, $result);

        // Verify all returned keys are valid and unique
        // Проверяем, что все возвращенные ключи валидны и уникальны
        $resultArray = $result->getDataAsArray();
        foreach ($resultArray as $key) {
            $this->assertArrayHasKey($key, $data);
        }
        $this->assertCount($num, array_unique($resultArray));
    }

    /**
     * Tests the rand() method requesting all elements.
     *
     * This test verifies that the rand() method correctly returns a
     * CoverArray containing all keys from the original array in random order
     * when the requested number equals the array size.
     *
     *
     * Тестирование метода rand() с запросом всех элементов.
     *
     * Этот тест проверяет, что метод rand() корректно возвращает
     * CoverArray, содержащий все ключи из исходного массива в случайном порядке,
     * когда запрошенное количество равно размеру массива.
     *
     * @see CoverArray::rand()
     * @see array_rand()
     */
    public function testRandAllElements(): void
    {
        // Test with all elements requested (should return all keys shuffled)
        // Тест с запросом всех элементов (должен вернуть все ключи в перемешанном порядке)
        $data = ['x' => 1, 'y' => 2, 'z' => 3];
        $num = 3;

        $expected = array_rand($data, $num);

        $cover = new CoverArray($data);
        $result = $cover->rand($num);

        $this->assertInstanceOf(CoverArray::class, $result);
        $this->assertCount($num, $result);

        // Verify all keys are present (order may vary)
        // Проверяем, что все ключи присутствуют (порядок может отличаться)
        $resultArray = $result->getDataAsArray();
        sort($resultArray);
        $expectedKeys = array_keys($data);
        sort($expectedKeys);
        $this->assertEquals($expectedKeys, $resultArray);
    }

    /**
     * Tests the rand() method with associative array.
     *
     * This test verifies that the rand() method correctly handles
     * associative arrays, returning string keys for associative arrays.
     *
     *
     * Тестирование метода rand() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод rand() корректно обрабатывает
     * ассоциативные массивы, возвращая строковые ключи для ассоциативных массивов.
     *
     * @see CoverArray::rand()
     * @see array_rand()
     */
    public function testRandWithAssociativeArray(): void
    {
        // Test with associative array
        // Тест с ассоциативным массивом
        $data = ['country' => 'Russia', 'region' => 'Moscow region', 'city' => 'Podolsk'];
        $num = 2;

        $expected = array_rand($data, $num);

        $cover = new CoverArray($data);
        $result = $cover->rand($num);

        $this->assertInstanceOf(CoverArray::class, $result);
        $this->assertCount($num, $result);

        $resultArray = $result->getDataAsArray();
        foreach ($resultArray as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }

    /**
     * Tests the rand() method with numeric indexed array.
     *
     * This test verifies that the rand() method correctly handles
     * numeric indexed arrays, returning integer keys.
     *
     *
     * Тестирование метода rand() с числовым индексированным массивом.
     *
     * Этот тест проверяет, что метод rand() корректно обрабатывает
     * числовые индексные массивы, возвращая целочисленные ключи.
     *
     * @see CoverArray::rand()
     * @see array_rand()
     */
    public function testRandWithNumericIndexedArray(): void
    {
        // Test with numeric indexed array
        // Тест с числовым индексированным массивом
        $data = ['PHP', 'MySql', 'HTML', 'CSS', 'JavaScript'];
        $num = 1;

        $expected = array_rand($data, $num);

        $cover = new CoverArray($data);
        $result = $cover->rand($num);

        // When num=1, array_rand returns a single value, not an array
        // Когда num=1, array_rand возвращает одиночное значение, а не массив
        $this->assertIsInt($result);
        $this->assertArrayHasKey($result, $data);
    }

    /**
     * Tests the rand() method exception for empty array.
     *
     * This test verifies that the rand() method throws a ValueError
     * when called on an empty array, mirroring PHP's array_rand() function behavior.
     *
     *
     * Тестирование исключения метода rand() для пустого массива.
     *
     * Этот тест проверяет, что метод rand() выбрасывает ValueError
     * при вызове на пустом массиве, отражая поведение функции array_rand() PHP.
     *
     * @see CoverArray::rand()
     * @see array_rand()
     */
    public function testRandThrowsValueErrorForEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];
        $cover = new CoverArray($data);

        // With empty array and num=1
        // С пустым массивом и num=1
        $this->expectException(ValueError::class);
        $cover->rand(1);
    }

    /**
     * Tests the rand() method with single element array.
     *
     * This test verifies that the rand() method correctly returns
     * the only key when called on an array with a single element.
     *
     *
     * Тестирование метода rand() с массивом из одного элемента.
     *
     * Этот тест проверяет, что метод rand() корректно возвращает
     * единственный ключ при вызове на массиве с одним элементом.
     *
     * @see CoverArray::rand()
     * @see array_rand()
     */
    public function testRandWithSingleElementArray(): void
    {
        // Test with single element array
        // Тест с массивом из одного элемента
        $data = ['only' => 'element'];

        $expected = array_rand($data);

        $cover = new CoverArray($data);
        $result = $cover->rand();

        $this->assertSame($expected, $result);
    }

    /**
     * Tests the rand() method with CoverArray as data source.
     *
     * This test verifies that the rand() method correctly works
     * with CoverArray objects, treating them like arrays for random
     * key selection.
     *
     *
     * Тестирование метода rand() с CoverArray в качестве источника данных.
     *
     * Этот тест проверяет, что метод rand() корректно работает
     * с объектами CoverArray, обрабатывая их как массивы для случайного
     * выбора ключей.
     *
     * @see CoverArray::rand()
     * @see array_rand()
     */
    public function testRandWithCoverArrayData(): void
    {
        // Test with CoverArray as data source
        // Тест с CoverArray в качестве источника данных
        $innerData = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $data = new CoverArray($innerData);
        $num = 2;

        $expected = array_rand($innerData, $num);

        $result = $data->rand($num);

        $this->assertInstanceOf(CoverArray::class, $result);
        $this->assertCount($num, $result);

        $resultArray = $result->getDataAsArray();
        foreach ($resultArray as $key) {
            $this->assertArrayHasKey($key, $innerData);
        }
    }
}