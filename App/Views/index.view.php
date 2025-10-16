<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éttermi Menükezelő</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 100%;
            max-width: 900px;
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #1a4d2e;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            color: #444;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 5px;
            margin-top: 30px;
        }
        form {
            display: grid;
            gap: 15px;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        form input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        form input[type="text"]:focus {
            border-color: #1a4d2e;
            outline: none;
        }
        form button {
            grid-column: 1 / -1;
            background-color: #1a4d2e;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, transform 0.2s;
        }
        form button:hover {
            background-color: #143822;
            transform: translateY(-2px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f8f8;
            font-weight: 600;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .delete-form, .edit-form {
            display: inline;
        }
        .edit-button, .delete-button {
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            margin-right: 5px;
        }
        .edit-button {
            background-color: #3498db;
            color: white;
        }
        .edit-button:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
        }
        .delete-button {
            background-color: #e74c3c;
            color: white;
        }
        .delete-button:hover {
            background-color: #c0392b;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Éttermi Menükezelő</h1>

        <h2>Új ételtípus hozzáadása</h2>
        <form action="" method="post">
            <input type="hidden" name="action" value="add_food_type">
            <div>
                <label for="food_type_name">Ételtípus neve:</label>
                <input type="text" id="food_type_name" name="name" placeholder="pl. Leves, Főétel, Desszert" required>
            </div>
            <button type="submit">Ételtípus hozzáadása</button>
        </form>

        <h2>Új étel hozzáadása</h2>
        <form action="" method="post">
            <input type="hidden" name="action" value="add_food">
            <div>
                <label for="food_type_id">Ételtípus:</label>
                <select id="food_type_id" name="food_type_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                    <option value="">Válassz ételtípust...</option>
                    <?php foreach ($foodTypes as $type): ?>
                        <option value="<?= htmlspecialchars($type['id']) ?>"><?= htmlspecialchars($type['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="food_name">Étel neve:</label>
                <input type="text" id="food_name" name="name" required>
            </div>
            <div>
                <label for="description">Leírás:</label>
                <input type="text" id="description" name="description" placeholder="Rövid leírás az ételről">
            </div>
            <div>
                <label for="ingredients">Összetevők:</label>
                <input type="text" id="ingredients" name="ingredients" placeholder="Főbb összetevők">
            </div>
            <div>
                <label for="price">Ár (Ft):</label>
                <input type="number" id="price" name="price" placeholder="2500" min="0" step="50" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
            </div>
            <button type="submit">Étel hozzáadása</button>
        </form>

        <h2>Ételtípusok</h2>
        <?php if (empty($foodTypes)): ?>
            <p>Nincsenek ételtípusok az adatbázisban.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ételtípus neve</th>
                        <th>Művelet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foodTypes as $type): ?>
                        <tr>
                            <td><?= htmlspecialchars($type['id']) ?></td>
                            <td><?= htmlspecialchars($type['name']) ?></td>
                            <td>
                                <form action="" method="post" class="delete-form">
                                    <input type="hidden" name="action" value="delete_food_type">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($type['id']) ?>">
                                    <button type="submit" class="delete-button" onclick="return confirm('Biztosan törölni szeretnéd? Ez minden kapcsolódó ételt is töröl!')">Törlés</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <h2>Ételek menüje</h2>
        <?php if (empty($foods)): ?>
            <p>Nincsenek ételek az adatbázisban.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kategória</th>
                        <th>Étel neve</th>
                        <th>Leírás</th>
                        <th>Összetevők</th>
                        <th>Ár</th>
                        <th>Felvéve</th>
                        <th>Művelet</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($foods as $food): ?>
                        <tr>
                            <td><?= htmlspecialchars($food['id']) ?></td>
                            <td><strong><?= htmlspecialchars($food['food_type_name']) ?></strong></td>
                            <td><?= htmlspecialchars($food['name']) ?></td>
                            <td><?= htmlspecialchars($food['description'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($food['ingredients'] ?? '-') ?></td>
                            <td><?= $food['price'] ? number_format($food['price'], 0) . ' Ft' : 'Ár egyeztetés szerint' ?></td>
                            <td><?= date('Y-m-d H:i', strtotime($food['created_at'])) ?></td>
                            <td>
                                <button class="edit-button" onclick="showEditForm(<?= htmlspecialchars($food['id']) ?>)">Szerkesztés</button>
                                <form action="" method="post" class="delete-form">
                                    <input type="hidden" name="action" value="delete_food">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($food['id']) ?>">
                                    <button type="submit" class="delete-button" onclick="return confirm('Biztosan törölni szeretnéd ezt az ételt?')">Törlés</button>
                                </form>
                            </td>
                        </tr>
                        <!-- Szerkesztő űrlap, ami alapból rejtett -->
                        <tr id="edit-form-<?= htmlspecialchars($food['id']) ?>" style="display:none;">
                            <td colspan="8">
                                <form action="" method="post" style="display: block; padding: 15px; background: #f9f9f9; border-radius: 8px;">
                                    <input type="hidden" name="action" value="edit_food">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($food['id']) ?>">
                                    <div style="display: grid; gap: 10px; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                                        <label>Kategória: 
                                            <select name="food_type_id" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                                <?php foreach ($foodTypes as $type): ?>
                                                    <option value="<?= htmlspecialchars($type['id']) ?>" <?= $type['id'] == $food['food_type_id'] ? 'selected' : '' ?>>
                                                        <?= htmlspecialchars($type['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </label>
                                        <label>Név: <input type="text" name="name" value="<?= htmlspecialchars($food['name']) ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></label>
                                        <label>Leírás: <input type="text" name="description" value="<?= htmlspecialchars($food['description'] ?? '') ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></label>
                                        <label>Összetevők: <input type="text" name="ingredients" value="<?= htmlspecialchars($food['ingredients'] ?? '') ?>" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></label>
                                        <label>Ár (Ft): <input type="number" name="price" value="<?= htmlspecialchars($food['price'] ?? '') ?>" min="0" step="50" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></label>
                                    </div>
                                    <button type="submit" style="margin-top: 10px; background-color: #27ae60; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">Mentés</button>
                                    <button type="button" onclick="showEditForm(<?= htmlspecialchars($food['id']) ?>)" style="margin-top: 10px; background-color: #95a5a6; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">Mégse</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <script>
        function showEditForm(id) {
            const form = document.getElementById('edit-form-' + id);
            form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>
</body>
</html>
