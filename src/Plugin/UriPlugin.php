<?php


namespace Imper86\ImmiApi\Plugin;


use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Imper86\ImmiApi\Enum\EndpointHost;
use Psr\Http\Message\RequestInterface;

class UriPlugin implements Plugin
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

        if ('/api' !== substr($uri->getPath(), 0, 4)) {
            $uri = $uri->withPath("/api{$uri->getPath()}");
        }

        return $next($request->withUri($uri));
    }
}
