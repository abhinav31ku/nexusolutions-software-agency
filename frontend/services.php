<?php
// Uses the ONE shared navbar/footer (includes/header.php + footer.php).
$page_title = 'Services | Nexusolutions';
$page_desc  = 'Website development, software development, mobile apps and technical support.';
$active     = 'services';
include 'includes/header.php';
?>

<section class="page-banner"><div class="container"><h1>Our Services</h1><p class="subtitle">Choose a service, then tell us about your project.</p></div></section>
<section class="section section-white"><div class="container"><div class="service-row"><img src="images/web.svg" alt=""><div><h3>Website Development</h3><p>We design and build responsive websites that look good on any screen and load quickly.</p><a href="contact.php?service=Website+Development" class="btn-primary">Contact Us</a></div></div><div class="service-row"><img src="images/software.svg" alt=""><div><h3>Software Development</h3><p>Custom software and web applications that connect to a database and fit your business.</p><a href="contact.php?service=Software+Development" class="btn-primary">Contact Us</a></div></div><div class="service-row"><img src="images/mobile.svg" alt=""><div><h3>Mobile Applications</h3><p>Mobile apps with simple, easy-to-use screens for your customers or your team.</p><a href="contact.php?service=Mobile+Applications" class="btn-primary">Contact Us</a></div></div><div class="service-row"><img src="images/support.svg" alt=""><div><h3>Technical Support</h3><p>Bug fixes, updates and regular check-ups so your software keeps working.</p><a href="contact.php?service=Technical+Support" class="btn-primary">Contact Us</a></div></div></div></section><section class="cta-strip"><div class="container"><h2>Ready to start your project?</h2><a href="contact.php" class="btn-primary">Contact Us</a></div></section>

<?php include 'includes/footer.php'; ?>
