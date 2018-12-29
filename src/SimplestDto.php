<?php

namespace Ulv\SimplestQueue;


/**
 * Data transfer object. Just a simple container.
 * @package Ulv\SimplestQueue
 */
class SimplestDto implements \ArrayAccess, \Countable, Dumpable
{
    /**
     * Internal storage
     */
    protected $data = [];

    /**
     * SimplestDto constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->init($data);
        }
    }

    protected function init($data)
    {
        $this->data = [];
        foreach ($data as $key => $value) {
            $this->offsetSet($key, $value);
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->data[$offset];
        }
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        if (!is_scalar($offset)) {
            throw new \InvalidArgumentException(__METHOD__.' offset must be scalar!');
        }

        if (!is_scalar($value)) {
            throw new \InvalidArgumentException(__METHOD__.' value must be scalar!');
        }

        $this->data[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->data);
    }

    public function dump()
    {
        return $this->data;
    }
}