<?php


namespace Imper86\ImmiApi\Plugin;


use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Imper86\ImmiApi\Enum\EndpointHost;
use Psr\Http\Message\RequestInterface;

class UriPlugin implements Plugin
{
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $uri = $request->getUri()
            ->withScheme('https')
            ->withHost(EndpointHost::API);

        if ('/api' !== substr($uri->getPath(), 0, 4)) {
            $uri = $uri->withPath("/api{$uri->getPath()}");
        }

        return $next($request->withUri($uri));
    }
}