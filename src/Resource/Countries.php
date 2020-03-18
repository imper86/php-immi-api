<?php


namespace Imper86\ImmiApi\Resource;


use Imper86\ImmiApi\Resource\Country\Translations;

/**
 * Class Countries
 * @package Imper86\ImmiApi\Resource
 *
 * @method Translations translations()
 */
class Countries extends AbstractResource
{
    use GetTrait;

    protected function getBaseUri(): string
    {
        return '/countries';
    }
}