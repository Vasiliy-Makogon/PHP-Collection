<?php

declare(strict_types=1);

namespace SimpleTraitMethods;

use Krugozor\Cover\Simple;
use Krugozor\Cover\Tests\SimpleTraitTestClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(Simple::class)]
class GetDataTest extends TestCase
{
    /**
     * Tests getData() returns an empty array for a new instance.
     *
     * This test verifies that calling getData() on a freshly created object
     * returns an empty array, since no data has been set yet.
     *
     *
     * Тестирует, что getData() возвращает пустой массив для нового экземпляра.
     *
     * Этот тест проверяет, что вызов getData() на только что созданном объекте
     * возвращает пустой массив, так как данные ещё не были установлены.
     *
     * @see Simple::getData()
     */
    public function testGetDataReturnsEmptyArrayForNewInstance(): void
    {
        $obj = new SimpleTraitTestClass();

        $this->assertSame([], $obj->getData());
    }

    /**
     * Tests getData() returns scalar values set via __set().
     *
     * This test verifies that getData() correctly returns all scalar values
     * that were assigned through the magic __set() method.
     *
     *
     * Тестирует, что getData() возвращает скалярные значения, установленные через __set().
     *
     * Этот тест проверяет, что getData() корректно возвращает все скалярные значения,
     * которые были присвоены через магический метод __set().
     *
     * @see Simple::getData()
     * @see Simple::__set()
     */
    public function testGetDataReturnsScalarValues(): void
    {
        $obj = new SimpleTraitTestClass();

        $obj->string = 'value';
        $obj->int = 42;
        $obj->float = 3.14;
        $obj->bool = true;
        $obj->null_val = null;

        $expected = [
            'string' => 'value',
            'int' => 42,
            'float' => 3.14,
            'bool' => true,
            'null_val' => null,
        ];

        $this->assertSame($expected, $obj->getData());
    }

    /**
     * Tests getData() returns arrays without any conversion.
     *
     * This test verifies that getData() returns nested arrays as plain PHP arrays,
     * without any transformation or wrapping.
     *
     *
     * Тестирует, что getData() возвращает массивы без какого-либо преобразования.
     *
     * Этот тест проверяет, что getData() возвращает вложенные массивы как обычные
     * PHP-массивы, без какой-либо трансформации или обёртки.
     *
     * @see Simple::getData()
     */
    public function testGetDataReturnsArraysWithoutConversion(): void
    {
        $obj = new SimpleTraitTestClass();

        $nested = ['level1' => ['level2' => 'deep']];
        $obj->list = [1, 2, 3];
        $obj->nested = $nested;

        $result = $obj->getData();

        $this->assertIsArray($result['list']);
        $this->assertSame([1, 2, 3], $result['list']);
        $this->assertIsArray($result['nested']);
        $this->assertSame($nested, $result['nested']);
    }

    /**
     * Tests getData() returns data set via setData().
     *
     * This test verifies that getData() correctly returns data
     * that was populated through the setData() method.
     *
     *
     * Тестирует, что getData() возвращает данные, установленные через setData().
     *
     * Этот тест проверяет, что getData() корректно возвращает данные,
     * которые были заполнены через метод setData().
     *
     * @see Simple::getData()
     * @see Simple::setData()
     */
    public function testGetDataReturnsDataSetViaSetData(): void
    {
        $obj = new SimpleTraitTestClass();

        $data = [
            'name' => 'John',
            'age' => 30,
            'tags' => ['php', 'dev'],
        ];

        $obj->setData($data);

        $this->assertSame($data, $obj->getData());
    }

    /**
     * Tests getData() returns object values by reference.
     *
     * This test verifies that objects stored in the internal array
     * are returned by reference, maintaining referential integrity.
     *
     *
     * Тестирует, что getData() возвращает объекты по ссылке.
     *
     * Этот тест проверяет, что объекты, хранящиеся во внутреннем массиве,
     * возвращаются по ссылке, сохраняя ссылочную целостность.
     *
     * @see Simple::getData()
     */
    public function testGetDataReturnsObjectsByReference(): void
    {
        $obj = new SimpleTraitTestClass();

        $stdObject = new stdClass();
        $stdObject->property = 'value';

        $obj->object = $stdObject;

        $result = $obj->getData();

        $this->assertSame($stdObject, $result['object']);
    }

    /**
     * Tests getData() returns an empty array after clear().
     *
     * This test verifies that after calling clear(), getData() returns
     * an empty array.
     *
     *
     * Тестирует, что getData() возвращает пустой массив после clear().
     *
     * Этот тест проверяет, что после вызова clear() метод getData()
     * возвращает пустой массив.
     *
     * @see Simple::getData()
     * @see Simple::clear()
     */
    public function testGetDataReturnsEmptyArrayAfterClear(): void
    {
        $obj = new SimpleTraitTestClass();

        $obj->setData(['key1' => 'value1', 'key2' => 'value2']);
        $obj->clear();

        $this->assertSame([], $obj->getData());
    }

    /**
     * Tests getData() reflects changes after unset.
     *
     * This test verifies that getData() correctly reflects the state
     * of internal data after properties have been removed via __unset().
     *
     *
     * Тестирует, что getData() отражает изменения после unset.
     *
     * Этот тест проверяет, что getData() корректно отражает состояние
     * внутренних данных после удаления свойств через __unset().
     *
     * @see Simple::getData()
     * @see Simple::__unset()
     */
    public function testGetDataReflectsChangesAfterUnset(): void
    {
        $obj = new SimpleTraitTestClass();

        $obj->setData(['a' => 1, 'b' => 2, 'c' => 3]);
        unset($obj->b);

        $this->assertSame(['a' => 1, 'c' => 3], $obj->getData());
    }

    /**
     * Tests that getData() returns an array type.
     *
     * This test verifies that the return type of getData() is always
     * a native PHP array.
     *
     *
     * Тестирует, что getData() возвращает тип array.
     *
     * Этот тест проверяет, что тип возвращаемого значения getData()
     * всегда является нативным PHP-массивом.
     *
     * @see Simple::getData()
     */
    public function testGetDataAlwaysReturnsArray(): void
    {
        $obj = new SimpleTraitTestClass();

        $this->assertIsArray($obj->getData());

        $obj->key = 'value';
        $this->assertIsArray($obj->getData());
    }
}
