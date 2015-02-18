<?php
// $Id: hour_test.php 1645 2011-12-30 20:03:00Z jjdai $

require_once 'simple_include.php';
require_once 'calendar_include.php';

require_once './calendar_test.php';

/**
 * Class TestOfHour
 */
class TestOfHour extends TestOfCalendar
{
    function TestOfHour()
    {
        $this->UnitTestCase('Test of Hour');
    }
    function setUp()
    {
        $this->cal = new Calendar_Hour(2003,10,25,13);
    }
    function testPrevDay_Array ()
    {
        $this->assertEqual(
            array(
                'year'   => 2003,
                'month'  => 10,
                'day'    => 24,
                'hour'   => 0,
                'minute' => 0,
                'second' => 0),
            $this->cal->prevDay('array'));
    }
    function testPrevMinute ()
    {
        $this->assertEqual(59,$this->cal->prevMinute());
    }
    function testThisMinute ()
    {
        $this->assertEqual(0,$this->cal->thisMinute());
    }
    function testNextMinute ()
    {
        $this->assertEqual(1,$this->cal->nextMinute());
    }
    function testPrevSecond ()
    {
        $this->assertEqual(59,$this->cal->prevSecond());
    }
    function testThisSecond ()
    {
        $this->assertEqual(0,$this->cal->thisSecond());
    }
    function testNextSecond ()
    {
        $this->assertEqual(1,$this->cal->nextSecond());
    }
    function testGetTimeStamp()
    {
        $stamp = mktime(13,0,0,10,25,2003);
        $this->assertEqual($stamp,$this->cal->getTimeStamp());
    }
}

/**
 * Class TestOfHourBuild
 */
class TestOfHourBuild extends TestOfHour
{
    function TestOfHourBuild()
    {
        $this->UnitTestCase('Test of Hour::build()');
    }
    function testSize()
    {
        $this->cal->build();
        $this->assertEqual(_EXTCAL_TS_MINUTE,$this->cal->size());
    }
    function testFetch()
    {
        $this->cal->build();
        $i=0;
        while ( $Child = $this->cal->fetch() ) {
            ++$i;
        }
        $this->assertEqual(_EXTCAL_TS_MINUTE,$i);
    }
    function testFetchAll()
    {
        $this->cal->build();
        $children = array();
        $i = 0;
        while ( $Child = $this->cal->fetch() ) {
            $children[$i]=$Child;
            ++$i;
        }
        $this->assertEqual($children,$this->cal->fetchAll());
    }
    function testSelection()
    {
        require_once(CALENDAR_ROOT . 'Minute.php');
        $selection = array(new Calendar_Minute(2003,10,25,13,32));
        $this->cal->build($selection);
        $i = 0;
        while ( $Child = $this->cal->fetch() ) {
            if ( $i == 32 )
                break;
            ++$i;
        }
        $this->assertTrue($Child->isSelected());
    }
}

if (!defined('TEST_RUNNING')) {
    define('TEST_RUNNING', true);
    $test = new TestOfHour();
    $test->run(new HtmlReporter());
    $test = new TestOfHourBuild();
    $test->run(new HtmlReporter());
}
