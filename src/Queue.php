<?php

namespace Ulv\SimplestQueue;
use Ulv\SimplestQueue\Serializer\DTOSerializer;
use Ulv\SimplestQueue\Serializer\SerializerInterface;


/**
 * Class Queue
 * @package Ulv\SimplestQueue
 */
class Queue implements QueueInterface
{
    /**
     * @var ConnectorInterface
     */
    protected $connector;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * Queue constructor.
     * @param ConnectorInterface $connector
     * @param SerializerInterface $serializer
     */
    public function __construct(ConnectorInterface $connector, SerializerInterface $serializer = null)
    {
        $this->connector = $connector;
        $this->serializer = $serializer ?: new DTOSerializer();
    }

    /**
     * @inheritDoc
     */
    public function push($dto)
    {
        if (!($dto instanceof \ArrayAccess)) {
            throw new \InvalidArgumentException(__METHOD__.' passed object *must* implement \ArrayAccess interface!');
        }

        return $this->connector->push($this->serializer->serialize($dto));
    }

    /**
     * @inheritDoc
     */
    public function pop()
    {
        try {
            return $this->serializer->unserialize($this->connector->pop());
        } catch (\Exception $e) {
            // special case
            return new SimplestDto();
        }
    }
}