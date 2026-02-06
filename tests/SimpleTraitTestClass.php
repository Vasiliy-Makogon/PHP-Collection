<?php

declare(strict_types=1);

namespace Krugozor\Cover\Tests;

use Krugozor\Cover\Simple;

/**
 * A test class that uses the Simple trait WITHOUT overriding its methods.
 *
 * This class is used exclusively for testing the Simple trait's __set(), setData()
 * and getData() methods directly, since CoverArray overrides some of these methods
 * with array2cover() conversion. By using this class in tests, we can achieve coverage
 * for the original trait methods.
 *
 *
 * Тестовый класс, использующий трейт Simple БЕЗ переопределения его методов.
 *
 * Этот класс используется исключительно для тестирования методов __set(), setData()
 * и getData() трейта Simple напрямую, поскольку CoverArray переопределяет некоторые
 * из этих методов с преобразованием array2cover(). Используя этот класс в тестах,
 * мы можем достичь покрытия для оригинальных методов трейта.
 */
class SimpleTraitTestClass
{
    use Simple;

    /**
     * Returns the internal data array for testing purposes.
     *
     * Возвращает внутренний массив данных для целей тестирования.
     *
     * @return array
     */
    public function getDataAsArray(): array
    {
        return $this->data;
    }
}
