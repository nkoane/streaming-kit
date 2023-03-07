<?php

namespace Rebirth\Stream;

class App
{
    private Server $server;

    public function __construct()
    {
        $this->server = new Server();
    }

    public function getServer(): Server
    {
        return $this->server;
    }
}
