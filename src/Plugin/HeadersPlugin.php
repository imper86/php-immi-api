<?php


namespace Imper86\ImmiApi\Plugin;


use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Imper86\ImmiApi\Enum\ContentType;
use Psr\Http\Message\RequestInterface;

class HeadersPlugin implements Plugin
{
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        if (!$request->hasHeader('Content-Type')) {
            $request = $request->withHeader('Content-Type', ContentType::LDJSON);
        }

        if (!$request->hasHeader('Accept')) {
            $request = $request->withHeader('Accept', ContentType::LDJSON);
        }

        return $next($request);
    }
}