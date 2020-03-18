<?php


namespace Imper86\ImmiApi\Oauth;


use Imper86\ImmiApi\Model\TokenInterface;

interface TokenRepositoryInterface
{
    public function load(): ?TokenInterface;

    public function save(TokenInterface $token): void;
}