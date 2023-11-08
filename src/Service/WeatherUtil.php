<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\MeasurementRepository;
use App\Repository\LocationRepository;

class WeatherUtil
{
    public function __construct(
        private readonly MeasurementRepository $measurementRepository,
        private readonly LocationRepository    $locationRepository,
    )
    {}


    /**
     * @return Measurement[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        return $this->measurementRepository->findByLocation($location);
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->FindOneBy([
            'country'=>$countryCode,
            'city'=>$city
            ]);

        return $this->getWeatherForLocation($location);
    }
}
