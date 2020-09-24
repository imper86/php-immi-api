<?php


namespace Imper86\ImmiApi\Resource;


use Imper86\ImmiApi\Resource\Orders\InvoiceAddresses;
use Imper86\ImmiApi\Resource\Orders\Items;
use Imper86\ImmiApi\Resource\Orders\ShippingAddresses;
use Imper86\ImmiApi\Resource\Orders\UploadInvoice;

/**
 * Class Orders
 * @package Imper86\ImmiApi\Resource
 *
 * @method InvoiceAddresses invoiceAddresses()
 * @method Items items()
 * @method ShippingAddresses shippingAddresses()
 * @method UploadInvoice uploadInvoice()
 */
class Orders extends AbstractResource
{
    use GetTrait, PostTrait, PutTrait, DeleteTrait;

    protected function getBaseUri(): string
    {
        return '/orders';
    }
}
