// Mobile menu
const menu_button = document.getElementById('menu-button');
const site_nav = document.getElementById('site-nav');

if (menu_button && site_nav) {
  menu_button.addEventListener('click', function () {
    const open = site_nav.classList.toggle('open');
    menu_button.setAttribute('aria-expanded', open);
  });
}

// Profile dropdown
const account = document.querySelector('.account');
const profile_button = document.getElementById('profile-button');
const profile_menu = document.getElementById('profile-menu');

function show_profile_menu(show) {
  profile_menu.hidden = !show;
  profile_button.setAttribute('aria-expanded', show);
}

if (account && profile_button && profile_menu) {
  profile_button.addEventListener('click', function (event) {
    event.stopPropagation();
    show_profile_menu(profile_menu.hidden);
  });
  document.addEventListener('click', function (event) {
    if (!account.contains(event.target)) {
      show_profile_menu(false);
    }
  });
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      show_profile_menu(false);
    }
  });
}

// Project filter (projects.php)
const filter_buttons = document.querySelectorAll('.filter-button');
const project_items = document.querySelectorAll('.project-item');

filter_buttons.forEach(function (button) {
  button.addEventListener('click', function () {
    const category = button.getAttribute('data-category');

    filter_buttons.forEach(function (other) { other.classList.remove('active'); });
    button.classList.add('active');

    project_items.forEach(function (item) {
      item.hidden = category !== 'all' && item.getAttribute('data-category') !== category;
    });
  });
});

// Show/hide password. The buttons are hidden in the HTML, so without JS the field just stays hidden.
document.querySelectorAll('.show-password').forEach(function (button) {
  const field = document.getElementById(button.getAttribute('data-target'));
  button.hidden = false;
  button.addEventListener('click', function () {
    const hidden = field.type === 'password';
    field.type = hidden ? 'text' : 'password';
    button.textContent = hidden ? 'Hide' : 'Show';
  });
});

// Login form check. If it passes, the form is sent the normal way.
const login_form = document.getElementById('login-form');

if (login_form) {
  const username_input = document.getElementById('username');
  const password_input = document.getElementById('password');
  const username_error = document.getElementById('username-error');
  const password_error = document.getElementById('password-error');

  // use our own messages instead of the browser's
  login_form.noValidate = true;

  login_form.addEventListener('submit', function (event) {
    const username = username_input.value.trim();
    let valid = true;

    username_error.textContent = '';
    password_error.textContent = '';
    username_input.classList.remove('input-error');
    password_input.classList.remove('input-error');

    if (username === '') {
      username_error.textContent = 'Please enter your username or email.';
      valid = false;
    } else if (username.indexOf('@') !== -1 && !/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(username)) {
      username_error.textContent = 'That email does not look right. Example: name@example.com';
      valid = false;
    }
    if (!valid) {
      username_input.classList.add('input-error');
    }

    if (password_input.value === '') {
      password_error.textContent = 'Please enter your password.';
      password_input.classList.add('input-error');
      valid = false;
    }

    if (!valid) {
      event.preventDefault();
    }
  });
}
