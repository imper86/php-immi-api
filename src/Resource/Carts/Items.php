<?php


namespace Imper86\ImmiApi\Resource\Carts;


use Imper86\ImmiApi\Resource\AbstractResource;
use Imper86\ImmiApi\Resource\DeleteTrait;
use Imper86\ImmiApi\Resource\GetTrait;
use Imper86\ImmiApi\Resource\PostTrait;
use Imper86\ImmiApi\Resource\PutTrait;

class Items extends AbstractResource
{
    use GetTrait, PostTrait, PutTrait, DeleteTrait;

    protected function getBaseUri(): string
    {
        return '/cart_items';
    }
}