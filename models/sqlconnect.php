<?php


class Database

{
    public $conn;


    public function getConnect ($host, $dbname, $username, $password)

    {
        $this->conn = null;

        // On essaye de ce connecté à la base de donnée
        try
        {
            // On crée une nouvelle connection avec PDO
            $this->conn = new PDO($host . ';' . $dbname, $username, $password);
            // On set les Attribute
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // On return la connection à la database
            return $this->conn;
        }
        catch (PDOException $exception) // On réceptionne les erreurs possibles
        {
            // Puis on les affiches les erreurs
            echo 'Connection error: ' . $exception->getMessage();
            exit;
        }
    }

}




// RESEAU LOCAL :
$pdo = (new Database)->getConnect(
    'mysql:host=localhost',
    'dbname=universes_worst_wasteman',
    'root',
    ''
);

