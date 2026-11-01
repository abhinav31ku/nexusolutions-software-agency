// ===== 1. Mobile menu: show/hide the links when the Menu button is clicked =====
var menuButton = document.getElementById("menu-button");
var navLinks = document.getElementById("nav-links");

if (menuButton) {
  menuButton.addEventListener("click", function () {
    navLinks.classList.toggle("open");
  });
}

// ===== 2. Project filters (projects.html) =====
var filterButtons = document.querySelectorAll(".filter-buttons button");
var projectCards = document.querySelectorAll(".project-card");

filterButtons.forEach(function (button) {
  button.addEventListener("click", function () {
    var category = button.getAttribute("data-category");

    // mark only the clicked button as active
    filterButtons.forEach(function (b) { b.classList.remove("active"); });
    button.classList.add("active");

    // show matching cards, hide the others
    projectCards.forEach(function (card) {
      if (category === "all" || card.getAttribute("data-category") === category) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });
});

// ===== 3. Login form (login.html) =====
var loginForm = document.getElementById("login-form");

if (loginForm) {
  var emailInput = document.getElementById("email");
  var passwordInput = document.getElementById("password");
  var emailError = document.getElementById("email-error");
  var passwordError = document.getElementById("password-error");
  var formMessage = document.getElementById("form-message");
  var showButton = document.getElementById("show-password");
  var loginButton = document.getElementById("login-button");

  // Show / hide password
  showButton.addEventListener("click", function () {
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      showButton.textContent = "Hide";
    } else {
      passwordInput.type = "password";
      showButton.textContent = "Show";
    }
  });

  // Check the form before sending it. Returns true if everything is OK.
  function formIsValid() {
    var ok = true;
    var email = emailInput.value.trim();
    emailError.textContent = "";
    passwordError.textContent = "";
    emailInput.classList.remove("input-error");
    passwordInput.classList.remove("input-error");

    if (email === "") {
      emailError.textContent = "Please enter your email.";
      emailInput.classList.add("input-error");
      ok = false;
    } else if (email.indexOf("@") !== -1 && email.indexOf(".") === -1) {
      // looks like an email but has no dot, e.g. name@site
      emailError.textContent = "That email does not look right. Example: name@example.com";
      emailInput.classList.add("input-error");
      ok = false;
    }

    if (passwordInput.value === "") {
      passwordError.textContent = "Please enter your password.";
      passwordInput.classList.add("input-error");
      ok = false;
    }
    return ok;
  }

  function showError(message) {
    formMessage.textContent = message;
    formMessage.style.display = "block";
    loginButton.disabled = false;
    loginButton.textContent = "Login";
  }

  loginForm.addEventListener("submit", function (event) {
    event.preventDefault();                 // stop the normal page reload
    formMessage.style.display = "none";
    if (!formIsValid()) { return; }

    loginButton.disabled = true;
    loginButton.textContent = "Logging in...";

    // Send the details to the existing PHP file login.php
    var data = new URLSearchParams();
    data.append("username", emailInput.value.trim());
    data.append("password", passwordInput.value);
    data.append("login_btn", "1");

    fetch("login.php", { method: "POST", body: data })
      .then(function (response) {
        // login.php redirects to another page when the login works
        if (response.redirected && response.url.indexOf("login.php") === -1) {
          window.location.href = response.url;
          return;
        }
        // otherwise read its error message
        return response.text().then(function (html) {
          var page = new DOMParser().parseFromString(html, "text/html");
          var alertBox = page.querySelector(".alert.error");
          showError(alertBox ? alertBox.textContent.trim() : "Login failed. Please try again.");
        });
      })
      .catch(function () {
        showError("Could not reach the server. Is XAMPP (Apache + MySQL) running?");
      });
  });
}
