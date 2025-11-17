<?php

namespace AP51\Views;

class FormProductView
{
    public function render(bool $update, $product)
    {
        $template = __DIR__ . "/../../public/assets/form_product.html";
        include_once $template;
    }
}