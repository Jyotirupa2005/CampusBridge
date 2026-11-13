<?php
// CampusBridge configuration. Update these values to match your local MySQL setup.
define('DB_HOST', 'localhost');
define('DB_NAME', 'campusbridge');
define('DB_USER', 'root');
define('DB_PASS', '');
define('BASE_URL', '/CampusBridge');
define('ADMIN_REGISTRATION_KEY', 'CampusBridge@Admin2026');
define('UPLOAD_DIR', __DIR__ . '/uploads/');
if (session_status() === PHP_SESSION_NONE) { session_start(); }

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
    return $pdo;
}
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function redirect(string $path): never { header('Location: ' . BASE_URL . '/' . ltrim($path, '/')); exit; }
function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function verify_csrf(): void { if ($_SERVER['REQUEST_METHOD'] === 'POST' && !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Invalid request token. Please go back and try again.'); } }
function current_user(): ?array { return $_SESSION['user'] ?? null; }
function require_student(): void { if (!current_user() || current_user()['role'] !== 'student') redirect('login.php'); }
function require_admin(): void { if (!current_user() || current_user()['role'] !== 'admin') redirect('admin/login.php'); }
function flash(string $type, string $message): void { $_SESSION['flash'] = ['type'=>$type, 'message'=>$message]; }
function show_flash(): void { if (!empty($_SESSION['flash'])) { $f=$_SESSION['flash']; echo '<div class="alert '.e($f['type']).'">'.e($f['message']).'</div>'; unset($_SESSION['flash']); } }
