const formLogin = document.getElementById("formLogin");

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
        alert(data.message || "Error al iniciar sesión");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Error al iniciar sesión");
    });
});
