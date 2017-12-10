<?php

namespace Kreso;

class JSON implements \ArrayAccess {

    protected $contents;
    protected $node_type;
    protected $max_depth;

    public function __construct($input, $max_depth = 255)
    {
        $this->max_depth = $max_depth;
        $deserialized = is_string($input) ? $this->deserialize($input) : $input;

        if (is_object($deserialized)) {
            $this->node_type = 'object';

        } else if (is_array($deserialized)) {
            $this->node_type = 'array';

        } else {
            throw new Exception('Invalid or malformed JSON');
        }

        foreach ($deserialized as $key => $value) {
            if (is_scalar($value)) {
                $this->contents[$key] = $value;

            } else if (is_object($value) || is_array($value)) {
                $this->contents[$key] = new JSON($value, $max_depth--);
            }
        }
    }

    protected function deserialize($string)
    {
        $object = json_decode($string);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception(json_last_error_msg());
        }
        return $object;
    }

    public function __get($key)
    {
        return isset($this->contents[$key]) ? $this->contents[$key] : NULL;
    }

    public function __set($key, $value)
    {
        $this->contents[$key] = $value;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->contents[] = $value;
        } else {
            $this->contents[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->contents[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->contents[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->contents[$offset]) ? $this->contents[$offset] : NULL;
    }

    public function __toString()
    {
        return $this->serialize();
    }

    protected function serialize($level = 0)
    {
        if ($level > $this->max_depth) {
            throw new Exception('The maximum stack depth has been exceeded');
        }

        $array = [];
        $string = '';

        if ($this->contents !== NULL) {
            foreach ($this->contents as $key => $value) {
                $value = $value instanceof JSON ? $value->serialize($level++) : json_encode($value);

                $array []= $this->node_type === 'object' ? "\"$key\": " . $value : $value;
            }

            $string = implode(', ', $array);
        }

        return $this->node_type === 'array' ? "[{$string}]" : "{{$string}}";
    }
}
