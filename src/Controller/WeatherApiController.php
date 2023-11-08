<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Service\WeatherUtil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Compiler\ResolveBindingsPass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;


class WeatherApiController extends AbstractController
{
    #[Route('api/v1/weather', name: 'app_weather_api')]
    public function index(
        #[MapQueryParameter] string $city,
        #[MapQueryParameter] string $country,
        WeatherUtil $util,
        #[MapQueryParameter] string $format,
        #[MapQueryParameter] bool $twig = false
    ): Response
    {
        $measurements = $util->getWeatherForCountryAndCity($country,$city);
        if($format ===  'csv'){
            if($twig){
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            }
            else{
                $response = "city,country,date,celsius,fahrehneit\n";

                foreach($measurements as $m){
                    $response .= sprintf('%s,%s,%s,%s,%s,%s',
                        $city,
                        $country,
                        $m->getDate()->format('Y-m-d'),
                        $m->getCelsius(),
                        $m->getFahrehneit(),
                        "\n"
                    );
                }
                return new Response($response);
            }

        }

        else {
            if ($twig) {
                return $this->render('weather_api/index.json.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            } else {
                return $this->json([
                    'city' => $city,
                    'country' => $country,
                    'measurements' => array_map(fn(Measurement $m) => [
                        'date' => $m->getDate()->format('Y-m-d'),
                        'celsius' => $m->getCelsius(),
                        'fahrenheit'=>$m->getFahrehneit(),
                    ], $measurements),
                ]);
            }
        }

    }
}
