<?php

namespace FixerIO;

use GuzzleHttp\ClientInterface;

class Rates
{
    const LATEST = 'latest';

    protected $client;
    protected $base;
    protected $symbols;
    protected $at;

    public function __construct(ClientInterface $client, $base = null, $symbols = null, $at = self::LATEST)
    {
        $this->client = $client;

        $this->base = $base;

        if (null === $symbols) {
            $this->symbols = null;
        } else {
            if (is_string($symbols)) {
                $symbols = [$symbols];
            }

            $this->symbols = implode(',', $symbols);
        }

        if ($at instanceof \DateTime) {
            $at = $at->format('Y-m-d');
        }

        $this->at = $at;
    }

    public function fetch()
    {
        $url = sprintf('%s/%s?', $this->client->getBaseUrl(), $this->at);

        if (null !== $this->base) {
            $url .= sprintf('base=%s', $this->base);
        }

        if (null !== $this->symbols) {
            $url .= sprintf('&symbols=%s', $this->symbols);
        }

        return $this->client->get($url)->json();
    }
}
