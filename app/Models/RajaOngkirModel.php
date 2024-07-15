<?php

namespace App\Models;

use CodeIgniter\Model;

class RajaOngkirModel extends Model
{
    protected $client;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest();
        $this->apiKey = '1feb04075e76d2f209f0a1142efc4d31';
        $this->baseUrl = 'https://api.rajaongkir.com/starter/';
    }

    public function getProvinces()
    {
        $response = $this->client->get($this->baseUrl . 'province', [
            'headers' => [
                'key' => $this->apiKey
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getCities($province_id)
    {
        $response = $this->client->get($this->baseUrl . 'city?province=' . $province_id, [
            'headers' => [
                'key' => $this->apiKey
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getCost($origin, $destination, $weight, $courier)
    {
        $response = $this->client->post($this->baseUrl . 'cost', [
            'form_params' => [
                'origin' => $origin,
                'destination' => $destination,
                'weight' => $weight,
                'courier' => $courier
            ],
            'headers' => [
                'key' => $this->apiKey
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
    public function getAvailableCouriers()
    {
        $response = $this->client->get($this->baseUrl . 'cost', [
            'headers' => [
                'key' => $this->apiKey
            ]
        ]);

        $result = json_decode($response->getBody(), true);

        $couriers = [];

        if (isset($result['rajaongkir']['results'])) {
            foreach ($result['rajaongkir']['results'] as $courier) {

                $couriers[] = $courier['code'];
            }
        }

        return $couriers;
    }


    public function getCostOptions($origin, $destination, $weight)
    {
        $couriers = ['jne', 'tiki', 'pos',];

        $costOptions = [];

        foreach ($couriers as $courier) {
            $response = $this->client->post($this->baseUrl . 'cost', [
                'form_params' => [
                    'origin' => $origin,
                    'destination' => $destination,
                    'weight' => $weight,
                    'courier' => $courier
                ],
                'headers' => [
                    'key' => $this->apiKey
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['rajaongkir']['results'][0]['costs'])) {
                $costOptions[$courier] = $result['rajaongkir']['results'][0]['costs'];
            }
        }

        return $costOptions;
    }
}
