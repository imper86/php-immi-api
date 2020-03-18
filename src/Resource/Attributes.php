<?php


namespace Imper86\ImmiApi\Resource;


use Imper86\ImmiApi\Resource\Attributes\Options;
use Imper86\ImmiApi\Resource\Attributes\Translations;

/**
 * Class Attributes
 * @package Imper86\ImmiApi\Resource
 *
 * @method Translations translations()
 * @method Options options()
 */
class Attributes extends AbstractResource
{
    use GetTrait;

    protected function getBaseUri(): string
    {
        return '/attributes';
    }
}