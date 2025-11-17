<?php

namespace AP52\Views;

class FormConnectionView
{
    public function render(array $users, array $servers)
    {
        $template = __DIR__ . "/../../public/assets/form_connection.html";
        include_once $template;
    }
}