<?php

namespace FixerIO;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;

class FixerIO
{
    const BASE_URL = 'http://api.fixer.io';

    protected $client;

    /**
     * Construct the FixerIO client
     * The config only allows a 'handler' parameter to pass a custom handler
     *
     * @param array $config config
     */
    public function __construct(array $config = [])
    {
        if (isset($config['handler'])) {
            if ($config['handler'] instanceof ClientInterface) {
                $this->client = $config['handler'];
            } else {
                throw new \InvalidArgumentException('The handler should be an instance of "GuzzleHttp\ClientInterface".');
            }
        } else {
            $this->client = new GuzzleClient([
                'base_url' => self::BASE_URL,
            ]);
        }
    }

    public function rates($base = 'EUR', $symbols = null, $at = Rates::LATEST)
    {
//        if(cache...) {
//        return from cache...;
//    }
        return new Rates($this->client, $base, $symbols, $at);
    }
}

