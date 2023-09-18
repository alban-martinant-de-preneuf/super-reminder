<?php

namespace App\Model;

abstract class DbConnection
{
    protected ?\PDO $pdo = null;

    public function __construct()
    {
        if (!$this->pdo) {
            try {
                // get database infos from ini file in config folder
                $db_config = parse_ini_file('config' . DIRECTORY_SEPARATOR . 'db.ini');
                // define PDO dsn with retrieved data
                $this->pdo = new \PDO($db_config['type'] . ':dbname=' . $db_config['name']
                    . ';host=' . $db_config['host']
                    . ';charset=' . $db_config['charset'], $db_config['user'], $db_config['password']);
                // prevent emulation of prepared requests
                $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            } catch (\PDOException $e) {
                header("HTTP/1.1 403 Acces refused to the database");
                die();
            }
        }
    }
}