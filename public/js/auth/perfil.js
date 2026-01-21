const formPassword = document.getElementById("formPassword");
const message_error = document.getElementById("message_error");

formPassword.addEventListener("submit", (e) => {
  e.preventDefault();

  message_error.innerHTML = "";

  const formData = new FormData(formPassword);

  fetch(`${base_url}change-password`, {
    method: "POST",
    body: formData,
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status == "error") {
        message_error.innerHTML = `
        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
          <div class="text-white">${data.message}</div>
        </div>
        `;

        return false;
      }

      formPassword.reset();

      message_error.innerHTML = `
      <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
        <div class="text-white">${data.message}</div>
      </div>
      `;
    });
});
