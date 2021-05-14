<?php


namespace Imper86\ImmiApi\Resource;


use Imper86\ImmiApi\Resource\Users\InvoiceAddresses;
use Imper86\ImmiApi\Resource\Users\Me;
use Imper86\ImmiApi\Resource\Users\PriceRules;
use Imper86\ImmiApi\Resource\Users\RegistrationApplications;
use Imper86\ImmiApi\Resource\Users\ShippingAddresses;

/**
 * Class Users
 * @package Imper86\ImmiApi\Resource
 *
 * @method InvoiceAddresses invoiceAddresses()
 * @method Me me()
 * @method PriceRules priceRules()
 * @method ShippingAddresses shippingAddresses()
 * @method RegistrationApplications registrationApplications()
 */
class Users extends AbstractResource
{
    use GetTrait, PostTrait, PutTrait;

    protected function getBaseUri(): string
    {
        return '/users';
    }
}
