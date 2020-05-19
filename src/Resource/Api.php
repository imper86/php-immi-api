<?php


namespace Imper86\ImmiApi\Resource;


use Psr\Http\Message\ResponseInterface;

class Api extends AbstractResource
{
    public function get(string $uri, ?array $query = null): ResponseInterface
    {
        return $this->apiGet($uri, $query);
    }

    public function post(string $uri, ?array $body = null): ResponseInterface
    {
        return $this->apiPost($uri, $body);
    }

    public function put(string $uri, ?array $body = null): ResponseInterface
    {
        return $this->apiPut($uri, $body);
    }

    public function delete(string $uri): ResponseInterface
    {
        return $this->apiDelete($uri);
    }
}
