<?php

use JustSteveKing\ParameterBag\ParameterBag;

it('can create a new parameter bag', function () {
    $object = createParameterBag();

    expect(
        value: $object,
    )->toBeInstanceOf(
        class: ParameterBag::class
    );

    expect(
        value: $object->all(),
    )->toBeEmpty();
});

it('can create a new parameter bag with default parameters', function () {
    $object = createParameterBag(
        parameters: [
            'foo' => 'bar'
        ],
    );

    expect(
        value: $object->all(),
    )->toHaveCount(
        count: 1,
    )->toEqual(
        expected: ['foo' => 'bar'],
    );
});

it('can retrieve items from the parameterbag', function () {
    $object = createParameterBag(
        parameters: [
            'foo' => 'bar'
        ],
    );

    expect(
        value: $object->get(
            key: 'foo'
        ),
    )->toEqual(
        expected: 'bar',
    );
});

it('can set items on a parameter bag', function () {
    $object = createParameterBag();

    expect(
        value: $object->all(),
    )->toBeEmpty()->toHaveCount(
        count: 0,
    )->toEqual(
        expected: [],
    );

    $object->set(
        key: 'foo',
        value: 'bar',
    );

    expect(
        value: $object->all(),
    )->toHaveCount(
        count: 1,
    )->toEqual(
        expected: ['foo' => 'bar'],
    );

    expect(
        value: $object->get(
        key: 'foo'
    ),
    )->toEqual(
        expected: 'bar',
    );
});

it('can remove items from the parameter bag', function () {
    $object = createParameterBag(
        parameters: [
                        'foo' => 'bar'
                    ],
    );

    expect(
        value: $object->get(
        key: 'foo'
    ),
    )->toEqual(
        expected: 'bar',
    );

    $object->remove(
        key: 'foo',
    );

    expect(
        value: $object->all(),
    )->toHaveCount(
        count: 0,
    )->toBeEmpty()->toEqual(
        expected: [],
    );
});

it('can build a parameter bag from a string', function () {
    $string = "foo=bar&test=true";
    $object = ParameterBag::fromString(
        attributes: $string,
    );

    expect(
        value: $object->all(),
    )->toHaveCount(
        count: 2,
    )->toEqual(
        expected: [
            'foo' => 'bar',
            'test' => 'true',
        ],
    );
});

it('can set something other than a string as a value', function () {
    $object = createParameterBag(
        parameters: [
            'test' => true,
        ],
    );

    expect(
        value: $object->get('test'),
    )->toBeBool()->toEqual(
        expected: true,
    );

    $object->remove(
        key: 'test',
    );

    expect(
        value: $object->all(),
    )->toBeEmpty();

    $object->set(
        key: 'test',
        value: [
            'framework' => 'pest',
        ],
    );

    expect(
        value: $object->all(),
    )->toHaveCount(
        count: 1,
    )->toEqual(
        expected: ['test' => ['framework' => 'pest']],
    );
});

it('can check if an item is in the parameter bag', function () {
    $object = createParameterBag();

    expect(
        value: $object->has(
            key: 'test',
        ),
    )->toBeFalse();

    $object->set(
        key: 'test',
        value: 'test',
    );

    expect(
        value: $object->has(
        key: 'test',
    ),
    )->toBeTrue();
});
