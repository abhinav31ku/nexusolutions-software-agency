<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/pricing.php';

$page_title = 'Services | Nexusolutions';
$page_desc = 'What we build and what it costs.';
$active = 'services';

$details = [
    'Website Development' => 'Up to five pages that work on phones, with a contact form. Usually 2 to 3 weeks.',
    'Software Development' => 'Small web apps with a database, like a stock tracker or a booking list. Written in plain PHP and MySQL. Usually 4 to 6 weeks.',
    'Mobile Applications' => 'Simple apps for phones. We agree on the screens first, then build them. Usually 5 to 8 weeks.',
    'Technical Support' => 'Bug fixes, small updates and backups, for sites we built or ones you already have. One request at a time.',
];
include __DIR__ . '/../includes/header.php';
?>
<section class="page-title">
  <div class="container">
    <h1>Services</h1>
    <p class="muted">Prices are demo amounts for this project. No real money is used.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <ul class="service-list service-list-wide">
      <?php foreach (service_prices() as $name => $price): ?>
      <li class="service-item">
        <div class="service-text">
          <h2 class="service-name"><?php echo e($name); ?></h2>
          <p><?php echo e($details[$name] ?? ''); ?></p>
        </div>
        <span class="service-price"><?php echo format_price($price); ?></span>
        <a href="contact.php?service=<?php echo urlencode($name); ?>" class="btn btn-outline">Send inquiry</a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
