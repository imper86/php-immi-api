<?php


namespace Imper86\ImmiApi\Model;


use DateTimeImmutable;
use DateTimeInterface;

interface TokenInterface
{
    public function __toString();

    public function getGrantType(): string;

    public function getAccessToken(): string;

    public function getRefreshToken(): ?string;

    public function getUserId(): ?string;

    public function getExpiry(): DateTimeImmutable;

    public function isExpired(?DateTimeInterface $now = null): bool;

    public function serialize(): array;
}