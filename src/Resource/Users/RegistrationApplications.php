<?php


namespace Imper86\ImmiApi\Resource\Users;


use Imper86\ImmiApi\Resource\AbstractResource;
use Imper86\ImmiApi\Resource\DeleteTrait;
use Imper86\ImmiApi\Resource\GetTrait;
use Imper86\ImmiApi\Resource\PostTrait;

class RegistrationApplications extends AbstractResource
{
    use GetTrait, PostTrait, DeleteTrait;

    protected function getBaseUri(): string
    {
        return '/user_registration_applications';
    }
}
