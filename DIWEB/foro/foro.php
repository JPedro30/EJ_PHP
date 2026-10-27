<?php
// 1. Simulación de datos que vienen de la Base de Datos
// (Ordenados cronológicamente)
$comentariosBD = [
    ['id' => 1, 'parent_id' => null, 'usuario' => 'Carlos', 'mensaje' => '¿Alguien sabe PHP?'],
    ['id' => 2, 'parent_id' => 1,    'usuario' => 'Ana',    'mensaje' => '¡Sí, yo sé!'],
    ['id' => 3, 'parent_id' => 2,    'usuario' => 'Carlos', 'mensaje' => '¿Cuántos años llevas usándolo?'],
    ['id' => 4, 'parent_id' => 1,    'usuario' => 'Pedro',  'mensaje' => 'Yo también sé un poco.'],
];

// 2. Agrupamos los comentarios por su 'parent_id'
// Usamos el valor 0 para los comentarios principales (los que no tienen padre)
$agrupados = [];
foreach ($comentariosBD as $c) {
    $padre = $c['parent_id'] ?? 0;
    $agrupados[$padre][] = $c;
}

// 3. La FUNCIÓN RECURSIVA que los dibuja en pantalla
function mostrarComentarios($padreId, $agrupados) {
    // Si no existen comentarios o respuestas para este padre, cortamos la ejecución
    if (!isset($agrupados[$padreId])) {
        return;
    }

    // Usamos una lista HTML y le aplicamos sangría (margen a la izquierda)
    echo '<ul style="margin-left: 20px; list-style-type: none;">';

    foreach ($agrupados[$padreId] as $comentario) {
        echo '<li>';
        echo '<strong>' . htmlspecialchars($comentario['usuario']) . ':</strong> ';
        echo htmlspecialchars($comentario['mensaje']);

        // --- AQUÍ ESTÁ LA RECURSIVIDAD ---
        // La función se llama a sí misma pasándole el ID del comentario actual.
        // Buscará si existen comentarios donde 'parent_id' sea igual a este ID.
        mostrarComentarios($comentario['id'], $agrupados);

        echo '</li>';
    }

    echo '</ul>';
}

// 4. LLAMADA INICIAL: Le pedimos que muestre los mensajes principales (padre 0)
mostrarComentarios(0, $agrupados);
?>