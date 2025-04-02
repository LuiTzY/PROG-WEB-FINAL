<?php 
        require_once __DIR__ . '/../vendor/autoload.php'; // carga las dependencias

        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        function conectarDB() {
            return new mysqli(
                $_ENV['MYSQL_HOST'],
                $_ENV['MYSQL_USER'],
                $_ENV['MYSQL_PASSWORD'],
                $_ENV['MYSQL_DATABASE'],
                $_ENV['MYSQL_PORT']
            );
        }

?>
