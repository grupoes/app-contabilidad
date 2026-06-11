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

  try {
    const res = await fetch(
      `${base_url}obtener-analisis-movimientos/${year.value}`,
    );

    if (!res.ok) {
      throw new Error(`HTTP error: ${res.status}`);
    }

    const data = await res.json();

    if (data.data.length != 0) {
      viewMovimientos(data.data);
    } else {
      tableMovimientos.innerHTML = `
      <tr>
        <td colspan="7" class="text-center">No hay Resultados</td>
      </tr>
      `;
    }
  } catch (error) {
    console.error("Error al obtener movimientos:", error);
  }
}

function viewMovimientos(datos) {
  let html = "";

  let ventas_gravadas = 0;
  let ventas_no_gravadas = 0;
  let compras_gravadas = 0;
  let compras_no_gravadas = 0;

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

    html += `
    <tr>
      <td>${mov.mes_descripcion}</td>
      <td>${mov.ventas_gravadas_decimal}</td>
      <td>${mov.ventas_no_gravadas_decimal}</td>
      <td>${mov.compras_gravadas_decimal}</td>
      <td>${mov.compras_no_gravadas_decimal}</td>
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
  let anio = year.options[year.selectedIndex].text;

  let tabla = document.getElementById("tableAnalisisMovimientos");
  let wb = XLSX.utils.table_to_book(tabla, {
    sheet: "Analisis Movimiento " + anio,
  });

  XLSX.writeFile(wb, "analisis_movimiento_" + anio + ".xlsx");
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
