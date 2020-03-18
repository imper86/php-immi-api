<?php


namespace Imper86\ImmiApi\Resource;


use Imper86\ImmiApi\Resource\Order\InvoiceAddresses;
use Imper86\ImmiApi\Resource\Order\Items;
use Imper86\ImmiApi\Resource\Order\ShippingAddresses;

/**
 * Class Orders
 * @package Imper86\ImmiApi\Resource
 *
 * @method InvoiceAddresses invoiceAddresses()
 * @method Items items()
 * @method ShippingAddresses shippingAddresses()
 */
class Orders extends AbstractResource
{
    use GetTrait, PostTrait, PutTrait, DeleteTrait;

    protected function getBaseUri(): string
    {
        return '/orders';
    }
}