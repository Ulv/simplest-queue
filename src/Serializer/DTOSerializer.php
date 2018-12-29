<?php
/**
 * Simple DTO serializer
 */

namespace Ulv\SimplestQueue\Serializer;

use Ulv\SimplestQueue\Dumpable;
use Ulv\SimplestQueue\SimplestDto;
use Webmozart\Assert\Assert;

class DTOSerializer implements SerializerInterface
{
    public function serialize(Dumpable $dto)
    {
        return json_encode($dto->dump());
    }

    public function unserialize($serializedDto)
    {
        Assert::notEmpty($serializedDto,__METHOD__.' "$serializedDto" cannot be empty!');

        $decodedData = json_decode($serializedDto, true);
        if ($decodedData === false || json_last_error()) {
            throw new \LogicException(__METHOD__ . ' object cannot be unserialized, source: ' .
                $serializedDto.', error: '.json_last_error().': '.json_last_error_msg());
        }

        return new SimplestDto($decodedData);
    }
}