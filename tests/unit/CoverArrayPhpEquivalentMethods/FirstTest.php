<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FirstTest extends TestCase
{
    /**
     * Helper method to assert first() behavior with both approaches.
     *
     * Вспомогательный метод для проверки поведения first() двумя подходами.
     */
    private function assertFirstCase(array $data, mixed $expected): void
    {
        $cover = new CoverArray($data);
        $result = $cover->first();

        if (function_exists('array_first')) {
            $nativeResult = array_first($data);
            $this->assertSame(
                $nativeResult,
                $result,
                "CoverArray::first() should match array_first() for data: " . var_export($data, true)
            );
        } else {
            $this->assertSame(
                $expected,
                $result,
                "CoverArray::first() returned unexpected result for data: " . var_export($data, true)
            );
        }
    }

    /**
     * Tests the first() method with sequential numeric array.
     *
     * This test verifies that the first() method correctly returns the first
     * element of a sequential numeric array.
     *
     *
     * Тестирование метода first() с последовательным числовым массивом.
     *
     * Этот тест проверяет, что метод first() корректно возвращает первый
     * элемент последовательного числового массива.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithSequentialNumericArray(): void
    {
        $data = [10, 20, 30, 40];
        $this->assertFirstCase($data, 10);
    }

    /**
     * Tests the first() method with associative array.
     *
     * This test verifies that the first() method correctly returns the first
     * element of an associative array (preserving insertion order in PHP 7+).
     *
     *
     * Тестирование метода first() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод first() корректно возвращает первый
     * элемент ассоциативного массива (сохраняя порядок вставки в PHP 7+).
     *
     * @see CoverArray::first()
     */
    public function testFirstWithAssociativeArray(): void
    {
        $data = ['a' => 'apple', 'b' => 'banana', 'c' => 'cherry'];
        $this->assertFirstCase($data, 'apple');
    }

    /**
     * Tests the first() method with empty array.
     *
     * This test verifies that the first() method correctly returns null
     * when called on an empty array.
     *
     *
     * Тестирование метода first() с пустым массивом.
     *
     * Этот тест проверяет, что метод first() корректно возвращает null
     * при вызове на пустом массиве.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithEmptyArray(): void
    {
        $data = [];
        $this->assertFirstCase($data, null);
    }

    /**
     * Tests the first() method with null as first element.
     *
     * This test verifies that the first() method correctly returns null
     * when the first element of the array is actually null.
     *
     *
     * Тестирование метода first() с null в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает null
     * когда первый элемент массива действительно равен null.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithNullAsFirstElement(): void
    {
        $data = [null, 'second', 'third'];
        $this->assertFirstCase($data, null);
    }

    /**
     * Tests the first() method with false as first element.
     *
     * This test verifies that the first() method correctly returns false
     * when the first element of the array is false.
     *
     *
     * Тестирование метода first() с false в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает false
     * когда первый элемент массива равен false.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithFalseAsFirstElement(): void
    {
        $data = [false, true, true];
        $this->assertFirstCase($data, false);
    }

    /**
     * Tests the first() method with zero as first element.
     *
     * This test verifies that the first() method correctly returns 0
     * when the first element of the array is zero.
     *
     *
     * Тестирование метода first() с 0 в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает 0
     * когда первый элемент массива равен 0.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithZeroAsFirstElement(): void
    {
        $data = [0, 1, 2];
        $this->assertFirstCase($data, 0);
    }

    /**
     * Tests the first() method with empty string as first element.
     *
     * This test verifies that the first() method correctly returns an empty string
     * when the first element of the array is an empty string.
     *
     *
     * Тестирование метода first() с пустой строкой в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает пустую строку
     * когда первый элемент массива является пустой строкой.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithEmptyStringAsFirstElement(): void
    {
        $data = ['', 'not empty', 'another'];
        $this->assertFirstCase($data, '');
    }

    /**
     * Tests the first() method with mixed key types array.
     *
     * This test verifies that the first() method correctly returns the first
     * element of an array with mixed key types.
     *
     *
     * Тестирование метода first() с массивом со смешанными типами ключей.
     *
     * Этот тест проверяет, что метод first() корректно возвращает первый
     * элемент массива со смешанными типами ключей.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithMixedKeyTypesArray(): void
    {
        $data = [0 => 'zero', 'one' => 1, 2 => 'two'];
        $this->assertFirstCase($data, 'zero');
    }

    /**
     * Tests that first() method doesn't affect array pointer.
     *
     * This test verifies that the first() method returns the same result
     * on multiple calls without affecting the internal array pointer.
     *
     *
     * Тестирование, что метод first() не затрагивает указатель массива.
     *
     * Этот тест проверяет, что метод first() возвращает одинаковый результат
     * при нескольких вызовах без воздействия на внутренний указатель массива.
     *
     * @see CoverArray::first()
     */
    public function testFirstDoesNotAffectArrayPointer(): void
    {
        $data = ['first', 'second', 'third'];
        $cover = new CoverArray($data);

        $this->assertSame('first', $cover->first());
        $this->assertSame('first', $cover->first());
        $this->assertSame('first', $cover->first());
    }

    /**
     * Tests the first() method with CoverArray as first element.
     *
     * This test verifies that the first() method correctly returns a CoverArray
     * instance when the first element is an array, as CoverArray converts
     * nested arrays to CoverArray instances.
     *
     *
     * Тестирование метода first() с CoverArray в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает экземпляр CoverArray
     * когда первый элемент является массивом, так как CoverArray преобразует
     * вложенные массивы в экземпляры CoverArray.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithCoverArrayAsFirstElement(): void
    {
        $nestedArray = ['nested' => 'value'];
        $data = [$nestedArray, 'simple', 123];
        $cover = new CoverArray($data);

        $firstElement = $cover->first();
        $this->assertInstanceOf(CoverArray::class, $firstElement);
        $this->assertSame($nestedArray, $firstElement->getDataAsArray());
    }

    /**
     * Tests the first() method with CoverArray object as first element.
     *
     * This test verifies that the first() method correctly returns a CoverArray
     * object when it's already a CoverArray instance, preserving the original object.
     *
     *
     * Тестирование метода first() с объектом CoverArray в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает объект CoverArray
     * когда он уже является экземпляром CoverArray, сохраняя исходный объект.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithCoverArrayObjectAsFirstElement(): void
    {
        $innerCover = new CoverArray(['x' => 1, 'y' => 2]);
        $data = [$innerCover, 'simple', 123];
        $cover = new CoverArray($data);

        $firstElement = $cover->first();
        $this->assertSame($innerCover, $firstElement);
        $this->assertInstanceOf(CoverArray::class, $firstElement);
    }

    /**
     * Tests the first() method with nested array as first element.
     *
     * This test verifies that the first() method correctly returns
     * a nested array converted to CoverArray instance.
     *
     *
     * Тестирование метода first() с вложенным массивом в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает
     * вложенный массив, преобразованный в экземпляр CoverArray.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithNestedArrayAsFirstElement(): void
    {
        $data = [['a' => 1, 'b' => 2], 'simple', 123];
        $expected = ['a' => 1, 'b' => 2];

        $cover = new CoverArray($data);
        $result = $cover->first();

        if (function_exists('array_first')) {
            $nativeResult = array_first($data);
            $this->assertEquals($nativeResult, $result->getDataAsArray());
        } else {
            $this->assertSame($expected, $result->getDataAsArray());
        }
    }

    /**
     * Tests the first() method with object as first element.
     *
     * This test verifies that the first() method correctly returns
     * an object when it's the first element.
     *
     *
     * Тестирование метода first() с объектом в качестве первого элемента.
     *
     * Этот тест проверяет, что метод first() корректно возвращает
     * объект, когда он является первым элементом.
     *
     * @see CoverArray::first()
     */
    public function testFirstWithObjectAsFirstElement(): void
    {
        $object = new \stdClass();
        $object->property = 'value';
        $data = [$object, 'simple', 123];

        $this->assertFirstCase($data, $object);
    }
}