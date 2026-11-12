<?php
require_once __DIR__ . '/auth.php';

$asset_version = '1';
$page_title = $page_title ?? 'Nexusolutions';
$page_desc = $page_desc ?? '';
$active = $active ?? '';
$nav_user = current_user();

// no caching, so the Back button does not show a navbar from before login/logout
if (!headers_sent()) {
    header('Cache-Control: no-store, must-revalidate');
}

$nav_items = [
    'home' => ['Home', 'index.php'],
    'services' => ['Services', 'services.php'],
    'about' => ['About', 'about.php'],
    'projects' => ['Projects', 'projects.php'],
    'contact' => ['Contact', 'contact.php'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo e($page_title); ?></title>
  <?php if ($page_desc !== ''): ?>
  <meta name="description" content="<?php echo e($page_desc); ?>">
  <?php endif; ?>
  <link rel="icon" type="image/svg+xml" href="<?php echo url('assets/img/favicon.svg'); ?>">
  <link rel="stylesheet" href="<?php echo url('assets/css/style.css'); ?>?v=<?php echo $asset_version; ?>">
</head>
<body>
<header class="site-header">
  <div class="container header-row">
    <a href="<?php echo url('public/index.php'); ?>" class="site-logo">Nexusolutions</a>

    <button type="button" id="menu-button" class="menu-button" aria-expanded="false" aria-controls="site-nav">Menu</button>

    <nav id="site-nav" class="site-nav" aria-label="Main">
      <ul class="nav-list">
        <?php foreach ($nav_items as $key => $item): ?>
        <li><a href="<?php echo url('public/' . $item[1]); ?>" class="nav-link<?php echo $key === $active ? ' active' : ''; ?>"><?php echo $item[0]; ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>

    <div class="account">
      <button type="button" id="profile-button" class="profile-button" aria-expanded="false" aria-haspopup="true">
        <?php echo $nav_user ? e($nav_user['username']) : 'Account'; ?>
      </button>
      <div id="profile-menu" class="profile-menu" hidden>
        <?php if ($nav_user): ?>
          <p class="profile-name"><?php echo e($nav_user['username']); ?></p>
          <p class="profile-email"><?php echo e($nav_user['email']); ?></p>
          <?php if ($nav_user['role'] === 'admin'): ?>
            <a href="<?php echo url('admin/index.php'); ?>">Dashboard</a>
          <?php else: ?>
            <a href="<?php echo url('public/my_inquiries.php'); ?>">My inquiries</a>
          <?php endif; ?>
          <a href="<?php echo url('public/logout.php'); ?>" class="profile-logout">Log out</a>
        <?php else: ?>
          <a href="<?php echo url('public/login.php'); ?>">Log in</a>
          <a href="<?php echo url('public/register.php'); ?>">Create account</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</header>
<main>
