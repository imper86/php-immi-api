<?php


namespace Imper86\ImmiApi\Resource\Products;


use Imper86\ImmiApi\Resource\AbstractResource;
use Imper86\ImmiApi\Resource\GetTrait;

class Images extends AbstractResource
{
    use GetTrait;

    protected function getBaseUri(): string
    {
        return '/product_images';
    }
}