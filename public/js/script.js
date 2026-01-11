$(document).ready(function() {
    let asientosSeleccionados = [];
    const $btnComprar = $("#btn-comprar");

    $("#mapa-asientos").on("click", ".btn-asiento", function() {
        const $btn = $(this);
        const idAsiento = $btn.data("id");
        const estado = $btn.data("status"); 

        if (estado === "ocupado") {
            return;
        }

        if (asientosSeleccionados.includes(idAsiento)) {
            asientosSeleccionados = asientosSeleccionados.filter(id => id !== idAsiento);
            $btn.removeClass("btn-primary").addClass("btn-outline-success");
        } else {
            asientosSeleccionados.push(idAsiento);
            $btn.removeClass("btn-outline-success").addClass("btn-primary");
        }

        if (asientosSeleccionados.length > 0) {
            $btnComprar.prop("disabled", false).text("Comprar (" + asientosSeleccionados.length + ")");
        } else {
            $btnComprar.prop("disabled", true).text("Selecciona asientos");
        }
    });

    $btnComprar.click(function() {
        if (asientosSeleccionados.length === 0) return;

        $.ajax({
            url: "process.php", 
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({ "idsAsientos": asientosSeleccionados }),
            success: function(respuesta) {
                if (respuesta.exito) {
                    alert("¡Compra realizada con éxito!");
                    location.reload(); 
                } else {
                    alert("Error: " + respuesta.mensaje);
                    location.reload();
                }
            },
            error: function(xhr, estado, error) {
                console.error("Error AJAX:", error);
                alert("Error al conectar con el servidor.");
            }
        });
    });
});