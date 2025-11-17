<?php

namespace AP52\Views;

class ListUsersView
{
    public function render(array $users)
    {
        $template = __DIR__ . "/../../public/assets/list_users.html";
        include_once $template;
    }
}