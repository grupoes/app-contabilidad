const input = document.getElementById("fancy-file-upload");
const canvas = document.getElementById("canvasPreview");
const ctx = canvas.getContext("2d");
const previewImgContainer = document.getElementById("previewImgContainer");
const previewCanvasContainer = document.getElementById(
  "previewCanvasContainer"
);
const controlsContainer = document.getElementById("controlsContainer");
const range = document.getElementById("rangeUmbral");
const valor = document.getElementById("valorUmbral");
const previewImage = document.getElementById("previewImage");
const btnGuardar = document.getElementById("btnGuardar");
const formSelloFirma = document.getElementById("formSelloFirma");

let imagenOriginal = null;
let tieneTransparencia = false;

// Mostrar valor
range.addEventListener("input", () => {
  valor.innerText = range.value;
  if (imagenOriginal && !tieneTransparencia) procesarImagen();
});

// Cargar imagen
input.addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (!file) return;

  // Ocultar ambos contenedores inicialmente
  previewImgContainer.classList.add("d-none");
  previewCanvasContainer.classList.add("d-none");
  controlsContainer.classList.add("d-none");
  btnGuardar.disabled = true;

  // 🔒 Validar que sea PNG
  if (file.type === "image/png") {
    const formData = new FormData();
    formData.append("imagen", file);

    fetch("/configuracion/transparenciaImagen", {
      method: "POST",
      body: formData,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.transparencia === true) {
          // Mostrar en <img> para PNG con transparencia
          tieneTransparencia = true;
          mostrarImagenSimple(file);
        } else {
          // Mostrar en <canvas> para PNG sin transparencia
          tieneTransparencia = false;
          procesarConCanvas(file);
        }
      })
      .catch((err) => {
        console.error("Error:", err);
        tieneTransparencia = false;
        procesarConCanvas(file);
      });

    return;
  }

  // Para otros formatos (JPG, JPEG)
  tieneTransparencia = false;
  procesarConCanvas(file);
});

function mostrarImagenSimple(file) {
  const reader = new FileReader();
  reader.onload = function (e) {
    previewImage.src = e.target.result;
    previewImgContainer.classList.remove("d-none");
    btnGuardar.disabled = false;
  };
  reader.readAsDataURL(file);
}

function procesarConCanvas(file) {
  const img = new Image();
  img.onload = function () {
    canvas.width = img.width;
    canvas.height = img.height;
    ctx.drawImage(img, 0, 0);
    imagenOriginal = img;

    // Mostrar UI
    previewCanvasContainer.classList.remove("d-none");
    controlsContainer.classList.remove("d-none");
    btnGuardar.disabled = false;

    // Detectar umbral automáticamente
    const umbralDetectado = detectarUmbral();
    range.value = umbralDetectado;
    valor.innerText = umbralDetectado;

    procesarImagen();
  };
  img.src = URL.createObjectURL(file);
}

// 🧠 Detecta un umbral inicial analizando el fondo
function detectarUmbral() {
  let imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
  let data = imgData.data;

  let blancos = [];

  for (let i = 0; i < data.length; i += 4) {
    let r = data[i];
    let g = data[i + 1];
    let b = data[i + 2];
    let lum = (r + g + b) / 3;

    // Tomar solo píxeles muy claros (posible fondo)
    if (lum > 200) {
      blancos.push(lum);
    }
  }

  if (blancos.length === 0) return 140;

  // Promedio de blancos
  let promedio = blancos.reduce((a, b) => a + b, 0) / blancos.length;

  // Ajuste automático
  let umbral = Math.floor(promedio - 10);
  return Math.min(220, Math.max(100, umbral));
}

// 🎨 Procesamiento en tiempo real (solo para imágenes sin transparencia)
function procesarImagen() {
  if (tieneTransparencia) return; // No procesar si ya tiene transparencia

  ctx.drawImage(imagenOriginal, 0, 0);

  let imgData = ctx.getImageData(0, 0, canvas.width, canvas.height);
  let data = imgData.data;
  let umbral = parseInt(range.value);

  for (let i = 0; i < data.length; i += 4) {
    let r = data[i];
    let g = data[i + 1];
    let b = data[i + 2];

    let lum = (r + g + b) / 3;

    // Fondo → transparente
    if (lum > umbral) {
      data[i + 3] = 0;
      continue;
    }

    // Detectar firma azul
    if (b > r + 15 && b > g + 15) {
      data[i + 3] = 255;
    } else {
      // Texto/sello → negro
      data[i] = 0;
      data[i + 1] = 0;
      data[i + 2] = 0;
      data[i + 3] = 255;
    }
  }

  ctx.putImageData(imgData, 0, 0);
}

formSelloFirma.addEventListener("submit", function (e) {
  e.preventDefault();

  // Si es imagen con canvas procesada, necesitamos convertirla a blob
  if (!tieneTransparencia && imagenOriginal) {
    canvas.toBlob(function (blob) {
      const formData = new FormData();
      formData.append("imagen", blob, "sello_firma.png");
      enviarFormData(formData);
    }, "image/png");
  } else {
    // Para PNG con transparencia o si no hay procesamiento
    const formData = new FormData(formSelloFirma);
    enviarFormData(formData);
  }
});

function enviarFormData(formData) {
  fetch("/configuracion/uploadSelloFirma", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);

      if (data.status === "success") {
        alert("Sello y firma subidos correctamente");
        // Opcional: limpiar el formulario
        formSelloFirma.reset();
        previewImgContainer.classList.add("d-none");
        previewCanvasContainer.classList.add("d-none");
        controlsContainer.classList.add("d-none");
        btnGuardar.disabled = true;
        imagenOriginal = null;
      } else {
        alert(data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Ocurrió un error al subir el sello y firma");
    });
}

function loadImagenSelloFirma() {
  fetch("/configuracion/getSelloFirma")
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        previewImage.src = data.link;
        previewImgContainer.classList.remove("d-none");
        btnGuardar.disabled = false;
      } else {
        previewImgContainer.classList.add("d-none");
      }
    });
}

loadImagenSelloFirma();
