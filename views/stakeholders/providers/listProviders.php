<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Gestión de Proveedores - NitaLink</title>
        <link rel="stylesheet" href="../../../public/css/listProducts.css">
        <style>
            .hidden {
                display: none;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="filter-buttons">
                <button onclick="filterProviders('')">Todos</button>
                <button onclick="filterProviders('Particular')">Proveedores Individuales</button>
                <button onclick="filterProviders('Empresa')">Proveedores Empresariales</button>
                <input type="text" id="search-input" name="name" placeholder="Buscar Proveedor por nombre" autocomplete="off">
            </div>
            <div class="tabla-paginacion">
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?= $i ?>" class="pagination-link <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
                <table border="1">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Producto Suministrado</th>
                            <th>Tipo de Proveedor</th>
                            <th class="individual">DNI</th>
                            <th class="company">Trabajadores</th>
                            <th class="company">Razón Social</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="provider-list">
                        <?php foreach ($providers as $provider): ?>
                            <tr id="row-<?= htmlspecialchars($provider['provider_id']) ?>" class="provider-row" data-provider-type="<?= htmlspecialchars($provider['provider_type']) ?>">
                                <td><?= htmlspecialchars($provider['provider_id']) ?></td>
                                <td><?= htmlspecialchars($provider['name']) ?></td>
                                <td><?= htmlspecialchars($provider['address']) ?></td>
                                <td><?= htmlspecialchars($provider['email']) ?></td>
                                <td><?= htmlspecialchars($provider['phone_number']) ?></td>
                                <td><?= htmlspecialchars($provider['product_supplied']) ?></td>
                                <td><?= htmlspecialchars($provider['provider_type']) ?></td>
                                <td class="individual"><?= htmlspecialchars($provider['dni'] ?? '-') ?></td>
                                <td class="company"><?= htmlspecialchars($provider['workers'] ?? '-') ?></td>
                                <td class="company"><?= htmlspecialchars($provider['social_reason'] ?? '-') ?></td>
                                <td>
                                    <button onclick="toggleEditForm('edit-form-<?= $provider['provider_id'] ?>'); setFormAction(<?= $provider['provider_id'] ?>, '<?= $provider['provider_type'] ?>')">Editar</button>
                                    <button onclick="deleteProvider(<?= $provider['provider_id'] ?>)">Borrar</button>
                                </td>
                            </tr>
                            <tr id="edit-form-<?= htmlspecialchars($provider['provider_id']) ?>" style="display:none;">
                                <td colspan="11">
                                    <form id="edit-form-<?= htmlspecialchars($provider['provider_id']) ?>-form" method="post">
                                        <input type="hidden" name="provider_id" value="<?= htmlspecialchars($provider['provider_id']) ?>">
                                        <input type="text" name="name" value="<?= htmlspecialchars($provider['name']) ?>">
                                        <input type="text" name="address" value="<?= htmlspecialchars($provider['address']) ?>">
                                        <input type="email" name="email" value="<?= htmlspecialchars($provider['email']) ?>">
                                        <input type="text" name="phone_number" value="<?= htmlspecialchars($provider['phone_number']) ?>">
                                        <input type="text" name="product_supplied" value="<?= htmlspecialchars($provider['product_supplied']) ?>">
                                        <input type="hidden" name="provider_type" value="<?= htmlspecialchars($provider['provider_type']) ?>">

                                        <?php if ($provider['provider_type'] == 'Particular'): ?>
                                            <input type="text" name="dni" value="<?= htmlspecialchars($provider['dni'] ?? '') ?>">
                                        <?php elseif ($provider['provider_type'] == 'Empresa'): ?>
                                            <input type="number" name="workers" value="<?= htmlspecialchars($provider['workers'] ?? '') ?>">
                                            <input type="text" name="social_reason" value="<?= htmlspecialchars($provider['social_reason'] ?? '') ?>">
                                        <?php endif; ?>
                                        <button type="submit">Guardar Cambios</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
        <script>
            function toggleEditForm(formId) {
                var form = document.getElementById(formId);
                form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
            }

            function filterProviders(providerType) {
                const rows = document.querySelectorAll('.provider-row');
                rows.forEach(function (row) {
                    if (providerType === '' || row.getAttribute('data-provider-type') === providerType) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
                toggleColumns(providerType);
            }

            function toggleColumns(providerType) {
                const columnsToShow = {
                    'Particular': ['individual'],
                    'Empresa': ['company'],
                    '': ['individual', 'company']
                };

                const allColumns = ['individual', 'company'];
                const columns = document.querySelectorAll('th, td');
                columns.forEach(column => {
                    allColumns.forEach(colClass => {
                        if (columnsToShow[providerType].includes(colClass)) {
                            column.classList.remove('hidden');
                        } else {
                            column.classList.add('hidden');
                        }
                    });
                });
            }

            function searchProvidersByName() {
                var input = document.getElementById('search-input').value.toLowerCase();
                var rows = document.querySelectorAll('.provider-row');
                rows.forEach(function (row) {
                    var name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    if (name.includes(input)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            document.getElementById('search-input').addEventListener('input', searchProvidersByName);

            document.addEventListener('DOMContentLoaded', () => {
                filterProviders(''); // Inicialmente mostrar todos los proveedores y todas las columnas
            });

            function setFormAction(providerId, providerType) {
                const form = document.getElementById(`edit-form-${providerId}-form`);

                let actionUrl = '';

                switch (providerType) {
                    case 'Particular':
                        actionUrl = '/nitalink/controllers/stakeholdersControllers/providersControllers/updateIndividualProviderController.php';
                        break;
                    case 'Empresa':
                        actionUrl = '/nitalink/controllers/stakeholdersControllers/providersControllers/updateCompanyProviderController.php';
                        break;
                    default:
                        actionUrl = '/nitalink/controllers/stakeholdersControllers/providersControllers/updateProviderController.php';
                }

                form.action = actionUrl;
            }

            function deleteProvider(providerId) {
                if (confirm('¿Está seguro de que desea eliminar este proveedor?')) {
                    fetch('../../../controllers/stakeholdersControllers/providersControllers/deleteProviderController.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'provider_id=' + providerId
                    })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Proveedor eliminado con éxito.");
                                    document.getElementById('row-' + providerId).remove();
                                } else {
                                    alert("Error al eliminar el proveedor.");
                                }
                            })
                            .catch(error => console.error('Error:', error));
                }
            }
        </script>
    </body>
</html>
