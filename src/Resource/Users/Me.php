<?php


namespace Imper86\ImmiApi\Resource\Users;


use Imper86\ImmiApi\Resource\AbstractResource;
use Psr\Http\Message\ResponseInterface;

class Me extends AbstractResource
{
    public function get(): ResponseInterface
    {
        return $this->apiGet('/users/me');
    }
}
