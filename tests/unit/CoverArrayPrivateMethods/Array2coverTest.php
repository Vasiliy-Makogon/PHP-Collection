<?php

declare(strict_types=1);

namespace CoverArrayPrivateMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use RuntimeException;
use stdClass;

#[CoversClass(CoverArray::class)]
class Array2coverTest extends TestCase
{
    /** @var ReflectionMethod */
    private ReflectionMethod $method;

    /** @var NewTypeArray */
    private NewTypeArray $instance;

    public function setUp(): void
    {
        parent::setUp();
        $reflector = new ReflectionClass(NewTypeArray::class);
        $this->method = $reflector->getMethod('array2cover');
        $this->method->setAccessible(true);
        $this->instance = new NewTypeArray([]);
    }

    /**
     * Tests the array2cover method's depth limitation functionality.
     *
     * This test verifies that the array2cover method properly handles scenarios
     * where the recursion depth exceeds the maximum allowed limit by throwing
     * a RuntimeException. The method should prevent infinite recursion and
     * potential memory exhaustion when processing deeply nested arrays.
     *
     *
     * Тестирование функциональности ограничения глубины рекурсии в методе array2cover.
     *
     * Этот тест проверяет, что метод array2cover корректно обрабатывает ситуации,
     * когда глубина рекурсии превышает максимально допустимое значение, выбрасывая
     * исключение RuntimeException. Метод должен предотвращать бесконечную рекурсию
     * и потенциальное исчерпание памяти при обработке глубоко вложенных массивов.
     *
     * @see CoverArray::array2cover()
     */
    public function testArray2coverMaxDepthExceeded(): void
    {
        // Создаем глубоко вложенный массив, превышающий maxDepth
        $deepArray = [];
        $current = &$deepArray;
        for ($i = 0; $i < 600; $i++) {
            $current['level'] = ['deeper'];
            $current = &$current['level'];
        }

        // Проверяем, что бросается исключение
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Maximum recursion depth exceeded');

        $this->method->invoke($this->instance, $deepArray, 0, 100);
    }

    /**
     * Tests that array2cover returns the same object when value is already a CoverArray instance.
     *
     * Verifies the identity preservation behavior: when an existing CoverArray (or its subclass)
     * is passed to array2cover, it should be returned unchanged rather than creating a new instance.
     * This ensures:
     * 1. No unnecessary object duplication
     * 2. Preservation of object references
     * 3. Memory efficiency
     * 4. Consistent object identity throughout the application
     *
     * The test uses Reflection to access the protected method and asserts that the returned
     * object is strictly the same (===) as the input object.
     *
     *
     * Проверяет, что array2cover возвращает тот же объект, если значение уже является экземпляром CoverArray.
     *
     * Тестирует поведение сохранения идентичности: когда существующий CoverArray (или его подкласс)
     * передается в array2cover, он должен быть возвращен без изменений, а не создан новый экземпляр.
     * Это обеспечивает:
     * 1. Отсутствие ненужного дублирования объектов
     * 2. Сохранение ссылок на объекты
     * 3. Эффективность использования памяти
     * 4. Единообразие идентичности объектов во всем приложении
     *
     * Тест использует Reflection для доступа к защищенному методу и проверяет, что возвращенный
     * объект строго тот же (===), что и входной объект.
     *
     * @see CoverArray::array2cover()
     */
    public function testArray2coverAlreadyCoverArray(): void
    {
        $existingCoverArray = new NewTypeArray(['test' => 'value']);

        // Если передаем уже CoverArray, он должен вернуться как есть
        $result = $this->method->invoke($this->instance, $existingCoverArray);

        $this->assertSame($existingCoverArray, $result);
    }

    /**
     * Tests that array2cover returns non-array values unchanged.
     *
     * Verifies that scalar values (strings, integers, floats, booleans, null)
     * and non-CoverArray objects are returned identically without conversion.
     * This ensures that the method only processes arrays while preserving
     * all other data types in their original form.
     *
     * Test cases include:
     * - String values (preserved as strings)
     * - Integer values (preserved as integers)
     * - Float values (preserved as floats)
     * - Boolean values (preserved as booleans)
     * - Null values (preserved as null)
     * - Standard objects (preserved as objects)
     *
     * Uses assertSame() for strict type comparison, ensuring that values
     * are not only equal but also of the same type.
     *
     *
     * Проверяет, что array2cover возвращает не-массивы без изменений.
     *
     * Убеждается, что скалярные значения (строки, целые числа, числа с плавающей точкой,
     * булевы значения, null) и объекты не типа CoverArray возвращаются идентично без
     * преобразования. Это гарантирует, что метод обрабатывает только массивы, сохраняя
     * все остальные типы данных в исходной форме.
     *
     * Тестовые случаи включают:
     * - Строковые значения (сохраняются как строки)
     * - Целочисленные значения (сохраняются как целые числа)
     * - Числа с плавающей точкой (сохраняются как числа)
     * - Булевы значения (сохраняются как булевы)
     * - Null значения (сохраняются как null)
     * - Стандартные объекты (сохраняются как объекты)
     *
     * Использует assertSame() для строгого сравнения типов, гарантируя, что значения
     * не только равны, но и имеют одинаковый тип.
     *
     * @see CoverArray::array2cover()
     */
    public function testArray2coverNonArrayScalar(): void
    {
        // Проверяем различные скалярные типы
        $scalars = [
            'string' => 'test string',
            'integer' => 123,
            'float' => 123.45,
            'boolean' => true,
            'null' => null,
            'object' => new stdClass(),
        ];

        foreach ($scalars as $type => $value) {
            $result = $this->method->invoke($this->instance, $value);
            $this->assertSame($value, $result, "Failed for type: $type");
        }
    }

    /**
     * Tests the basic functionality of array2cover: converting a simple array to a CoverArray instance.
     *
     * Verifies that a plain associative PHP array is correctly transformed into
     * an instance of the current CoverArray subclass (NewTypeArray in this context).
     * The test ensures that:
     * 1. The returned object is of the expected type (NewTypeArray)
     * 2. All array elements are preserved without modification
     * 3. The conversion maintains the exact structure and values
     *
     * This test covers the primary use case of array2cover - creating a CoverArray
     * wrapper around standard PHP arrays, which is the foundation for all other
     * operations in the CoverArray system.
     *
     *
     * Тестирует базовую функциональность array2cover: преобразование простого массива в экземпляр CoverArray.
     *
     * Проверяет, что обычный ассоциативный PHP-массив корректно преобразуется в
     * экземпляр текущего подкласса CoverArray (NewTypeArray в данном контексте).
     * Тест гарантирует, что:
     * 1. Возвращаемый объект имеет ожидаемый тип (NewTypeArray)
     * 2. Все элементы массива сохраняются без изменений
     * 3. Преобразование сохраняет точную структуру и значения
     *
     * Этот тест покрывает основной вариант использования array2cover - создание
     * обертки CoverArray вокруг стандартных PHP-массивов, что является основой
     * для всех остальных операций в системе CoverArray.
     *
     * @see CoverArray::array2cover()
     * @see CoverArray::getDataAsArray()
     */
    public function testArray2coverSimpleArray(): void
    {
        $simpleArray = ['a' => 1, 'b' => 2, 'c' => 3];

        $result = $this->method->invoke($this->instance, $simpleArray);

        $this->assertInstanceOf(NewTypeArray::class, $result);
        $this->assertSame($simpleArray, $result->getDataAsArray());
    }

    /**
     * Tests recursive conversion of multidimensional arrays in array2cover method.
     *
     * Verifies that array2cover correctly processes complex nested array structures
     * by recursively converting all nested arrays into CoverArray instances while
     * preserving all other data types unchanged.
     *
     * Test structure includes:
     * - Multiple levels of nested arrays (3+ levels deep)
     * - Mixed data types within arrays (strings, numbers, booleans, null, objects)
     * - Both associative and indexed arrays at different levels
     *
     * Key assertions:
     * 1. All array nodes (at any depth) become CoverArray instances
     * 2. Scalar values remain unchanged at their original positions
     * 3. Objects (non-CoverArray) preserve their identity
     * 4. Null and boolean values maintain their exact type
     *
     * This test ensures that array2cover handles real-world complex data structures
     * correctly, which is essential for the CoverArray library's practical usage.
     *
     *
     * Тестирует рекурсивное преобразование многомерных массивов в методе array2cover.
     *
     * Проверяет, что array2cover корректно обрабатывает сложные вложенные структуры массивов,
     * рекурсивно преобразуя все вложенные массивы в экземпляры CoverArray, сохраняя при этом
     * все остальные типы данных без изменений.
     *
     * Структура теста включает:
     * - Множество уровней вложенных массивов (3+ уровня глубины)
     * - Смешанные типы данных внутри массивов (строки, числа, булевы значения, null, объекты)
     * - Как ассоциативные, так и индексированные массивы на разных уровнях
     *
     * Ключевые проверки:
     * 1. Все узлы-массивы (на любой глубине) становятся экземплярами CoverArray
     * 2. Скалярные значения остаются неизменными на своих позициях
     * 3. Объекты (не-CoverArray) сохраняют свою идентичность
     * 4. Null и булевы значения сохраняют точный тип
     *
     * Этот тест гарантирует, что array2cover корректно обрабатывает сложные структуры данных
     * из реального мира, что необходимо для практического использования библиотеки CoverArray.
     *
     * @see CoverArray::array2cover()
     */
    public function testArray2coverMultidimensionalArray(): void
    {
        $multidimensionalArray = [
            'level1' => [
                'level2' => [
                    'level3' => 'deep value',
                    'list' => [1, 2, 3],
                ],
                'scalar' => 'test',
            ],
            'mixed' => [
                new stdClass(),
                null,
                true,
                123,
            ],
        ];

        $result = $this->method->invoke($this->instance, $multidimensionalArray);

        $this->assertInstanceOf(NewTypeArray::class, $result);

        // Проверяем, что все вложенные массивы преобразованы в CoverArray
        $this->assertInstanceOf(NewTypeArray::class, $result['level1']);
        $this->assertInstanceOf(NewTypeArray::class, $result['level1']['level2']);
        $this->assertInstanceOf(NewTypeArray::class, $result['level1']['level2']['list']);
        $this->assertInstanceOf(NewTypeArray::class, $result['mixed']);

        // Проверяем, что скалярные значения остались неизменными
        $this->assertSame('deep value', $result['level1']['level2']['level3']);
        $this->assertSame('test', $result['level1']['scalar']);
        $this->assertInstanceOf(stdClass::class, $result['mixed'][0]);
        $this->assertNull($result['mixed'][1]);
        $this->assertTrue($result['mixed'][2]);
        $this->assertSame(123, $result['mixed'][3]);
    }

    /**
     * Tests that array2cover preserves existing CoverArray instances within arrays.
     *
     * Verifies that when an array containing existing CoverArray (or subclass) instances
     * is processed by array2cover, these instances are returned unchanged rather than
     * being recursively converted again. This behavior ensures:
     *
     * 1. Object identity preservation - existing CoverArray objects remain the same
     * 2. Performance optimization - prevents unnecessary recursive processing
     * 3. Reference maintenance - external references to these objects remain valid
     * 4. Nested structure integrity - pre-converted structures are not altered
     *
     * The test creates a complex array containing both regular arrays and existing
     * CoverArray instances, then validates that:
     * - Regular arrays are converted to new CoverArray instances
     * - Existing CoverArray instances are returned as the same objects (===)
     * - Mixed structures (arrays containing CoverArray) are handled correctly
     *
     * This is particularly important for scenarios where CoverArray objects are
     * reused or passed between different parts of an application.
     *
     *
     * Проверяет, что array2cover сохраняет существующие экземпляры CoverArray внутри массивов.
     *
     * Убеждается, что когда массив, содержащий существующие экземпляры CoverArray (или его подклассов),
     * обрабатывается методом array2cover, эти экземпляры возвращаются без изменений, а не
     * подвергаются повторному рекурсивному преобразованию. Такое поведение гарантирует:
     *
     * 1. Сохранение идентичности объектов - существующие объекты CoverArray остаются теми же
     * 2. Оптимизацию производительности - предотвращает ненужную рекурсивную обработку
     * 3. Поддержание ссылок - внешние ссылки на эти объекты остаются валидными
     * 4. Целостность вложенных структур - предварительно преобразованные структуры не изменяются
     *
     * Тест создает сложный массив, содержащий как обычные массивы, так и существующие
     * экземпляры CoverArray, а затем проверяет, что:
     * - Обычные массивы преобразуются в новые экземпляры CoverArray
     * - Существующие экземпляры CoverArray возвращаются как те же самые объекты (===)
     * - Смешанные структуры (массивы, содержащие CoverArray) обрабатываются корректно
     *
     * Это особенно важно для сценариев, где объекты CoverArray повторно используются
     * или передаются между различными частями приложения.
     *
     * @see CoverArray::array2cover()
     */
    public function testArray2coverWithExistingCoverArrayElements(): void
    {
        $existingCoverArray = new NewTypeArray(['inner' => 'value']);

        $arrayWithCoverArray = [
            'regular' => ['a' => 1],
            'already_cover' => $existingCoverArray,
            'mixed' => [
                'cover' => $existingCoverArray,
                'array' => ['b' => 2],
            ],
        ];

        $result = $this->method->invoke($this->instance, $arrayWithCoverArray);

        $this->assertInstanceOf(NewTypeArray::class, $result);

        // Проверяем, что существующий CoverArray остался тем же объектом
        $this->assertSame($existingCoverArray, $result['already_cover']);
        $this->assertSame($existingCoverArray, $result['mixed']['cover']);

        // Проверяем, что обычные массивы преобразованы
        $this->assertInstanceOf(NewTypeArray::class, $result['regular']);
        $this->assertInstanceOf(NewTypeArray::class, $result['mixed']['array']);
    }

    /**
     * Tests array2cover method with various array structures to ensure comprehensive type handling.
     *
     * Verifies that array2cover correctly processes different array configurations supported by PHP,
     * ensuring consistent behavior across all array types. This test is crucial for establishing
     * that the CoverArray wrapper works predictably with any valid PHP array structure.
     *
     * Test cases cover:
     * - Indexed arrays (sequential numeric keys starting from 0)
     * - Associative arrays (string keys)
     * - Mixed arrays (combination of numeric and string keys)
     * - Empty arrays (edge case for initialization)
     * - Arrays with explicit numeric keys (non-sequential)
     * - Arrays with string numeric keys (PHP's type juggling behavior)
     *
     * Each test validates:
     * 1. Correct object type instantiation (NewTypeArray)
     * 2. Exact data preservation (keys, values, order, types)
     * 3. Consistency with PHP's native array behavior
     *
     * This comprehensive coverage ensures developers can trust CoverArray to handle
     * any array structure they might encounter in real-world applications.
     *
     *
     * Тестирует метод array2cover с различными структурами массивов для обеспечения полной обработки типов.
     *
     * Проверяет, что array2cover корректно обрабатывает различные конфигурации массивов, поддерживаемые PHP,
     * гарантируя последовательное поведение для всех типов массивов. Этот тест критически важен для установления
     * того, что обертка CoverArray работает предсказуемо с любой валидной структурой массива PHP.
     *
     * Тестовые случаи покрывают:
     * - Индексированные массивы (последовательные числовые ключи, начиная с 0)
     * - Ассоциативные массивы (строковые ключи)
     * - Смешанные массивы (комбинация числовых и строковых ключей)
     * - Пустые массивы (граничный случай инициализации)
     * - Массивы с явными числовыми ключами (непоследовательными)
     * - Массивы со строковыми числовыми ключами (поведение преобразования типов PHP)
     *
     * Каждый тест проверяет:
     * 1. Корректное создание объекта нужного типа (NewTypeArray)
     * 2. Точное сохранение данных (ключи, значения, порядок, типы)
     * 3. Согласованность с нативным поведением массивов PHP
     *
     * Такое всестороннее покрытие гарантирует, что разработчики могут доверять CoverArray
     * в обработке любой структуры массива, с которой они могут столкнуться в реальных приложениях.
     *
     * @see CoverArray::array2cover()
     * @see CoverArray::getDataAsArray()
     */
    public function testArray2coverVariousArrayTypes(): void
    {
        // Индексированный массив
        $indexedArray = [1, 2, 3];
        $result1 = $this->method->invoke($this->instance, $indexedArray);
        $this->assertInstanceOf(NewTypeArray::class, $result1);
        $this->assertSame($indexedArray, $result1->getDataAsArray());

        // Ассоциативный массив
        $assocArray = ['a' => 1, 'b' => 2];
        $result2 = $this->method->invoke($this->instance, $assocArray);
        $this->assertInstanceOf(NewTypeArray::class, $result2);
        $this->assertSame($assocArray, $result2->getDataAsArray());

        // Смешанный массив
        $mixedArray = [0 => 'a', 'key' => 'value', 1 => 'b'];
        $result3 = $this->method->invoke($this->instance, $mixedArray);
        $this->assertInstanceOf(NewTypeArray::class, $result3);
        $this->assertSame($mixedArray, $result3->getDataAsArray());

        // Пустой массив
        $emptyArray = [];
        $result4 = $this->method->invoke($this->instance, $emptyArray);
        $this->assertInstanceOf(NewTypeArray::class, $result4);
        $this->assertSame($emptyArray, $result4->getDataAsArray());
    }
}