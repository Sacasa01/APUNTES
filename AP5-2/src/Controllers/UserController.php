<?php

namespace AP52\Controllers;

use AP52\Core\EntityManager;
use AP52\Entity\User;
use AP52\Repository\UserRepository;
use AP52\Views\ListUsersView;
use AP52\Views\FormUserView;
use AP52\Views\DeleteUserView;

class UserController
{
    private EntityManager $entityManager;
    private UserRepository $repository;

    public function __construct()
    {
        $this->entityManager = new EntityManager();
        $this->repository = $this->entityManager->getEntityManager()->getRepository(User::class);
    }

    /**
     * Lista todos los usuarios
     */
    public function list(): void
    {
        $users = $this->repository->findAll();
        $view = new ListUsersView();
        $view->render($users);
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
     * Crea un nuevo usuario
     */
    private function create(): void
    {
        if (isset($_POST['submit'])) {
            // Validar campos requeridos
            if (!isset($_POST['username'], $_POST['name'], $_POST['first_subname'],
                       $_POST['country'], $_POST['email']) ||
                empty($_POST['username']) || empty($_POST['name']) ||
                empty($_POST['first_subname']) || empty($_POST['country']) ||
                empty($_POST['email'])) {
                $this->noRuta();
                return;
            }

            $user = new User();
            $user->setUsername($_POST['username']);
            $user->setName($_POST['name']);
            $user->setFirstSubname($_POST['first_subname']);
            $user->setSecondSubname($_POST['second_subname'] ?? null);
            $user->setAddress($_POST['address'] ?? null);
            $user->setTelephone($_POST['telephone'] ?? null);
            $user->setCity($_POST['city'] ?? null);
            $user->setCountry($_POST['country']);
            $user->setObservation($_POST['observation'] ?? null);
            $user->setEmail($_POST['email']);

            $em = $this->entityManager->getEntityManager();
            $em->persist($user);
            $em->flush();

            $this->list();
        } else {
            $view = new FormUserView();
            $view->render(false, null);
        }
    }

    /**
     * Actualiza un usuario existente
     */
    private function update(?string $id): void
    {
        $userId = intval($id);
        $user = $this->repository->find($userId);

        if (!$user) {
            $this->noRuta();
            return;
        }

        if (isset($_POST['submit'])) {
            if (!isset($_POST['username'], $_POST['name'], $_POST['first_subname'],
                       $_POST['country'], $_POST['email']) ||
                empty($_POST['username']) || empty($_POST['name']) ||
                empty($_POST['first_subname']) || empty($_POST['country']) ||
                empty($_POST['email'])) {
                $this->noRuta();
                return;
            }

            $user->setUsername($_POST['username']);
            $user->setName($_POST['name']);
            $user->setFirstSubname($_POST['first_subname']);
            $user->setSecondSubname($_POST['second_subname'] ?? null);
            $user->setAddress($_POST['address'] ?? null);
            $user->setTelephone($_POST['telephone'] ?? null);
            $user->setCity($_POST['city'] ?? null);
            $user->setCountry($_POST['country']);
            $user->setObservation($_POST['observation'] ?? null);
            $user->setEmail($_POST['email']);

            $em = $this->entityManager->getEntityManager();
            $em->flush();

            $this->list();
        } else {
            $view = new FormUserView();
            $view->render(true, $user);
        }
    }

    /**
     * Elimina un usuario
     */
    private function delete(?string $id): void
    {
        $userId = intval($id);
        $user = $this->repository->find($userId);

        if (!$user) {
            $this->noRuta();
            return;
        }

        if (isset($_POST['confirm'])) {
            try {
                $em = $this->entityManager->getEntityManager();
                $em->remove($user);
                $em->flush();

                $this->list();
            } catch (\Exception $e) {
                $view = new DeleteUserView();
                $error = "No se puede eliminar el usuario porque tiene conexiones asociadas.";
                $view->render($user, $error);
            }
        } else {
            $view = new DeleteUserView();
            $view->render($user);
        }
    }

    private function noRuta()
    {
        (new MainController)->noRuta();
    }
}