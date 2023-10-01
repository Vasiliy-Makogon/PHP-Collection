<?php

declare(strict_types=1);

use Krugozor\Cover\CoverArray;
use Krugozor\Cover\Tests\NewTypeArray;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoverArray::class)]
class CoverArrayTest extends TestCase
{
    /** @var NewTypeArray */
    protected NewTypeArray $data;

    public function setUp(): void
    {
        $this->data = new NewTypeArray([
            'name' => 'Vasiliy',
            'age' => 40,
            'langs' => [
                'backend' => ['PHP', 'MySql'],
                'frontend' => ['HTML', 'CSS', 'JavaScript']
            ],
        ]);
    }

    public function testIsIterable()
    {
        $this->assertIsIterable($this->data);
    }

    public function testToStringMethod()
    {
        $this->assertSame('', (string) $this->data);
    }

    public function testMagicGetMethod()
    {
        $this->assertSame('Vasiliy', $this->data->name);
    }

    public function testMagicSetMethod()
    {
        $this->data->name = 'Ivan';
        $this->assertSame('Ivan', $this->data->name);

        $this->data->stdClassValue = new stdClass();
        $this->data->arrayValue = [1, 2, 3]; // [] => self type
        $this->data->coverArrayValue = (new CoverArray([1, 2, 3]));

        $this->assertInstanceOf(stdClass::class, $this->data->stdClassValue);
        $this->assertInstanceOf(NewTypeArray::class, $this->data->arrayValue);
        $this->assertInstanceOf(CoverArray::class, $this->data->coverArrayValue);
    }

    public function testMagicIssetMethod()
    {
        $this->assertSame(true, isset($this->data->name));
    }

    public function testMagicUnsetMethod()
    {
        unset($this->data->name);
        $this->assertSame(false, isset($this->data->name));
    }

    public function testItemMethod()
    {
        $this->assertSame('PHP', $this->data->get('langs.backend')->item(0));
    }

    public function testGetDataMethod()
    {
        $this->assertIsArray($this->data->getData());
    }

    public function testSetDataMethod()
    {
        // $this->data->get('langs.backend') => [0 => 'PHP', 1 => 'MySql']

        $this->data->get('langs.backend')->setData(new CoverArray([
            2 => 'C++', 3 => 'C#'
        ]));
        $this->data->get('langs.backend')->setData([
            4 => 'Python', 5 => 'Ruby'
        ]);

        $this->assertSame(
            ['PHP', 'MySql', 'C++', 'C#', 'Python', 'Ruby'],
            $this->data->get('langs.backend')->getDataAsArray()
        );
    }

    public function testClearMethod()
    {
        $this->assertEmpty($this->data->clear());
    }

    public function testCountMethod()
    {
        $this->assertCount(2, $this->data->get('langs'));
        $this->assertCount(2, $this->data->get('langs.backend'));
        $this->assertCount(3, $this->data->get('langs.frontend'));
    }

    public function testGetMethod()
    {
        $this->assertSame('PHP', $this->data->get('langs.backend.0'));
    }

    public function testInstanceOfSelf()
    {
        $this->assertInstanceOf(NewTypeArray::class, $this->data);
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('langs'));
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('langs.backend'));
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('langs.frontend'));

        $this->assertInstanceOf(CoverArray::class, $this->data);
        $this->assertInstanceOf(CoverArray::class, $this->data->get('langs'));
        $this->assertInstanceOf(CoverArray::class, $this->data->get('langs.backend'));
        $this->assertInstanceOf(CoverArray::class, $this->data->get('langs.frontend'));
    }

    public function testPrependMethod()
    {
        $this->data->get('langs.backend')->prepend('C++');
        $this->assertSame('C++', $this->data->get('langs.backend')->getFirst());
    }

    public function testAppendMethod()
    {
        $this->data->get('langs.backend')->append('C#');
        $this->assertSame('C#', $this->data->get('langs.backend')->getLast());
    }

    public function testGetLastMethod()
    {
        $this->assertSame('MySql', $this->data->get('langs.backend')->getLast());
    }

    public function testGetFirstMethod()
    {
        $this->assertSame('PHP', $this->data->get('langs.backend')->getFirst());
    }

    public function testGetDataAsArrayMethod()
    {
        $this->assertIsArray($this->data->getDataAsArray());
    }





}