<?php

namespace App\Services;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

class MyFatoorahService
{
    protected $apiKey;
    protected $baseUrl;
    protected $client;
    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('myfatoorah.api_key');
        $this->baseUrl = config('myfatoorah.base_url');
    }




    public function sendPayment($data)
    {
        $callbackUrl = route(
            'payment.callback',
            [
                'cardsDetailesId' => base64_encode($data['cardsDetailesId']),
                'UserId' =>  base64_encode($data['currentUserId']),
                'accountType' =>  $data['accountType'],
                'InvoiceValue' => $data['InvoiceValue']
            ]
        );

        $ErrorUrl = 'http://localhost:3000/cards';
        $url = "{$this->baseUrl}/v2/SendPayment";

        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'CustomerName' => $data['CustomerName'],
                'NotificationOption' => 'LNK',
                'InvoiceValue' => $data['InvoiceValue'],
                'DisplayCurrencyIso' => $data['currency'],
                'CustomerEmail' => $data['CustomerEmail'],
                'CallBackUrl' => $callbackUrl,
                'ErrorUrl' => $ErrorUrl,
                'Language' => 'en',
            ],
        ]);
        return json_decode($response->getBody(), true);
    }



    public function bookedPayment($data)
    {
        $callbackUrl = route(
            'payment.bookedcallback',
            [
                'InvoiceValue' => $data['InvoiceValue'],
                'uniqueDataId' => $data['uniqueDataId'],
                'accountType' => $data['accountType']
            ]
        );
        $ErrorUrl = 'http://localhost:3000/paymenterror';
        $url = "{$this->baseUrl}/v2/SendPayment";

        $response = $this->client->post($url, [
            'headers' => [
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'CustomerName' => $data['CustomerName'],
                'NotificationOption' => 'LNK',
                'InvoiceValue' => $data['InvoiceValue'],
                'DisplayCurrencyIso' => $data['currency'],
                'CustomerEmail' => $data['CustomerEmail'],
                'CallBackUrl' => $callbackUrl,
                'ErrorUrl' => $ErrorUrl,
                'Language' => 'en',
            ],
        ]);
        return json_decode($response->getBody(), true);
    }




    public function getPaymentStatus(string $paymentId)
    {
        $url = "{$this->baseUrl}/v2/GetPaymentStatus";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->post($url, [
            'KeyType' => 'PaymentId',
            'Key' => $paymentId,
        ]);

        return $response->json();
    }
}
