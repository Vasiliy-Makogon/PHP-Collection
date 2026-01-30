<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class FromArrayTest extends TestCase
{
    /**
     * Tests fromArray() static factory method creates CoverArray from native array.
     *
     * This test verifies that the fromArray() method correctly creates
     * a new CoverArray instance from a native PHP array.
     *
     *
     * Тестирование статического фабричного метода fromArray() для создания CoverArray из обычного массива.
     *
     * Этот тест проверяет, что метод fromArray() корректно создает
     * новый экземпляр CoverArray из обычного массива PHP.
     *
     * @see CoverArray::fromArray()
     */
    public function testFromArrayCreatesInstanceFromNativeArray(): void
    {
        $data = ['name' => 'John', 'age' => 30, 'active' => true];

        $cover = CoverArray::fromArray($data);

        $this->assertInstanceOf(CoverArray::class, $cover);
        $this->assertSame($data, $cover->getDataAsArray());
    }

    /**
     * Tests fromArray() with empty array.
     *
     * This test verifies that fromArray() correctly handles an empty array,
     * creating an empty CoverArray instance.
     *
     *
     * Тестирование fromArray() с пустым массивом.
     *
     * Этот тест проверяет, что fromArray() корректно обрабатывает пустой массив,
     * создавая пустой экземпляр CoverArray.
     *
     * @see CoverArray::fromArray()
     */
    public function testFromArrayWithEmptyArray(): void
    {
        $cover = CoverArray::fromArray([]);

        $this->assertInstanceOf(CoverArray::class, $cover);
        $this->assertTrue($cover->isEmpty());
        $this->assertSame([], $cover->getDataAsArray());
    }

    /**
     * Tests fromArray() with nested array structure.
     *
     * This test verifies that fromArray() correctly handles nested arrays,
     * preserving the complete structure.
     *
     *
     * Тестирование fromArray() с вложенной структурой массива.
     *
     * Этот тест проверяет, что fromArray() корректно обрабатывает вложенные массивы,
     * сохраняя полную структуру.
     *
     * @see CoverArray::fromArray()
     */
    public function testFromArrayWithNestedStructure(): void
    {
        $data = [
            'user' => [
                'profile' => [
                    'name' => 'Alice',
                    'settings' => ['theme' => 'dark', 'lang' => 'en']
                ]
            ],
            'items' => [1, 2, 3]
        ];

        $cover = CoverArray::fromArray($data);

        $this->assertSame($data, $cover->getDataAsArray());
    }

    /**
     * Tests fromArray() with sequential numeric array.
     *
     * This test verifies that fromArray() correctly handles
     * sequential numeric arrays (lists).
     *
     *
     * Тестирование fromArray() с последовательным числовым массивом.
     *
     * Этот тест проверяет, что fromArray() корректно обрабатывает
     * последовательные числовые массивы (списки).
     *
     * @see CoverArray::fromArray()
     */
    public function testFromArrayWithNumericArray(): void
    {
        $data = ['apple', 'banana', 'cherry'];

        $cover = CoverArray::fromArray($data);

        $this->assertSame($data, $cover->getDataAsArray());
        $this->assertEquals(3, $cover->count());
    }

    /**
     * Tests fromArray() with various data types.
     *
     * This test verifies that fromArray() correctly handles arrays
     * containing various PHP data types.
     *
     *
     * Тестирование fromArray() с различными типами данных.
     *
     * Этот тест проверяет, что fromArray() корректно обрабатывает массивы,
     * содержащие различные типы данных PHP.
     *
     * @see CoverArray::fromArray()
     */
    public function testFromArrayWithVariousDataTypes(): void
    {
        $object = new \stdClass();
        $object->property = 'value';

        $data = [
            'string' => 'text',
            'integer' => 123,
            'float' => 3.14,
            'boolean_true' => true,
            'boolean_false' => false,
            'null_value' => null,
            'array' => [1, 2, 3],
            'object' => $object
        ];

        $cover = CoverArray::fromArray($data);

        $this->assertSame($data, $cover->getDataAsArray());
    }

    /**
     * Tests fromArray() works correctly with NewTypeArray subclass.
     *
     * This test verifies that fromArray() returns an instance of the called class
     * when invoked on a subclass of CoverArray (static factory method behavior).
     *
     *
     * Тестирование корректной работы fromArray() с подклассом NewTypeArray.
     *
     * Этот тест проверяет, что fromArray() возвращает экземпляр вызванного класса
     * при вызове на подклассе CoverArray (поведение статического фабричного метода).
     *
     * @see CoverArray::fromArray()
     */
    public function testFromArrayWithSubclass(): void
    {
        $data = ['key' => 'value'];

        $cover = NewTypeArray::fromArray($data);

        $this->assertInstanceOf(NewTypeArray::class, $cover);
        $this->assertSame($data, $cover->getDataAsArray());
    }

    /**
     * Tests fromArray() creates independent instance from source array.
     *
     * This test verifies that modifications to the original array
     * do not affect the CoverArray instance created from it.
     *
     *
     * Тестирование создания независимого экземпляра fromArray() от исходного массива.
     *
     * Этот тест проверяет, что модификации исходного массива
     * не влияют на экземпляр CoverArray, созданный из него.
     *
     * @see CoverArray::fromArray()
     */
    public function testFromArrayCreatesIndependentInstance(): void
    {
        $data = ['key' => 'value'];
        $cover = CoverArray::fromArray($data);

        // Modify original array
        $data['key'] = 'modified';
        $data['new_key'] = 'new_value';

        // CoverArray should remain unchanged
        $this->assertSame('value', $cover->key);
        $this->assertNull($cover->new_key);
    }

    /**
     * Tests fromArray() with associative array having string keys.
     *
     * This test verifies that fromArray() correctly preserves
     * string keys in associative arrays.
     *
     *
     * Тестирование fromArray() с ассоциативным массивом со строковыми ключами.
     *
     * Этот тест проверяет, что fromArray() корректно сохраняет
     * строковые ключи в ассоциативных массивах.
     *
     * @see CoverArray::fromArray()
     */
    public function testFromArrayWithStringKeys(): void
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com'
        ];

        $cover = CoverArray::fromArray($data);

        $this->assertSame('John', $cover->first_name);
        $this->assertSame('Doe', $cover->last_name);
        $this->assertSame('john@example.com', $cover->email);
    }

    /**
     * Tests fromArray() with mixed numeric and string keys.
     *
     * This test verifies that fromArray() correctly handles arrays
     * with both numeric and string keys.
     *
     *
     * Тестирование fromArray() со смешанными числовыми и строковыми ключами.
     *
     * Этот тест проверяет, что fromArray() корректно обрабатывает массивы
     * с числовыми и строковыми ключами одновременно.
     *
     * @see CoverArray::fromArray()
     */
    public function testFromArrayWithMixedKeys(): void
    {
        $data = [
            0 => 'zero',
            'key' => 'value',
            1 => 'one',
            'another' => 'data'
        ];

        $cover = CoverArray::fromArray($data);

        $this->assertSame($data, $cover->getDataAsArray());
    }

    /**
     * Tests fromArray() equivalence with constructor.
     *
     * This test verifies that fromArray() produces the same result
     * as creating a CoverArray via constructor.
     *
     *
     * Тестирование эквивалентности fromArray() и конструктора.
     *
     * Этот тест проверяет, что fromArray() дает тот же результат,
     * что и создание CoverArray через конструктор.
     *
     * @see CoverArray::fromArray()
     * @see CoverArray::__construct()
     */
    public function testFromArrayEquivalentToConstructor(): void
    {
        $data = ['name' => 'Test', 'items' => [1, 2, 3]];

        $fromFactory = CoverArray::fromArray($data);
        $fromConstructor = new CoverArray($data);

        $this->assertSame(
            $fromConstructor->getDataAsArray(),
            $fromFactory->getDataAsArray()
        );
    }
}
