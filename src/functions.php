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
    $crunch = new Crunch($data);

    return $crunch->getValues();
}

