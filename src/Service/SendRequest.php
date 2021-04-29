<?php


namespace App\Service;


use App\Entity\User;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpClient\HttpClient;

class SendRequest
{
    private ParameterBagInterface $parameterBag;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    public function sendRequest(array $emails, string $data): string
    {
        $httpClient = HttpClient::create([
            'auth_basic' => [
                $this->parameterBag->get('mailer_app_username'),
                $this->parameterBag->get('mailer_app_password')
            ]
        ]);

        $response = $httpClient->request('POST',
            $this->parameterBag->get('api_url'),
            [
                'json' => [
                    'emails' => $emails,
                    'newsletter_data' => $data
                ]
            ]
        );

        if (200 !== $response->getStatusCode()) {
            throw new \Exception(json_decode($response->getContent()), $response->getStatusCode());
        }

        return json_decode($response->getContent());
    }
}