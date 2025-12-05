<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods\CoverArrayMagicMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class ToStringTest extends TestCase
{
    /**
     * Tests default __toString() returns empty string.
     *
     * This test verifies that the default implementation of __toString()
     * in the CoverArray class returns an empty string, as specified
     * in the method's documentation. This allows subclasses to override
     * the method with custom string representation logic.
     *
     *
     * Тестирование возврата пустой строки по умолчанию в __toString().
     *
     * Этот тест проверяет, что реализация __toString() по умолчанию
     * в классе CoverArray возвращает пустую строку, как указано
     * в документации метода. Это позволяет подклассам переопределять
     * метод с пользовательской логикой строкового представления.
     *
     * @see CoverArray::__toString()
     */
    public function testDefaultToStringReturnsEmptyString(): void
    {
        $array = new NewTypeArray(['key' => 'value']);
        $result = (string) $array;

        $this->assertSame('', $result);
        $this->assertEmpty($result);
        $this->assertIsString($result);
    }

    /**
     * Tests __toString() with different data states.
     *
     * This test ensures that CoverArray objects return an empty string
     * when cast to string, regardless of data content or modifications.
     * It covers empty arrays, data modifications, and complex structures.
     *
     *
     * Тестирование __toString() с различными состояниями данных.
     *
     * Этот тест гарантирует, что объекты CoverArray возвращают пустую строку
     * при приведении к строке, независимо от содержимого данных или модификаций.
     * Он охватывает пустые массивы, модификации данных и сложные структуры.
     *
     * @see CoverArray::__toString()
     */
    public function testToStringWithVariousDataStates(): void
    {
        // Тест с пустым массивом
        $emptyArray = new NewTypeArray();
        $this->assertSame('', (string) $emptyArray);
        $this->assertEmpty((string) $emptyArray);

        // Тест с данными и последующими модификациями
        $array = new NewTypeArray(['initial' => 'value']);
        $initialString = (string) $array;

        $array->newKey = 'new_value';
        $array->initial = 'modified';
        unset($array->initial);
        $modifiedString = (string) $array;

        $this->assertSame('', $initialString);
        $this->assertSame('', $modifiedString);
        $this->assertSame($initialString, $modifiedString);

        // Тест со сложной структурой данных
        $complexArray = new NewTypeArray([
            'string' => 'text',
            'int' => 42,
            'array' => [1, 2, 3],
            'object' => new stdClass(),
            'null' => null,
            'nested' => new NewTypeArray([
                'inner' => new NewTypeArray([
                    'deep' => 'value'
                ])
            ])
        ]);

        $this->assertSame('', (string) $complexArray);
    }

    /**
     * Tests __toString() behavior in different string contexts.
     *
     * This test verifies that CoverArray objects behave correctly
     * in various string contexts including concatenation, interpolation,
     * and output functions.
     *
     *
     * Тестирование поведения __toString() в различных строковых контекстах.
     *
     * Этот тест проверяет, что объекты CoverArray ведут себя корректно
     * в различных строковых контекстах, включая конкатенацию, интерполяцию
     * и функции вывода.
     *
     * @see CoverArray::__toString()
     */
    public function testToStringInDifferentStringContexts(): void
    {
        $array = new NewTypeArray(['key' => 'value']);

        // Конкатенация
        $concatenated = 'Prefix' . $array . 'Suffix';
        $this->assertEquals('PrefixSuffix', $concatenated);

        // Интерполяция строк
        $interpolated = "Value: $array";
        $this->assertEquals('Value: ', $interpolated);

        // Функции вывода
        ob_start();
        echo $array;
        $echoOutput = ob_get_clean();
        $this->assertEquals('', $echoOutput);

        ob_start();
        print $array;
        $printOutput = ob_get_clean();
        $this->assertEquals('', $printOutput);

        // Строковые операции
        $this->assertEquals('', strtoupper((string) $array));
        $this->assertEquals('', trim((string) $array));
        $this->assertEquals(0, strlen((string) $array));
    }

    /**
     * Tests __toString() can be overridden in subclasses.
     *
     * This test verifies that subclasses can successfully override
     * the __toString() method to provide custom string representation
     * while the base class still returns an empty string.
     *
     *
     * Тестирование возможности переопределения __toString() в подклассах.
     *
     * Этот тест проверяет, что подклассы могут успешно переопределять
     * метод __toString() для предоставления пользовательского строкового
     * представления, в то время как базовый класс все еще возвращает пустую строку.
     *
     * @see CoverArray::__toString()
     */
    public function testToStringCanBeOverriddenInSubclasses(): void
    {
        // Подкласс с простым переопределением
        $simpleCustomArray = new class extends NewTypeArray {
            public function __toString(): string
            {
                return 'CustomString';
            }
        };

        $simpleCustomArray->setData(['key' => 'value']);
        $this->assertEquals('CustomString', (string) $simpleCustomArray);

        // Подкласс с переопределением, использующим данные
        $dataAwareCustomArray = new class extends NewTypeArray {
            public function __toString(): string
            {
                return json_encode($this->getDataAsArray(), JSON_THROW_ON_ERROR);
            }
        };

        $dataAwareCustomArray->setData(['name' => 'John', 'age' => 30]);
        $result = (string) $dataAwareCustomArray;

        $this->assertJson($result);
        $decoded = json_decode($result, true);
        $this->assertEquals(['name' => 'John', 'age' => 30], $decoded);

        // Проверяем, что базовый класс по-прежнему возвращает пустую строку
        $baseArray = new NewTypeArray(['same' => 'data']);
        $this->assertEquals('', (string) $baseArray);
    }

    /**
     * Tests __toString() does not modify internal data.
     *
     * This test ensures that casting to string does not modify
     * the internal data structure of the CoverArray object and
     * handles edge cases correctly.
     *
     *
     * Тестирование того, что __toString() не изменяет внутренние данные.
     *
     * Этот тест гарантирует, что приведение к строке не изменяет
     * внутреннюю структуру данных объекта CoverArray и корректно
     * обрабатывает граничные случаи.
     *
     * @see CoverArray::__toString()
     */
    public function testToStringDoesNotModifyDataAndHandlesEdgeCases(): void
    {
        $data = [
            'key1' => 'value1',
            'key2' => [1, 2, 3],
            'key3' => new NewTypeArray(['nested' => 'value'])
        ];

        $array = new NewTypeArray($data);
        $originalData = $array->getDataAsArray();

        // Многократное приведение к строке
        $string1 = (string) $array;
        $string2 = (string) $array;
        $string3 = (string) $array;

        // Проверяем, что данные не изменились
        $this->assertEquals($originalData, $array->getDataAsArray());
        $this->assertSame('', $string1);
        $this->assertSame('', $string2);
        $this->assertSame('', $string3);

        // Проверяем конкретные значения
        $this->assertEquals('value1', $array->key1);
        $this->assertInstanceOf(NewTypeArray::class, $array->key2);
        $this->assertEquals([1, 2, 3], $array->key2->getDataAsArray());
        $this->assertInstanceOf(NewTypeArray::class, $array->key3);

        // Граничные случаи
        // Циклическая ссылка
        $cyclicArray = new NewTypeArray(['self' => null]);
        $cyclicArray->self = $cyclicArray;
        $this->assertSame('', (string) $cyclicArray);

        // Большие данные
        $largeData = [];
        for ($i = 0; $i < 1000; $i++) {
            $largeData['key_' . $i] = 'value_' . $i;
        }
        $largeArray = new NewTypeArray($largeData);
        $this->assertSame('', (string) $largeArray);

        // Специальные символы
        $specialArray = new NewTypeArray([
            'newline' => "Line1\nLine2",
            'tab' => "Column1\tColumn2",
            'unicode' => "Привет 世界 🌍",
            'binary' => "\x00\x01\x02\x03"
        ]);
        $this->assertSame('', (string) $specialArray);
    }

    /**
     * Tests __toString() performance and comparison operations.
     *
     * This test verifies that the __toString() method performs
     * efficiently and behaves correctly in comparison operations.
     *
     *
     * Тестирование производительности __toString() и операций сравнения.
     *
     * Этот тест проверяет, что метод __toString() выполняется
     * эффективно и ведет себя корректно в операциях сравнения.
     *
     * @see CoverArray::__toString()
     */
    public function testToStringPerformanceAndComparisons(): void
    {
        // Производительность с большим набором данных
        $largeData = [];
        for ($i = 0; $i < 5000; $i++) {
            $largeData['key_' . $i] = str_repeat('value', 20);
        }

        $array = new NewTypeArray($largeData);

        $startTime = microtime(true);
        $result = (string) $array;
        $endTime = microtime(true);

        $executionTime = $endTime - $startTime;

        $this->assertSame('', $result);
        // Преобразование в строку должно быть быстрым
        $this->assertLessThan(0.01, $executionTime,
            '__toString() should be very fast even with large datasets');

        // Операции сравнения
        $array = new NewTypeArray(['data' => 'value']);
        $stringValue = (string) $array;

        $this->assertSame('', $stringValue);
        $this->assertTrue($stringValue === '');
        $this->assertTrue($stringValue == '');
        $this->assertFalse($stringValue === 'not empty');
        $this->assertFalse($stringValue == 'not empty');

        // Слабое сравнение с другими пустыми значениями
        $this->assertTrue($stringValue == null);
        $this->assertFalse($stringValue == 0);
        $this->assertTrue($stringValue == false);

        // Строгое сравнение
        $this->assertFalse($stringValue === null);
        $this->assertFalse($stringValue === 0);
        $this->assertFalse($stringValue === false);

        // Сравнение с другими пустыми строками
        $this->assertTrue($stringValue === '');
        $this->assertFalse($stringValue === ' ');
        $this->assertFalse($stringValue === '0');
    }
}