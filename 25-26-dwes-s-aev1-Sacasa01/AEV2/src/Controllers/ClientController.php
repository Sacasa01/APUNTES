<?php

namespace AEV2\Controllers;

use AEV2\Controllers\MainController;
use AEV2\Core\EntityManager;
use AEV2\Entity\Client;
use AEV2\Repository\ClientRepository;
use AEV2\Views\ListClientsView;

class ClientController
{
    private EntityManager $entityManager;
    private ClientRepository $repository;

    public function __construct()
    {
        $this->entityManager = new EntityManager();
        $this->repository = $this->entityManager->getEntityManager()->getRepository(Client::class);
    }

    /**
     * Lista todos los clientes
     *
     * @return void
     */
    public function list(): void
    {
        $clients = $this->repository->findAll();
        $view = new ListClientsView();
        $view->render($clients);
    }

    private function noRuta()
    {
        (new MainController)->noRuta();
    }
}