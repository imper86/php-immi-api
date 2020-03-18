<?php


namespace Imper86\ImmiApi\Resource;


use Psr\Http\Message\ResponseInterface;

trait DeleteTrait
{
    abstract protected function getBaseUri(): string;
    abstract protected function apiDelete(string $uri): ResponseInterface;

    public function delete(string $id): ResponseInterface
    {
        return $this->apiDelete(sprintf('%s/%s', $this->getBaseUri(), $id));
    }
}