document.addEventListener("DOMContentLoaded", function () {
    const botones = document.querySelectorAll(".btn-add-carrito");

    botones.forEach(boton => {
    boton.addEventListener("click", function (e) {
        e.preventDefault();

        const idProducto = this.dataset.id; // suponemos que el botón tiene data-id="1"

        // 1️⃣ Llamar a procesar_pedido.php para añadir el producto
        fetch("procesar_pedido.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `id=${idProducto}&accion=agregar`
        })
        .then(response => response.text())
        .then(() => {
        // 2️⃣ Una vez añadido, pedimos el total actualizado
        return fetch("actualizar_carrito.php");
        })
        .then(response => response.text())
        .then(total => {
        // 3️⃣ Actualizamos el contador del carrito
        document.getElementById("contador-carrito").textContent = total;
        })
        .catch(error => console.error("Error:", error));
    });
    });
});