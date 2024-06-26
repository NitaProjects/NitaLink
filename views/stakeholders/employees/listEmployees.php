<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Listado de Empleados</title>
        <link rel="stylesheet" href="../../../public/css/tabla.css">
    </head>
    <body>
        <main>
            <div class="filter-buttons">
                <button onclick="filterEmployees('all')">Todos</button>
                <button onclick="filterEmployees('Departamento A')">Departamento A</button>
                <button onclick="filterEmployees('Departamento B')">Departamento B</button>
                <input type="text" id="search-input" name="name" placeholder="Buscar Empleado por nombre" autocomplete="off">
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
                            <th>ID Empleado</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Salario</th>
                            <th>Departamento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="employees-list">
                        <?php foreach ($employees as $employee): ?>
                            <tr id="row-<?= htmlspecialchars($employee['employee_id']) ?>" class="employee-row <?= htmlspecialchars($employee['department']) ?>">
                                <td><?= htmlspecialchars($employee['employee_id']) ?></td>
                                <td><?= htmlspecialchars($employee['name']) ?></td>
                                <td><?= htmlspecialchars($employee['address']) ?></td>
                                <td><?= htmlspecialchars($employee['email']) ?></td>
                                <td><?= htmlspecialchars($employee['phone_number']) ?></td>
                                <td><?= htmlspecialchars($employee['salary']) ?>€/año</td>
                                <td><?= htmlspecialchars($employee['department']) ?></td>
                                <td>
                                    <button onclick="toggleEditForm('edit-form-<?= $employee['employee_id'] ?>')">Editar</button>
                                    <button onclick="deleteEmployee(<?= $employee['employee_id'] ?>)">Borrar</button>
                                </td>
                            </tr>
                            <tr id="edit-form-<?= htmlspecialchars($employee['employee_id']) ?>" style="display:none;">
                                <td colspan="8">
                                    <form action="../../../controllers/stakeholdersControllers/employeesControllers/updateEmployeeController.php" method="post">
                                        <input type="hidden" name="employee_id" value="<?= htmlspecialchars($employee['employee_id']) ?>">
                                        <input type="text" name="name" value="<?= htmlspecialchars($employee['name']) ?>">
                                        <input type="text" name="address" value="<?= htmlspecialchars($employee['address']) ?>">
                                        <input type="email" name="email" value="<?= htmlspecialchars($employee['email']) ?>">
                                        <input type="text" name="phone_number" value="<?= htmlspecialchars($employee['phone_number']) ?>">
                                        <input type="text" name="salary" value="<?= htmlspecialchars($employee['salary']) ?>">
                                        <input type="text" name="department" value="<?= htmlspecialchars($employee['department']) ?>">
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

            function filterEmployees(department) {
                var rows = document.querySelectorAll('.employee-row');
                rows.forEach(function (row) {
                    if (department === 'all') {
                        row.style.display = 'table-row';
                    } else if (row.classList.contains(department)) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            function searchEmployeesByName() {
                var input = document.getElementById('search-input').value.toLowerCase();
                var rows = document.querySelectorAll('.employee-row');
                rows.forEach(function (row) {
                    var name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    if (name.includes(input)) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            document.getElementById('search-input').addEventListener('input', searchEmployeesByName);
        </script>
    </body>
</html>

