<?php

/*
 * This file is part of the GiBilogic Elements package.
 *
 * (c) GiBilogic Srl <info@gibilogic.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gibilogic\Elements\Geocoding\Tests;

use Gibilogic\Elements\Geocoding\Point;

/**
 * Unit tests for the Point class.
 *
 * @author Matteo Guindani https://github.com/Ingannatore
 * @see Point
 * @see \PHPUnit_Framework_TestCase
 */
class PointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests for invalid latitude values during class construction.
     */
    public function testInvalidLatitude()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        new Point(91, 0);
    }

    /**
     * Tests for invalid longitude values during class construction.
     */
    public function testInvalidLongitude()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        new Point(0, 181);
    }

    /**
     * Tests the degrees round of the class constructor.
     */
    public function testRounding()
    {
        $point = new Point(45.123456789, 20.123456789);
        $this->assertEquals(45.1234568, $point->getLatitude());
        $this->assertEquals(20.1234568, $point->getLongitude());
    }

    /**
     * Tests the conversion from degrees to radiants.
     */
    public function testRadiants()
    {
        $pointZero = new Point(0, 0);
        $this->assertEquals(0, $pointZero->getLatitudeInRadiants());
        $this->assertEquals(0, $pointZero->getLongitudeInRadiants());

        $point = new Point(45, 22.5);
        $this->assertEquals(0.7853982, $point->getLatitudeInRadiants());
        $this->assertEquals(0.3926991, $point->getLongitudeInRadiants());
    }

    /**
     * Tests the calculation of distance between points.
     */
    public function testDistance()
    {
        $milan = new Point(45.464161, 9.190336);
        $rome = new Point(41.893056, 12.482778);
        $this->assertEquals(477.17, $milan->distance($rome));
        $this->assertEquals($rome->distance($milan), $milan->distance($rome));
    }
}
