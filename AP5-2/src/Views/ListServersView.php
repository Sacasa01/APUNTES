<?php

namespace AP52\Views;

class ListServersView
{
    public function render(array $servers)
    {
        $template = __DIR__ . "/../../public/assets/list_servers.html";
        include_once $template;
    }
}