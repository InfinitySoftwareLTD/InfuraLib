<?php

namespace InfinitySolutions\Infura;

use Bezhanov\Ethereum\Converter;
use InfinitySolutions\Infura\Contracts\NetworkInterface;
use InfinitySolutions\Infura\Exceptions\NetworkErrorException;
use InfinitySolutions\Infura\Networks\Mainnet;

class Infura
{
    protected $address;
    protected $network;
    protected $data;
    protected $params;

    /**
     * Infura constructor.
     * @param NetworkInterface|null $network
     */
    public function __construct(NetworkInterface $network = null)
    {
        $this->network = !is_null($network) ? $network : new Mainnet;
    }

    private function network()
    {
        return $this->network;
    }

    /**
     * @param $address
     * @return $this
     */
    public function setAddress($address): Infura
    {
        $this->address = $address;
        return $this;
    }

    public function setParams($params)
    {
        $this->params = $params;
        return $this;
    }

    public function sendRequest(): Infura
    {
        $client = new \GuzzleHttp\Client();
        $req = $client->post($this->network()->uri() . '/'.config('infura.project_id'), ['json' => $this->params]);
        $this->data = json_decode($req->getBody()->getContents());
        return $this;
    }

    private function getResponse()
    {
        return $this->data;
    }

    /**
     * @return string
     * @throws NetworkErrorException
     */
    public function getBalance(): string
    {
        if (isset($this->getResponse()->error)){
            throw new NetworkErrorException($this->getResponse()->error->message);
        }

        $converter = new Converter();
        return $converter->fromWei((string) hexdec($this->getResponse()->result));
    }
}