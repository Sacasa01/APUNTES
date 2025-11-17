<?php

namespace AP51\Core;


use AP51\Controllers\MainController;
use AP51\Core\Interfaces\IRequest;
use AP51\Core\Interfaces\IRoute;

class Dispatcher
{
    private $routeList;
    private IRequest $currentRequest;

    /**
     *  Para poder crear un objeto Dispatcher debemos enviar las rutas de la aplicación y la URI del navegador
     *  para que el dispatcher puéda redirigir al lugar controller correcto con los parámetros adecuados.
     * @param IRoute $routeCollection
     * @param IRequest $request
     */
    public function __construct(IRoute $routeCollection, IRequest $request)
    {
        $this->routeList = $routeCollection->getRoutes();
        $this->currentRequest = $request;
        $this->dispatch();
    }

    /**
     * Redirigimos la aplicación al controlador adecuado.
     */
    private function dispatch()
    {
        //Verificamos que la ruta que hemos recibido está dentro de las rutás de la aplicación
        if (isset($this->routeList[$this->currentRequest->getRoute()])) {
            //Aqui dentro tenetemos un texto del tipo AP51\Controller\DetalleController
            $controllerClass = "AP51\\Controllers\\" . $this->routeList[$this->currentRequest->getRoute()]["controller"];
            //Es equivalente a $controller = new AP51\Controller\MainController o DetalleController;
            $controller = new $controllerClass;
            //Es equivalente al texto main o detail
            $action = $this->routeList[$this->currentRequest->getRoute()]["action"];
            //Comprobamos que se han enviado o no parámetros por la ruta y lanzamos la acción del controller
            if (!is_null($this->currentRequest->getParams())) {
                //Como visual Studio no sabe si los parámetros son o no un array da un fallo de iteración, pero realmente funciona adecuadamente
                $controller->$action(...$this->currentRequest->getParams());
            } else {
                //Equivalente a $controller->main();
                $controller->$action();
            }
        } else {
            $controller = new MainController();
            $controller->noRuta();
        }
    }
}