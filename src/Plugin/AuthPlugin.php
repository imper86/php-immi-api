<?php

namespace Imper86\ImmiApi\Plugin;

use DateInterval;
use DateTime;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Imper86\ImmiApi\Enum\GrantType;
use Imper86\ImmiApi\Model\TokenInterface;
use Imper86\ImmiApi\Oauth\OauthClientInterface;
use Imper86\ImmiApi\Oauth\TokenRepositoryInterface;
use Psr\Http\Message\RequestInterface;
use RuntimeException;

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
    /**
     * @var DateInterval|null
     */
    private $validityInterval;

    public function __construct(
        TokenRepositoryInterface $tokenRepository,
        OauthClientInterface $oauthClient,
        ?DateInterval $validityInterval = null
    ) {
        $this->tokenRepository = $tokenRepository;
        $this->oauthClient = $oauthClient;
        $this->validityInterval = $validityInterval;
    }

    public function handleRequest(
        RequestInterface $request,
        callable $next,
        callable $first
    ): Promise {
        $token = $this->tokenRepository->load();

        if (!$token || $request->hasHeader('Authorization')) {
            return $next($request);
        }

        $now = new DateTime();

        if ($this->validityInterval) {
            $now->add($this->validityInterval);
        }

        if ($token->isExpired($now)) {
            $token = $this->handleExpired($token);
            $this->tokenRepository->save($token);
        }

        return $next(
            $request->withHeader(
                'Authorization',
                sprintf('Bearer %s', $token->__toString())
            )
        );
    }

    private function handleExpired(TokenInterface $token): TokenInterface
    {
        if ($token->getRefreshToken()) {
            return $this->oauthClient->fetchTokenWithRefreshToken(
                $token->getRefreshToken()
            );
        }

        if (GrantType::CLIENT_CREDENTIALS === $token->getGrantType()) {
            return $this->oauthClient->fetchTokenWithClientCredentials();
        }

        throw new RuntimeException(
            "Can't find a way to refresh expired token"
        );
    }
}
