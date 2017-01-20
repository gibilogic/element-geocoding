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

use InvalidArgumentException;

/**
 * A geographical point with latitude and longitude.
 *
 * @author Matteo Guindani https://github.com/Ingannatore
 */
class Point
{
    /**
     * Radius of the Earth in km
     */
    const EARTH_RADIUS = 6371;

    /**
     * The latitude in degrees
     *
     * @var float $latitude
     */
    protected $latitude;

    /**
     * The longitude in degrees
     *
     * @var float $longitude
     */
    protected $longitude;

    /**
     * An external identifier for this point (i.e. to link to an object in your application)
     *
     * @var string $identifier
     */
    protected $identifier;

    /**
     * Class constructor.
     *
     * @param float $latitude The latitude in degrees
     * @param float $longitude The longitude in degrees
     * @param string $identifier An external identifier for this point
     * @throws InvalidArgumentException
     */
    public function __construct($latitude, $longitude, $identifier)
    {
        if ($latitude > 90 || $latitude < -90) {
            throw new InvalidArgumentException(sprintf('Invalid latitude value: %s', $latitude));
        }

        if ($longitude > 180 || $longitude < -180) {
            throw new InvalidArgumentException(sprintf('Invalid longitude value: %s', $longitude));
        }

        $this->latitude = round($latitude, 7);
        $this->longitude = round($longitude, 7);
        $this->identifier = $identifier;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('[%.7f, %.7f]', $this->latitude, $this->longitude);
    }

    /**
     * Returns the latitude in degrees.
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Returns the latitude in radiants.
     *
     * @return float
     *
     * @see https://en.wikipedia.org/wiki/Radian
     */
    public function getLatitudeInRadiants()
    {
        return $this->toRadians($this->latitude);
    }

    /**
     * Returns the longitude in degrees.
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Returns the longitude in radiants.
     *
     * @return float
     *
     * @see https://en.wikipedia.org/wiki/Radian
     */
    public function getLongitudeInRadiants()
    {
        return $this->toRadians($this->longitude);
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Returns the distance in km from coordinates.
     *
     * @param Point $that
     * @return float
     */
    public function distance(Point $that)
    {
        $thisLat = $this->getLatitudeInRadiants();
        $thisLng = $this->getLongitudeInRadiants();
        $thatLat = $that->getLatitudeInRadiants();
        $thatLng = $that->getLongitudeInRadiants();

        $h = $this->haversine($thatLat - $thisLat) + (cos($thatLat) * cos($thisLat) * $this->haversine($thatLng - $thisLng));
        return round(2 * self::EARTH_RADIUS * asin(sqrt($h)), 2);
    }

    /**
     * Returns the half versine value for the given angle (in radiants).
     *
     * @param float $radiants
     * @return float
     *
     * @see https://en.wikipedia.org/wiki/Versine#Haversine
     */
    private function haversine($radiants)
    {
        return (1 - cos($radiants)) / 2;
    }

    /**
     * @param float $degrees
     * @return float
     */
    private function toRadians($degrees)
    {
        return empty($degrees) ? 0 : round($degrees * (pi() / 180), 7);
    }
}
