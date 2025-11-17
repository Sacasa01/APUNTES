<?php
declare(strict_types=1);

namespace AEV2\Controllers;

use AEV2\Views\MainView;

class MainController
{

    public function main(): void
    {
        $view = new MainView();
        $view->render();
    }

    public function noRuta(): void
    {
        $view = new MainView();
        $view->error();
    }
}
