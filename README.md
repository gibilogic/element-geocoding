# GiBiLogic "Elements" library

Often we find ourselves writing the same code for different projects, over and over again.

We got bored, so we decided to collect all these bits and pieces of code in ready-to-use packages.

# Geocoding Element

This package contains useful classes for working with geographical coordinates.

It uses Google's geocoding service; you can find more informations on its [official documentation](https://developers.google.com/maps/documentation/geocoding/start).

## Installation

Add this package to the `composer.json` of your application with the console command:

```bash
composer require gibilogic/element-geocoding
```

Or, if you are using the `composer.phar` version, use the console command:

```bash
php composer.phar require gibilogic/element-geocoding
```

## Usage

### Basics

Use the `Point` class to manage geographical points with latitude and longitude:

```php
$milan = new Point(45.464161, 9.190336);
$rome = new Point(41.893056, 12.482778);
```

Use the `Route` class to manage relation between two points:

```php
$route = new Route($milan, $rome);
$distance = $route->getDistance();
```

`Route` instances can also be compared by using the `compareTo` method:

```php
$milanRomeRoute = new Route($milan, $rome);
$milanTurinRoute = new Route($milan, $turin);

$comparison = $milanRomeRoute->compareTo($milanTurinRoute);
```

Use the `geocodeAddress` method of the `GoogleGeocodeService` to get a `Point` instance from an address:

```php
$point = $googleGeocodeService->geocodeAddress('via Aldo Moro 48, 25124 Brescia, Italy');
```

### Advanced

Add and implement the `GeocodeableInterface` to existing classes:

```php
class Address implements GeocodeableInterface
{
    protected $address;
    protected $zipCode;
    protected $city;
    protected $province;

    protected $latitude;
    protected $longitude;

    // ...

    public function getAddressForGeocoding()
    {
        return sprintf('%s, %s %s (%s), Italy',
            $this->address,
            $this->zipCode,
            $this->city,
            $this->province
        );
    }

    public function getCoordinates()
    {
        return new Point($this->latitude, $this->longitude);
    }

    public function setCoordinates(Point $point)
    {
        $this->latitude = $point->getLatitude();
        $this->longitude = $point->getLongitude();
    }
}
```

Then use the `geocode` method of the `GoogleGeocodeService`:

```php
$point = $googleGeocodeService->geocode($address);
```

## Contributions

You can contribute to the growth of this library in a lot of different ways:

* Create an issue about a bug or a feature you would like to see implemented
* Open pull requests about fixes, new features, tests, documentation, etc.
* Use the library and let us know ;)

## License

See the attached [license](LICENSE) file.
