<?php

namespace Ulv\SimplestQueue;

use Mockery as m;

class RedisConnectorTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * @param $data
     * @dataProvider pushDataProvider
     */
    public function testPush($data)
    {
        $redisMock = m::mock(\Redis::class)
            ->shouldReceive('lpush')
            ->once()
            ->andReturn(true)
            ->getMock();

        $sut = new RedisConnector($redisMock);
        $result = $sut->push($data);

        $this->assertTrue($result);
    }

    public function pushDataProvider()
    {
        return [
            ['abcdef'],
            [100],
            [serialize(['a' => 1, 'b' => 2])],
            [json_encode(['a' => 3, 'b' => 4])],
        ];
    }

    /**
     * @param $data
     * @dataProvider pushInvalidDataProvider
     */
    public function testPushInvalid($data)
    {
        $this->expectException(\InvalidArgumentException::class);
        $redisMock = m::mock(\Redis::class)
            ->shouldReceive('lpush')
            ->never()
            ->getMock();

        $sut = new RedisConnector($redisMock);
        $sut->push($data);
    }

    public function pushInvalidDataProvider()
    {
        return [
            [['abcdef', 1]],
            [null],
            [''],
            [[]],
            [new \stdClass()],
        ];
    }

    public function testPushPop()
    {
        $data = json_encode(['a' => 1, 'b' => 2]);
        $redisMock = m::mock(\Redis::class)
            ->shouldReceive('lpush')
            ->once()
            ->andReturn(true)
            ->getMock()
            ->shouldReceive('rpop')
            ->once()
            ->andReturn($data)
            ->getMock();

        $sut = new RedisConnector($redisMock);
        $result = $sut->push($data);
        $this->assertTrue($result);
        $this->assertEquals($data, $sut->pop());
    }

    public function testPopEmptyQueue()
    {
        $redisMock = m::mock(\Redis::class)
            ->shouldReceive('rpop')
            ->once()
            ->andReturn(null)
            ->getMock();

        $sut = new RedisConnector($redisMock);
        $this->assertNull($sut->pop());
    }
}
