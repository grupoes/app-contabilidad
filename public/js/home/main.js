document.addEventListener("DOMContentLoaded", () => {});

const listEmpresas = document.getElementById("listEmpresas");

loadEmpresas();

function loadEmpresas() {
  fetch("/empresas")
    .then((response) => response.json())
    .then((data) => {
      viewEmpresas(data.data);
    })
    .catch((error) => {
      console.error("Error al cargar las empresas:", error);
    });
}

function viewEmpresas(data) {
  let html = "";
  data.forEach((empresa) => {
    html += `
    <div class="col-12 col-lg-4 col-xxl-4 d-flex">
        <div class="card rounded-4 w-100 cursor-pointer" onclick="viewBoletas('${empresa.ruc}')">
            <div class="card-body">
                <div class="">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <h5 class="mb-0">${empresa.datos_empresa.razon_social}</h5>
                    </div>
                    <p class="mb-2">${empresa.ruc}</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="">
                            <p class="mb-3">${empresa.datos_empresa.direccion_fiscal}</p>
                        </div>
                        <img src="${base_url}assets/images/apps/store.png" width="100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
        `;
  });

  listEmpresas.innerHTML = html;
}

function viewBoletas(ruc) {
  window.location.href = `empresa/boletas/${ruc}`;
}
