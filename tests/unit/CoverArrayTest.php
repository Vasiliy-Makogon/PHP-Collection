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
    public function testIsIterable(): void
    {
        $this->assertIsIterable($this->data);
    }

    /**
     * @see CoverArray::__toString()
     */
    public function testToStringMethod(): void
    {
        $this->assertSame('', (string) $this->data);
    }

    /**
     * @see CoverArray::__get()
     */
    public function testMagicGetMethod(): void
    {
        $this->assertSame('Vasiliy', $this->data->name);
        $this->assertInstanceOf(NewTypeArray::class, $this->data->langs);
        $this->assertInstanceOf(CoverArray::class, $this->data->langs);
        $this->assertNull($this->data->nonexistent);
    }

    /**
     * @see CoverArray::__set()
     */
    public function testMagicSetMethod(): void
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
    public function testMagicIssetMethod(): void
    {
        $this->assertTrue(isset($this->data->name));
        $this->assertFalse(isset($this->data->nonexistent));
    }

    /**
     * @see CoverArray::__unset()
     */
    public function testMagicUnsetMethod(): void
    {
        unset($this->data->name);
        $this->assertFalse(isset($this->data->name));
    }

    /**
     * @see CoverArray::item()
     */
    public function testItemMethod(): void
    {
        $this->assertSame('PHP', $this->data->get('langs.backend')->item(0));
        $this->assertSame('Vasiliy', $this->data->item('name'));
        $this->assertNull($this->data->item('nonexistent'));
        $this->assertNull($this->data->item(100));
    }

    /**
     * @see CoverArray::getData()
     */
    public function testGetDataMethod(): void
    {
        $this->assertIsArray($this->data->getData());
    }

    /**
     * @see CoverArray::setData()
     */
    public function testSetDataMethod(): void
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
    public function testClearMethod(): void
    {
        $this->assertEmpty($this->data->clear());
    }

    /**
     * @see CoverArray::count()
     */
    public function testCountMethod(): void
    {
        $this->assertCount(2, $this->data);
        $this->assertCount(3, $this->data->get('langs.frontend'));
    }

    /**
     * @see CoverArray::get()
     */
    public function testGetMethod(): void
    {
        $this->assertSame('PHP', $this->data->get('langs.backend.0'));
        $this->assertSame('Vasiliy', $this->data->get('name'));
        $this->assertNull($this->data->get('langs.backend.10'));
        $this->assertNull($this->data->get('nonexistent.nonexistent.nonexistent'));
    }

    public function testInstanceOfSelf(): void
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
    public function testPrependMethod(): void
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
    public function testAppendMethod(): void
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
    public function testGetLastMethod(): void
    {
        $this->assertSame('MySql', $this->data->get('langs.backend')->getLast());
    }

    /**
     * @see CoverArray::getFirst()
     */
    public function testGetFirstMethod(): void
    {
        $this->assertSame('PHP', $this->data->get('langs.backend')->getFirst());
    }

    /**
     * @see CoverArray::getDataAsArray()
     */
    public function testGetDataAsArrayMethod(): void
    {
        $this->assertIsArray($this->data->getDataAsArray());
    }

    /**
     * @see CoverArray::offsetSet()
     */
    public function testOffsetSetMethod(): void
    {
        $this->data['age'] = 40;
        $this->data['workplaces'] = ['Mvideo', 'Svyaznoy'];
        $this->data['nullValue'] = null;

        $this->assertSame(40, $this->data->get('age'));
        $this->assertInstanceOf(NewTypeArray::class, $this->data->get('workplaces'));
        $this->assertInstanceOf(CoverArray::class, $this->data->get('workplaces'));
        $this->assertNull($this->data->get('nullValue'));
    }

    /**
     * @see CoverArray::offsetGet()
     */
    public function testOffsetGetMethod(): void
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
    public function testOffsetExistsMethod(): void
    {
        $this->assertTrue(isset($this->data['name']));
        $this->assertFalse(isset($this->data['nonexistent']));
    }

    /**
     * @see CoverArray::offsetUnset()
     */
    public function offsetUnset(): void
    {
        unset($this->data['name']);
        $this->assertFalse(isset($this->data['name']));
    }

    /**
     * @see CoverArray::__serialize()
     */
    public function testSerializeMethod(): void
    {
        $this->assertSame(
            'O:33:"Krugozor\Cover\Tests\NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}',
            serialize($this->data->get('langs.backend'))
        );
    }

    /**
     * @see CoverArray::__unserialize()
     */
    public function testUnserializeMethod(): void
    {
        $this->assertEquals(
            unserialize('O:33:"Krugozor\Cover\Tests\NewTypeArray":2:{i:0;s:3:"PHP";i:1;s:5:"MySql";}'),
            $this->data->get('langs.backend')
        );
    }

    /**
     * @see CoverArray::reverse()
     */
    public function testReverseMethod(): void
    {
        $this->assertSame([0 => 'MySql', 1 => 'PHP'], $this->data->get('langs.backend')->reverse(false));
        $this->assertSame([1 => 'MySql', 0 => 'PHP'], $this->data->get('langs.backend')->reverse(true));
    }

    /**
     * @see CoverArray::filter()
     */
    public function testFilterMethod(): void
    {
        // pass value as the only argument to callback instead
        $this->assertSame(['PHP'], $this->data->get('langs.backend')->filter(function ($value) {
            return preg_match('~P~', $value);
        })->getDataAsArray());

        $this->assertSame(['backend' => ['PHP', 'MySql']], $this->data->get('langs')->filter(function ($key) {
            return $key === 'backend';
        }, ARRAY_FILTER_USE_KEY)->getDataAsArray());

        // pass both value and key as arguments to callback instead of the value
        $this->assertSame(['backend' => ['PHP', 'MySql']], $this->data->get('langs')->filter(function ($value, $key) {
            return $key === 'backend' && $value->in('PHP');
        }, ARRAY_FILTER_USE_BOTH)->getDataAsArray());
    }

    /**
     * @see CoverArray::implode()
     */
    public function testImplodeMethod(): void
    {
        $this->assertSame('PHP, MySql', $this->data->get('langs.backend')->implode(', '));
    }

    /**
     * @see CoverArray::mapAssociative()
     */
    public function testMapAssociativeMethod(): void
    {
        $this->assertSame(
            ['0: PHP', '1: MySql'],
            $this->data->get('langs.backend')->mapAssociative(
                fn(string $key, string $value): string => "$key: $value"
            )->getDataAsArray()
        );
    }

    /**
     * @see CoverArray::map()
     */
    public function testMapMethod(): void
    {
        $this->assertSame(
            ['value: PHP', 'value: MySql'],
            $this->data->get('langs.backend')->map(
                fn(string $value): string => "value: $value"
            )->getDataAsArray()
        );
    }

    /**
     * @see CoverArray::in()
     */
    public function testInMethod(): void
    {
        $this->data->setData(['age' => 40]);

        $this->assertTrue($this->data->in(40, true));
        $this->assertTrue($this->data->in(40, false));

        $this->assertTrue($this->data->in('40', false));
        $this->assertFalse($this->data->in('40', true));
    }
}