fetch('/Controlador/verificar_sesion.php')
    .then(res => res.json())
    .then(data => {
        const contenedorMenu = document.getElementById('menu-container');

        // Aquí cargarías los platos desde PHP con otro fetch
        fetch('/Controlador/controlador_platos.php')
            .then(res => res.json())
            .then(platos => {
                platos.forEach(plato => {
                    const div = document.createElement('div');
                    div.className = 'plato';
                    div.innerHTML = `
                    <div class="menu-item">
                    <div class="item-info">
                        <h3>${plato.nombre_plato}</h3>
                        <p>Precio: S/.${plato.precio}</p>
                         </div>
                        ${
                            data.logueado && data.rol === 'Usuario'
                            ? `<button class="btn-agregar" data-nombre="${plato.nombre_plato}" data-precio="${plato.precio}">Agregar al carrito</button>`
                            : ''
                        }
                        </div>
                    `;
                    contenedorMenu.appendChild(div);
                });
            });
    });
