<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php');
    exit;
}

$id_usuario = $_SESSION['id_usuario'];
$rol = $_SESSION['rol'];

// Procesar actualización oficial del Admin
if ($rol === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_fallo'])) {
    $fase_admin = $_POST['fase_admin'];
    $pasaron = $_POST['pasaron'] ?? []; // IDs de actuaciones marcadas
    
    // Obtener todas las actuaciones de esa fase
    $stmtF = $pdo->prepare("SELECT id_actuacion FROM actuaciones WHERE fase = :fase");
    $stmtF->execute(['fase' => $fase_admin]);
    $todas = $stmtF->fetchAll(PDO::FETCH_COLUMN);

    $stmtUpd = $pdo->prepare("UPDATE actuaciones SET pasa_oficial = :pasa WHERE id_actuacion = :id");
    foreach ($todas as $id_act) {
        $pasa = in_array($id_act, $pasaron) ? 1 : 0;
        $stmtUpd->execute(['pasa' => $pasa, 'id' => $id_act]);
    }
}

// Fase y Fecha seleccionadas
$fase = $_GET['fase'] ?? 'Preliminares';

// Obtener los días disponibles para esta fase
$stmtDias = $pdo->prepare("SELECT DISTINCT fecha FROM actuaciones WHERE fase = :fase ORDER BY fecha ASC");
$stmtDias->execute(['fase' => $fase]);
$diasDisponibles = $stmtDias->fetchAll(PDO::FETCH_COLUMN);

$fecha_seleccionada = $_GET['fecha'] ?? ($diasDisponibles[0] ?? date('Y-m-d'));

// Obtener actuaciones del día con el voto del usuario actual
$queryAct = "
    SELECT a.id_actuacion, a.orden, ag.nombre, ag.modalidad, ag.autor, v.voto
    FROM actuaciones a
    JOIN agrupaciones ag ON a.id_agrupacion = ag.id_agrupacion
    LEFT JOIN valoraciones v ON a.id_actuacion = v.id_actuacion AND v.id_usuario = :id_user
    WHERE a.fase = :fase AND a.fecha = :fecha
    ORDER BY a.orden ASC
";
$stmtAct = $pdo->prepare($queryAct);
$stmtAct->execute(['id_user' => $id_usuario, 'fase' => $fase, 'fecha' => $fecha_seleccionada]);
$actuaciones = $stmtAct->fetchAll();

// Obtener clasificados en VERDE del usuario para esta fase
$queryClas = "
    SELECT ag.nombre, ag.modalidad, a.pasa_oficial
    FROM valoraciones v
    JOIN actuaciones a ON v.id_actuacion = a.id_actuacion
    JOIN agrupaciones ag ON a.id_agrupacion = ag.id_agrupacion
    WHERE v.id_usuario = :id_user AND a.fase = :fase AND v.voto = 'verde'
    ORDER BY ag.modalidad, ag.nombre
";
$stmtClas = $pdo->prepare($queryClas);
$stmtClas->execute(['id_user' => $id_usuario, 'fase' => $fase]);
$misClasificados = $stmtClas->fetchAll();
$sesion = 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porra COAC 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Nav Fases -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">🎭 Porra COAC</a>
            <div class="navbar-nav me-auto">
                <?php foreach (['Preliminares', 'Cuartos', 'Semifinales', 'Final'] as $f): ?>
                    <a class="nav-link <?= ($fase === $f) ? 'active fw-bold text-warning' : '' ?>" 
                       href="dashboard.php?fase=<?= $f ?>"><?= $f ?></a>
                <?php endforeach; ?>
            </div>
            <span class="navbar-text me-3 text-white">Hola, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Salir</a>
        </div>
    </nav>

    <div class="container my-4">
        
        <!-- Subnav Días -->
        <?php if (!empty($diasDisponibles)): ?>
            <ul class="nav nav-pills mb-4 bg-white p-2 rounded shadow-sm">
                <?php foreach ($diasDisponibles as $i => $d): $sesion = $i+1;?>
                    
                    <li class="nav-item">
                        <a class="nav-link <?= ($sesion === $d) ? 'active bg-danger' : '' ?>" 
                           href="dashboard.php?fase=<?= $fase ?>&sesion=<?= $sesion ?>">
                           Sesion <?= $sesion?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="row">
            <!-- Tabla de Actuaciones del Día -->
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-danger fw-bold">Actuaciones - <?= $fase ?> - Sesion <?= $sesion ?></h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Tipo</th>
                                        <th>Agrupación</th>
                                        <th>Autor</th>
                                        <th class="text-center">Tu Selección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($actuaciones)): ?>
                                        <tr><td colspan="5" class="text-center py-4 text-muted">No hay actuaciones registradas para este día.</td></tr>
                                    <?php endif; ?>
                                    <?php foreach ($actuaciones as $act): ?>
                                        <tr>
                                            <td><span class="badge bg-secondary"><?= $act['orden'] ?></span></td>
                                            <td><?= htmlspecialchars($act['modalidad']) ?></td>
                                            <td><strong><?= htmlspecialchars($act['nombre']) ?></strong></td>
                                            <td><small class="text-muted"><?= htmlspecialchars($act['autor']) ?></small></td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" onclick="votar(<?= $act['id_actuacion'] ?>, 'verde', this)" 
                                                            class="btn btn-sm <?= ($act['voto'] === 'verde') ? 'btn-success' : 'btn-outline-success' ?>">Pasa</button>
                                                    <button type="button" onclick="votar(<?= $act['id_actuacion'] ?>, 'amarillo', this)" 
                                                            class="btn btn-sm <?= ($act['voto'] === 'amarillo') ? 'btn-warning' : 'btn-outline-warning' ?>">Puede</button>
                                                    <button type="button" onclick="votar(<?= $act['id_actuacion'] ?>, 'rojo', this)" 
                                                            class="btn btn-sm <?= ($act['voto'] === 'rojo') ? 'btn-danger' : 'btn-outline-danger' ?>">No</button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Lateral: Mis Clasificados -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-success text-white fw-bold">
                        🏆 Mis Pasos a <?= $fase ?> (<span id="count-pasos"><?= count($misClasificados) ?></span>)
                    </div>
                    <ul class="list-group list-group-flush" id="lista-clasificados">
                        <?php if (empty($misClasificados)): ?>
                            <li class="list-group-item text-muted text-center py-3">Aún no has marcado agrupaciones en verde.</li>
                        <?php endif; ?>
                        <?php foreach ($misClasificados as $clas): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-secondary me-1"><?= $clas['modalidad'] ?></span>
                                    <strong><?= htmlspecialchars($clas['nombre']) ?></strong>
                                </div>
                                <?php if (is_null($clas['pasa_oficial'])): ?>
                                    <span class="badge bg-light text-dark border">Pendiente</span>
                                <?php elseif ($clas['pasa_oficial'] == 1): ?>
                                    <span class="badge bg-success">✔ Pasó</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">✖ Caída</span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Panel Exclusivo de Admin -->
                <?php if ($rol === 'admin'): ?>
                    <div class="card shadow-sm border-danger">
                        <div class="card-header bg-danger text-white fw-bold">⚙️ Admin: Fallo Oficial (<?= $fase ?>)</div>
                        <div class="card-body">
                            <form method="POST">
                                <input type="hidden" name="fase_admin" value="<?= $fase ?>">
                                <div class="mb-3">
                                    <?php foreach ($actuaciones as $act): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="pasaron[]" 
                                                   value="<?= $act['id_actuacion'] ?>" id="admin_<?= $act['id_actuacion'] ?>">
                                            <label class="form-check-label" for="admin_<?= $act['id_actuacion'] ?>">
                                                <?= htmlspecialchars($act['nombre']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button type="submit" name="guardar_fallo" class="btn btn-sm btn-danger w-100 fw-bold">Publicar Fallo Oficial</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Script AJAX para guardado instantáneo -->
    <script>
    function votar(idActuacion, color, boton) {
        const formData = new FormData();
        formData.append('id_actuacion', idActuacion);
        formData.append('voto', color);

        fetch('guardar_voto_ajax.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Actualizar estilos de los botones en la fila
                const grupo = boton.parentElement;
                const botones = grupo.querySelectorAll('button');
                botones[0].className = 'btn btn-sm ' + (color === 'verde' ? 'btn-success' : 'btn-outline-success');
                botones[1].className = 'btn btn-sm ' + (color === 'amarillo' ? 'btn-warning' : 'btn-outline-warning');
                botones[2].className = 'btn btn-sm ' + (color === 'rojo' ? 'btn-danger' : 'btn-outline-danger');
                
                // Recargar ventana para actualizar la lista de clasificados lateral
                location.reload();
            }
        });
    }
    </script>
</body>
</html>