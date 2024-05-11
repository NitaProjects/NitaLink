<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Clientes</title>
    <link rel="stylesheet" href="../../../public/css/tabla.css">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>ID Cliente</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Balance</th>
                <th>Tipo de Membresía</th>
                <th>Tipo de Cliente</th>
                <th>Número de Empleados</th>
                <th>Razón Social</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client['client_id']) ?></td>
                <td><?= htmlspecialchars($client['name']) ?></td>
                <td><?= htmlspecialchars($client['address']) ?></td>
                <td><?= htmlspecialchars($client['email']) ?></td>
                <td><?= htmlspecialchars($client['phone_number']) ?></td>
                <td><?= htmlspecialchars($client['account_balance']) ?>€</td>
                <td><?= htmlspecialchars($client['membership_type']) ?></td>
                <td><?= htmlspecialchars($client['client_type']) ?></td>
                <td><?= $client['client_type'] === 'empresa' ? htmlspecialchars($client['company_workers']) : '-' ?></td>
                <td><?= $client['client_type'] === 'empresa' ? htmlspecialchars($client['corporate_reason']) : '-' ?></td>
                <td>
                    <button onclick="toggleEditForm('edit-form-<?= $client['client_id'] ?>')">Editar</button>
                    <button onclick="deleteCliente(<?= $client['client_id'] ?>)">Borrar</button>
                </td>
            </tr>
            <tr id="edit-form-<?= htmlspecialchars($client['client_id']) ?>" style="display:none;">
                <td colspan="11">
                    <form action="../../../controllers/stakeholdersControllers/clientsControllers/updateClientController.php" method="post">
                        <input type="hidden" name="client_id" value="<?= htmlspecialchars($client['client_id']) ?>">
                        <input type="text" name="name" value="<?= htmlspecialchars($client['name']) ?>">
                        <input type="text" name="address" value="<?= htmlspecialchars($client['address']) ?>">
                        <input type="email" name="email" value="<?= htmlspecialchars($client['email']) ?>">
                        <input type="text" name="phone_number" value="<?= htmlspecialchars($client['phone_number']) ?>">
                        <input type="text" name="account_balance" value="<?= htmlspecialchars($client['account_balance']) ?>">
                        <input type="text" name="membership_type" value="<?= htmlspecialchars($client['membership_type']) ?>">
                        <input type="text" name="client_type" value="<?= htmlspecialchars($client['client_type']) ?>">
                        <input type="text" name="company_workers" value="<?= $client['client_type'] === 'empresa' ? htmlspecialchars($client['company_workers']) : '' ?>">
                        <input type="text" name="corporate_reason" value="<?= $client['client_type'] === 'empresa' ? htmlspecialchars($client['corporate_reason']) : '' ?>">
                        <button type="submit">Guardar Cambios</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
