<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function Index(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric'
        ]);

        //Get weather from selected city
        $getCity = Http::get(env('OPEN_WEATHER_MAP_HOST') . 'data/2.5/forecast?lat=' . request('lat') . '&lon=' . request('lon') . '&units=metric&APPID=' . env('OPEN_WEATHER_MAP_KEY'));
        if (count($getCity['list'])) {
            return $getCity['list'];
        }
        return 'error';
    }

    public function CurrentCity(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric'
        ]);

        //Get weather from selected city
        $getCity = Http::get(env('OPEN_WEATHER_MAP_HOST') . 'data/2.5/weather?lat=' . request('lat') . '&lon=' . request('lon') . '&units=metric&APPID=' . env('OPEN_WEATHER_MAP_KEY'));
        if ($getCity) {
            return $getCity;
        }
        return 'error';
    }

    public function RelatedPlaces(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric'
        ]);

        $date = date_create();

        //Get Related Places
        $getRelatedPlaces = Http::get('https://api.geoapify.com/v2/places?categories=commercial,commercial.shopping_mall&filter=circle:'.request('lon').','.request('lat').',5000&bias=proximity:'.request('lon').','.request('lat').'&limit=10&apiKey='.env('GEOAPIFY_KEY'));
        if (count($getRelatedPlaces['features'])) {
            return $getRelatedPlaces['features'];
        }
        return 'error';
    }

    public function AutoCompleteCity($city)
    {
        //Get autocomplete city's
        $getCity = Http::get(env('GEOAPIFY_HOST') . 'v1/geocode/autocomplete?text=' . $city . '&apiKey=' . env('GEOAPIFY_KEY'));
        if (count($getCity['features'])) {
            return $getCity['features'];
        }
        return 'error';
    }
}
