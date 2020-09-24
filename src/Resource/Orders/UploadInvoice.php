<?php


namespace Imper86\ImmiApi\Resource\Orders;


use Imper86\ImmiApi\Resource\AbstractResource;
use InvalidArgumentException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class UploadInvoice extends AbstractResource
{
    /**
     * @param string $id
     * @param string|resource|StreamInterface $file
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    public function put(string $id, $file): ResponseInterface
    {
        if ($file instanceof StreamInterface) {
            $stream = $file;
        }

        if (gettype($file) === 'string') {
            $stream = $this->streamFactory->createStream($file);
        }

        if (gettype($file) === 'resource') {
            $stream = $this->streamFactory->createStreamFromResource($file);
        }

        if (!isset($stream)) {
            throw new InvalidArgumentException("File must be string, resource or stream");
        }

        $request = $this->requestFactory->createRequest('PUT', sprintf('/orders/%s/upload_invoice', $id))
            ->withBody($stream);

        return $this->httpClient->sendRequest($request);
    }
}
