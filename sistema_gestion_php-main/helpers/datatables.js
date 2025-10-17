//DESARROLLAR CON CACHE DESACTIVADO EN EL NAVEGADOR, MAS COMOD POR LO MENOS PARA MI (BRIAN)
console.log("TEST ARCHIVO DATATABLES.JS CARGADO CORRECTAMENTE");

// SELECCIONAMOS EL BOTON QUE YA EXISTE EN product.view.php
let nuevoBtn = document.querySelector('button[data-bs-target="#modalCrear"]');

let table = new DataTable('#tabla', {
    language: {
        url: 'https://cdn.datatables.net/plug-ins/2.3.3/i18n/es-AR.json'
    },
    lengthMenu: [
                [6, 12, 24],
                ['6', '12', '24']
            ],
    // buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
    layout: {
        topStart: [nuevoBtn, {
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: 'Descargar PDF',
                    title: 'Informe_de_gestion_de_productos',
                    messageTop: '',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                //FALTA MODIFICAR LOS DEMAS BOTONES
                'excel',
                'csv',
                'print'
                // 'colvis'
            ]
        }], // arriba izquierda
        topEnd: 'search',           // arriba derecha
        bottomStart: ['info', 'pageLength'],      // abajo izquierda
        bottomEnd: 'paging'     // abajo derecha → paginación
    }
});