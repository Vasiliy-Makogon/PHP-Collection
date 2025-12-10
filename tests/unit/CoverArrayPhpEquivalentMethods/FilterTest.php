<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FilterTest extends TestCase
{
    /**
     * Tests the filter() method with callback that filters by value.
     *
     * This test verifies that the filter() method correctly filters elements
     * by their values using a callback function, mirroring PHP's array_filter()
     * function behavior with default mode (0).
     *
     *
     * Тестирование метода filter() с callback, который фильтрует по значению.
     *
     * Этот тест проверяет, что метод filter() корректно фильтрует элементы
     * по их значениям с использованием callback-функции, отражая поведение
     * функции array_filter() PHP с режимом по умолчанию (0).
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithValueCallback(): void
    {
        $data = [1, 2, 3, 4, 5];
        $callback = function ($value) {
            return $value % 2 === 0; // только четные числа
        };

        $expected = array_filter($data, $callback);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->filter($callback)->getDataAsArray()
        );
    }

    /**
     * Tests the filter() method with callback that filters by key.
     *
     * This test verifies that the filter() method correctly filters elements
     * by their keys using a callback function, mirroring PHP's array_filter()
     * function behavior with ARRAY_FILTER_USE_KEY mode.
     *
     *
     * Тестирование метода filter() с callback, который фильтрует по ключу.
     *
     * Этот тест проверяет, что метод filter() корректно фильтрует элементы
     * по их ключам с использованием callback-функции, отражая поведение
     * функции array_filter() PHP с режимом ARRAY_FILTER_USE_KEY.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithKeyCallback(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $callback = function ($key) {
            return in_array($key, ['a', 'c']); // только ключи 'a' и 'c'
        };

        $expected = array_filter($data, $callback, ARRAY_FILTER_USE_KEY);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->filter($callback, ARRAY_FILTER_USE_KEY)->getDataAsArray()
        );
    }

    /**
     * Tests the filter() method with callback that filters by both value and key.
     *
     * This test verifies that the filter() method correctly filters elements
     * by both values and keys using a callback function, mirroring PHP's array_filter()
     * function behavior with ARRAY_FILTER_USE_BOTH mode.
     *
     *
     * Тестирование метода filter() с callback, который фильтрует и по значению, и по ключу.
     *
     * Этот тест проверяет, что метод filter() корректно фильтрует элементы
     * и по значениям, и по ключам с использованием callback-функции, отражая поведение
     * функции array_filter() PHP с режимом ARRAY_FILTER_USE_BOTH.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithValueAndKeyCallback(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4];
        $callback = function ($value, $key) {
            return $value > 1 && $key !== 'c'; // значение > 1 и ключ не 'c'
        };

        $expected = array_filter($data, $callback, ARRAY_FILTER_USE_BOTH);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->filter($callback, ARRAY_FILTER_USE_BOTH)->getDataAsArray()
        );
    }

    /**
     * Tests the filter() method without callback.
     *
     * This test verifies that the filter() method correctly removes empty values
     * when no callback is provided, mirroring PHP's array_filter() function behavior
     * without a callback.
     *
     *
     * Тестирование метода filter() без callback.
     *
     * Этот тест проверяет, что метод filter() корректно удаляет пустые значения
     * когда callback не предоставлен, отражая поведение функции array_filter() PHP
     * без callback.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithoutCallback(): void
    {
        $data = [0 => 'a', 1 => false, 2 => null, 3 => '', 4 => 'b'];

        $expected = array_filter($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->filter()->getDataAsArray()
        );
    }

    /**
     * Tests the filter() method with callback that always returns false.
     *
     * This test verifies that the filter() method correctly returns an empty array
     * when the callback always returns false, mirroring PHP's array_filter() function behavior.
     *
     *
     * Тестирование метода filter() с callback, который всегда возвращает false.
     *
     * Этот тест проверяет, что метод filter() корректно возвращает пустой массив
     * когда callback всегда возвращает false, отражая поведение функции array_filter() PHP.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithCallbackAlwaysFalse(): void
    {
        $data = ['x' => 1, 'y' => 2, 'z' => 3];
        $callback = function ($value) {
            return false;
        };

        $expected = array_filter($data, $callback);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->filter($callback)->getDataAsArray()
        );
    }

    /**
     * Tests the filter() method with callback that always returns true.
     *
     * This test verifies that the filter() method correctly returns the entire array
     * when the callback always returns true, mirroring PHP's array_filter() function behavior.
     *
     *
     * Тестирование метода filter() с callback, который всегда возвращает true.
     *
     * Этот тест проверяет, что метод filter() корректно возвращает весь массив
     * когда callback всегда возвращает true, отражая поведение функции array_filter() PHP.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithCallbackAlwaysTrue(): void
    {
        $data = ['x' => 1, 'y' => 2, 'z' => 3];
        $callback = function ($value) {
            return true;
        };

        $expected = array_filter($data, $callback);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->filter($callback)->getDataAsArray()
        );
    }

    /**
     * Tests the filter() method with empty array.
     *
     * This test verifies that the filter() method correctly handles empty arrays,
     * returning an empty array without errors, mirroring PHP's array_filter() function behavior.
     *
     *
     * Тестирование метода filter() с пустым массивом.
     *
     * Этот тест проверяет, что метод filter() корректно обрабатывает пустые массивы,
     * возвращая пустой массив без ошибок, отражая поведение функции array_filter() PHP.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithEmptyArray(): void
    {
        $data = [];

        $expected = array_filter($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->filter()->getDataAsArray()
        );
    }

    /**
     * Tests the filter() method with array containing only falsey values.
     *
     * This test verifies that the filter() method correctly removes all falsey values
     * when called without a callback, mirroring PHP's array_filter() function behavior.
     *
     *
     * Тестирование метода filter() с массивом, содержащим только ложные значения.
     *
     * Этот тест проверяет, что метод filter() корректно удаляет все ложные значения
     * при вызове без callback, отражая поведение функции array_filter() PHP.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithOnlyFalseyValues(): void
    {
        $data = [0, false, null, ''];

        $expected = array_filter($data);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->filter()->getDataAsArray()
        );
    }

    /**
     * Tests the filter() method with callback that filters numeric values.
     *
     * This test verifies that the filter() method correctly filters numeric values
     * using a simple comparison callback, mirroring PHP's array_filter() function behavior.
     *
     *
     * Тестирование метода filter() с callback, который фильтрует числовые значения.
     *
     * Этот тест проверяет, что метод filter() корректно фильтрует числовые значения
     * с использованием простого callback сравнения, отражая поведение функции array_filter() PHP.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithNumericComparison(): void
    {
        $data = [10, 20, 30, 40, 50];
        $callback = function ($value) {
            return $value > 25;
        };

        $expected = array_filter($data, $callback);

        $cover = new CoverArray($data);
        $this->assertSame(
            $expected,
            $cover->filter($callback)->getDataAsArray()
        );
    }

    /**
     * Tests the filter() method with CoverArray as element.
     *
     * This test verifies that the filter() method correctly handles CoverArray
     * objects as array elements, applying the callback to the CoverArray instances.
     *
     *
     * Тестирование метода filter() с CoverArray как элементом.
     *
     * Этот тест проверяет, что метод filter() корректно обрабатывает объекты
     * CoverArray как элементы массива, применяя callback к экземплярам CoverArray.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithCoverArrayElements(): void
    {
        $innerCover1 = new CoverArray(['active' => true, 'value' => 10]);
        $innerCover2 = new CoverArray(['active' => false, 'value' => 20]);
        $innerCover3 = new CoverArray(['active' => true, 'value' => 30]);

        $data = [
            'first' => $innerCover1,
            'second' => $innerCover2,
            'third' => $innerCover3,
            'scalar' => 40
        ];

        $callback = function ($value, $key) {
            if ($value instanceof CoverArray) {
                return $value['active'] === true;
            }
            return $value > 25;
        };

        $cover = new CoverArray($data);
        $result = $cover->filter($callback, ARRAY_FILTER_USE_BOTH);

        // Проверяем, что отфильтрованы правильные элементы
        $this->assertCount(3, $result);
        $this->assertArrayHasKey('first', $result->getDataAsArray());
        $this->assertArrayHasKey('third', $result->getDataAsArray());
        $this->assertArrayNotHasKey('second', $result->getDataAsArray());
        $this->assertSame($data['scalar'], $result->last());

        // Проверяем, что объекты CoverArray сохранились
        $this->assertSame($innerCover1, $result['first']);
        $this->assertSame($innerCover3, $result['third']);
    }

    /**
     * Tests the filter() method with nested arrays that become CoverArray instances.
     *
     * This test verifies that the filter() method correctly handles nested arrays
     * that are automatically converted to CoverArray instances, and the callback
     * receives these CoverArray instances for filtering.
     *
     *
     * Тестирование метода filter() с вложенными массивами, которые становятся экземплярами CoverArray.
     *
     * Этот тест проверяет, что метод filter() корректно обрабатывает вложенные массивы,
     * которые автоматически преобразуются в экземпляры CoverArray, и callback
     * получает эти экземпляры CoverArray для фильтрации.
     *
     * @see CoverArray::filter()
     * @see array_filter()
     */
    public function testFilterWithNestedArraysAsCoverArray(): void
    {
        $data = [
            'item1' => ['enabled' => true, 'name' => 'First'],
            'item2' => ['enabled' => false, 'name' => 'Second'],
            'item3' => ['enabled' => true, 'name' => 'Third']
        ];

        $callback = function ($value, $key) {
            // $value будет экземпляром CoverArray из-за автоматического преобразования
            return $value instanceof CoverArray && $value['enabled'] === true;
        };

        $cover = new CoverArray($data);
        $result = $cover->filter($callback, ARRAY_FILTER_USE_BOTH);

        // Проверяем результат
        $this->assertCount(2, $result);
        $this->assertArrayHasKey('item1', $result->getDataAsArray());
        $this->assertArrayHasKey('item3', $result->getDataAsArray());
        $this->assertArrayNotHasKey('item2', $result->getDataAsArray());

        // Проверяем, что элементы являются CoverArray
        $this->assertInstanceOf(CoverArray::class, $result['item1']);
        $this->assertInstanceOf(CoverArray::class, $result['item3']);
    }
}