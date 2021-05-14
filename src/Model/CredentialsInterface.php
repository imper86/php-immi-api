<?php


namespace Imper86\ImmiApi\Model;


interface CredentialsInterface
{
    public function getClientId(): string;

    public function getClientSecret(): string;

    public function getRedirectUri(): ?string;

    public function isSandbox(): bool;
}
