<?php
// Shared header for the PHP pages. Works from frontend/ and backend/.
include_once __DIR__ . '/../../backend/session.php';
$base = (basename(dirname($_SERVER['SCRIPT_FILENAME'])) === 'backend') ? '../frontend/' : '';
$loggedIn = isset($_SESSION['user_id']);
// Login state comes ONLY from the session above; it never looks at which page is open.
$page_title = $page_title ?? 'Nexusolutions';
$page_desc  = $page_desc  ?? '';
$active     = $active     ?? '';
// Never cache: after Login/Logout the Back button must not show an old navbar.
if (!headers_sent()) { header('Cache-Control: no-store, must-revalidate'); }
// The ONE list of navbar links, in display order: key => [label, file].
$navItems = [
    'home'     => ['Home',     'index.php'],
    'services' => ['Services', 'services.php'],
    'about'    => ['About',    'about.php'],
    'projects' => ['Projects', 'projects.php'],
    'contact'  => ['Contact',  'contact.php'],
];
if (!function_exists('nav_active')) {
    function nav_active($key, $active) { return $key === $active ? ' class="active"' : ''; }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($page_title); ?></title><?php if ($page_desc !== ''): ?><meta name="description" content="<?php echo htmlspecialchars($page_desc); ?>"><?php endif; ?><link rel="stylesheet" href="<?php echo $base; ?>css/style.css?v=5"></head>
<body>
<header class="navbar"><div class="container">
  <a href="<?php echo $base; ?>index.php" class="logo">Nexu<span>solutions</span></a>
  <div class="nav-right">
    <ul id="nav-links" class="nav-links" data-base="<?php echo $base; ?>">
      <?php foreach ($navItems as $key => $item): ?>
      <li><a href="<?php echo $base . $item[1]; ?>"<?php echo nav_active($key, $active); ?>><?php echo $item[0]; ?></a></li>
      <?php endforeach; ?>
    </ul>
    <div id="account-item" class="account<?php echo $loggedIn ? ' is-logged-in' : ''; ?>" data-rendered="server" data-auth="<?php echo $loggedIn ? '1' : '0'; ?>">
      <button type="button" id="profile-button" class="profile-button" aria-expanded="false" aria-haspopup="true" aria-label="Open profile menu" title="Profile"><svg class="profile-icon" viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 0 1 6-6h4a6 6 0 0 1 6 6v1"/></svg></button>
      <div id="profile-menu" class="profile-menu" hidden>
      <?php if ($loggedIn): ?>
        <p class="profile-name"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></p>
        <p class="profile-email"><?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></p>
        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
          <a href="<?php echo $base; ?>../backend/admin.php">Dashboard</a>
        <?php endif; ?>
        <a href="<?php echo $base; ?>logout.php" class="profile-logout">Logout</a>
      <?php else: ?>
        <p class="profile-name">Welcome</p><p class="profile-email">You are not logged in</p>
        <a href="<?php echo $base; ?>login.html">Login</a>
        <a href="<?php echo $base; ?>register.php">Create account</a>
      <?php endif; ?>
      </div>
    </div>
    <button id="menu-button" class="menu-button" aria-label="Open menu">Menu</button>
  </div>
</div></header>
<main>
