<?php

namespace AP52\Views;

class ListConnectionsView
{
    public function render(array $connections)
    {
        $template = __DIR__ . "/../../public/assets/list_connections.html";
        include_once $template;
    }
}