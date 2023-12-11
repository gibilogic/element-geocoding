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
use Gibilogic\Elements\Geocoding\Route;

/**
 * Unit tests for the Route class.
 *
 * @author Matteo Guindani https://github.com/Ingannatore
 * @see Route
 * @see \PHPUnit\Framework\TestCase
 */
class RouteTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests the calculation of distance between points.
     */
    public function testDistance()
    {
        $milan = new Point(45.464161, 9.190336);
        $rome = new Point(41.893056, 12.482778);
        $route = new Route($milan, $rome);

        $this->assertEquals(477.17, $route->getDistance());
    }
}
