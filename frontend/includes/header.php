<?php
// Shared header for the PHP pages. Works from frontend/ and backend/.
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$base = (basename(dirname($_SERVER['SCRIPT_FILENAME'])) === 'backend') ? '../frontend/' : '';
$loggedIn = isset($_SESSION['user_id']) || isset($_SESSION['role']);
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nexusolutions</title><link rel="stylesheet" href="<?php echo $base; ?>css/style.css"></head>
<body>
<header class="navbar"><div class="container">
  <a href="<?php echo $base; ?>index.html" class="logo">Nexu<span>solutions</span></a>
  <button id="menu-button" class="menu-button" aria-label="Open menu">Menu</button>
  <ul id="nav-links" class="nav-links">
    <li><a href="<?php echo $base; ?>index.html">Home</a></li>
    <li><a href="<?php echo $base; ?>services.html">Services</a></li>
    <li><a href="<?php echo $base; ?>about.html">About</a></li>
    <li><a href="<?php echo $base; ?>projects.html">Projects</a></li>
    <li><a href="<?php echo $base; ?>contact.php">Contact</a></li>
    <?php if ($loggedIn): ?>
      <?php if (($_SESSION['role'] ?? '') === 'admin'): ?><li><a href="<?php echo $base; ?>../backend/admin.php">Dashboard</a></li><?php endif; ?>
      <li><span style="color:#fff"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></span></li>
      <li><a href="<?php echo $base; ?>logout.php" class="nav-button">Logout</a></li>
    <?php else: ?>
      <li><a href="<?php echo $base; ?>login.html" class="nav-button">Login</a></li>
    <?php endif; ?>
  </ul>
</div></header>
<main>
