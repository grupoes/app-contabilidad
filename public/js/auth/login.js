const formLogin = document.getElementById("formLogin");

const message_error = document.getElementById("message_error");

formLogin.addEventListener("submit", function (event) {
  event.preventDefault();
  const formData = new FormData(formLogin);

  fetch("/login", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
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
