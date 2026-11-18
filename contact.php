<?php
// Handler form kontak portofolio Fithrah Aulia Rahmi.
// ponytail: uses PHP mail(); replace with SMTP/API when the host has no mail transport.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: index.html');
	exit;
}

$clean = static fn ($v) => str_replace(["\r", "\n"], ' ', trim((string) $v));
$name    = $clean($_POST['name'] ?? '');
$email   = filter_var(trim((string) ($_POST['email'] ?? '')), FILTER_VALIDATE_EMAIL);
$subject = $clean($_POST['subject'] ?? '');
$message = trim((string) ($_POST['message'] ?? ''));

if ($name === '' || $email === false || $subject === '' || $message === '') {
	header('Location: index.html#contact');
	exit;
}

$to      = 'fithrahaulia726@gmail.com';
$headers = [
	'From: noreply@' . preg_replace('/[^a-z0-9.\-]/i', '', $_SERVER['HTTP_HOST'] ?? 'localhost'),
	'Reply-To: ' . $email,
	'Content-Type: text/plain; charset=UTF-8',
];
$body = "Nama: {$name}\nEmail: {$email}\nSubjek: {$subject}\n\n{$message}\n";

@mail($to, $subject, $body, implode("\r\n", $headers));

header('Location: thank-you.html');
