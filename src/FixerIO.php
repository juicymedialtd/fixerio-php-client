<?php

namespace FixerIO;

use Doctrine\Common\Cache\CacheProvider;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;

class FixerIO
{
    const BASE_URL = 'http://api.fixer.io';

    protected $cache;
    protected $ttl;
    protected $client;

    /**
     * Construct the FixerIO client
     * The config only allows a 'handler' parameter to pass a custom handler
     *
     * @param CacheProvider $cache  cache
     * @param int           $ttl
     * @param array         $config config
     */
    public function __construct(CacheProvider $cache = null, $ttl = 0, array $config = [])
    {
        $this->cache = $cache;
        $this->ttl = $ttl;

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

    public function fetchRates($base = 'EUR', $symbols = null, $at = Rates::LATEST)
    {
        $rates = new Rates($this->client, $base, $symbols, $at);

        if (null !== $this->cache) {
            $token = $rates->tokenize();

            $memRates = $this->cache->fetch($token);

            if (false === $memRates) {
                $memRates = $rates->fetch();

                $this->cache->save($token, $memRates, $this->ttl);
            }

            return $memRates;
        }

        return $rates->fetch();
    }
}

