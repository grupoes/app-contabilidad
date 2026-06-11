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
  const tabla = document.getElementById("tableAnalisisMovimientos");

  // Load ExcelJS dynamically from CDN if not present
  function loadExcelJSScript() {
    return new Promise((resolve, reject) => {
      if (window.ExcelJS && typeof window.ExcelJS.Workbook !== 'undefined') return resolve();
      const urls = [
        'https://cdn.jsdelivr.net/npm/exceljs@4.3.0/dist/exceljs.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js',
      ];
      let idx = 0;

      function tryLoad() {
        if (window.ExcelJS && typeof window.ExcelJS.Workbook !== 'undefined') return resolve();
        if (idx >= urls.length) return reject(new Error('Failed to load ExcelJS from CDNs'));

        const s = document.createElement('script');
        s.src = urls[idx++];
        s.onload = () => {
          // allow UMD to attach
          setTimeout(() => {
            if (window.ExcelJS && typeof window.ExcelJS.Workbook !== 'undefined') return resolve();
            tryLoad();
          }, 100);
        };
        s.onerror = () => tryLoad();
        document.head.appendChild(s);
      }

      tryLoad();
    });
  }

  function fallbackHtmlXls() {
    const style = `
      <style>
        table { border-collapse: collapse; }
        table, th, td { border: 1px solid #000; }
        th { font-weight: bold; background-color: #f2f2f2; text-align: center; }
        td { padding: 4px; }
        tr:last-child td { font-weight: bold; background-color: #f9f9f9; }
      </style>
    `;
    const html = `<!DOCTYPE html><html><head><meta charset="utf-8"/>${style}</head><body><table>${tabla.innerHTML}</table></body></html>`;
    const blob = new Blob([html], { type: "application/vnd.ms-excel" });
    const filename = "analisis_movimiento_" + anio + ".xls";
    if (window.navigator && window.navigator.msSaveOrOpenBlob) {
      window.navigator.msSaveOrOpenBlob(blob, filename);
    } else {
      const link = document.createElement("a");
      link.href = URL.createObjectURL(blob);
      link.download = filename;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    }
  }

  function exportWithExcelJS() {
    try {
      const workbook = new ExcelJS.Workbook();
      const ws = workbook.addWorksheet("Analisis Movimiento " + anio);

      // Read rows from table
      const trs = Array.from(tabla.querySelectorAll("tr"));
      trs.forEach((tr, rowIndex) => {
        const cells = Array.from(tr.children);
        const rowValues = cells.map((td) => td.textContent.trim());
        const row = ws.addRow(rowValues);

        // Apply header style on first row
        if (rowIndex === 0) {
          row.font = { bold: true };
          row.alignment = { vertical: "middle", horizontal: "center" };
        }

        // Apply border to each cell
        row.eachCell({ includeEmpty: true }, (cell) => {
          cell.border = {
            top: { style: "thin" },
            left: { style: "thin" },
            bottom: { style: "thin" },
            right: { style: "thin" },
          };
          // Try to set numeric format if looks like number
          const v = cell.value;
          if (typeof v === "string") {
            const num = v
              .replace(/\./g, "")
              .replace(/,/g, ".")
              .replace(/[^0-9.-]/g, "");
            if (num !== "" && !isNaN(Number(num))) {
              cell.value = Number(num);
              cell.numFmt = "#,##0.00";
              // Ensure header and last row cells are bold
              if (rowIndex === 0) {
                cell.font = Object.assign({}, cell.font, { bold: true });
              }
              if (rowIndex === lastRowIndex) {
                cell.font = Object.assign({}, cell.font, { bold: true });
                // light fill for last row
                cell.fill = cell.fill || {
                  type: "pattern",
                  pattern: "solid",
                  fgColor: { argb: "FFF9F9F9" },
                };
              }
              cell.alignment = { horizontal: "right" };
            }
          }
        });
      });

      // Adjust column widths
      ws.columns.forEach((col) => {
        let maxLength = 10;
        col.eachCell({ includeEmpty: true }, (cell) => {
          const text = cell.value ? String(cell.value) : "";
          if (text.length > maxLength) maxLength = text.length;
        });
        col.width = Math.min(Math.max(maxLength + 2, 10), 40);
      });

      workbook.xlsx.writeBuffer().then((buffer) => {
        const blob = new Blob([buffer], {
          type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        });
        const filename = "analisis_movimiento_" + anio + ".xlsx";
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      });
    } catch (err) {
      console.error("ExcelJS export failed:", err);
      fallbackHtmlXls();
    }
  }
            workbook.xlsx.writeBuffer().then((buffer) => {
  loadExcelJSScript()
    .then(exportWithExcelJS)
    .catch((err) => {
      console.warn("Could not load ExcelJS, using HTML .xls fallback:", err);
      fallbackHtmlXls();
    });
}

// ========================
// Lanzar modal al cargar
            }).catch((err) => {
                console.error('writeBuffer failed:', err);
                fallbackHtmlXls();
            });
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
