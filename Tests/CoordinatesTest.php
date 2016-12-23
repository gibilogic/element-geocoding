<?php

/*
 * This file is part of the GiBilogic Elements package.
 *
 * (c) GiBilogic Srl <info@gibilogic.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gibilogic\Elements\Slugger\Tests;

use Gibilogic\Elements\Geocoding\Point;

/**
 * Unit tests for the Coordinates class.
 *
 * @author Matteo Guindani https://github.com/Ingannatore
 * @see Point
 * @see \PHPUnit_Framework_TestCase
 */
class CoordinatesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for null or empty string
     */
    public function testConstructor()
    {
        $coords = new Point(45.123456789, 20.123456789);
    }
}
