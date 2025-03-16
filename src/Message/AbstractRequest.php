<?php

namespace Omnipay\Przelewy24\Message;

use Omnipay\Common\Message\AbstractRequest as BaseAbstractRequest;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractRequest extends BaseAbstractRequest
{
    protected string $liveEndpoint = 'https://secure.przelewy24.pl/';
    protected string $testEndpoint = 'https://sandbox.przelewy24.pl/';

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setMerchantId(string $value): AbstractRequest
    {
        return $this->setParameter('merchantId', $value);
    }

    /**
     * @return string
     */
    public function getPosId(): string
    {
        return $this->getParameter('posId');
    }

    /**
     * @param  string  $value
     *
     * @return $this
     */
    public function setPosId(string $value): AbstractRequest
    {
        return $this->setParameter('posId', $value);
    }

    /**
     * @return string
     */
    public function getCrc(): string
    {
        return $this->getParameter('crc');
    }

    /**
     * @param  string  $value
     *
     * @return $this
     */
    public function setCrc(string $value): AbstractRequest
    {
        return $this->setParameter('crc', $value);
    }

    /**
     * @return string
     */
    public function getChannel(): ?string
    {
        return $this->getParameter('channel');
    }

    /**
     * @param  string  $value
     *
     * @return $this
     */
    public function setChannel(string $value): AbstractRequest
    {
        return $this->setParameter('channel', $value);
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    /**
     * @param  string      $method
     * @param  string      $endpoint
     * @param  array|null  $data
     *
     * @return ResponseInterface
     */
    protected function sendRequest(string $method, string $endpoint, array $data = null): ResponseInterface
    {
        if (null === $data) {
            $data = array();
        }

        $data['p24_merchant_id'] = $this->getMerchantId();
        $data['p24_pos_id'] = $this->getMerchantId();

        return $this->httpClient->request(
            $method,
            $this->getEndpoint() . $endpoint,
            array('Content-Type' => 'application/x-www-form-urlencoded'),
            http_build_query($data, '', '&')
        );
    }
}
