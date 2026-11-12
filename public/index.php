<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/pricing.php';

$page_title = 'Nexusolutions';
$page_desc = 'Websites, small web apps and mobile apps for small businesses, built by a team of six students.';
$active = 'home';
include __DIR__ . '/../includes/header.php';
?>
<section class="intro">
  <div class="container intro-grid">
    <div>
      <h1>Websites, web apps and mobile apps for small businesses.</h1>
      <p>We are six students who build and look after software for shops, clinics and small teams. Send us what you need and you can follow the request until it is done.</p>
      <p class="intro-links">
        <a href="contact.php" class="btn btn-primary">Send an inquiry</a>
        <a href="services.php" class="text-link">Services and prices</a>
      </p>
    </div>
    <dl class="fact-list">
      <dt>Open slots</dt><dd>3 projects at a time</dd>
      <dt>Reply time</dt><dd>Within 2 working days</dd>
      <dt>Built with</dt><dd>PHP, MySQL, JavaScript</dd>
      <dt>Payments</dt><dd>Demo only, no real money</dd>
    </dl>
  </div>
</section>

<section class="section">
  <div class="container">
    <h2>What we take on</h2>
    <ul class="service-list">
      <?php foreach (service_prices() as $name => $price): ?>
      <li class="service-item">
        <span class="service-name"><?php echo e($name); ?></span>
        <span class="service-price"><?php echo format_price($price); ?></span>
        <a href="contact.php?service=<?php echo urlencode($name); ?>" class="text-link">Ask about this</a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<section class="section section-alt">
  <div class="container">
    <h2>How an inquiry works</h2>
    <ol class="step-list">
      <li>Log in and send an inquiry with a few lines about your project.</li>
      <li>Pay the demo amount by scanning a QR code with your phone.</li>
      <li>We change the status to In Progress and start work.</li>
      <li>When it is done the status becomes Completed. You can check it any time under My inquiries.</li>
    </ol>
  </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
