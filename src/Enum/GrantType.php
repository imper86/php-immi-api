<?php


namespace Imper86\ImmiApi\Enum;


final class GrantType
{
    public const CLIENT_CREDENTIALS = 'client_credentials';
    public const AUTHORIZATION_CODE = 'authorization_code';
    public const REFRESH_TOKEN = 'refresh_token';
}