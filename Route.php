<?php

/*
 * This file is part of the GiBilogic Elements package.
 *
 * (c) GiBilogic Srl <info@gibilogic.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gibilogic\Elements\Geocoding;

/**
 * A geographical route between two points.
 *
 * @author Matteo Guindani https://github.com/Ingannatore
 * @see Point
 */
class Route
{
    /**
     * @var Point $from
     */
    protected $from;

    /**
     * @var Point $to
     */
    protected $to;

    /**
     * @var float $distance
     */
    protected $distance;

    /**
     * Class constructor.
     *
     * @param Point $from
     * @param Point $to
     */
    public function __construct(Point $from, Point $to)
    {
        $this->from = $from;
        $this->to = $to;
        $this->distance = $from->distance($to);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s -> %s = %.2f', (string)$this->from, (string)$this->to, $this->distance);
    }

    /**
     * @param Route $other
     * @return int
     */
    public function compareTo(Route $other)
    {
        return round($this->distance - $other->getDistance());
    }

    /**
     * @return Point
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return Point
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return float
     */
    public function getDistance()
    {
        return $this->distance;
    }
}
