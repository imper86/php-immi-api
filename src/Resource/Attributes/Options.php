<?php


namespace Imper86\ImmiApi\Resource\Attributes;


use Imper86\ImmiApi\Resource\AbstractResource;
use Imper86\ImmiApi\Resource\Attributes\Options\Translations as OptionTranslations;
use Imper86\ImmiApi\Resource\GetTrait;

/**
 * Class Options
 * @package Imper86\ImmiApi\Resource\Attributes
 *
 * @method OptionTranslations translations()
 */
class Options extends AbstractResource
{
    use GetTrait;

    protected function getBaseUri(): string
    {
        return '/attribute_options';
    }
}