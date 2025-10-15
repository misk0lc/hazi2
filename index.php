<?php
// --- Fájl: index.php (főkönyvtár) ---
// Ez az MVC alkalmazás "Controller" része - Éttermi alkalmazás

// Egyszerű autoloader a kód betöltéséhez
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

use App\Models\Food;
use App\Models\FoodType;
use App\Services\RestaurantManager;

// Adatbázis konfiguráció (valós projektben .env fájlban lenne)
$dbHost = 'localhost';
$dbName = 'restaurant_db';
$dbUser = 'root';
$dbPass = '';

$pdo = null;
try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName}", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Adatbázis-kapcsolat sikeressége
} catch (PDOException $e) {
    die("Hiba az adatbázis-kapcsolatban: " . $e->getMessage());
}

// Létrehozzuk a táblákat, ha még nem léteznek
$sql = "
    CREATE TABLE IF NOT EXISTS food_types (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL
    ) ENGINE=InnoDB;

    CREATE TABLE IF NOT EXISTS foods (
        id INT AUTO_INCREMENT PRIMARY KEY,
        food_type_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        description TEXT,
        ingredients TEXT,
        price DECIMAL(6,2) DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (food_type_id) REFERENCES food_types(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;
";
$pdo->exec($sql);

$manager = new RestaurantManager($pdo);

// A kérések feldolgozása (routing)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_food_type') {
        // Új ételtípus hozzáadása
        if (!empty($_POST['name'])) {
            $foodType = new FoodType(null, $_POST['name']);
            $manager->addFoodType($foodType);
            header("Location: " . $_SERVER['PHP_SELF']); // Oldal frissítése
            exit;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'add_food') {
        // Új étel hozzáadása
        if (!empty($_POST['name']) && !empty($_POST['food_type_id'])) {
            $food = new Food(
                null,
                (int)$_POST['food_type_id'],
                $_POST['name'],
                $_POST['description'] ?? null,
                $_POST['ingredients'] ?? null,
                !empty($_POST['price']) ? (float)$_POST['price'] : null
            );
            $manager->addFood($food);
            header("Location: " . $_SERVER['PHP_SELF']); // Oldal frissítése
            exit;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit_food') {
        // Étel szerkesztése
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $id = (int)$_POST['id'];
            $data = [
                'food_type_id' => !empty($_POST['food_type_id']) ? (int)$_POST['food_type_id'] : null,
                'name' => $_POST['name'] ?? null,
                'description' => $_POST['description'] ?? null,
                'ingredients' => $_POST['ingredients'] ?? null,
                'price' => !empty($_POST['price']) ? (float)$_POST['price'] : null,
            ];

            // Töröljük a null értékeket
            $data = array_filter($data, function($value) {
                return $value !== null && $value !== '';
            });
            
            $manager->editFood($id, $data);
            header("Location: " . $_SERVER['PHP_SELF']); // Oldal frissítése
            exit;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_food') {
        // Étel törlése
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $manager->deleteFood((int)$_POST['id']);
            header("Location: " . $_SERVER['PHP_SELF']); // Oldal frissítése
            exit;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_food_type') {
        // Ételtípus törlése
        if (isset($_POST['id']) && is_numeric($_POST['id'])) {
            $manager->deleteFoodType((int)$_POST['id']);
            header("Location: " . $_SERVER['PHP_SELF']); // Oldal frissítése
            exit;
        }
    }
}

// Adatok lekérése a listázáshoz a HTML-ben
$foodTypes = $manager->listFoodTypes();
$foods = $manager->listFoods();

// Megjelenítő fájl behívása
require_once 'App\Views\index.view.php';