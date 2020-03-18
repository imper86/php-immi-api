<?php


namespace Imper86\ImmiApi\Oauth;


use Imper86\ImmiApi\Model\TokenInterface;
use Psr\Http\Message\ResponseInterface;

interface TokenFactoryInterface
{
    public function createFromResponse(ResponseInterface $response, string $grantType): TokenInterface;
}