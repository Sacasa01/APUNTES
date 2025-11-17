<?php

namespace AP52\Views;

class MainView
{
    const HTML = __DIR__ . '/../../public/assets/main.html';
    const HTML_ERROR = __DIR__ . '/../../public/assets/404.html';

    /**
     * Renderiza la vista de listado de tareas.
     * @return void
     */
    public function render(): void
    {
        require_once self::HTML;
    }

    public function error(string $error = 'Ruta no definida'): void
    {
        require_once self::HTML_ERROR;
    }

}