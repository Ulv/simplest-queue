<?php

namespace Ulv\SimplestQueue;


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
     * Queue constructor.
     * @param ConnectorInterface $connector
     */
    public function __construct(ConnectorInterface $connector)
    {
        $this->connector = $connector;
    }

    /**
     * @inheritDoc
     */
    public function push($dto)
    {
        if (!($dto instanceof \Serializable)) {
            throw new \InvalidArgumentException(__METHOD__.' passed object *must* implement \Serializable interface!');
        }

        return $this->connector->push(serialize($dto));
    }

    /**
     * @inheritDoc
     */
    public function pop()
    {
        return unserialize($this->connector->pop());
    }
}