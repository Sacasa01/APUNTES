<?php

namespace AEV2\Controllers;

use AEV2\Controllers\MainController;
use AEV2\Core\EntityManager;
use AEV2\Entity\Order;
use AEV2\Repository\OrderRepository;
use AEV2\Views\ListOrdersView;
use AEV2\Views\DetailOrderView;

class OrderController
{
    private EntityManager $entityManager;
    private OrderRepository $repository;

    public function __construct()
    {
        $this->entityManager = new EntityManager();
        $this->repository = $this->entityManager->getEntityManager()->getRepository(Order::class);
    }

    /**
     * Lista todos los pedidos
     *
     * @return void
     */
    public function list(): void
    {
        $orders = $this->repository->findAll();
        $view = new ListOrdersView();
        $view->render($orders);
    }

    /**
     * Gestiona las operaciones sobre pedidos
     *
     * Rutas disponibles:
     * - /pedido/read/{id} -> mostrar detalle de un pedido
     *
     * @param mixed ...$params Array de parámetros donde $params[0] es la acción y $params[1] es el ID
     * @return void
     */
    public function crud(...$params): void
    {
        $action = $params[0] ?? null;
        $id = $params[1] ?? null;

        switch ($action) {
            case 'read':
                $this->read($id);
                break;
            default:
                $this->noRuta();
        }
    }

    /**
     * Muestra el detalle de un pedido
     *
     * Busca el pedido por ID y muestra su información detallada incluyendo los detalles del pedido.
     *
     * @param string|null $id ID del pedido a mostrar
     * @return void
     */
    private function read(?string $id): void
    {
        $orderId = intval($id);
        $order = $this->repository->find($orderId);

        if (!$order) {
            $this->noRuta();
            return;
        }

        $view = new DetailOrderView();
        $view->render($order);
    }

    private function noRuta()
    {
        (new MainController)->noRuta();
    }
}