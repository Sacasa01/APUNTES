<?php

namespace AP52\Core;


use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;

class EntityManager
{
    private \Doctrine\ORM\EntityManager $entityManager;

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager(): \Doctrine\ORM\EntityManager
    {
        return $this->entityManager;
    }

    public function __construct()
    {
        //Primero debemos obtener la ruta donde se encuentran las entidades.
        $path = array(__DIR__ . '/../' . $_ENV['ENTITYFOLDER']);
        //Definimos si estamos trabajando en desarrollo o no
        $isDevMode = boolval($_ENV['DEVELOP_MODE']);
        //Configuramos los parámetros de la conexión con la BB.DD.
        $dbParams = array(
            'host' => $_ENV['DBHOST'],
            'driver' => $_ENV['DBDRIVER'],
            'user' => $_ENV['DBUSER'],
            'password' => $_ENV['DBPASSWORD'],
            'dbname' => $_ENV['DBNAME']
        );
        //Creamos la configuración para la conexión con un método estatico de Doctrine
        $config = ORMSetup::createAttributeMetadataConfiguration($path, $isDevMode);
        //Creamos una conexión para poder trabajar
        $connection = DriverManager::getConnection($dbParams, $config);
        //E instanciamos el entityManager definitivo con la conexión establecidad y la configuración cargada.
        $this->entityManager = new \Doctrine\ORM\EntityManager($connection, $config);
    }
}