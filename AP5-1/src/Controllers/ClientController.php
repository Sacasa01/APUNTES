<?php

namespace AP51\Controllers;

use AP51\Core\EntityManager;
use AP51\Entity\Client;
use AP51\Repository\ClientRepository;
use AP51\Views\ListClientsView;

class ClientController
{
    private EntityManager $entityManager; //Gestiona la conexión con Doctrine
    private ClientRepository $repository; //Hace las consultas específicas de clientes

    public function __construct()
    {
        $this->entityManager = new EntityManager(); //Crea una instancia
        $this->repository = $this->entityManager->getEntityManager()->getRepository(Client::class);
        //guarda en este repo, Obtiene el EntityManager,              Obtiene el ClientRepository
    }

    /**
     * Lista todos los clientes
     *
     * @return void
     */
    public function list(): void
    {
        $clients = $this->repository->findAll(); //SELECT * FROM CLIENTE;
        $view = new ListClientsView();  //devuelve un array de objetos
        $view->render($clients);    //renderizará
    }

    private function noRuta()
    {
        (new MainController)->noRuta();
    }
}