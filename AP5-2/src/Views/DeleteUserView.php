<?php

namespace AP52\Views;

use AP52\Entity\User;

class DeleteUserView
{
    public function render(User $user, ?string $error = null)
    {
        $template = __DIR__ . "/../../public/assets/delete_user.html";
        include_once $template;
    }
}