<?php

namespace AP52\Views;

use AP52\Entity\Server;

class FormServerView
{
    public function render(bool $update, ?Server $server)
    {
        $template = __DIR__ . "/../../public/assets/form_server.html";
        include_once $template;
    }
}