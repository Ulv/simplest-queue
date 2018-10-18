<?php

namespace Ulv\SimplestQueue;

class RedisConnector implements ConnectorInterface
{
    const QUEUE_KEY_TEMPLATE = 'simplest:queue:%s';

    /**
     * @var \Redis
     */
    protected $redis;

    /**
     * Queue name
     * @var string
     */
    protected $queue = '';

    /**
     * RedisConnector constructor.
     * @param \Redis $redis
     */
    public function __construct(\Redis $redis, $queueName = null)
    {
        $this->redis = $redis;
        $this->queue = $this->buildQueueName($queueName ?: 'default');
    }

    /**
     * @param $queueName
     * @return string
     */
    protected function buildQueueName($queueName)
    {
        return sprintf(self::QUEUE_KEY_TEMPLATE, $queueName);
    }

    /**
     * @inheritdoc
     */
    public function push($value)
    {
        if (!is_scalar($value)) {
            throw new \InvalidArgumentException(__METHOD__ . ' value must be scalar!');
        }

        if (empty($value)) {
            throw new \InvalidArgumentException(__METHOD__ . ' value must not be empty!');
        }

        return (bool)$this->redis->lPush($this->queue, $value);
    }

    /**
     * @inheritdoc
     */
    public function pop()
    {
        return $this->redis->rPop($this->queue);
    }
}