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
 * Interface for classes that can be geocoded.
 *
 * @author Matteo Guindani https://github.com/Ingannatore
 */
interface GeocodeableInterface
{
    /**
     * @return string The address to be used for geocoding
     */
    public function getAddressForGeocoding();

    /**
     * @return Point The object's coordinates
     */
    public function getCoordinates();

    /**
     * @param Point $point The new coordinates
     * @return mixed
     */
    public function setCoordinates(Point $point);
}
