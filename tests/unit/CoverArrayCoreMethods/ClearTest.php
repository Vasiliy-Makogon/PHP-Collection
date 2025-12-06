<?php

declare(strict_types=1);

namespace CoverArrayCoreMethods;

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(CoverArray::class)]
class ClearTest extends TestCase
{
    /**
     * Tests clear() method removes all data from CoverArray.
     *
     * This test verifies that the clear() method completely empties
     * the internal data storage of a CoverArray instance, regardless
     * of its initial contents. It ensures that after calling clear(),
     * the object behaves as if it was freshly instantiated with no data,
     * including proper behavior of isEmpty() and count() methods.
     *
     *
     * Тестирование метода clear() на удаление всех данных из CoverArray.
     *
     * Этот тест проверяет, что метод clear() полностью очищает
     * внутреннее хранилище данных экземпляра CoverArray, независимо
     * от его исходного содержимого. Он гарантирует, что после вызова clear()
     * объект ведет себя как свежесозданный без данных, включая корректное
     * поведение методов isEmpty() и count().
     *
     * @see CoverArray::clear()
     * @see CoverArray::isEmpty()
     * @see CoverArray::count()
     */
    public function testClearMethodRemovesAllData(): void
    {
        // Arrange: Create NewTypeArray with various data types
        $cover = new NewTypeArray([
            'string' => 'test value',
            'number' => 42,
            'array' => ['nested' => 'value'],
            'object' => new \stdClass(),
            'null' => null,
            'boolean' => true,
        ]);

        // Assert: Verify initial state
        $this->assertFalse($cover->isEmpty(), 'NewTypeArray should not be empty initially');
        $this->assertEquals(6, $cover->count(), 'NewTypeArray should have 6 items initially');

        // Act: Clear all data
        $result = $cover->clear();

        // Assert: Verify cleared state
        $this->assertTrue($cover->isEmpty(), 'NewTypeArray should be empty after clear()');
        $this->assertEquals(0, $cover->count(), 'NewTypeArray should have 0 items after clear()');

        // Assert: Verify clear() returns the same instance for method chaining
        $this->assertSame($cover, $result, 'clear() should return the same instance for method chaining');

        // Assert: Verify all keys are removed
        $this->assertNull($cover->string, 'String key should be removed');
        $this->assertNull($cover->number, 'Number key should be removed');
        $this->assertNull($cover->array, 'Array key should be removed');
        $this->assertNull($cover->object, 'Object key should be removed');
        $this->assertNull($cover->null, 'Null key should be removed');
        $this->assertNull($cover->boolean, 'Boolean key should be removed');
    }

    /**
     * Tests clear() method on already empty NewTypeArray.
     *
     * This test verifies that calling clear() on an already empty
     * NewTypeArray instance does not cause any errors or side effects.
     * It ensures the method is idempotent and safe to call multiple times
     * without changing the object's valid empty state.
     *
     *
     * Тестирование метода clear() на уже пустом CoverArray.
     *
     * Этот тест проверяет, что вызов clear() на уже пустом экземпляре
     * CoverArray не вызывает ошибок или побочных эффектов.
     * Он гарантирует, что метод идемпотентен и безопасен для многократного
     * вызова без изменения корректного пустого состояния объекта.
     *
     * @see CoverArray::clear()
     * @see CoverArray::isEmpty()
     */
    public function testClearOnEmptyCoverArray(): void
    {
        // Arrange: Create empty NewTypeArray
        $cover = new NewTypeArray();

        // Assert: Verify initial empty state
        $this->assertTrue($cover->isEmpty(), 'NewTypeArray should be empty initially');
        $this->assertEquals(0, $cover->count(), 'NewTypeArray should have 0 items initially');

        // Act: Clear already empty NewTypeArray
        $result = $cover->clear();

        // Assert: Verify state remains empty
        $this->assertTrue($cover->isEmpty(), 'NewTypeArray should remain empty after clear()');
        $this->assertEquals(0, $cover->count(), 'NewTypeArray should still have 0 items after clear()');
        $this->assertSame($cover, $result, 'clear() should return the same instance');
    }

    /**
     * Tests clear() method preserves object identity and type.
     *
     * This test verifies that after calling clear(), the CoverArray
     * instance remains the same object with preserved identity and type,
     * capable of accepting new data. It ensures that clear() only affects
     * the internal data storage without altering the object's fundamental
     * characteristics or breaking its future usability.
     *
     *
     * Тестирование метода clear() на сохранение идентичности и типа объекта.
     *
     * Этот тест проверяет, что после вызова clear() экземпляр CoverArray
     * остается тем же объектом с сохраненной идентичностью и типом,
     * способным принимать новые данные. Он гарантирует, что clear()
     * влияет только на внутреннее хранилище данных, не изменяя фундаментальные
     * характеристики объекта и не нарушая его будущую пригодность к использованию.
     *
     * @see CoverArray::clear()
     * @see CoverArray::setData()
     */
    public function testClearPreservesObjectIdentityAndUsability(): void
    {
        // Arrange: Create NewTypeArray with data and store its identity
        $cover = new NewTypeArray(['key1' => 'value1', 'key2' => 'value2']);
        $originalHash = spl_object_hash($cover);

        // Act: Clear data and reuse the object
        $cover->clear();
        $cover->setData(['new_key' => 'new_value']);

        // Assert: Verify object identity is preserved
        $this->assertEquals($originalHash, spl_object_hash($cover),
            'Object identity should be preserved after clear()');

        // Assert: Verify object can accept new data
        $this->assertFalse($cover->isEmpty(), 'NewTypeArray should accept new data after clear()');
        $this->assertEquals('new_value', $cover->new_key,
            'NewTypeArray should store new data correctly after clear()');
        $this->assertEquals(1, $cover->count(),
            'NewTypeArray should have correct count after reusing');
    }

    /**
     * Tests clear() method in method chaining scenarios.
     *
     * This test verifies that clear() returns the same CoverArray instance,
     * enabling fluent interface patterns and method chaining. It ensures
     * that developers can chain clear() with other methods for concise
     * and readable code without intermediate variable assignments.
     *
     *
     * Тестирование метода clear() в сценариях цепочки методов.
     *
     * Этот тест проверяет, что clear() возвращает тот же экземпляр CoverArray,
     * позволяя использовать шаблоны текучего интерфейса и цепочки методов.
     * Он гарантирует, что разработчики могут объединять clear() с другими
     * методами для лаконичного и читаемого кода без промежуточных присваиваний.
     *
     * @see CoverArray::clear()
     * @see CoverArray::setData()
     * @see CoverArray::append()
     */
    public function testClearSupportsMethodChaining(): void
    {
        // Arrange: Create NewTypeArray
        $cover = new NewTypeArray(['old' => 'data']);

        // Act & Assert: Test method chaining
        $result = $cover
            ->clear()
            ->setData(['first' => 'value'])
            ->append('new_item')
            ->append('another_item');

        // Assert: Verify chaining works correctly
        $this->assertSame($cover, $result, 'Method chaining should return the same instance');
        $this->assertEquals(3, $cover->count(), 'Should have 3 items after chained operations');
        $this->assertEquals('value', $cover->first, 'First item should be set correctly');
        $this->assertEquals('new_item', $cover[0], 'First appended item should be correct');
        $this->assertEquals('another_item', $cover[1], 'Second appended item should be correct');
    }

    /**
     * Tests clear() method with nested CoverArray structures.
     *
     * This test verifies that clear() only affects the immediate
     * CoverArray instance and does not recursively clear nested
     * CoverArray objects. It ensures proper separation of concerns
     * and prevents unintended data loss in complex object graphs.
     *
     *
     * Тестирование метода clear() с вложенными структурами CoverArray.
     *
     * Этот тест проверяет, что clear() влияет только на непосредственный
     * экземпляр CoverArray и не рекурсивно очищает вложенные объекты CoverArray.
     * Он обеспечивает правильное разделение ответственности и предотвращает
     * непреднамеренную потерю данных в сложных графах объектов.
     *
     * @see CoverArray::clear()
     * @see CoverArray::array2cover()
     */
    public function testClearDoesNotAffectNestedCoverArrays(): void
    {
        // Arrange: Create nested structure
        $nested = new NewTypeArray(['inner_key' => 'inner_value']);
        $parent = new NewTypeArray([
            'nested' => $nested,
            'other' => 'value'
        ]);

        // Store reference to nested object
        $nestedHash = spl_object_hash($parent->nested);

        // Act: Clear parent only
        $parent->clear();

        // Assert: Verify nested object still exists with its data
        $this->assertNull($parent->nested, 'Reference to nested object should be removed from parent');
        $this->assertFalse($nested->isEmpty(), 'Nested NewTypeArray should still have its data');
        $this->assertEquals('inner_value', $nested->inner_key,
            'Nested NewTypeArray data should be preserved');

        // Verify object identity of nested array
        $this->assertEquals($nestedHash, spl_object_hash($nested),
            'Nested NewTypeArray object identity should be preserved');
    }
}