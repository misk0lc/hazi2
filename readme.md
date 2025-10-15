# Éttermi Alkalmazás - Restaurant Management System

## Áttekintés
Egyszerű PHP-alapú éttermi alkalmazás, amely lehetővé teszi ételtípusok és ételek kezelését. Az alkalmazás JSON API-t biztosít HTTP végpontokon keresztül.

## Kódstruktúra

### Modellek (`App\Models\`)
- **FoodType**: Ételtípusok (pl. Leves, Főétel, Desszert)
- **Food**: Ételek részletes adatokkal (név, leírás, összetevők, ár)

### Szolgáltatások (`App\Services\`)
- **RestaurantManager**: Adatbázis műveleteket kezel (CRUD operations)

### Vezérlő
- **index.php**: Főkontroller, JSON API végpontokat biztosít

## Adatbázis Szerkezet

```sql
-- Ételtípusok tábla
CREATE TABLE food_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Ételek tábla
CREATE TABLE foods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    food_type_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    ingredients TEXT,
    price DECIMAL(6,2) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (food_type_id) REFERENCES food_types(id) ON DELETE CASCADE
);
```

## API Végpontok

### Ételtípusok
- **Listázás**: `GET /index.php?resource=food_types&action=list`
- **Részletek**: `GET /index.php?resource=food_types&action=get&id=1`
- **Hozzáadás**: `POST /index.php?resource=food_types&action=add`
- **Módosítás**: `POST /index.php?resource=food_types&action=edit&id=1`
- **Törlés**: `POST /index.php?resource=food_types&action=delete&id=1`

### Ételek
- **Listázás**: `GET /index.php?resource=foods&action=list`
- **Részletek**: `GET /index.php?resource=foods&action=get&id=1`
- **Hozzáadás**: `POST /index.php?resource=foods&action=add`
- **Módosítás**: `POST /index.php?resource=foods&action=edit&id=1`
- **Törlés**: `POST /index.php?resource=foods&action=delete&id=1`


## Funkciók

### RestaurantManager Osztály
- **addFoodType()**: Új ételtípus hozzáadása
- **listFoodTypes()**: Ételtípusok listázása
- **editFoodType()**: Ételtípus módosítása
- **deleteFoodType()**: Ételtípus törlése
- **addFood()**: Új étel hozzáadása
- **listFoods()**: Ételek listázása JOIN-nal (ételtípus nevével)
- **listFoodsByType()**: Ételek szűrése típus szerint
- **editFood()**: Étel módosítása
- **deleteFood()**: Étel törlése

### Food Modell Funkciók
- **getFormattedPrice()**: Ár formázása ("1290 Ft" vagy "Ár egyeztetés szerint")
- **displayFood()**: Étel megjelenítése formázott stringként

## Hibakezelés
- JSON válaszok HTTP státuszkódokkal
- 400: Hiányzó adatok
- 404: Nem található erőforrás
- 500: Szerver/adatbázis hiba
- PDO Exception kezelés

## Konfiguráció
```php
$dbHost = 'localhost';
$dbName = 'restaurant_db';
$dbUser = 'root';
$dbPass = '';
```
