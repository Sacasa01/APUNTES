<?php

namespace AP51\Views;

class ListProductsView
{
    public function render(array $products)
    {
        $template = __DIR__ . "/../../public/assets/list_products.html";
        include_once $template;
    }
}