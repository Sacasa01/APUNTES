<?php

namespace AP52\Views;

use AP52\Entity\Server;

class DeleteServerView
{
    public function render(Server $server, ?string $error = null)
    {
        $template = __DIR__ . "/../../public/assets/delete_server.html";
        include_once $template;
    }
}