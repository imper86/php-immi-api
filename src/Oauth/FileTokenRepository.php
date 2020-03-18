<?php


namespace Imper86\ImmiApi\Oauth;


use Imper86\ImmiApi\Model\Token;
use Imper86\ImmiApi\Model\TokenInterface;

class FileTokenRepository implements TokenRepositoryInterface
{
    /**
     * @var string
     */
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function load(): ?TokenInterface
    {
        if (!file_exists($this->path)) {
            return null;
        }

        $raw = json_decode(file_get_contents($this->path), true);

        return new Token($raw);
    }

    public function save(TokenInterface $token): void
    {
        file_put_contents($this->path, json_encode($token->serialize()));
    }
}