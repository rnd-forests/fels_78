<?php

use Carbon\Carbon;

class HelperFunctionsTest extends UnitTestCase
{
    public function testShortTimeFormat()
    {
        $timestamp = '2015-08-08 12:57:02';
        $this->assertEquals('2015-08-08', short_time($timestamp));
    }

    public function testFullTimeFormat()
    {
        $timestamp1 = '2015-08-08 12:57:02';
        $timestamp2 = '2015-08-08';
        $this->assertEquals('2015-08-08, 12:57:02', full_time($timestamp1));
        $this->assertEquals('2015-08-08, 00:00:00', full_time($timestamp2));
    }

    public function testPluralizeWordWithPrecedingCounter()
    {
        $this->assertEquals('0 Repositories', plural('Repository', 0));
        $this->assertEquals('1 Repository', plural('Repository', 1));
        $this->assertEquals('2 Repositories', plural('Repository', 2));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPluralizeWordException()
    {
        plural('Repository', 'five');
    }

    public function testPluralizeWordWithPrecedingCounterAndMiddlePattern()
    {
        $this->assertEquals(plural2('person', 'crazy', 0), '0 crazy people');
        $this->assertEquals(plural2('person', 'crazy', 1), '1 crazy person');
        $this->assertEquals(plural2('person', 'crazy', 2), '2 crazy people');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testPluralizeWordWithMiddlePatternException()
    {
        plural2('person', 'crazy', 'ten');
    }

    public function testCalculateRemainingDays()
    {
        $this->assertEquals('0 days remaining', remaining_days(Carbon::now()));
        $this->assertEquals('1 day remaining', remaining_days(Carbon::now()->addDay()));
        $this->assertEquals('2 days remaining', remaining_days(Carbon::now()->addDays(2)));
    }

    public function testCountingCollection()
    {
        $this->assertSame(0, counting(collect([])));
        $this->assertSame(4, counting(collect([1, 2, 3, 4])));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCountingCollectionException()
    {
        counting([1, 2, 3, 4]);
    }
}
