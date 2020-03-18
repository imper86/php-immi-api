<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 20.10.2019
 * Time: 14:40
 */

namespace Imper86\ImmiApi\Resource;

use Imper86\ImmiApi\ImmiInterface;
use Psr\Http\Client\ClientInterface as HttpClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

abstract class AbstractResource implements ResourceInterface
{
    /**
     * @var ImmiInterface
     */
    protected $immi;
    /**
     * @var RequestFactoryInterface
     */
    protected $requestFactory;
    /**
     * @var UriFactoryInterface
     */
    protected $uriFactory;
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;
    /**
     * @var StreamFactoryInterface
     */
    protected $streamFactory;
    /**
     * @var \ReflectionClass
     */
    private $reflection;

    public function __construct(ImmiInterface $immi)
    {
        $this->immi = $immi;
        $this->requestFactory = $immi->getBuilder()->getRequestFactory();
        $this->uriFactory = $immi->getBuilder()->getUriFactory();
        $this->streamFactory = $immi->getBuilder()->getStreamFactory();
        $this->httpClient = $immi->getBuilder()->getHttpClient();
        $this->reflection = new \ReflectionClass($this);
    }

    public function __call($name, $arguments)
    {
        $className = sprintf('%s\\%s', $this->reflection->getName(), ucfirst($name));

        if (class_exists($className) && is_a($className, ResourceInterface::class, true)) {
            return new $className($this->immi);
        }

        throw new \InvalidArgumentException(sprintf('%s resource not found', $name));
    }

    protected function apiGet(string $uri, ?array $query = null): ResponseInterface
    {
        $uri = $this->uriFactory->createUri($uri);

        if ($query) {
            $uri = $uri->withQuery(http_build_query($query));
        }

        $request = $this->requestFactory->createRequest('GET', $uri);
        return $this->httpClient->sendRequest($request);
    }

    protected function apiPost(string $uri, ?array $body = null): ResponseInterface
    {
        $request = $this->requestFactory->createRequest('POST', $uri);

        if ($body) {
            $stream = $this->streamFactory->createStream(json_encode($body));
            $request = $request->withBody($stream);
        }

        return $this->httpClient->sendRequest($request);
    }

    protected function apiPut(string $uri, ?array $body = null): ResponseInterface
    {
        $request = $this->requestFactory->createRequest('PUT', $uri);

        if ($body) {
            $stream = $this->streamFactory->createStream(json_encode($body));
            $request = $request->withBody($stream);
        }

        return $this->httpClient->sendRequest($request);
    }

    protected function apiDelete(string $uri): ResponseInterface
    {
        $request = $this->requestFactory->createRequest('DELETE', $uri);
        return $this->httpClient->sendRequest($request);
    }
}
