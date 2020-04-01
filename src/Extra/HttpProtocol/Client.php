<?php

namespace Galdino\Proxy\Extra\HttpProtocol;

use React\EventLoop\LoopInterface;
use React\HttpClient\Request;
use React\HttpClient\RequestData;
use React\Socket\Connector;
use React\Socket\ConnectorInterface;

class Client extends \React\HttpClient\Client
{
    private $connector;

    public function __construct(LoopInterface $loop, ConnectorInterface $connector = null)
    {
        if ($connector === null) {
            $connector = new Connector($loop);
        }

        $this->connector = $connector;

        parent::__construct($loop, $connector);
    }

    public function request($method, $url, array $headers = array(), $protocolVersion = '1.0', $proxy = null)
    {
        $requestData = new \Galdino\Proxy\Extra\HttpProtocol\RequestData($method, $url, $headers, $protocolVersion, $proxy);

        return new Request($this->connector, $requestData);
    }
}