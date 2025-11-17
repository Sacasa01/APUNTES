<?php

namespace AP52\Views;

use AP52\Entity\User;

class FormUserView
{
    public function render(bool $update, ?User $user)
    {
        $template = __DIR__ . "/../../public/assets/form_user.html";
        include_once $template;
    }
}