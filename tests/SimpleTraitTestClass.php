<?php

declare(strict_types=1);

namespace Krugozor\Cover\Tests;

use Krugozor\Cover\Simple;

/**
 * A test class that uses the Simple trait WITHOUT overriding its methods.
 *
 * This class is used exclusively for testing the Simple trait's __set() and setData()
 * methods directly, since CoverArray overrides these methods with array2cover() conversion.
 * By using this class in tests, we can achieve coverage for the original trait methods.
 *
 *
 * Тестовый класс, использующий трейт Simple БЕЗ переопределения его методов.
 *
 * Этот класс используется исключительно для тестирования методов __set() и setData()
 * трейта Simple напрямую, поскольку CoverArray переопределяет эти методы с преобразованием
 * array2cover(). Используя этот класс в тестах, мы можем достичь покрытия для оригинальных
 * методов трейта.
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
