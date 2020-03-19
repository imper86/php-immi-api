<?php


namespace Imper86\ImmiApi\Resource\Commands;


use Imper86\ImmiApi\Resource\AbstractResource;
use Imper86\ImmiApi\Resource\PostTrait;

class CartCheckouts extends AbstractResource
{
    use PostTrait;

    protected function getBaseUri(): string
    {
        return '/commands/cart_checkouts';
    }
}