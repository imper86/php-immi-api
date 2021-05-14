<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 25.10.2019
 * Time: 16:42
 */

namespace Imper86\ImmiApi;

use Http\Client\Common\Plugin;
use Imper86\HttpClientBuilder\Builder;
use Imper86\HttpClientBuilder\BuilderInterface;
use Imper86\ImmiApi\Model\CredentialsInterface;
use Imper86\ImmiApi\Oauth\OauthClient;
use Imper86\ImmiApi\Oauth\OauthClientInterface;
use Imper86\ImmiApi\Plugin\HeadersPlugin;
use Imper86\ImmiApi\Plugin\UriPlugin;
use Imper86\ImmiApi\Resource\Api;
use Imper86\ImmiApi\Resource\Attributes;
use Imper86\ImmiApi\Resource\Carts;
use Imper86\ImmiApi\Resource\Commands;
use Imper86\ImmiApi\Resource\ContactRequests;
use Imper86\ImmiApi\Resource\Countries;
use Imper86\ImmiApi\Resource\Orders;
use Imper86\ImmiApi\Resource\Products;
use Imper86\ImmiApi\Resource\ResourceInterface;
use Imper86\ImmiApi\Resource\Users;
use InvalidArgumentException;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class Asana
 * @package Imper86\ImmiApi
 *
 * @method Api api()
 * @method Attributes attributes()
 * @method Carts carts()
 * @method Commands commands()
 * @method ContactRequests contactRequests()
 * @method Countries countries()
 * @method Orders orders()
 * @method Products products()
 * @method Users users()
 */
class Immi implements ImmiInterface
{
    /**
     * @var BuilderInterface
     */
    private $builder;
    /**
     * @var CredentialsInterface
     */
    private $credentials;
    /**
     * @var OauthClientInterface|null
     */
    private $oauthClient;
    /**
     * @var \ReflectionClass
     */
    private $reflection;

    public function __construct(CredentialsInterface $credentials, ?BuilderInterface $httpClientBuilder = null)
    {
        $this->credentials = $credentials;
        $this->builder = $httpClientBuilder ?: new Builder();
        $this->reflection = new \ReflectionClass($this);

        $this->addPlugin(new UriPlugin($credentials->isSandbox()));
        $this->addPlugin(new HeadersPlugin());
    }

    public function __call($name, $arguments)
    {
        $className = sprintf('%s\\%s\\%s', $this->reflection->getNamespaceName(), 'Resource', ucfirst($name));

        if (class_exists($className) && is_a($className, ResourceInterface::class, true)) {
            return new $className($this);
        }

        throw new InvalidArgumentException(sprintf('%s resource not found', $name));
    }

    public function getBuilder(): BuilderInterface
    {
        return $this->builder;
    }

    public function oauth(): OauthClientInterface
    {
        if (null === $this->oauthClient) {
            $this->oauthClient = new OauthClient($this->credentials);
        }

        return $this->oauthClient;
    }

    public function addPlugin(Plugin $plugin): void
    {
        $this->builder->addPlugin($plugin);
    }

    public function removePlugin(string $fqcn): void
    {
        $this->builder->removePlugin($fqcn);
    }

    public function addCache(CacheItemPoolInterface $cacheItemPool, array $config = []): void
    {
        $this->builder->addCache($cacheItemPool, $config);
    }

    public function removeCache(): void
    {
        $this->builder->removeCache();
    }
}
