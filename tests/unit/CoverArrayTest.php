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
            'langs' => [
                'backend' => ['PHP', 'MySql'],
                'frontend' => ['HTML', 'CSS', 'JavaScript']
            ],
        ]);
    }

    /**
     * @see CoverArray::getIterator()
     */
    public function testIsIterable()
    {
        $this->assertIsIterable($this->data);
    }

    /**
     * @see CoverArray::__toString()
     */
    public function testToStringMethod()
    {
        $this->assertSame('', (string) $this->data);
    }

    /**
     * @see CoverArray::__get()
     */
    public function testMagicGetMethod()
    {
        $this->assertSame('Vasiliy', $this->data->name);
        $this->assertInstanceOf(NewTypeArray::class, $this->data->langs);
        $this->assertInstanceOf(CoverArray::class, $this->data->langs);
        $this->assertNull($this->data->nonexistent);
    }

    /**
     * @see CoverArray::__set()
     */
    public function testMagicSetMethod()
    {
        $this->data->scalarValue = 1;
        $this->data->stdClassValue = new stdClass();
        $this->data->arrayValue = [1, 2, 3]; // array converted to self class type
        $this->data->newTypeArray = new NewTypeArray([1, 2, 3]);
        $this->data->coverArrayValue = new CoverArray([1, 2, 3]);

        $this->assertSame(1, $this->data->scalarValue);
        $this->assertInstanceOf(stdClass::class, $this->data->stdClassValue);
        $this->assertInstanceOf(NewTypeArray::class, $this->data->arrayValue);
        $this->assertInstanceOf(NewTypeArray::class, $this->data->newTypeArray);
        $this->assertInstanceOf(CoverArray::class, $this->data->coverArrayValue);
    }

    /**
     * @see CoverArray::__isset()
     */
    public function testMagicIssetMethod()
    {
        $this->assertTrue(isset($this->data->name));
        $this->assertFalse(isset($this->data->nonexistent));
    }

    /**
     * @see CoverArray::__unset()
     */
    public function testMagicUnsetMethod()
    {
        unset($this->data->name);
        $this->assertFalse(isset($this->data->name));
    }

    /**
     * @see CoverArray::item()
     */
    public function testItemMethod()
    {
        $this->assertSame('PHP', $this->data->get('langs.backend')->item(0));
        $this->assertSame('Vasiliy', $this->data->item('name'));
        $this->assertNull($this->data->item('nonexistent'));
        $this->assertNull($this->data->item(100));
    }

    /**
     * @see CoverArray::getData()
     */
    public function testGetDataMethod()
    {
        $this->assertIsArray($this->data->getData());
    }

    /**
     * @see CoverArray::setData()
     */
    public function testSetDataMethod()
    {
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

    /**
     * @see CoverArray::clear()
     */
    public function testClearMethod()
    {
        $this->assertEmpty($this->data->clear());
    }

    /**
     * @see CoverArray::count()
     */
    public function testCountMethod()
    {
        $this->assertCount(2, $this->data);
        $this->assertCount(3, $this->data->get('langs.frontend'));
    }

    /**
     * @see CoverArray::get()
     */
    public function testGetMethod()
    {
        $this->assertSame('PHP', $this->data->get('langs.backend.0'));
        $this->assertSame('Vasiliy', $this->data->get('name'));
        $this->assertNull($this->data->get('langs.backend.10'));
        $this->assertNull($this->data->get('nonexistent.nonexistent.nonexistent'));
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

    /**
     * @see CoverArray::prepend()
     */
    public function testPrependMethod()
    {
        $this->data->get('langs.backend')->prepend('C++');
        $this->assertSame('C++', $this->data->get('langs.backend')->getFirst());

        $this->data->get('langs.backend')->prepend(['Python', 'Ruby']);
        $this->assertSame(['Python', 'Ruby'], $this->data->get('langs.backend')->getFirst()->getDataAsArray());

        $this->data->get('langs.backend')->prepend('Java', 'C#');
        $this->assertSame('C#', $this->data->get('langs.backend')->getFirst());
    }

    /**
     * @see CoverArray::append()
     */
    public function testAppendMethod()
    {
        $this->data->get('langs.backend')->append('C++');
        $this->assertSame('C++', $this->data->get('langs.backend')->getLast());

        $this->data->get('langs.backend')->append(['Python', 'Ruby']);
        $this->assertSame(['Python', 'Ruby'], $this->data->get('langs.backend')->getLast()->getDataAsArray());

        $this->data->get('langs.backend')->append('Java', 'C#');
        $this->assertSame('C#', $this->data->get('langs.backend')->getLast());
    }

    /**
     * @see CoverArray::getLast()
     */
    public function testGetLastMethod()
    {
        $this->assertSame('MySql', $this->data->get('langs.backend')->getLast());
    }

    /**
     * @see CoverArray::getFirst()
     */
    public function testGetFirstMethod()
    {
        $this->assertSame('PHP', $this->data->get('langs.backend')->getFirst());
    }

    /**
     * @see CoverArray::getDataAsArray()
     */
    public function testGetDataAsArrayMethod()
    {
        $this->assertIsArray($this->data->getDataAsArray());
    }

    /**
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetMethod()
    {
        $this->data['age'] = 40;
        $this->data['workplaces'] = ['Mvideo', 'Svyaznoy'];

        $this->assertSame(40, $this->data->get('age'));
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('workplaces'));
        $this->assertInstanceOf(CoverArray::class, $this->data->get('workplaces'));
    }

    /**
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetMethod()
    {
        $this->assertSame('Vasiliy', $this->data['name']);
        $this->assertSame('PHP', $this->data['langs']['backend'][0]);
        $this->assertInstanceOf(NewTypeArray::class, $this->data['langs']['backend']);
        $this->assertInstanceOf(CoverArray::class, $this->data['langs']['backend']);
        $this->assertNull($this->data['nonexistent']);
    }

    /**
     * @see CoverArray::offsetExists()
     */
    public function testOffsetExistsMethod()
    {
        $this->assertTrue(isset($this->data['name']));
        $this->assertFalse(isset($this->data['nonexistent']));
    }

    /**
     * @see CoverArray::offsetUnset()
     */
    public function offsetUnset()
    {
        unset($this->data['name']);
        $this->assertFalse(isset($this->data['name']));
    }

    /**
     * @see CoverArray::__serialize()
     */
    public function testSerializeMethod()
    {
        $this->assertSame(
            'O:33:"Krugozor\Cover\Tests\NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}',
            serialize($this->data->get('langs.backend'))
        );
    }

    /**
     * @see CoverArray::__unserialize()
     */
    public function testUnserializeMethod()
    {
        $this->assertEquals(
            unserialize('O:33:"Krugozor\Cover\Tests\NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}'),
            $this->data->get('langs.backend')
        );
    }

    /**
     * @see CoverArray::reverse()
     */
    public function testReverseMethod()
    {
        $this->assertSame(['MySql', 'PHP'], $this->data->get('langs.backend')->reverse());
    }

    /**
     * @see CoverArray::filter()
     */
    public function testFilterMethod()
    {
        $this->assertSame(['PHP'], $this->data->get('langs.backend')->filter(function ($value) {
            return preg_match('~P~', $value);
        })->getDataAsArray());
    }

    /**
     * @see CoverArray::implode()
     */
    public function testImplodeMethod()
    {
        $this->assertSame('PHP, MySql', $this->data->get('langs.backend')->implode(', '));
    }

    /**
     * @see CoverArray::mapAssociative()
     */
    public function testMapAssociativeMethod()
    {
        $this->assertSame(
            ['0: PHP', '1: MySql'],
            $this->data->get('langs.backend')->mapAssociative(
                fn(string $key, string $value): string => "$key: $value"
            )->getDataAsArray()
        );
    }

    /**
     * @see CoverArray::mapAssociative()
     */
    public function testMapMethod()
    {
        $this->assertSame(
            ['value: PHP', 'value: MySql'],
            $this->data->get('langs.backend')->map(
                fn(string $value): string => "value: $value"
            )->getDataAsArray()
        );
    }
}