<?php


namespace Imper86\ImmiApi\Resource\Attributes;


use Imper86\ImmiApi\Resource\AbstractResource;
use Imper86\ImmiApi\Resource\GetTrait;

class Translations extends AbstractResource
{
    use GetTrait;

    protected function getBaseUri(): string
    {
        return '/attribute_translations';
    }
}