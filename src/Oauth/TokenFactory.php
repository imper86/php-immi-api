<?php


namespace Imper86\ImmiApi\Oauth;


use Imper86\ImmiApi\Model\Token;
use Imper86\ImmiApi\Model\TokenInterface;
use Lcobucci\JWT\Parser;
use Psr\Http\Message\ResponseInterface;

class TokenFactory implements TokenFactoryInterface
{
    public function createFromResponse(ResponseInterface $response, string $grantType): TokenInterface
    {
        $body = json_decode($response->getBody()->__toString(), true);
        $parsed = (new Parser())->parse($body['access_token']);

        return new Token([
            'access_token' => $body['access_token'],
            'refresh_token' => $body['refresh_token'] ?? null,
            'grant_type' => $grantType,
            'expiry' => $parsed->getClaim('exp'),
            'user_id' => $parsed->hasClaim('uid') ? $parsed->getClaim('uid') : null,
        ]);
    }
}