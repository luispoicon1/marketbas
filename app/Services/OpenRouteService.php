<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenRouteService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openrouteservice.org/v2/directions/driving-car';
    protected $latOrigen;
    protected $lngOrigen;

    public function __construct()
    {
        $this->apiKey = env('ORS_API_KEY');

        // Coordenadas fijas del Mercado de Abastos de Chincha Alta
        $this->latOrigen = -13.41865;
        $this->lngOrigen = -76.13274;
    }

    public function calcularDistancia($latDestino, $lngDestino)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://api.openrouteservice.org/v2/directions/driving-car', [
            'coordinates' => [
                [(float) env('MERCADO_LNG'), (float) env('MERCADO_LAT')], // origen
                [(float) $lngDestino, (float) $latDestino] // destino
            ]
        ]);
    
        if ($response->successful()) {
            $data = $response->json();
            return $data['routes'][0]['summary']['distance'] / 1000; // en km
        }
    
        return null;
    }
    



    public function obtenerCoordenadasDesdeDireccion($direccion)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])->get('https://api.openrouteservice.org/geocode/search', [
            'text' => $direccion,
            'size' => 1,
            'boundary.country' => 'PE',
        ]);

        if ($response->successful() && isset($response['features'][0])) {
            return [
                'lat' => $response['features'][0]['geometry']['coordinates'][1],
                'lng' => $response['features'][0]['geometry']['coordinates'][0],
            ];
        }

        return null;
    }
}
