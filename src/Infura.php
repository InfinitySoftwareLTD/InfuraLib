<?php

namespace InfinitySolutions\Infura;

use App\Exceptions\ConnectionErrorException;
use Bezhanov\Ethereum\Converter;
use InfinitySolutions\Infura\Contracts\NetworkInterface;
use InfinitySolutions\Infura\Exceptions\NetworkErrorException;
use InfinitySolutions\Infura\Networks\Mainnet;
use InfinitySolutions\Infura\Traits\Method;
use InfinitySolutions\Infura\Traits\Parameters;

class Infura{

    use Method, Parameters;

    protected $network;
    protected $data;

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

    public function buildRequestBody(): array
    {
        return [
            'id' => $this->getId(),
            'jsonrpc' => config('infura.jsonrpc'),
            'method' => $this->getMethod(),
            'params' => $this->getParams()
        ];
    }

    public function sendRequest(): Infura
    {
        $client = new \GuzzleHttp\Client();
        $req = $client->post($this->network()->uri() . '/'.config('infura.project_id'), ['json' => $this->buildRequestBody()]);
        if ($req->getStatusCode() == 200){
            $this->data = json_decode($req->getBody()->getContents());
        }else{
            throw new ConnectionErrorException('There is an error connecting to all Edge node servers.');
        }
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
        return $converter->fromWei((string) hexdec($this->getResponse()->result),'ether');
    }

    public function getGasPrice(): string
    {
        if (isset($this->getResponse()->error)){
            throw new NetworkErrorException($this->getResponse()->error->message);
        }

        $converter = new Converter();
        return $converter->fromWei((string) hexdec($this->getResponse()->result),'ether');
    }
}