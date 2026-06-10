<?php
require_once "db.php";

class RecetteIngredientsModel
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Ingrédients d'une recette donnée
    public function getIngredientsParRecette($recipe_id)
    {
        $sql = "SELECT r.name AS recette,
                       i.name AS ingredient,
                       ri.quantity
                FROM recipe_ingredients ri
                INNER JOIN recipes r
                ON ri.recipe_id = r.recipe_id
                INNER JOIN ingredients i
                ON ri.ingredient_id = i.ingredient_id
                WHERE r.recipe_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $recipe_id);
        $stmt->execute();

        return $stmt->get_result();
    }
}
?>