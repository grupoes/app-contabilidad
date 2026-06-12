function pdtRenta() {
  window.location.href = base_url + "pdt-renta";
}

function pdtPlame() {
  window.location.href = base_url + "pdt-plame";
}

function pdtAnual() {
  window.location.href = base_url + "pdt-anual";
}

// ========================
// Elementos del DOM
// ========================
const pdtanual = document.getElementById("pdtanual");
const year = document.getElementById("year");
const tableMovimientos = document.getElementById("tableMovimientos");

// ========================
// Verificar PDT anual
// ========================
verificarPdtAnual();

async function verificarPdtAnual() {
  try {
    const res = await fetch(`${base_url}verificar-pdt-anual`);
    const data = await res.json();

    if (data.data && data.data.length !== 0) {
      pdtanual.removeAttribute("hidden");
    }
  } catch (error) {
    console.error("Error al verificar PDT anual:", error);
  }
}

// ========================
// Obtener años
// ========================
obtenerAnios();

async function obtenerAnios() {
  try {
    const res = await fetch(`${base_url}getAniosAll`);

    if (!res.ok) {
      throw new Error(`HTTP error: ${res.status}`);
    }

    const data = await res.json();
    const datos = data.data;

    if (datos && datos.length !== 0) {
      let html = `<option value="">Seleccione año</option>`;

      datos.forEach((item) => {
        html += `<option value="${item.id_anio}">${item.anio_descripcion}</option>`;
      });

      year.innerHTML = html;

      // Cargar movimientos del primer año
      year.value = datos[0].id_anio;
      obtenerMovimientos();
    }
  } catch (error) {
    console.error("Error al obtener años:", error);
  }
}

// ========================
// Obtener movimientos
// ========================
async function obtenerMovimientos() {
  if (!year.value) return;

  console.log("Obteniendo movimientos para el año:", year.value);

  try {
    const res = await fetch(
      `${base_url}obtener-analisis-movimientos/${year.value}`,
    );

    if (!res.ok) {
      throw new Error(`HTTP error: ${res.status}`);
    }

    const data = await res.json();

    console.log(data);

    if (data.data.length != 0) {
      if (Number(year.value) >= 12) {
        if (data.afp === "si") {
          document.getElementById("planilla").removeAttribute("hidden");
        } else {
          document.getElementById("planilla").setAttribute("hidden", "hidden");
        }
      } else {
        // Si el año es menor a 2026, aseguramos ocultar la columna
        document.getElementById("planilla").setAttribute("hidden", "hidden");
      }

      viewMovimientos(data.data, data.afp);
    } else {
      const cols = Number(year.value) >= 2026 && data.afp === "si" ? 6 : 5;
      tableMovimientos.innerHTML = `
      <tr>
        <td colspan="${cols}" class="text-center">No hay Resultados</td>
      </tr>
      `;
    }
  } catch (error) {
    console.error("Error al obtener movimientos:", error);
  }
}

function viewMovimientos(datos, afp) {
  let html = "";

  let ventas_gravadas = 0;
  let ventas_no_gravadas = 0;
  let compras_gravadas = 0;
  let compras_no_gravadas = 0;
  let total_r1 = 0;

  datos.forEach((mov) => {
    ventas_gravadas += parseFloat(
      mov.ventas_gravadas_decimal.replace(/,/g, ""),
    );
    ventas_no_gravadas += parseFloat(
      mov.ventas_no_gravadas_decimal.replace(/,/g, ""),
    );
    compras_gravadas += parseFloat(
      mov.compras_gravadas_decimal.replace(/,/g, ""),
    );
    compras_no_gravadas += parseFloat(
      mov.compras_no_gravadas_decimal.replace(/,/g, ""),
    );
    if (afp === "si" && mov.total_r1) {
      total_r1 += parseFloat(String(mov.total_r1).replace(/,/g, "")) || 0;
    }

    html += `
    <tr>
      <td>${mov.mes_descripcion}</td>
      <td>${mov.ventas_gravadas_decimal}</td>
      <td>${mov.ventas_no_gravadas_decimal}</td>
      <td>${mov.compras_gravadas_decimal}</td>
      <td>${mov.compras_no_gravadas_decimal}</td>
      ${afp === "si" ? `<td>${mov.total_r1}</td>` : ""}
    </tr>
    `;
  });

  html += `
    <tr>
      <td><strong>Total</strong></td>
      <td><strong>${ventas_gravadas.toLocaleString("es-PE", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })}</strong></td>
      <td><strong>${ventas_no_gravadas.toLocaleString("es-PE", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })}</strong></td>
      <td><strong>${compras_gravadas.toLocaleString("es-PE", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })}</strong></td>
      <td><strong>${compras_no_gravadas.toLocaleString("es-PE", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
      })}</strong></td>
      ${afp === "si" ? `<td><strong>${total_r1.toLocaleString("es-PE", { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</strong></td>` : ""}
    </tr>
  `;

  tableMovimientos.innerHTML = html;
}

// ========================
// Evento cambio de año
// ========================
year.addEventListener("change", () => {
  obtenerMovimientos();
});

function descargarExcel() {
  const numeroDoc = document.getElementById("numero_doc");
  if (!year.value) {
    alert("Seleccione un año antes de descargar.");
    return;
  }
  if (!numeroDoc || !numeroDoc.value) {
    alert("No se encontró el RUC/ID de documento.");
    return;
  }

  const url = `${url_servidor}api/descargar-excel/${encodeURIComponent(
    year.value,
  )}/${encodeURIComponent(numeroDoc.value)}`;
  window.open(url, "_blank");
}

// ========================
// Lanzar modal al cargar
// ========================
document.addEventListener("DOMContentLoaded", () => {
  verifyCorreo();
});

function verifyCorreo() {
  fetch(`${base_url}verify-correo`)
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "warning") {
        const modalCorreo = new bootstrap.Modal(
          document.getElementById("modalCorreo"),
        );
        modalCorreo.show();
      }
    });
}

const formCorreo = document.getElementById("formCorreo");
formCorreo.addEventListener("submit", (e) => {
  e.preventDefault();
  const formData = new FormData(formCorreo);
  fetch(`${base_url}save-correo`, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        const modalCorreo = bootstrap.Modal.getInstance(
          document.getElementById("modalCorreo"),
        );
        modalCorreo.hide();

        alert(data.message);
      } else {
        alert(data.message);
      }
    });
});
