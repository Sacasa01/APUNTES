<?php

namespace AP51\Controllers;

use AP51\Core\EntityManager;
use AP51\Entity\Product;
use AP51\Repository\ProductRepository;
use AP51\Views\ListProductsView;
use AP51\Views\FormProductView;
use AP51\Views\DeleteProductView;

class ProductController
{
    private EntityManager $entityManager;
    private ProductRepository $repository;

    public function __construct()
    {
        $this->entityManager = new EntityManager();
        $this->repository = $this->entityManager->getEntityManager()->getRepository(Product::class);
    }

    /**
     * Lista todos los productos
     *
     * @return void
     */
    public function list(): void
    {
        $products = $this->repository->findAll();
        $view = new ListProductsView();
        $view->render($products);
    }

    /**
     * Gestiona las operaciones CRUD según los parámetros recibidos
     *
     * Rutas disponibles:
     * - /producto/create -> crear nuevo producto
     * - /producto/update/{id} -> actualizar producto existente
     * - /producto/delete/{id} -> eliminar producto
     *
     * @param mixed ...$params Array de parámetros donde $params[0] es la acción y $params[1] es el ID (opcional)
     * @return void
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
     * Crea un nuevo producto
     *
     * Si recibe datos por POST, crea el producto y redirige al listado.
     * Si no, muestra el formulario de creación.
     *
     * IMPORTANTE: El ID del producto debe ser proporcionado por el usuario (no es autogenerado)
     *
     * @return void
     */
    private function create(): void
    {
        if (isset($_POST['submit'])) {
            // Validar que los campos requeridos estén presentes
            if (!isset($_POST['id']) || !isset($_POST['description']) ||
                empty($_POST['id']) || empty($_POST['description'])) {
                $this->noRuta();
                return;
            }

            $id = intval($_POST['id']);

            // Verificar que el ID no exista ya
            $existingProduct = $this->repository->find($id);
            if ($existingProduct) {
                // El producto ya existe, mostrar error o redirigir
                $this->list();
                return;
            }

            $product = new Product();
            $product->setId($id);
            $product->setDescription($_POST['description']);

            $em = $this->entityManager->getEntityManager();
            $em->persist($product);
            $em->flush();

            $this->list();
        } else {
            $view = new FormProductView();
            $view->render(false, null);
        }
    }

    /**
     * Actualiza un producto existente
     *
     * Si recibe datos por POST, actualiza el producto y redirige al listado.
     * Si no, muestra el formulario de edición con los datos actuales del producto.
     *
     * @param string|null $id ID del producto a actualizar
     * @return void
     */
    private function update(?string $id): void
    {
        $productId = intval($id);
        $product = $this->repository->find($productId);

        if (!$product) {
            $this->noRuta();
            return;
        }

        if (isset($_POST['submit'])) {
            if (!isset($_POST['description']) || empty($_POST['description'])) {
                $this->noRuta();
                return;
            }

            $product->setDescription($_POST['description']);

            $em = $this->entityManager->getEntityManager();
            $em->flush();

            $this->list();
        } else {
            $view = new FormProductView();
            $view->render(true, $product);
        }
    }

    /**
     * Elimina un producto
     *
     * Si recibe confirmación por POST, elimina el producto y redirige al listado.
     * Si no, muestra la pantalla de confirmación de eliminación.
     *
     * @param string|null $id ID del producto a eliminar
     * @return void
     */
    private function delete(?string $id): void
    {
        $productId = intval($id);
        $product = $this->repository->find($productId);

        if (!$product) {
            $this->noRuta();
            return;
        }

        if (isset($_POST['confirm'])) {
            try {
                $em = $this->entityManager->getEntityManager();
                $em->remove($product);
                $em->flush();

                $this->list();
            } catch (\Exception $e) {
                $view = new DeleteProductView();
                $error = "No se puede eliminar el producto.";
                $view->render($product, $error);
            }
        } else {
            $view = new DeleteProductView();
            $view->render($product);
        }
    }

    private function noRuta()
    {
        (new MainController)->noRuta();
    }
}