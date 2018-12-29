<?php

namespace Ulv\SimplestQueue;


class SimplestDtoTest extends \PHPUnit\Framework\TestCase
{
    protected $testData = ['a' => 1, 'b' => 2, 'c' => 'abcdef'];

    /**
     * We do not expect any exceptions
     * @dataProvider validInitDataProvider
     */
    public function testInit($data)
    {
        $sut = new SimplestDto($data);
        $this->assertInstanceOf(SimplestDto::class, $sut);
    }

    public function validInitDataProvider()
    {
        return [
            [$this->testData],
            [[4, 'a' => 'zzzz']],
        ];
    }

    /**
     * @dataProvider invalidInitDataProvider
     */
    public function testInvalidInit($data)
    {
        $this->expectException(\InvalidArgumentException::class);
        $sut = new SimplestDto($data);
    }

    public function invalidInitDataProvider()
    {
        return [
            [['a' => 1, 'b' => 2, 'c' => 'abcdef', [1, 2]]],
            [[4, 'a' => 'zzzz', new \stdClass()]],
            [[new \stdClass(), 'a' => 'zzzz', new \stdClass()]],
        ];
    }

    public function testExists()
    {
        $sut = new SimplestDto($this->testData);
        $this->assertTrue(isset($sut['a']));
        $this->assertFalse(isset($sut['z']));
    }

    public function testGet()
    {
        $sut = new SimplestDto($this->testData);
        $this->assertEquals($this->testData['a'], $sut['a']);
    }

    public function testSet()
    {
        $sut = new SimplestDto();
        $sut['a'] = 3;
        $this->assertEquals(3, $sut['a']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalid()
    {
        $sut = new SimplestDto();
        $sut[['a']] = 3;
    }

    public function testSetInvalid2()
    {
        $this->expectException(\InvalidArgumentException::class);
        $sut = new SimplestDto($this->testData);
        $sut['a'] = function () {
            return false;
        };
    }

    public function testUnset()
    {
        $sut = new SimplestDto($this->testData);
        unset($sut['a']);
        $this->assertEquals(null, $sut['a']);
    }

    public function testSerializeUnserialize()
    {
        $sut = new SimplestDto($this->testData);
        $serialized = serialize($sut);
        $this->assertEquals($sut, unserialize($serialized));
    }
}
