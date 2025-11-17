<?php

namespace AP51\Views;

class DetailOrderView
{
    public function render($order)
    {
        $template = __DIR__ . "/../../public/assets/detail_order.html";
        include_once $template;
    }
}