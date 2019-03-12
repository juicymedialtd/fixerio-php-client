<?php

namespace FixerIO;

use GuzzleHttp\ClientInterface;

class Rates
{
//    const LATEST = 'latest?access_key=';
    protected $client;
    protected $base;
    protected $symbols;
    protected $at;

    public function __construct(ClientInterface $client, $base = null, $symbols = null, $at = null)
    {
        !$at ? $at = $this->getAccessKey() : '';

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

    public static function getAccessKey(){
        return 'latest?access_key=' . getenv(FIXERIO_ACCESS_KEY);
    }

    public function fetch()
    {
        $params = [];

        if (null !== $this->base) {
            $params['base'] = $this->base;
        }

        if (null !== $this->symbols) {
            $params['symbols'] = $this->symbols;
        }

        $body = (string)$this->client->request('GET', $this->at, ['query' => $params])->getBody();

        return json_decode($body, true);
    }

    public function tokenize()
    {
        $at = $this->at;

        if ($at == $this->getAccessKey()) {
            $at = new \DateTime();
        }

        if ($at instanceof \DateTime) {
            $at = $at->format('Ymd');
        }

        return sprintf('%s%s%s', $this->base, $this->symbols, $at);
    }
}
