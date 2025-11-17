<?php

namespace AP52\Controllers;

use AP52\Core\EntityManager;
use AP52\Entity\Server;
use AP52\Repository\ServerRepository;
use AP52\Views\ListServersView;
use AP52\Views\FormServerView;
use AP52\Views\DeleteServerView;

class ServerController
{
    private EntityManager $entityManager;
    private ServerRepository $repository;

    public function __construct()
    {
        $this->entityManager = new EntityManager();
        $this->repository = $this->entityManager->getEntityManager()->getRepository(Server::class);
    }

    /**
     * Lista todos los servidores
     */
    public function list(): void
    {
        $servers = $this->repository->findAll();
        $view = new ListServersView();
        $view->render($servers);
    }

    /**
     * Gestiona las operaciones CRUD según los parámetros recibidos
     */
    public function crud(...$params): void
    {
        $action = $params[0] ?? null;
        $id = $params[1] ?? null;

        switch ($action) {
            case 'create':
                $this->create();
                break;
            case 'update':
                $this->update($id);
                break;
            case 'delete':
                $this->delete($id);
                break;
            default:
                $this->noRuta();
        }
    }

    /**
     * Crea un nuevo servidor
     */
    private function create(): void
    {
        if (isset($_POST['submit'])) {
            // Validar campos requeridos
            if (!isset($_POST['url'], $_POST['country_server'], $_POST['domain']) ||
                empty($_POST['url']) || empty($_POST['country_server']) ||
                empty($_POST['domain'])) {
                $this->noRuta();
                return;
            }

            $server = new Server();
            $server->setUrl($_POST['url']);
            $server->setCountryServer($_POST['country_server']);
            $server->setObservation($_POST['observation'] ?? null);
            $server->setDomain($_POST['domain']);
            $server->setIp($_POST['ip'] ?? null);

            $em = $this->entityManager->getEntityManager();
            $em->persist($server);
            $em->flush();

            $this->list();
        } else {
            $view = new FormServerView();
            $view->render(false, null);
        }
    }

    /**
     * Actualiza un servidor existente
     */
    private function update(?string $id): void
    {
        $serverId = intval($id);
        $server = $this->repository->find($serverId);

        if (!$server) {
            $this->noRuta();
            return;
        }

        if (isset($_POST['submit'])) {
            if (!isset($_POST['url'], $_POST['country_server'], $_POST['domain']) ||
                empty($_POST['url']) || empty($_POST['country_server']) ||
                empty($_POST['domain'])) {
                $this->noRuta();
                return;
            }

            $server->setUrl($_POST['url']);
            $server->setCountryServer($_POST['country_server']);
            $server->setObservation($_POST['observation'] ?? null);
            $server->setDomain($_POST['domain']);
            $server->setIp($_POST['ip'] ?? null);

            $em = $this->entityManager->getEntityManager();
            $em->flush();

            $this->list();
        } else {
            $view = new FormServerView();
            $view->render(true, $server);
        }
    }

    /**
     * Elimina un servidor
     */
    private function delete(?string $id): void
    {
        $serverId = intval($id);
        $server = $this->repository->find($serverId);

        if (!$server) {
            $this->noRuta();
            return;
        }

        if (isset($_POST['confirm'])) {
            try {
                $em = $this->entityManager->getEntityManager();
                $em->remove($server);
                $em->flush();

                $this->list();
            } catch (\Exception $e) {
                $view = new DeleteServerView();
                $error = "No se puede eliminar el servidor porque tiene conexiones asociadas.";
                $view->render($server, $error);
            }
        } else {
            $view = new DeleteServerView();
            $view->render($server);
        }
    }

    private function noRuta()
    {
        (new MainController)->noRuta();
    }
}