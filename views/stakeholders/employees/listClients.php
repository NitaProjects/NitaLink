<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Clientes</title>
    <link rel="stylesheet" href="../../../public/css/tabla.css">
</head>
<body>
    <main>
        <div class="filter-buttons">
            <button onclick="filterClients('all')">Todos</button>
            <button onclick="filterClients('Particular')">Clientes Particulares</button>
            <button onclick="filterClients('Empresa')">Empresas</button>
        </div>
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
                        <th>DNI</th>
                        <th>Tipo de Cliente</th>
                        <th>Número de Empleados</th>
                        <th>Razón Social</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id = clients-list>
                    <?php foreach ($clients as $client): ?>
                    <tr id="row-<?= htmlspecialchars($client['client_id']) ?>" class="client-row <?= htmlspecialchars($client['client_type']) ?>">
                        <td><?= htmlspecialchars($client['client_id']) ?></td>
                        <td><?= htmlspecialchars($client['name']) ?></td>
                        <td><?= htmlspecialchars($client['address']) ?></td>
                        <td><?= htmlspecialchars($client['email']) ?></td>
                        <td><?= htmlspecialchars($client['phone_number']) ?></td>
                        <td><?= htmlspecialchars($client['account_balance']) ?>€</td>
                        <td><?= htmlspecialchars($client['membership_type']) ?></td>
                        <td><?= htmlspecialchars($client['dni'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($client['client_type']) ?></td>
                        <td><?= htmlspecialchars($client['workers'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($client['social_reason'] ?? '-') ?></td>
                        <td>
                            <button onclick="toggleEditForm('edit-form-<?= $client['client_id'] ?>')">Editar</button>
                            <button onclick="deleteCliente(<?= $client['client_id'] ?>)">Borrar</button>
                        </td>
                    </tr>
                    <tr id="edit-form-<?= htmlspecialchars($client['client_id']) ?>" style="display:none;">
                        <td colspan="12">
                            <form action="../../../controllers/stakeholdersControllers/clientsControllers/updateClientController.php" method="post">
                                <input type="hidden" name="client_id" value="<?= htmlspecialchars($client['client_id']) ?>">
                                <input type="hidden" name="client_type" value="<?= htmlspecialchars($client['client_type']) ?>">
                                <input type="text" name="name" value="<?= htmlspecialchars($client['name']) ?>">
                                <input type="text" name="address" value="<?= htmlspecialchars($client['address']) ?>">
                                <input type="email" name="email" value="<?= htmlspecialchars($client['email']) ?>">
                                <input type="text" name="phone_number" value="<?= htmlspecialchars($client['phone_number']) ?>">
                                <input type="text" name="account_balance" value="<?= htmlspecialchars($client['account_balance']) ?>">
                                <input type="text" name="membership_type" value="<?= htmlspecialchars($client['membership_type']) ?>">
                                <?php if ($client['client_type'] == 'Particular'): ?>
                                    <input type="text" name="dni" value="<?= htmlspecialchars($client['dni'] ?? '') ?>">
                                <?php else: ?>
                                    <input type="text" name="workers" value="<?= htmlspecialchars($client['workers'] ?? '') ?>">
                                    <input type="text" name="social_reason" value="<?= htmlspecialchars($client['social_reason'] ?? '') ?>">
                                <?php endif; ?>
                                <button type="submit">Guardar Cambios</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </main>
    <script>
        function toggleEditForm(formId) {
            var form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
        }


        function filterClients(type) {
            var rows = document.querySelectorAll('.client-row');
            rows.forEach(function(row) {
                if (type === 'all') {
                    row.style.display = 'table-row';
                } else if (row.classList.contains(type)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>

