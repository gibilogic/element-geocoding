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
 * Unit tests for the Coordinates class.
 *
 * @author Matteo Guindani https://github.com/Ingannatore
 * @see Point
 * @see \PHPUnit_Framework_TestCase
 */
class PointTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the class constructor.
     */
    public function testConstructor()
    {
        $point = new Point(45.123456789, 20.123456789);

        $this->assertEquals(45.1234568, $point->getLatitude());
        $this->assertEquals(20.1234568, $point->getLongitude());
    }
}
