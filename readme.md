# 🍽️ Éttermi Menükezelő Alkalmazás

Objektumorientált PHP alkalmazás éttermi menü kezelésére adatbáziskezeléssel, végpontkezeléssel, HTML felülettel.

## Funkcionalitás

### Ételtípusok kezelése
- Ételtípusok hozzáadása (pl. Leves, Főétel, Desszert)
- Ételtípusok törlése

### Ételek kezelése
- Ételek hozzáadása a megfelelő kategóriákhoz
- Ételek szerkesztése (név, leírás, összetevők, ár)
- Ételek törlése
- Ételek listázása kategóriánként

## Adatbázis struktúra

### Táblák létrehozása

```sql
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
```

## Használat

1. Hozz létre egy `restaurant_db` nevű adatbázist
2. Futtasd a fenti SQL parancsokat a táblák létrehozásához
3. Indítsd el az alkalmazást a böngészőben

## Technológiai stack

- **Backend**: PHP 8+ (objektumorientált)
- **Adatbázis**: MySQL/MariaDB
- **Frontend**: HTML, CSS, JavaScript
- **Architektúra**: MVC pattern

