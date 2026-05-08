$(document).ready(function () {
    const tablePersonal = $('#tablePersonal').DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
        },
        dom: 'lrtip',
        autoWidth: false,
        columnDefs: [
            { orderable: false, targets: 4 },
            { width: "50px", targets: 0 },
            { width: "150px", targets: 2 },
            { width: "150px", targets: 4 }
        ],
        ajax: {
            url: `${BASE_URL}get-lista-personal`,
            dataSrc: function (json) {
                if (json.status === 'error') {
                    alert(json.message);
                    if (json.redirect) {
                        window.location.href = json.redirect;
                    }
                    return [];
                }
                return json.data || [];
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'nombres' },
            { data: 'numero_documento' },
            { data: 'correo' },
            {
                data: null,
                render: function (data, type, row) {
                    if (row.correo && row.correo.trim() !== '') {
                        return `
                            <button type="button" class="btn btn-grd-warning btn-sm d-flex align-items-center gap-1 btn-reset" data-id="${row.id}">
                                <i class="material-icons-outlined fs-6">restart_alt</i> Resetear
                            </button>
                        `;
                    }
                    return '<span class="badge bg-warning text-dark">Sin correo</span>';
                }
            }
        ]
    });

    // Vincular nuestro buscador personalizado con DataTables
    $('#searchPersonal').on('keyup', function () {
        tablePersonal.search(this.value).draw();
    });

    // Manejar el clic en el botón de resetear
    $('#tablePersonal').on('click', '.btn-reset', function () {
        const id = $(this).data('id');
        const rowData = tablePersonal.row($(this).parents('tr')).data();

        Swal.fire({
            title: '¿Estás seguro?',
            html: `Se reseteará la cuenta de <b>${rowData.nombres}</b>.<br><br>La contraseña volverá a ser su número de documento y se eliminará su correo configurado.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, resetear',
            cancelButtonText: 'Cancelar',
            background: 'var(--bs-body-bg)',
            color: 'var(--bs-body-color)'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                fetch(`${BASE_URL}reset-personal/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        Swal.close();
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Reseteado!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            tablePersonal.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message
                            });
                            if (data.redirect) {
                                setTimeout(() => {
                                    window.location.href = data.redirect;
                                }, 2000);
                            }
                        }
                    })
                    .catch(error => {
                        Swal.close();
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al procesar la solicitud.'
                        });
                    });
            }
        });
    });
});
