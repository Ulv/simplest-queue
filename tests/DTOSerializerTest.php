<?php

namespace Ulv\SimplestQueue;

use Ulv\SimplestQueue\Serializer\DTOSerializer;

class DTOSerializerTest extends \PHPUnit\Framework\TestCase
{
    public function testSerializeUnserialize()
    {
        $data =['a' => 1, 'b' => 2];
        $dto = new SimplestDto($data);

        $sut = new DTOSerializer();
        $serialized = $sut->serialize($dto);
        $unserialized = $sut->unserialize($serialized);

        $this->assertInstanceOf(SimplestDto::class, $unserialized);
        $this->assertEquals($dto->count(), $unserialized->count());
        $this->assertEquals($dto, $unserialized);
    }

    /**
     * @expectedException \LogicException
     */
    public function testSerializeUnserializeError()
    {
        $sut = new DTOSerializer();
        $sut->unserialize('abcdef:123,asdasd');
    }
}
