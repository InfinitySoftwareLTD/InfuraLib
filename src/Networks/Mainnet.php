<?php

namespace InfinitySolutions\Infura\Networks;

use InfinitySolutions\Infura\Contracts\NetworkInterface;

class Mainnet implements NetworkInterface {

    public function uri(): string
    {
        return 'https://mainnet.infura.io/v3';
    }
}