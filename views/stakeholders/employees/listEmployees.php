<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Empleados</title>
    <link rel="stylesheet" href="../../../public/css/tabla.css">
</head>
<body>
    <h1>Listado de Empleados</h1>
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
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $employee): ?>
            <tr>
                <td><?= htmlspecialchars($employee['employee_id']) ?></td>
                <td><?= htmlspecialchars($employee['name']) ?></td>
                <td><?= htmlspecialchars($employee['address']) ?></td>
                <td><?= htmlspecialchars($employee['email']) ?></td>
                <td><?= htmlspecialchars($employee['phone_number']) ?></td>
                <td><?= htmlspecialchars($employee['salary']) ?>€/año</td>
                <td><?= htmlspecialchars($employee['department']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>




