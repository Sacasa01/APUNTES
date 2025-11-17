<?php

namespace AP51\Views;

class ListClientsView
{
    public function render(array $clients)
    {
        $template = __DIR__ . "/../../public/assets/list_clients.html";
        include_once $template;
    }
}