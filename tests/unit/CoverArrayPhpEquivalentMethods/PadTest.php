<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class PadTest extends TestCase
{
    /**
     * Tests the pad() method with positive length (padding to the right).
     *
     * This test verifies that the pad() method correctly pads the CoverArray
     * to the right when positive length is specified, mirroring PHP's array_pad()
     * function behavior.
     *
     *
     * Тестирование метода pad() с положительной длиной (дополнение справа).
     *
     * Этот тест проверяет, что метод pad() корректно дополняет CoverArray
     * справа, когда указана положительная длина, отражая поведение функции
     * array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithPositiveLength(): void
    {
        // Test padding to the right (positive length)
        // Тест дополнения справа (положительная длина)
        $data = [1, 2, 3];
        $expected = array_pad($data, 5, 0);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->pad(5, 0)->getDataAsArray());
    }

    /**
     * Tests the pad() method with negative length (padding to the left).
     *
     * This test verifies that the pad() method correctly pads the CoverArray
     * to the left when negative length is specified, mirroring PHP's array_pad()
     * function behavior.
     *
     *
     * Тестирование метода pad() с отрицательной длиной (дополнение слева).
     *
     * Этот тест проверяет, что метод pad() корректно дополняет CoverArray
     * слева, когда указана отрицательная длина, отражая поведение функции
     * array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithNegativeLength(): void
    {
        // Test padding to the left (negative length)
        // Тест дополнения слева (отрицательная длина)
        $data = [1, 2, 3];
        $expected = array_pad($data, -5, 0);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->pad(-5, 0)->getDataAsArray());
    }

    /**
     * Tests the pad() method with length smaller than array size.
     *
     * This test verifies that the pad() method returns the original array
     * unchanged when the specified length is smaller than the array size,
     * mirroring PHP's array_pad() function behavior.
     *
     *
     * Тестирование метода pad() с длиной меньше размера массива.
     *
     * Этот тест проверяет, что метод pad() возвращает исходный массив
     * без изменений, когда указанная длина меньше размера массива,
     * отражая поведение функции array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithLengthSmallerThanArraySize(): void
    {
        // Test with length smaller than array size (no padding)
        // Тест с длиной меньше размера массива (без дополнения)
        $data = [1, 2, 3, 4, 5];
        $expected = array_pad($data, 3, 0);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->pad(3, 0)->getDataAsArray());
    }

    /**
     * Tests the pad() method with negative length smaller than array size.
     *
     * This test verifies that the pad() method returns the original array
     * unchanged when the absolute value of negative length is smaller than
     * the array size, mirroring PHP's array_pad() function behavior.
     *
     *
     * Тестирование метода pad() с отрицательной длиной меньше размера массива.
     *
     * Этот тест проверяет, что метод pad() возвращает исходный массив
     * без изменений, когда абсолютное значение отрицательной длины меньше
     * размера массива, отражая поведение функции array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithNegativeLengthSmallerThanArraySize(): void
    {
        // Test with negative length smaller than array size (no padding)
        // Тест с отрицательной длиной меньше размера массива (без дополнения)
        $data = [1, 2, 3, 4, 5];
        $expected = array_pad($data, -3, 0);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->pad(-3, 0)->getDataAsArray());
    }

    /**
     * Tests the pad() method with string values.
     *
     * This test verifies that the pad() method correctly handles string values
     * for both the array elements and the padding value, mirroring PHP's
     * array_pad() function behavior.
     *
     *
     * Тестирование метода pad() со строковыми значениями.
     *
     * Этот тест проверяет, что метод pad() корректно обрабатывает строковые значения
     * как для элементов массива, так и для значения дополнения, отражая поведение
     * функции array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithStringValues(): void
    {
        // Test with string values
        // Тест со строковыми значениями
        $data = ['a', 'b', 'c'];
        $expected = array_pad($data, 5, 'default');

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->pad(5, 'default')->getDataAsArray());
    }

    /**
     * Tests the pad() method with array as padding value.
     *
     * This test verifies that the pad() method correctly handles array values
     * for padding, converting nested arrays to CoverArray instances,
     * mirroring PHP's array_pad() function behavior but with conversion of arrays.
     *
     *
     * Тестирование метода pad() с массивом в качестве значения дополнения.
     *
     * Этот тест проверяет, что метод pad() корректно обрабатывает значения-массивы
     * для дополнения, преобразуя вложенные массивы в экземпляры CoverArray,
     * отражая поведение функции array_pad() PHP, но с преобразованием массивов.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithArrayAsPaddingValue(): void
    {
        // Test with array as padding value
        // Тест с массивом в качестве значения для дополнения
        $data = [1, 2];
        $padValue = ['nested' => 'value'];
        $expected = array_pad($data, 4, $padValue);

        $cover = new CoverArray($data);
        $result = $cover->pad(4, $padValue);

        // Проверяем первые два элемента (исходные)
        $this->assertSame($expected[0], $result[0]);
        $this->assertSame($expected[1], $result[1]);

        // Проверяем, что добавленные элементы являются CoverArray
        $this->assertInstanceOf(CoverArray::class, $result[2]);
        $this->assertInstanceOf(CoverArray::class, $result[3]);
        $this->assertSame($padValue, $result[2]->getDataAsArray());
        $this->assertSame($padValue, $result[3]->getDataAsArray());
    }

    /**
     * Tests the pad() method with CoverArray as padding value.
     *
     * This test verifies that the pad() method correctly handles CoverArray
     * objects as padding values, preserving them without additional conversion.
     *
     *
     * Тестирование метода pad() с CoverArray в качестве значения дополнения.
     *
     * Этот тест проверяет, что метод pad() корректно обрабатывает объекты
     * CoverArray как значения для дополнения, сохраняя их без дополнительного преобразования.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithCoverArrayAsPaddingValue(): void
    {
        // Test with CoverArray as padding value
        // Тест с CoverArray в качестве значения дополнения
        $data = [1, 2];
        $padValue = new CoverArray(['x' => 1, 'y' => 2]);
        $expected = array_pad($data, 4, $padValue);

        $cover = new CoverArray($data);
        $result = $cover->pad(4, $padValue);

        // Проверяем, что результат имеет правильную длину
        $this->assertCount(4, $result);

        // Проверяем, что добавленные элементы являются тем же объектом CoverArray
        $this->assertSame($padValue, $result[2]);
        $this->assertSame($padValue, $result[3]);
        $this->assertInstanceOf(CoverArray::class, $result[2]);
    }

    /**
     * Tests the pad() method with null as padding value.
     *
     * This test verifies that the pad() method correctly handles null values
     * for padding, mirroring PHP's array_pad() function behavior.
     *
     *
     * Тестирование метода pad() с null в качестве значения дополнения.
     *
     * Этот тест проверяет, что метод pad() корректно обрабатывает значения null
     * для дополнения, отражая поведение функции array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithNullAsPaddingValue(): void
    {
        // Test with null as padding value
        // Тест с null в качестве значения для дополнения
        $data = ['a', 'b'];
        $expected = array_pad($data, 4, null);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->pad(4, null)->getDataAsArray());
    }

    /**
     * Tests the pad() method with empty array.
     *
     * This test verifies that the pad() method correctly handles empty arrays,
     * creating a new array of the specified length with the padding value,
     * mirroring PHP's array_pad() function behavior.
     *
     *
     * Тестирование метода pad() с пустым массивом.
     *
     * Этот тест проверяет, что метод pad() корректно обрабатывает пустые массивы,
     * создавая новый массив указанной длины со значением дополнения,
     * отражая поведение функции array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithEmptyArray(): void
    {
        // Test with empty array
        // Тест с пустым массивом
        $data = [];
        $expected = array_pad($data, 3, 'fill');

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->pad(3, 'fill')->getDataAsArray());
    }

    /**
     * Tests the pad() method with length zero.
     *
     * This test verifies that the pad() method returns the original array
     * when length is zero, mirroring PHP's array_pad() function behavior.
     *
     *
     * Тестирование метода pad() с длиной ноль.
     *
     * Этот тест проверяет, что метод pad() возвращает исходный массив
     * когда длина равна нулю, отражая поведение функции array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithLengthZero(): void
    {
        // Test with length 0
        // Тест с длиной 0
        $data = [1, 2, 3];
        $expected = array_pad($data, 0, 0);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->pad(0, 0)->getDataAsArray());
    }

    /**
     * Tests the pad() method with associative array.
     *
     * This test verifies that the pad() method correctly handles associative arrays,
     * reindexing keys when padding, mirroring PHP's array_pad() function behavior.
     *
     *
     * Тестирование метода pad() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод pad() корректно обрабатывает ассоциативные массивы,
     * переиндексируя ключи при дополнении, отражая поведение функции array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithAssociativeArray(): void
    {
        // Test with associative array (keys are reindexed)
        // Тест с ассоциативным массивом (ключи переиндексируются)
        $data = ['a' => 1, 'b' => 2];
        $expected = array_pad($data, 4, 0);

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->pad(4, 0)->getDataAsArray());
    }

    /**
     * Tests the pad() method with mixed padding (left and right).
     *
     * This test verifies that the pad() method correctly pads both left and right
     * when the absolute value of length is greater than the array size and length
     * is positive, mirroring PHP's array_pad() function behavior.
     *
     *
     * Тестирование метода pad() со смешанным дополнением (слева и справа).
     *
     * Этот тест проверяет, что метод pad() корректно дополняет и слева, и справа
     * когда абсолютное значение длины больше размера массива и длина положительная,
     * отражая поведение функции array_pad() PHP.
     *
     * @see CoverArray::pad()
     * @see array_pad()
     */
    public function testPadWithMixedPadding(): void
    {
        // Test with mixed padding (left and right with same value)
        // Тест со смешанным дополнением (слева и справа одинаковым значением)
        $data = [1, 2, 3];
        $expected = array_pad($data, 7, 'x');

        $cover = new CoverArray($data);
        $this->assertSame($expected, $cover->pad(7, 'x')->getDataAsArray());
    }
}