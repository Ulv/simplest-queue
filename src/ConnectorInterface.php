<?php

namespace Ulv\SimplestQueue;

/**
 * Data storage connector interface
 * @package Ulv\SimplestQueue
 */
interface ConnectorInterface
{
    /**
     * @param $value
     * @return bool
     */
    public function push($value);

    /**
     * @return string
     */
    public function pop();
}