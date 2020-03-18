<?php


namespace Imper86\ImmiApi\Resource;


use Imper86\ImmiApi\Resource\Cart\Items;

/**
 * Class Carts
 * @package Imper86\ImmiApi\Resource
 *
 * @method Items items()
 */
class Carts extends AbstractResource
{
    use GetTrait, PostTrait, PutTrait;

    protected function getBaseUri(): string
    {
        return '/carts';
    }
}