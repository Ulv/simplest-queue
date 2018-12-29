<?php

namespace Ulv\SimplestQueue;

use Mockery as m;

class QueueTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testInit()
    {
        $connector = m::mock(ConnectorInterface::class);
        $sut = new Queue($connector);
        $this->assertInstanceOf(Queue::class, $sut);
    }

    public function testPush()
    {
        $connector = m::mock(ConnectorInterface::class)
            ->shouldReceive('push')
            ->once()
            ->andReturn(true)
            ->getMock();

        $sut = new Queue($connector);
        $result = $sut->push(new SimplestDto(['a' => 1, 'b' => 2]));

        $this->assertTrue($result);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPushInvalid()
    {
        $connector = m::mock(ConnectorInterface::class)
            ->shouldReceive('push')
            ->never()
            ->getMock();

        $sut = new Queue($connector);
        $sut->push(new \stdClass());
    }

    public function testPop()
    {
        $data = ['a' => 1, 'b' => 2];
        $dto = new SimplestDto($data);
        $connector = m::mock(ConnectorInterface::class)
            ->shouldReceive('pop')
            ->andReturn(json_encode($data))
            ->once()
            ->getMock();

        $sut = new Queue($connector);
        $this->assertEquals($dto, $sut->pop());
    }

    public function testPopEmptyQueue()
    {
        $connector = m::mock(ConnectorInterface::class)
            ->shouldReceive('pop')
            ->andReturn(null)
            ->once()
            ->getMock();

        $sut = new Queue($connector);
        $this->assertEquals(0,$sut->pop()->count());
    }
}
