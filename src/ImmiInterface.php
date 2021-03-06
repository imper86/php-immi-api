<?php
/**
 * Author: Adrian Szuszkiewicz <me@imper.info>
 * Github: https://github.com/imper86
 * Date: 25.10.2019
 * Time: 16:37
 */

namespace Imper86\ImmiApi;

use Http\Client\Common\Plugin;
use Imper86\HttpClientBuilder\BuilderInterface;
use Imper86\ImmiApi\Oauth\OauthClientInterface;
use Imper86\ImmiApi\Resource\Api;
use Imper86\ImmiApi\Resource\Attributes;
use Imper86\ImmiApi\Resource\Carts;
use Imper86\ImmiApi\Resource\Commands;
use Imper86\ImmiApi\Resource\ContactRequests;
use Imper86\ImmiApi\Resource\Countries;
use Imper86\ImmiApi\Resource\Orders;
use Imper86\ImmiApi\Resource\Products;
use Imper86\ImmiApi\Resource\Users;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Interface AsanaInterface
 * @package Imper86\Immi
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
interface ImmiInterface
{
    /**
     * @return OauthClientInterface
     */
    public function oauth(): OauthClientInterface;

    /**
     * @return BuilderInterface
     */
    public function getBuilder(): BuilderInterface;

    /**
     * @param Plugin $plugin
     */
    public function addPlugin(Plugin $plugin): void;

    /**
     * Fully qualified class name of plugin
     *
     * @param string $fqcn
     */
    public function removePlugin(string $fqcn): void;

    /**
     * @param CacheItemPoolInterface $cacheItemPool
     * @param array $config
     */
    public function addCache(CacheItemPoolInterface $cacheItemPool, array $config = []): void;

    /**
     * Removes cache plugin from http client
     */
    public function removeCache(): void;
}
