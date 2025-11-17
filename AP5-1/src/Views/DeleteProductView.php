<?php

namespace AP51\Views;

class DeleteProductView
{
    public function render($product, $error = "")
    {
        $template = __DIR__ . "/../../public/assets/delete_product.html";
        include_once $template;
    }
}