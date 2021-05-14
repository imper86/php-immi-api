<?php


namespace Imper86\ImmiApi\Plugin;


use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Imper86\ImmiApi\Enum\ContentType;
use Imper86\ImmiApi\Enum\EndpointHost;
use Psr\Http\Message\RequestInterface;

class OauthPlugin implements Plugin
{
    /**
     * @var bool
     */
    private $sandbox;

    public function __construct(bool $sandbox = false)
    {
        $this->sandbox = $sandbox;
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $uri = $request->getUri()
            ->withScheme('https')
            ->withHost($this->sandbox ? EndpointHost::SANDBOX : EndpointHost::API);
        $request = $request
            ->withHeader('Content-Type', ContentType::X_WWW_FORM_URLENCODED)
            ->withHeader('Accept', ContentType::JSON)
            ->withUri($uri);

        return $next($request);
    }
}
