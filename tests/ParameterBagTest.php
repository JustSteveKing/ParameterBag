<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\ParameterBag;

use PHPUnit\Framework\TestCase;
use JustSteveKing\ParameterBag\ParameterBag;

class ParameterBagTest extends TestCase
{
    public function buildParameterBag(array $parameters = [])
    {
        return new ParameterBag($parameters);
    }

    public function testParameterBagCanBeCreated()
    {
        $this->assertInstanceOf(
            ParameterBag::class,
            $this->buildParameterBag()
        );
    }

    public function testCanGetParameterFromParameterBag()
    {
        $bag = $this->buildParameterBag(
            [
            'foo' => 'bar'
            ]
        );

        $this->assertEquals(
            'bar',
            $bag->get('foo')
        );
    }

    public function testCanCheckIfParameterBagHasItem()
    {
        $bag = $this->buildParameterBag(
            [
            'foo' => 'bar'
            ]
        );

        $this->assertTrue($bag->has('foo'));
    }

    public function testCanGetAllParametersFromBag()
    {
        $bag = $this->buildParameterBag(
            $parameters = [
            'foo' => 'bar'
            ]
        );

        $this->assertEquals($parameters, $bag->all());
    }

    public function testCanSetItemOnParameterBag()
    {
        $bag = $this->buildParameterBag();
        $this->assertEquals([], $bag->all());
        $bag->set('foo', 'bar');
        $this->assertTrue($bag->has('foo'));
    }

    public function testCanRemoveItemFromParameterBag()
    {
        $bag = $this->buildParameterBag(
            $parameters = [
            'foo' => 'bar'
            ]
        );
        $this->assertTrue($bag->has('foo'));
        $bag->remove('foo');
        $this->assertEquals([], $bag->all());
    }

    public function testCanGetAllItemsFromAtttributeBag()
    {
        $bag = $this->buildParameterBag(
            $parameters = [
            'foo' => 'bar'
            ]
        );
        $this->assertTrue($bag->has('foo'));
    }

    public function testWeCanBuildAnAtributeBagFromAString()
    {
        $string = "foo=bar&test=true";
        $bag = ParameterBag::fromString($string);
        $this->assertTrue($bag->has('foo'));
        $this->assertEquals('bar', $bag->get('foo'));
        $this->assertTrue($bag->has('test'));
        $this->assertEquals('true', $bag->get('test'));
    }
}
