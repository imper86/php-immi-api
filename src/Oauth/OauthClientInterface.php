<?php


namespace Imper86\ImmiApi\Oauth;


use Http\Client\Common\Plugin;
use Imper86\ImmiApi\Model\TokenInterface;
use Psr\Http\Message\UriInterface;

interface OauthClientInterface
{
    public function getAuthorizationUri(?string $state = null): UriInterface;

    public function fetchTokenWithCode(string $code): TokenInterface;

    public function fetchTokenWithRefreshToken(string $refreshToken): TokenInterface;

    public function fetchTokenWithClientCredentials(): TokenInterface;

    public function addPlugin(Plugin $plugin): void;

    public function removePlugin(string $fqcn): void;
}