<?php
/**
 * DTO serializer interface
 */

namespace Ulv\SimplestQueue\Serializer;

use Ulv\SimplestQueue\Dumpable;

interface SerializerInterface
{
    public function serialize(Dumpable $dto);
    public function unserialize($serializedDto);
}