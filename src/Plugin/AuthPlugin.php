<?php


namespace Imper86\ImmiApi\Plugin;


use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Imper86\ImmiApi\Enum\GrantType;
use Imper86\ImmiApi\Model\TokenInterface;
use Imper86\ImmiApi\Oauth\OauthClientInterface;
use Imper86\ImmiApi\Oauth\TokenRepositoryInterface;
use Psr\Http\Message\RequestInterface;

class AuthPlugin implements Plugin
{
    /**
     * @var TokenRepositoryInterface
     */
    private $tokenRepository;
    /**
     * @var OauthClientInterface
     */
    private $oauthClient;

    public function __construct(TokenRepositoryInterface $tokenRepository, OauthClientInterface $oauthClient)
    {
        $this->tokenRepository = $tokenRepository;
        $this->oauthClient = $oauthClient;
    }

    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $token = $this->tokenRepository->load();

        if (!$token || $request->hasHeader('Authorization')) {
            return $next($request);
        }

        if ($token->isExpired()) {
            $token = $this->handleExpired($token);
            $this->tokenRepository->save($token);
        }

        return $next($request->withHeader('Authorization', sprintf('Bearer %s', $token->__toString())));
    }

    private function handleExpired(TokenInterface $token): TokenInterface
    {
        if ($token->getRefreshToken()) {
            return $this->oauthClient->fetchTokenWithRefreshToken($token->getRefreshToken());
        }

        if (GrantType::CLIENT_CREDENTIALS === $token->getGrantType()) {
            return $this->oauthClient->fetchTokenWithClientCredentials();
        }

        throw new \RuntimeException("Can't find a way to refresh expired token");
    }
}