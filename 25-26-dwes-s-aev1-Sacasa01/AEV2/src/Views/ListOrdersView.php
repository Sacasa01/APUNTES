<?php

namespace AEV2\Views;

class ListOrdersView
{
    public function render(array $orders)
    {
        $template = __DIR__ . "/../../public/assets/list_orders.html";
        include_once $template;
    }
}