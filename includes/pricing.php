<?php
require_once __DIR__ . '/../config/config.php';

// Demo prices in rupees. Only these services can be ordered.
function service_prices() {
    return [
        'Website Development' => 5000,
        'Software Development' => 8000,
        'Mobile Applications' => 10000,
        'Technical Support' => 1000,
    ];
}

function service_names() {
    return array_keys(service_prices());
}

function service_price($name) {
    $prices = service_prices();
    return $prices[$name] ?? null;
}

function format_price($amount) {
    return 'Rs. ' . number_format($amount);
}

// The phone opens this link after scanning the QR code.
function build_scan_url($token) {
    return rtrim(BASE_URL, '/') . '/public/pay_scan.php?token=' . urlencode($token);
}
