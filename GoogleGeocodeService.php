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
 * Wrapper for the Google's geocode service.
 *
 * @codeCoverageIgnore
 *
 * @author Matteo Guindani https://github.com/Ingannatore
 * @see https://developers.google.com/maps/documentation/geocoding/start
 */
class GoogleGeocodeService
{
    /**
     * URL of the Google's geocode service
     */
    const URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    /**
     * Status for a successful response
     */
    const SUCCESSFUL_RESPONSE_STATUS = 'OK';

    /**
     * Status for "over quota" error message
     */
    const OVER_QUOTA_RESPONSE_STATUS = 'OVER_QUERY_LIMIT';

    /**
     * @var string $apiKey A valid Google API key
     */
    protected $apiKey;

    /**
     * Constructor.
     *
     * @param string $apiKey A valid Google API key (mandatory)
     * @throws \Exception
     */
    public function __construct($apiKey)
    {
        if (empty($apiKey)) {
            throw new \Exception('The Google geocode service needs a valid Google API key');
        }

        $this->apiKey = $apiKey;
    }

    /**
     * Geocodes the given object.
     *
     * @param GeocodeableInterface $object The object to be geocoded
     * @return bool `TRUE` on success, `FALSE` otherwise
     */
    public function geocode(GeocodeableInterface $object)
    {
        try {
            $object->setCoordinates(
                $this->geocodeAddress($object->getAddressForGeocoding())
            );
        } catch (\Exception $ex) {
            return false;
        }

        return true;
    }

    /**
     * Geocodes the given address.
     *
     * @param string $address The address to geocode
     * @return Point The address' coordinates (latitude and longitude)
     */
    public function geocodeAddress($address)
    {
        return $this->getCoordinates($this->execute([
            'key' => $this->apiKey,
            'address' => $address,
        ]));
    }

    /**
     * @param Point $from
     * @param Point|Point[] $to
     * @param int $maxDistance
     * @param bool $sortByDistance
     * @return Route[]
     */
    public function calculateDistances(Point $from, $to, $maxDistance = null, $sortByDistance = false)
    {
        if (!is_array($to)) {
            $to = [$to];
        }

        $routes = [];
        foreach ($to as $point) {
            $routes[] = new Route($from, $point);
        }

        if (null !== $maxDistance) {
            $routes = array_filter($routes, function (Route $route) use ($maxDistance) {
                return $route->getDistance() <= $maxDistance;
            });
        }

        if ($sortByDistance) {
            usort($routes, function (Route $a, Route $b) {
                return $a->compareTo($b);
            });
        }

        return $routes;
    }

    /**
     * Extracts and returns the coordinates (latitude and longitude) from the
     * response of the geocode service.
     *
     * @param array $response The geocode service response
     * @return Point The coordinates (latitude and longitude)
     * @throws \Exception
     * @see https://developers.google.com/maps/documentation/geocoding/intro#GeocodingResponses
     */
    protected function getCoordinates(array $response)
    {
        if (empty($response['results'])) {
            throw new \Exception('Unable to get a result from the geocode service');
        }

        $location = $response['results'][0]['geometry']['location'];
        return new Point($location['lat'], $location['lng']);
    }

    /**
     * Executes a cURL call towards the geocode service.
     *
     * @param array $params The params of the call
     * @return array The service response as an associative array
     * @throws \Exception
     */
    private function execute(array $params)
    {
        $curlInstance = curl_init();
        if (false === $curlInstance) {
            throw new \Exception('Unable to initialize the cURL service');
        }

        curl_setopt_array($curlInstance, [
            CURLOPT_URL => sprintf('%s?%s', self::URL, http_build_query($params)),
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $response = json_decode(curl_exec($curlInstance), true);
        curl_close($curlInstance);

        if (empty($response)) {
            throw new \Exception('Empty response from the geocode service');
        }

        if (self::OVER_QUOTA_RESPONSE_STATUS == $response['status']) {
            throw new \Exception('API usage limit exceeded for your API key [' . print_r($response, true) . ']');
        }

        if (self::SUCCESSFUL_RESPONSE_STATUS != $response['status']) {
            throw new \Exception('Invalid response from the geocode service [' . print_r($response, true) . ']');
        }

        return $response;
    }
}
