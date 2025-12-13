<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class PrependTest extends TestCase
{
    /**
     * Tests the prepend() method with single element.
     *
     * This test verifies that the prepend() method correctly adds
     * a single element to the beginning of the CoverArray, shifting
     * existing elements to higher indices, and returns the same instance
     * for method chaining.
     *
     *
     * Тестирование метода prepend() с одним элементом.
     *
     * Этот тест проверяет, что метод prepend() корректно добавляет
     * один элемент в начало CoverArray, сдвигая существующие элементы
     * на более высокие индексы, и возвращает тот же экземпляр для цепочек вызовов.
     *
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    public function testPrependSingleElement(): void
    {
        $data = ['PHP', 'MySql'];
        $expected = $data;
        array_unshift($expected, 'C++');

        $cover = new CoverArray($data);
        $result = $cover->prepend('C++');

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the prepend() method with multiple elements.
     *
     * This test verifies that the prepend() method correctly adds
     * multiple elements to the beginning of the CoverArray in the order
     * they are provided, shifting existing elements to higher indices.
     *
     *
     * Тестирование метода prepend() с несколькими элементами.
     *
     * Этот тест проверяет, что метод prepend() корректно добавляет
     * несколько элементов в начало CoverArray в том порядке, в котором
     * они предоставлены, сдвигая существующие элементы на более высокие индексы.
     *
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    public function testPrependMultipleElements(): void
    {
        $data = ['PHP', 'MySql'];
        $expected = $data;
        array_unshift($expected, 'Python', 'Ruby');

        $cover = new CoverArray($data);
        $cover->prepend('Python', 'Ruby');

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the prepend() method with array element.
     *
     * This test verifies that the prepend() method correctly converts
     * array elements to CoverArray instances when prepending them,
     * unlike PHP's array_unshift() which adds arrays as-is.
     *
     *
     * Тестирование метода prepend() с элементом-массивом.
     *
     * Этот тест проверяет, что метод prepend() корректно преобразует
     * элементы-массивы в экземпляры CoverArray при добавлении их в начало,
     * в отличие от array_unshift() PHP, который добавляет массивы как есть.
     *
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    public function testPrependArrayElement(): void
    {
        $data = ['PHP', 'MySql'];
        $arrayValue = ['Python', 'Ruby'];

        $expected = $data;
        array_unshift($expected, $arrayValue);

        $cover = new CoverArray($data);
        $cover->prepend($arrayValue);

        $this->assertCount(3, $cover);

        $firstElement = $cover->first();
        $this->assertInstanceOf(CoverArray::class, $firstElement);
        $this->assertSame($arrayValue, $firstElement->getDataAsArray());
    }

    /**
     * Tests the prepend() method with CoverArray element.
     *
     * This test verifies that the prepend() method correctly handles
     * CoverArray objects as elements, preserving them without conversion.
     *
     *
     * Тестирование метода prepend() с элементом типа CoverArray.
     *
     * Этот тест проверяет, что метод prepend() корректно обрабатывает
     * объекты CoverArray как элементы, сохраняя их без преобразования.
     *
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    public function testPrependCoverArrayElement(): void
    {
        $data = ['PHP', 'MySql'];
        $coverArrayValue = new CoverArray(['Python', 'Ruby']);

        $expected = $data;
        array_unshift($expected, $coverArrayValue);

        $cover = new CoverArray($data);
        $cover->prepend($coverArrayValue);

        $this->assertCount(3, $cover);
        $firstElement = $cover->first();
        $this->assertSame($coverArrayValue, $firstElement);
        $this->assertInstanceOf(CoverArray::class, $firstElement);
    }

    /**
     * Tests the unshift() alias method.
     *
     * This test verifies that the unshift() method, which is an alias
     * of prepend(), behaves identically to prepend() and returns the
     * same instance for method chaining.
     *
     *
     * Тестирование метода-алиаса unshift().
     *
     * Этот тест проверяет, что метод unshift(), являющийся алиасом
     * метода prepend(), ведет себя идентично prepend() и возвращает
     * тот же экземпляр для цепочек вызовов.
     *
     * @see CoverArray::unshift()
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    public function testUnshiftAlias(): void
    {
        $data = ['PHP', 'MySql'];
        $expected = $data;
        array_unshift($expected, 'Java', 'C#');

        $cover = new CoverArray($data);
        $result = $cover->unshift('Java', 'C#');

        $this->assertSame($expected, $cover->getDataAsArray());
        $this->assertSame($cover, $result);
    }

    /**
     * Tests the prepend() method with empty array.
     *
     * This test verifies that the prepend() method correctly handles
     * prepending elements to an empty CoverArray, mirroring PHP's
     * array_unshift() function behavior.
     *
     *
     * Тестирование метода prepend() с пустым массивом.
     *
     * Этот тест проверяет, что метод prepend() корректно обрабатывает
     * добавление элементов в пустой CoverArray, отражая поведение
     * функции array_unshift() PHP.
     *
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    public function testPrependToEmptyArray(): void
    {
        $data = [];
        $expected = $data;
        array_unshift($expected, 'first');

        $cover = new CoverArray($data);
        $cover->prepend('first');

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the prepend() method with associative array.
     *
     * This test verifies that the prepend() method correctly handles
     * associative arrays by adding new elements with numeric indices
     * while preserving existing string keys, mirroring PHP's
     * array_unshift() function behavior.
     *
     *
     * Тестирование метода prepend() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод prepend() корректно обрабатывает
     * ассоциативные массивы, добавляя новые элементы с числовыми индексами,
     * сохраняя существующие строковые ключи, отражая поведение
     * функции array_unshift() PHP.
     *
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    public function testPrependToAssociativeArray(): void
    {
        $data = ['b' => 'PHP', 'c' => 'MySql'];
        $expected = $data;
        array_unshift($expected, 'Java');

        $cover = new CoverArray($data);
        $cover->prepend('Java');

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the prepend() method with associative array element.
     *
     * This test verifies that the prepend() method correctly converts
     * associative array elements to CoverArray instances when prepending them.
     *
     *
     * Тестирование метода prepend() с элементом-ассоциативным массивом.
     *
     * Этот тест проверяет, что метод prepend() корректно преобразует
     * элементы-ассоциативные массивы в экземпляры CoverArray при добавлении их в начало.
     *
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    public function testPrependAssociativeArrayElement(): void
    {
        $data = ['b' => 'PHP', 'c' => 'MySql'];
        $assocArray = ['a' => 'Java'];

        $expected = $data;
        array_unshift($expected, $assocArray);

        $cover = new CoverArray($data);
        $cover->prepend($assocArray);

        $firstElement = $cover->first();
        $this->assertInstanceOf(CoverArray::class, $firstElement);
        $this->assertSame($assocArray, $firstElement->getDataAsArray());
    }

    /**
     * Tests the prepend() method with numeric indices reindexing.
     *
     * This test verifies that the prepend() method correctly reindexes
     * numeric indices when adding elements to the beginning of the array,
     * mirroring PHP's array_unshift() function behavior.
     *
     *
     * Тестирование метода prepend() с переиндексацией числовых индексов.
     *
     * Этот тест проверяет, что метод prepend() корректно переиндексирует
     * числовые индексы при добавлении элементов в начало массива,
     * отражая поведение функции array_unshift() PHP.
     *
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    public function testPrependWithNumericIndicesReindexing(): void
    {
        $data = [0 => 'PHP', 1 => 'MySql'];
        $expected = $data;
        array_unshift($expected, 'new');

        $cover = new CoverArray($data);
        $cover->prepend('new');

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests that prepend() and unshift() produce identical results.
     *
     * This test verifies that the prepend() method and its unshift() alias
     * produce identical results when called with the same arguments.
     *
     *
     * Тестирование, что prepend() и unshift() дают идентичные результаты.
     *
     * Этот тест проверяет, что метод prepend() и его алиас unshift()
     * дают идентичные результаты при вызове с одинаковыми аргументами.
     *
     * @see CoverArray::prepend()
     * @see CoverArray::unshift()
     */
    public function testPrependAndUnshiftIdenticalResults(): void
    {
        $data = ['c', 'd', 'e'];
        $expected = $data;
        array_unshift($expected, 'a', 'b');

        $cover1 = new CoverArray($data);
        $cover2 = new CoverArray($data);

        $cover1->prepend('a', 'b');
        $cover2->unshift('a', 'b');

        $this->assertEquals($cover1->getDataAsArray(), $cover2->getDataAsArray());
    }

    /**
     * Tests the prepend() method with complex nested structure.
     *
     * This test verifies that the prepend() method correctly handles
     * prepending to a CoverArray with complex nested structure.
     *
     *
     * Тестирование метода prepend() со сложной вложенной структурой.
     *
     * Этот тест проверяет, что метод prepend() корректно обрабатывает
     * добавление элементов в начало CoverArray со сложной вложенной структурой.
     *
     * @see CoverArray::prepend()
     * @see array_unshift()
     */
    public function testPrependWithComplexNestedStructure(): void
    {
        $data = [
            'backend' => ['PHP', 'MySql'],
            'frontend' => ['HTML', 'CSS']
        ];
        $expected = $data;
        array_unshift($expected, 'new_top_level');

        $cover = new CoverArray($data);
        $cover->prepend('new_top_level');

        $this->assertSame($expected, $cover->getDataAsArray());
    }

    /**
     * Tests the prepend() method without arguments.
     *
     * This test verifies that the prepend() method returns the same instance
     * unchanged when called without arguments.
     *
     *
     * Тестирование метода prepend() без аргументов.
     *
     * Этот тест проверяет, что метод prepend() возвращает тот же экземпляр
     * без изменений при вызове без аргументов.
     *
     * @see CoverArray::prepend()
     */
    public function testPrependWithoutArguments(): void
    {
        $data = ['PHP'];
        $cover = new CoverArray($data);

        $result = $cover->prepend();

        $this->assertSame($cover, $result);
        $this->assertSame($data, $cover->getDataAsArray());
    }
}