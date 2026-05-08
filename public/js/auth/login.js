const formLogin = document.getElementById("formLogin");

const message_error = document.getElementById("message_error");

formLogin.addEventListener("submit", function (event) {
  event.preventDefault();
  const formData = new FormData(formLogin);

  fetch(`${BASE_URL}login`, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success" || data.status === "warning") {
        window.location.href = data.redirect;
      } else {
        message_error.innerHTML = `
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
          <div class="text-white">${data.message}</div>
        </div>
        `;
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Error al iniciar sesión");
    });
});

document.getElementById("forgot-password").addEventListener("click", function () {
  const username = document.getElementById("username").value;

  if (!username) {
    Swal.fire({
      icon: "warning",
      title: "Atención",
      text: "Por favor, ingrese su usuario en el campo correspondiente antes de continuar.",
    });
    return;
  }

  Swal.fire({
    title: "Verificando usuario...",
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });

  fetch(`${BASE_URL}auth/verify-user/${username}`)
    .then((response) => response.json())
    .then((data) => {
      Swal.close();
      if (data.status === "success" || data.status === true) {
        if (data.email) {
          const masked = maskEmail(data.email);
          Swal.fire({
            icon: "info",
            title: "Usuario verificado",
            html: `El correo asociado a este usuario es: <b>${masked}</b>`,
            confirmButtonText: "Continuar",
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = `${BASE_URL}auth/forgot-password`;
            }
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "El usuario no tiene un correo electrónico configurado. Contacte al administrador.",
          });
        }
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: data.message || "El usuario no existe o no se pudo verificar.",
        });
      }
    })
    .catch((error) => {
      Swal.close();
      console.error("Error:", error);
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "Ocurrió un problema al verificar el usuario.",
      });
    });
});

function maskEmail(email) {
  const [name, domain] = email.split("@");
  if (name.length <= 8) {
    // Si es muy corto, mostrar menos
    return name.substring(0, 1) + "******" + name.substring(name.length - 1) + "@" + domain;
  }
  const maskedName = name.substring(0, 4) + "******" + name.substring(name.length - 4);
  return `${maskedName}@${domain}`;
}
