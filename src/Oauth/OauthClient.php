<?php


namespace Imper86\ImmiApi\Oauth;


use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\ErrorPlugin;
use Imper86\HttpClientBuilder\Builder;
use Imper86\HttpClientBuilder\BuilderInterface;
use Imper86\ImmiApi\Enum\EndpointHost;
use Imper86\ImmiApi\Enum\GrantType;
use Imper86\ImmiApi\Model\CredentialsInterface;
use Imper86\ImmiApi\Model\TokenInterface;
use Imper86\ImmiApi\Plugin\OauthPlugin;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class OauthClient implements OauthClientInterface
{
    /**
     * @var CredentialsInterface
     */
    private $credentials;
    /**
     * @var BuilderInterface
     */
    private $builder;
    /**
     * @var TokenFactoryInterface
     */
    private $tokenFactory;

    public function __construct(CredentialsInterface $credentials)
    {
        $this->credentials = $credentials;
        $this->builder = new Builder();
        $this->tokenFactory = new TokenFactory();

        $this->addPlugin(new ErrorPlugin());
        $this->addPlugin(new OauthPlugin());
    }

    public function getAuthorizationUri(?string $state = null): UriInterface
    {
        $query = [
            'client_id' => $this->credentials->getClientId(),
            'redirect_uri' => $this->credentials->getRedirectUri(),
            'response_type' => 'code',
        ];

        if ($state) {
            $query['state'] = $state;
        }

        return $this->builder->getUriFactory()->createUri('/oauth/v2/authorize')
            ->withScheme('https')
            ->withHost(EndpointHost::API)
            ->withQuery(http_build_query($query));
    }

    public function fetchTokenWithCode(string $code): TokenInterface
    {
        $request = $this->generateTokenRequest([
            'grant_type' => GrantType::AUTHORIZATION_CODE,
            'code' => $code,
            'redirect_uri' => $this->credentials->getRedirectUri(),
        ]);
        $response = $this->builder->getHttpClient()->sendRequest($request);

        return $this->tokenFactory->createFromResponse($response, GrantType::AUTHORIZATION_CODE);
    }

    public function fetchTokenWithRefreshToken(string $refreshToken): TokenInterface
    {
        $request = $this->generateTokenRequest([
            'grant_type' => GrantType::REFRESH_TOKEN,
            'refresh_token' => $refreshToken,
            'redirect_uri' => $this->credentials->getRedirectUri(),
        ]);
        $response = $this->builder->getHttpClient()->sendRequest($request);

        return $this->tokenFactory->createFromResponse($response, GrantType::REFRESH_TOKEN);
    }

    public function fetchTokenWithClientCredentials(): TokenInterface
    {
        $request = $this->generateTokenRequest(['grant_type' => GrantType::CLIENT_CREDENTIALS]);
        $response = $this->builder->getHttpClient()->sendRequest($request);

        return $this->tokenFactory->createFromResponse($response, GrantType::CLIENT_CREDENTIALS);
    }

    public function addPlugin(Plugin $plugin): void
    {
        $this->builder->addPlugin($plugin);
    }

    public function removePlugin(string $fqcn): void
    {
        $this->builder->removePlugin($fqcn);
    }

    private function generateTokenRequest(array $body): RequestInterface
    {
        $uri = $this->builder->getUriFactory()->createUri('/oauth/v2/token');
        $body['client_id'] = $this->credentials->getClientId();
        $body['client_secret'] = $this->credentials->getClientSecret();

        $stream = $this->builder->getStreamFactory()->createStream(http_build_query($body));

        return $this->builder->getRequestFactory()->createRequest('POST', $uri)
            ->withBody($stream);
    }
}