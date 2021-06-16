<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class WeatherApiController extends Controller
{

    private $baseUrl = "api.openweathermap.org/data/2.5";
    private $apiKey = "28e5ced723e59780943c5b42ed738095";
    private $units = 'metric';
    private $lang = 'es';

    /**
     * Result for single city query with basic information.
     *
     * @param Request $request
     * @return array | mixed
     */
    public function searchWeatherForOneCity(Request $request): array
    {
        //$searchParameter = $request->query;
        $response = Http::get($this->baseUrl . "/weather", [
            'q' => 'caracas',
            'appid' => $this->apiKey,
            'units' => $this->units,
            'lang' => $this->lang
        ]);

        return $response->json();

    }

    /**
     * Result for single city with city details and forecast info.
     *
     * @param Request $request
     * @return array | mixed
     */
    public function weatherCityWithForecast(Request $request): array
    {
        //Santiago de chile default parameters
        $latitude = $request->latitude ?? '-33.4569';
        $longitude = $request->longitude ?? '-70.6483';
        $responseCity = Http::get($this->baseUrl . "/weather", [
            'lat' => $latitude,
            'lon' => $longitude,
            'appid' => $this->apiKey,
            'units' => $this->units,
            'lang' => $this->lang
        ]);

        $responseForecast = Http::get($this->baseUrl . "/onecall", [
            'lat' => $latitude,
            'lon' => $longitude,
            'appid' => $this->apiKey,
            'units' => $this->units,
            'lang' => $this->lang,
            'exclude' => 'minutely,hourly'
        ]);

        $response['current'] = $responseCity->json();
        $response['forecast'] = $responseForecast->json();

        return $response;

    }

    /**
     * Result for single city query with detailed information and forecast.
     *
     * @param Request $request
     * @return array | mixed
     */
    public function searchWeatherOneCityDetailed(Request $request): array
    {
        $latitude = $request->latitude ?? '-33.4569';
        $longitude = $request->longitude ?? '-70.6483';
        $response = Http::get($this->baseUrl . "/onecall", [
            'lat' => $latitude,
            'lon' => $longitude,
            'appid' => $this->apiKey,
            'units' => $this->units,
            'lang' => $this->lang,
            'exclude' => 'minutely,hourly'
        ]);

        return $response->json();

    }

    /**
     * List of cities and weather for search query.
     *
     * @param Request $request
     * @return array | mixed
     */
    public function searchHandleListResults(Request $request)
    {
        $searchParameter = $request->busqueda;
        $response = Http::get($this->baseUrl . "/find", [
            'q' => $searchParameter,
            'appid' => $this->apiKey,
            'units' => $this->units,
            'lang' => $this->lang
        ]);

        return $response->json();

    }

}
