<?php

namespace AP52\Controllers;

use AP52\Core\EntityManager;
use AP52\Entity\Connection;
use AP52\Entity\User;
use AP52\Entity\Server;
use AP52\Repository\ConnectionRepository;
use AP52\Repository\UserRepository;
use AP52\Repository\ServerRepository;
use AP52\Views\ListConnectionsView;
use AP52\Views\FormConnectionView;

class ConnectionController
{
    private EntityManager $entityManager;
    private ConnectionRepository $repository;
    private UserRepository $userRepository;
    private ServerRepository $serverRepository;

    public function __construct()
    {
        $this->entityManager = new EntityManager();
        $em = $this->entityManager->getEntityManager();
        $this->repository = $em->getRepository(Connection::class);
        $this->userRepository = $em->getRepository(User::class);
        $this->serverRepository = $em->getRepository(Server::class);
    }

    /**
     * Lista todas las conexiones
     */
    public function list(): void
    {
        $connections = $this->repository->findAll();
        $view = new ListConnectionsView();
        $view->render($connections);
    }

    /**
     * Gestiona las operaciones CRUD según los parámetros recibidos
     * NOTA: Solo se permite crear conexiones, no actualizar ni eliminar
     */
    public function crud(...$params): void
    {
        $action = $params[0] ?? null;

        switch ($action) {
            case 'create':
                $this->create();
                break;
            default:
                $this->noRuta();
        }
    }

    /**
     * Crea una nueva conexión
     */
    private function create(): void
    {
        if (isset($_POST['submit'])) {
            // Validar campos requeridos
            if (!isset($_POST['user_id'], $_POST['server_id'], $_POST['ip'],
                       $_POST['date_connection']) ||
                empty($_POST['user_id']) || empty($_POST['server_id']) ||
                empty($_POST['ip']) || empty($_POST['date_connection'])) {
                $this->noRuta();
                return;
            }

            $userId = intval($_POST['user_id']);
            $serverId = intval($_POST['server_id']);

            $user = $this->userRepository->find($userId);
            $server = $this->serverRepository->find($serverId);

            if (!$user || !$server) {
                $this->noRuta();
                return;
            }

            try {
                $dateConnection = new \DateTime($_POST['date_connection']);
            } catch (\Exception $e) {
                $this->noRuta();
                return;
            }

            $connection = new Connection();
            $connection->setUser($user);
            $connection->setServer($server);
            $connection->setIp($_POST['ip']);
            $connection->setDateConnection($dateConnection);

            $em = $this->entityManager->getEntityManager();
            $em->persist($connection);
            $em->flush();

            $this->list();
        } else {
            // Obtener usuarios y servidores para los desplegables
            $users = $this->userRepository->findAll();
            $servers = $this->serverRepository->findAll();

            $view = new FormConnectionView();
            $view->render($users, $servers);
        }
    }

    private function noRuta()
    {
        (new MainController)->noRuta();
    }
}