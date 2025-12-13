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
     * Tests the pop() method with sequential array.
     *
     * This test verifies that the pop() method correctly removes
     * and returns the last element of a sequential CoverArray,
     * shortening the array by one element, mirroring PHP's array_pop() function.
     *
     *
     * Тестирование метода pop() с последовательным массивом.
     *
     * Этот тест проверяет, что метод pop() корректно удаляет
     * и возвращает последний элемент последовательного CoverArray,
     * уменьшая массив на один элемент, отражая поведение функции array_pop() PHP.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopWithSequentialArray(): void
    {
        $data = [1, 2, 3];
        $expectedArray = $data;
        $expectedValue = array_pop($expectedArray);

        $cover = new CoverArray($data);
        $actualValue = $cover->pop();

        $this->assertSame($expectedValue, $actualValue);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the pop() method with associative array.
     *
     * This test verifies that the pop() method correctly removes
     * and returns the last element of an associative CoverArray,
     * shortening the array by one element, mirroring PHP's array_pop() function.
     *
     *
     * Тестирование метода pop() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод pop() корректно удаляет
     * и возвращает последний элемент ассоциативного CoverArray,
     * уменьшая массив на один элемент, отражая поведение функции array_pop() PHP.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopWithAssociativeArray(): void
    {
        $data = ['a' => 1, 'b' => 2, 'c' => 3];
        $expectedArray = $data;
        $expectedValue = array_pop($expectedArray);

        $cover = new CoverArray($data);
        $actualValue = $cover->pop();

        $this->assertSame($expectedValue, $actualValue);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the pop() method with empty array.
     *
     * This test verifies that the pop() method correctly returns null
     * when called on an empty CoverArray, mirroring PHP's array_pop() function.
     *
     *
     * Тестирование метода pop() с пустым массивом.
     *
     * Этот тест проверяет, что метод pop() корректно возвращает null
     * при вызове на пустом CoverArray, отражая поведение функции array_pop() PHP.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopWithEmptyArray(): void
    {
        $data = [];
        $expectedArray = $data;
        $expectedValue = array_pop($expectedArray);

        $cover = new CoverArray($data);
        $actualValue = $cover->pop();

        $this->assertSame($expectedValue, $actualValue);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the pop() method with single element array.
     *
     * This test verifies that the pop() method correctly removes
     * and returns the only element from a single-element CoverArray,
     * leaving an empty array, mirroring PHP's array_pop() function.
     *
     *
     * Тестирование метода pop() с массивом из одного элемента.
     *
     * Этот тест проверяет, что метод pop() корректно удаляет
     * и возвращает единственный элемент из одноэлементного CoverArray,
     * оставляя пустой массив, отражая поведение функции array_pop() PHP.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopWithSingleElementArray(): void
    {
        $data = ['single'];
        $expectedArray = $data;
        $expectedValue = array_pop($expectedArray);

        $cover = new CoverArray($data);
        $actualValue = $cover->pop();

        $this->assertSame($expectedValue, $actualValue);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the pop() method with mixed value types.
     *
     * This test verifies that the pop() method correctly handles
     * arrays containing mixed value types, mirroring PHP's array_pop() function.
     *
     *
     * Тестирование метода pop() со смешанными типами значений.
     *
     * Этот тест проверяет, что метод pop() корректно обрабатывает
     * массивы, содержащие смешанные типы значений, отражая поведение функции array_pop() PHP.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopWithMixedValueTypes(): void
    {
        $data = ['string', 123, null, false];
        $expectedArray = $data;
        $expectedValue = array_pop($expectedArray);

        $cover = new CoverArray($data);
        $actualValue = $cover->pop();

        $this->assertSame($expectedValue, $actualValue);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the pop() method with array value.
     *
     * This test verifies that the pop() method correctly handles
     * arrays containing array values, converting them to CoverArray
     * instances when popped, unlike PHP's array_pop() which returns arrays as-is.
     *
     *
     * Тестирование метода pop() со значением-массивом.
     *
     * Этот тест проверяет, что метод pop() корректно обрабатывает
     * массивы, содержащие значения-массивы, преобразуя их в экземпляры CoverArray
     * при извлечении, в отличие от array_pop() PHP, который возвращает массивы как есть.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopWithArrayValue(): void
    {
        $data = [1, 2, ['nested' => 'value']];
        $expectedArray = $data;
        $expectedValue = array_pop($expectedArray);

        $cover = new CoverArray($data);
        $actualValue = $cover->pop();

        // Проверяем, что возвращенный объект является CoverArray и содержит правильные данные
        $this->assertInstanceOf(CoverArray::class, $actualValue);
        $this->assertSame($expectedValue, $actualValue->getDataAsArray());
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the pop() method with multiple consecutive pops.
     *
     * This test verifies that the pop() method correctly removes
     * elements one by one from the CoverArray until it's empty,
     * mirroring PHP's array_pop() function behavior.
     *
     *
     * Тестирование метода pop() с несколькими последовательными извлечениями.
     *
     * Этот тест проверяет, что метод pop() корректно удаляет
     * элементы один за другим из CoverArray, пока он не станет пустым,
     * отражая поведение функции array_pop() PHP.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopWithMultipleConsecutivePops(): void
    {
        $data = [10, 20, 30, 40];
        $cover = new CoverArray($data);

        // First pop
        // Первый pop
        $expectedArray1 = $data;
        $expectedValue1 = array_pop($expectedArray1);
        $actualValue1 = $cover->pop();
        $this->assertSame($expectedValue1, $actualValue1);
        $this->assertSame($expectedArray1, $cover->getDataAsArray());

        // Second pop
        // Второй pop
        $expectedArray2 = $expectedArray1;
        $expectedValue2 = array_pop($expectedArray2);
        $actualValue2 = $cover->pop();
        $this->assertSame($expectedValue2, $actualValue2);
        $this->assertSame($expectedArray2, $cover->getDataAsArray());

        // Third pop
        // Третий pop
        $expectedArray3 = $expectedArray2;
        $expectedValue3 = array_pop($expectedArray3);
        $actualValue3 = $cover->pop();
        $this->assertSame($expectedValue3, $actualValue3);
        $this->assertSame($expectedArray3, $cover->getDataAsArray());

        // Fourth pop
        // Четвертый pop
        $expectedArray4 = $expectedArray3;
        $expectedValue4 = array_pop($expectedArray4);
        $actualValue4 = $cover->pop();
        $this->assertSame($expectedValue4, $actualValue4);
        $this->assertSame($expectedArray4, $cover->getDataAsArray());

        // Fifth pop (from empty array)
        // Пятый pop (из пустого массива)
        $expectedArray5 = $expectedArray4;
        $expectedValue5 = array_pop($expectedArray5);
        $actualValue5 = $cover->pop();
        $this->assertSame($expectedValue5, $actualValue5);
        $this->assertSame($expectedArray5, $cover->getDataAsArray());
    }

    /**
     * Tests the pop() method with numeric string keys.
     *
     * This test verifies that the pop() method correctly handles
     * arrays with numeric string keys, mirroring PHP's array_pop() function.
     *
     *
     * Тестирование метода pop() с числовыми строковыми ключами.
     *
     * Этот тест проверяет, что метод pop() корректно обрабатывает
     * массивы с числовыми строковыми ключами, отражая поведение функции array_pop() PHP.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopWithNumericStringKeys(): void
    {
        $data = ['0' => 'a', '1' => 'b', '2' => 'c'];
        $expectedArray = $data;
        $expectedValue = array_pop($expectedArray);

        $cover = new CoverArray($data);
        $actualValue = $cover->pop();

        $this->assertSame($expectedValue, $actualValue);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }

    /**
     * Tests the pop() method with CoverArray as element.
     *
     * This test verifies that the pop() method correctly handles
     * arrays containing CoverArray objects as elements, preserving
     * the CoverArray instance without additional conversion.
     *
     *
     * Тестирование метода pop() с элементом типа CoverArray.
     *
     * Этот тест проверяет, что метод pop() корректно обрабатывает
     * массивы, содержащие объекты CoverArray как элементы, сохраняя
     * экземпляр CoverArray без дополнительного преобразования.
     *
     * @see CoverArray::pop()
     * @see array_pop()
     */
    public function testPopWithCoverArrayElement(): void
    {
        // Тестируем случай, когда последний элемент - объект CoverArray
        $innerCover = new CoverArray(['x' => 1, 'y' => 2]);
        $data = ['first', 'second', $innerCover];

        $expectedArray = $data;
        $expectedValue = array_pop($expectedArray);

        $cover = new CoverArray($data);
        $actualValue = $cover->pop();

        // Проверяем, что возвращен тот же объект CoverArray
        $this->assertSame($innerCover, $actualValue);
        $this->assertInstanceOf(CoverArray::class, $actualValue);
        $this->assertSame($expectedArray, $cover->getDataAsArray());
    }
}