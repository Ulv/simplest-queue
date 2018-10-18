<?php

namespace Ulv\SimplestQueue;

interface QueueInterface
{
    /**
     * Push data transfer object to queue
     * @param $dto
     * @return mixed
     */
    public function push($dto);

    /**
     * Pop data transfer object to queue
     * @return mixed
     */
    public function pop();
}