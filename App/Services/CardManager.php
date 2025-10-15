<?php

namespace App\Services;
use App\Models\Food;
use App\Models\FoodType;
use PDO;
use PDOException;

class RestaurantManager
{
    private PDO $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    // FoodType methods
    public function addFoodType(FoodType $foodType): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO food_types (name) VALUES (?)");
        $stmt->execute([$foodType->getName()]);
    }
    
    public function listFoodTypes(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM food_types ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function editFoodType(int $id, array $data): void
    {
        if (empty($data)) {
            return;
        }
        $setClause = [];
        $params = [];
        foreach ($data as $key => $value) {
            $setClause[] = "{$key} = ?";
            $params[] = $value;
        }
        $params[] = $id;
        $sql = "UPDATE food_types SET " . implode(', ', $setClause) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }
    
    public function deleteFoodType(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM food_types WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    // Food methods
    public function addFood(Food $food): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO foods (food_type_id, name, description, ingredients, price) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $food->getFoodTypeId(),
            $food->getName(),
            $food->getDescription(),
            $food->getIngredients(),
            $food->getPrice()
        ]);
    }
    
    public function listFoods(): array
    {
        $stmt = $this->pdo->query("
            SELECT f.*, ft.name as food_type_name 
            FROM foods f 
            JOIN food_types ft ON f.food_type_id = ft.id 
            ORDER BY ft.name ASC, f.name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function listFoodsByType(int $foodTypeId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT f.*, ft.name as food_type_name 
            FROM foods f 
            JOIN food_types ft ON f.food_type_id = ft.id 
            WHERE f.food_type_id = ? 
            ORDER BY f.name ASC
        ");
        $stmt->execute([$foodTypeId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function editFood(int $id, array $data): void
    {
        if (empty($data)) {
            return;
        }
        $setClause = [];
        $params = [];
        foreach ($data as $key => $value) {
            $setClause[] = "{$key} = ?";
            $params[] = $value;
        }
        $params[] = $id;
        $sql = "UPDATE foods SET " . implode(', ', $setClause) . " WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }
    
    public function deleteFood(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM foods WHERE id = ?");
        $stmt->execute([$id]);
    }
}