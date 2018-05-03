<?php

namespace GromNaN\JsonCrunch;

class Crunch implements \JsonSerializable
{
    private $index = [];
    private $values = [];

    public function jsonSerialize()
    {
        return $this->values;
    }

    public function __construct($data)
    {
        $this->flatten($data);
    }

    public function getValues() :array
    {
        return $this->values;
    }

    private function flatten($data)
    {
        $flattened = is_array($data) ? array_map([$this, 'flatten'], $data) : $data;

        return $this->insert($flattened);
    }

    private function insert($value) :int
    {
        if (\is_array($value)) {
            \ksort($value);
        }
        $key = \json_encode($value);

        if (!\array_key_exists($key, $this->index)) {
            $i = count($this->index);
            $this->index[$key] = $i;
            $this->values[] = $value;

            return $i;
        }

        return $this->index[$key];
    }
}
