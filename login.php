
<?php
require_once __DIR__ . '/config.php';

$role = $_GET['role'] ?? $_POST['role'] ?? '';

if (!in_array($role, ['student', 'admin'], true)) {
    $role = '';
}

if (current_user()) {
    redirect(
        current_user()['role'] === 'admin'
        ? 'admin/dashboard.php'
        : 'student/dashboard.php'
    );
}

$pageTitle = 'Login';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $email = strtolower(trim($_POST['email'] ?? ''));
    $pass = $_POST['password'] ?? '';

    if ($role === '') {
        $error = 'Please select your account type.';
    } else {
        $stmt = db()->prepare(
            'SELECT id, name, email, password, role
             FROM users WHERE email = ? AND role = ?'
        );

        $stmt->execute([$email, $role]);
        $user = $stmt->fetch();

        if ($user && password_verify($pass, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            redirect(
                $role === 'admin'
                ? 'admin/dashboard.php'
                : 'student/dashboard.php'
            );
        } else {
            $error = 'Invalid email or password. Please check your details.';
        }
    }
}

require __DIR__ . '/includes/header.php';
?>

<section class="form-page">
    <div class="container">
        <div class="form-shell">

            <?php if ($role === ''): ?>

                <div class="eyebrow">Welcome to CampusBridge</div>
                <h1>Account Portal</h1>
                <p class="form-intro">
                    Choose your account type to continue.
                </p>

                <div class="field">
                    <h3>Student Account</h3>
                    <p>For students applying for college admission.</p>
                    <a class="btn form-submit"
                       href="<?= BASE_URL ?>/login.php?role=student">
                        Student Login
                    </a>
                    <a href="<?= BASE_URL ?>/register.php">
                        Register as Student
                    </a>
                </div>

                <div class="field">
                    <h3>Administrator Account</h3>
                    <p>For administrators managing student applications.</p>
                    <a class="btn form-submit"
                       href="<?= BASE_URL ?>/login.php?role=admin">
                        Admin Login
                    </a>
                    <a href="<?= BASE_URL ?>/register.php">
                        Register as Admin
                    </a>
                </div>

            <?php else: ?>

                <div class="eyebrow">
                    <?= $role === 'admin' ? 'Administrator Login' : 'Student Login' ?>
                </div>

                <h1>Login to your account</h1>

                <p class="form-intro">
                    Enter your registered email and password.
                </p>

                <?php if ($error): ?>
                    <div class="alert error"
                         style="width:100%;margin:0 0 15px">
                        <?= e($error) ?>
                    </div>
                <?php endif; ?>

                <form method="post">
                    <input type="hidden" name="csrf"
                           value="<?= e(csrf_token()) ?>">

                    <input type="hidden" name="role"
                           value="<?= e($role) ?>">

                    <div class="field">
                        <label>Email address</label>
                        <input type="email" name="email" required
                               value="<?= e($_POST['email'] ?? '') ?>">
                    </div>

                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="password" required>
                    </div>

                    <button class="btn form-submit" type="submit">
                        Login
                    </button>
                </form>

                <div class="form-foot">
                    New account?
                    <a href="<?= BASE_URL ?>/register.php">
                        Register here
                    </a>
                </div>

                <div class="form-foot">
                    <a href="<?= BASE_URL ?>/login.php">
                        Back to Account Portal
                    </a>
                </div>

            <?php endif; ?>

        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
