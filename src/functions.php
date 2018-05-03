<?php

namespace GromNaN\JsonCrunch;

function uncrunch($values)
{
    $expanded = new \SplFixedArray(count($values));
    $lookup = function ($i) use ($expanded) {
        return $expanded[$i];
    };

    foreach ($values as $i => $value) {
        $expanded[$i] = is_array($value) ? array_map($lookup, $value) : $value;
    }

    return end($expanded);
}

function crunch($data)
{
    $index = new \ArrayObject();
    $values = new \ArrayObject();

    crunch_flatten($data, $index, $values);

    return (array) $values;
}

/**
 * @internal
 *
 * @param  [type]       $data   [description]
 * @param  \ArrayObject $index  [description]
 * @param  \ArrayObject $values [description]
 * @return [type]               [description]
 */
function crunch_flatten($data, \ArrayObject $index, \ArrayObject $values)
{
    $recurse = function ($data) use ($index, $values) {
        return crunch_flatten($data, $index, $values);
    };

    $flattened = is_array($data) ? array_map($recurse, $data) : $data;

    return crunch_insert($flattened, $index, $values);
}

/**
 * @internal
 *
 * @param  [type]       $value  [description]
 * @param  \ArrayObject $index  [description]
 * @param  \ArrayObject $values [description]
 * @return [type]               [description]
 */
function crunch_insert($value, \ArrayObject $index, \ArrayObject $values)
{
    if (is_array($value)) {
        ksort($value);
    }
    $key = json_encode($value);

    if (!$index->offsetExists($key)) {
        $i = $index->count();
        $index->offsetSet($key, $i);
        $values->append($value);

        return $i;
    }

    return $index->offsetGet($key);
}
