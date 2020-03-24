<?php


namespace Imper86\ImmiApi\Resource;


use Imper86\ImmiApi\Resource\Products\Attributes as ProductAttributes;
use Imper86\ImmiApi\Resource\Products\Images;
use Imper86\ImmiApi\Resource\Products\Prices;
use Imper86\ImmiApi\Resource\Products\Translations;

/**
 * Class Products
 * @package Imper86\ImmiApi\Resource
 *
 * @method ProductAttributes attributes()
 * @method Images images()
 * @method Prices prices()
 * @method Translations translations()
 */
class Products extends AbstractResource
{
    use GetTrait, PutTrait;

    protected function getBaseUri(): string
    {
        return '/products';
    }
}