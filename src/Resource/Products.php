<?php


namespace Imper86\ImmiApi\Resource;


use Imper86\ImmiApi\Resource\Product\Attributes as ProductAttributes;
use Imper86\ImmiApi\Resource\Product\Images;
use Imper86\ImmiApi\Resource\Product\Prices;
use Imper86\ImmiApi\Resource\Product\Translations;

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
    use GetTrait;

    protected function getBaseUri(): string
    {
        return '/products';
    }
}