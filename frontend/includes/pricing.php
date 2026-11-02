<?php
// Demo prices for each service (no real money is used).
function service_price($serviceType) {
    $prices = [
        'Website Development'  => 5000,
        'Software Development' => 8000,
        'Mobile Applications'  => 10000,
        'Technical Support'    => 1000,
        'Logo Design'          => 1500,
        'Web Development'      => 5000,
        'Video Editing'        => 2500,
        'General Consultation' => 500,
    ];
    return $prices[$serviceType] ?? 500;
}

// The services shown in the contact form (same names as the Services page).
function service_names() {
    return ['Website Development', 'Software Development', 'Mobile Applications', 'Technical Support'];
}

// The link that the QR code opens on the phone.
// On localhost a phone can't reach "localhost", so we use this computer's network address instead.
function build_scan_url($token) {
    preg_match('/^(.*?)(:\d+)?$/', $_SERVER['HTTP_HOST'], $m);
    $name = $m[1];
    $port = $m[2] ?? '';
    if ($name === 'localhost' || $name === '127.0.0.1' || $name === '[::1]') {
        $name = gethostbyname(gethostname());
    }
    $folder = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $scheme . '://' . $name . $port . $folder . '/pay_scan.php?token=' . $token;
}
