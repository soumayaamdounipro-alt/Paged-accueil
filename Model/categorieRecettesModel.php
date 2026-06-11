<?php
require_once "db.php";

class CategorieRecettesModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Liste des recettes avec leur catégorie
    public function getRecettesAvecCategorie()
    {
        $sql = "SELECT
                       r.name AS recette,
                       c.label AS categorie
                FROM recipes r
                INNER JOIN categories c
                ON r.category_id = c.category_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>