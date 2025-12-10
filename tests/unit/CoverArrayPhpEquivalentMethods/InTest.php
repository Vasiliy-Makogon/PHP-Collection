<?php

declare(strict_types=1);

namespace CoverArrayPhpEquivalentMethods;

use Krugozor\Cover\CoverArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class InTest extends TestCase
{
    /**
     * Tests the in() method with integer search using strict comparison.
     *
     * This test verifies that the in() method correctly finds
     * an integer value in the CoverArray using strict type comparison,
     * mirroring PHP's in_array() function with strict parameter set to true.
     *
     *
     * Тестирование метода in() с поиском целого числа и строгим сравнением.
     *
     * Этот тест проверяет, что метод in() корректно находит
     * целочисленное значение в CoverArray, используя строгое сравнение типов,
     * отражая функцию in_array() PHP с параметром strict установленным в true.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithIntegerSearchStrictComparison(): void
    {
        $data = [1982, 1990, 2000];
        $cover = new CoverArray($data);

        $expected = in_array(1982, $data, true);
        $result = $cover->in(1982, true);

        $this->assertSame($expected, $result);
    }

    /**
     * Tests the in() method with integer search using non-strict comparison.
     *
     * This test verifies that the in() method correctly finds
     * an integer value in the CoverArray using non-strict comparison,
     * mirroring PHP's in_array() function with strict parameter set to false.
     *
     *
     * Тестирование метода in() с поиском целого числа и нестрогим сравнением.
     *
     * Этот тест проверяет, что метод in() корректно находит
     * целочисленное значение в CoverArray, используя нестрогое сравнение,
     * отражая функцию in_array() PHP с параметром strict установленным в false.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithIntegerSearchNonStrictComparison(): void
    {
        $data = [1982, 1990, 2000];
        $cover = new CoverArray($data);

        $expected = in_array(1982, $data, false);
        $result = $cover->in(1982, false);

        $this->assertSame($expected, $result);
    }

    /**
     * Tests the in() method with string vs integer using non-strict comparison.
     *
     * This test verifies that the in() method correctly finds
     * a string value that equals an integer in the CoverArray
     * using non-strict comparison, mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() со строкой против целого числа и нестрогим сравнением.
     *
     * Этот тест проверяет, что метод in() корректно находит
     * строковое значение, равное целому числу в CoverArray,
     * используя нестрогое сравнение, отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithStringVsIntegerNonStrictComparison(): void
    {
        $data = [1982, 1990, 2000];
        $cover = new CoverArray($data);

        $expected = in_array('1982', $data, false);
        $result = $cover->in('1982', false);

        $this->assertSame($expected, $result);
    }

    /**
     * Tests the in() method with string vs integer using strict comparison.
     *
     * This test verifies that the in() method correctly does not find
     * a string value when looking for an integer in the CoverArray
     * using strict comparison, mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() со строкой против целого числа и строгим сравнением.
     *
     * Этот тест проверяет, что метод in() корректно не находит
     * строковое значение при поиске целого числа в CoverArray,
     * используя строгое сравнение, отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithStringVsIntegerStrictComparison(): void
    {
        $data = [1982, 1990, 2000];
        $cover = new CoverArray($data);

        $expected = in_array('1982', $data, true);
        $result = $cover->in('1982', true);

        $this->assertSame($expected, $result);
    }

    /**
     * Tests that the in() method does not modify the original CoverArray.
     *
     * This test verifies that the in() method does not modify
     * the original CoverArray instance when searching for values.
     *
     *
     * Тестирование, что метод in() не изменяет исходный CoverArray.
     *
     * Этот тест проверяет, что метод in() не изменяет
     * исходный экземпляр CoverArray при поиске значений.
     *
     * @see CoverArray::in()
     */
    public function testInDoesNotModifyOriginalArray(): void
    {
        $data = [1982, 1990, 2000];
        $cover = new CoverArray($data);

        $cover->in(1982, true);

        $this->assertSame($data, $cover->getDataAsArray());
    }

    /**
     * Tests the in() method with non-existent value.
     *
     * This test verifies that the in() method correctly returns false
     * when searching for a value that does not exist in the CoverArray,
     * mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() с несуществующим значением.
     *
     * Этот тест проверяет, что метод in() корректно возвращает false
     * при поиске значения, которого нет в CoverArray,
     * отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithNonExistentValue(): void
    {
        $data = [1982, 1990, 2000];
        $cover = new CoverArray($data);

        $expected = in_array(9999, $data, true);
        $result = $cover->in(9999, true);

        $this->assertSame($expected, $result);
    }

    /**
     * Tests the in() method with mixed type array and strict comparison.
     *
     * This test verifies that the in() method correctly finds
     * values of various types in a mixed-type array using strict comparison,
     * mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() со смешанным типом массива и строгим сравнением.
     *
     * Этот тест проверяет, что метод in() корректно находит
     * значения различных типов в массиве смешанных типов, используя строгое сравнение,
     * отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithMixedTypeArrayStrictComparison(): void
    {
        $data = [42, '42', 42.0, true, false, null, 'string'];
        $cover = new CoverArray($data);

        $this->assertSame(in_array(42, $data, true), $cover->in(42, true));
        $this->assertSame(in_array('42', $data, true), $cover->in('42', true));
        $this->assertSame(in_array(true, $data, true), $cover->in(true, true));
        $this->assertSame(in_array(null, $data, true), $cover->in(null, true));
    }

    /**
     * Tests the in() method with mixed type array and non-strict comparison.
     *
     * This test verifies that the in() method correctly finds
     * values of various types in a mixed-type array using non-strict comparison,
     * mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() со смешанным типом массива и нестрогим сравнением.
     *
     * Этот тест проверяет, что метод in() корректно находит
     * значения различных типов в массиве смешанных типов, используя нестрогое сравнение,
     * отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithMixedTypeArrayNonStrictComparison(): void
    {
        $data = [42, '42', 42.0, true, false, null, 'string'];
        $cover = new CoverArray($data);

        $this->assertSame(in_array(42, $data, false), $cover->in(42, false));
        $this->assertSame(in_array('42', $data, false), $cover->in('42', false));
        $this->assertSame(in_array(true, $data, false), $cover->in(true, false));
        $this->assertSame(in_array(1, $data, false), $cover->in(1, false));
    }

    /**
     * Tests the in() method with empty array.
     *
     * This test verifies that the in() method correctly returns false
     * when searching in an empty CoverArray, mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() с пустым массивом.
     *
     * Этот тест проверяет, что метод in() корректно возвращает false
     * при поиске в пустом CoverArray, отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithEmptyArray(): void
    {
        $cover = new CoverArray([]);

        $expected = in_array('anything', [], true);
        $result = $cover->in('anything', true);

        $this->assertSame($expected, $result);
    }

    /**
     * Tests the in() method with associative array.
     *
     * This test verifies that the in() method correctly finds
     * values in an associative CoverArray, mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() с ассоциативным массивом.
     *
     * Этот тест проверяет, что метод in() корректно находит
     * значения в ассоциативном CoverArray, отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithAssociativeArray(): void
    {
        $data = ['name' => 'John', 'age' => 30, 'city' => 'New York'];
        $cover = new CoverArray($data);

        $this->assertSame(in_array('John', $data, true), $cover->in('John', true));
        $this->assertSame(in_array(30, $data, true), $cover->in(30, true));
    }

    /**
     * Tests the in() method with array search.
     *
     * This test verifies that the in() method correctly searches
     * for arrays in the CoverArray, considering that nested arrays
     * are converted to CoverArray instances internally.
     *
     *
     * Тестирование метода in() с поиском массива.
     *
     * Этот тест проверяет, что метод in() корректно ищет
     * массивы в CoverArray, учитывая что вложенные массивы
     * преобразуются в экземпляры CoverArray внутри.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithArraySearch(): void
    {
        $data = ['top' => ['nested' => 'value'], 'other' => 'test'];
        $cover = new CoverArray($data);

        // В CoverArray вложенный массив ['nested' => 'value'] преобразован в CoverArray
        // Поэтому при строгом сравнении массив не равен объекту CoverArray
        $this->assertFalse($cover->in(['nested' => 'value'], true));

        // Проверяем, что объект CoverArray с такими же данными НЕ считается равным
        // (это другой объект)
        $innerCover = $cover->get('top');
        $this->assertInstanceOf(CoverArray::class, $innerCover);

        // Проверяем, что объект CoverArray содержится в данных
        $this->assertTrue($cover->in($innerCover, true));
    }

    /**
     * Tests the in() method with case-sensitive string comparison.
     *
     * This test verifies that the in() method correctly handles
     * case-sensitive string comparisons, mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() с регистрозависимым сравнением строк.
     *
     * Этот тест проверяет, что метод in() корректно обрабатывает
     * регистрозависимое сравнение строк, отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithCaseSensitiveStringComparison(): void
    {
        $data = ['PHP', 'MySQL', 'JavaScript'];
        $cover = new CoverArray($data);

        $this->assertSame(in_array('php', $data, true), $cover->in('php', true));
        $this->assertSame(in_array('PHP', $data, true), $cover->in('PHP', true));
    }

    /**
     * Tests the in() method with float comparison.
     *
     * This test verifies that the in() method correctly handles
     * float value comparisons, mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() со сравнением чисел с плавающей точкой.
     *
     * Этот тест проверяет, что метод in() корректно обрабатывает
     * сравнение чисел с плавающей точкой, отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithFloatComparison(): void
    {
        $data = [1.5, 2.0, 3.14159];
        $cover = new CoverArray($data);

        $this->assertSame(in_array(1.5, $data, true), $cover->in(1.5, true));
        $this->assertSame(in_array(2, $data, false), $cover->in(2, false));
        $this->assertSame(in_array(2, $data, true), $cover->in(2, true));
    }

    /**
     * Tests the in() method with default strict parameter.
     *
     * This test verifies that the in() method uses false as the default
     * value for the strict parameter, mirroring PHP's in_array() function.
     *
     *
     * Тестирование метода in() с параметром strict по умолчанию.
     *
     * Этот тест проверяет, что метод in() использует false в качестве
     * значения по умолчанию для параметра strict, отражая функцию in_array() PHP.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithDefaultStrictParameter(): void
    {
        $data = ['10', 10, 20];
        $cover = new CoverArray($data);

        $this->assertSame(in_array(10, $data, false), $cover->in(10));
        $this->assertSame(in_array('10', $data, false), $cover->in('10'));
    }

    /**
     * Tests the in() method with CoverArray as needle value.
     *
     * This test verifies that the in() method correctly handles
     * CoverArray objects as needle values, both with strict and non-strict comparison.
     *
     *
     * Тестирование метода in() со значением needle типа CoverArray.
     *
     * Этот тест проверяет, что метод in() корректно обрабатывает
     * объекты CoverArray как значения needle, как со строгим, так и с нестрогим сравнением.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithCoverArrayAsNeedle(): void
    {
        $innerCover = new CoverArray(['x' => 1, 'y' => 2]);
        $data = ['simple', $innerCover, 'another'];

        $cover = new CoverArray($data);

        // Strict comparison - should find exact same object
        // Строгое сравнение - должно найти точно тот же объект
        $expectedStrict = in_array($innerCover, $data, true);
        $resultStrict = $cover->in($innerCover, true);
        $this->assertSame($expectedStrict, $resultStrict);

        // Non-strict comparison - should also find the object
        // Нестрогое сравнение - также должно найти объект
        $expectedNonStrict = in_array($innerCover, $data, false);
        $resultNonStrict = $cover->in($innerCover, false);
        $this->assertSame($expectedNonStrict, $resultNonStrict);

        // Test with a different CoverArray instance with same content
        // Тест с другим экземпляром CoverArray с таким же содержимым
        $similarCover = new CoverArray(['x' => 1, 'y' => 2]);
        $expectedSimilarStrict = in_array($similarCover, $data, true);
        $resultSimilarStrict = $cover->in($similarCover, true);
        $this->assertSame($expectedSimilarStrict, $resultSimilarStrict);
    }

    /**
     * Tests the in() method with array containing CoverArray objects.
     *
     * This test verifies that the in() method correctly searches
     * for values in arrays that contain CoverArray objects as elements.
     * Since arrays are converted to CoverArray when stored, searching
     * for an array will not find a CoverArray object.
     *
     *
     * Тестирование метода in() с массивом, содержащим объекты CoverArray.
     *
     * Этот тест проверяет, что метод in() корректно ищет
     * значения в массивах, содержащих объекты CoverArray как элементы.
     * Поскольку массивы преобразуются в CoverArray при хранении, поиск
     * массива не найдет объект CoverArray.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithArrayContainingCoverArray(): void
    {
        $coverArray1 = new CoverArray(['a' => 1]);
        $coverArray2 = new CoverArray(['b' => 2]);

        $data = [$coverArray1, $coverArray2, 'simple'];

        $cover = new CoverArray($data);

        // Should find CoverArray objects
        // Должен найти объекты CoverArray
        $this->assertTrue($cover->in($coverArray1, true));
        $this->assertTrue($cover->in($coverArray2, true));

        // Should NOT find array with same content as CoverArray
        // НЕ должен найти массив с тем же содержимым, что и CoverArray
        $this->assertFalse($cover->in(['a' => 1], true));
        $this->assertFalse($cover->in(['b' => 2], true));
    }

    /**
     * Tests the in() method with nested arrays containing CoverArray.
     *
     * This test verifies that the in() method correctly searches
     * for values in arrays that contain CoverArray objects as elements.
     * Since nested arrays are converted to CoverArray, searching for
     * an array will not find a CoverArray object.
     *
     *
     * Тестирование метода in() с вложенными массивами, содержащими CoverArray.
     *
     * Этот тест проверяет, что метод in() корректно ищет
     * значения в массивах, содержащих объекты CoverArray как элементы.
     * Поскольку вложенные массивы преобразуются в CoverArray, поиск
     * массива не найдет объект CoverArray.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithNestedArraysContainingCoverArray(): void
    {
        $innerCover = new CoverArray(['inner' => 'value']);
        $data = [
            'top' => $innerCover,
            'array' => ['nested' => $innerCover],
            'simple' => 'test'
        ];

        $cover = new CoverArray($data);

        // Should find CoverArray at top level
        // Должен найти CoverArray на верхнем уровне
        $this->assertTrue($cover->in($innerCover, true));

        // Should NOT find array representation of CoverArray
        // НЕ должен найти представление CoverArray в виде массива
        $this->assertFalse($cover->in(['inner' => 'value'], true));
    }

    /**
     * Tests the in() method with boolean search.
     *
     * This test verifies that the in() method correctly handles
     * boolean values in various comparison modes.
     *
     *
     * Тестирование метода in() с поиском булевых значений.
     *
     * Этот тест проверяет, что метод in() корректно обрабатывает
     * булевы значения в различных режимах сравнения.
     *
     * @see CoverArray::in()
     * @see in_array()
     */
    public function testInWithBooleanSearch(): void
    {
        $data = [true, false, 1, 0, '1', ''];
        $cover = new CoverArray($data);

        // Strict comparison
        // Строгое сравнение
        $this->assertSame(in_array(true, $data, true), $cover->in(true, true));
        $this->assertSame(in_array(false, $data, true), $cover->in(false, true));

        // Non-strict comparison
        // Нестрогое сравнение
        $this->assertSame(in_array(true, $data, false), $cover->in(true, false));
        $this->assertSame(in_array(false, $data, false), $cover->in(false, false));
    }
}