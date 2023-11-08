<?php

namespace App\Controller;

use App\Entity\Location;
use App\Service\WeatherUtil;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{city}/{country?}', name: 'app_weather', requirements: ['id' => '\d+'])]
    public function city( WeatherUtil $util ,#[MapEntity(stripNull: True)]Location $location): Response
    {
        $measurements = $util->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [
            'location'=>$location,
            'measurements'=>$measurements,
        ]);
    }
}
