
<?php
require_once __DIR__ . '/config.php';

if (current_user()) {
    redirect(
        current_user()['role'] === 'admin'
        ? 'admin/dashboard.php'
        : 'student/dashboard.php'
    );
}

$pageTitle = 'Create an account';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'student';
    $adminKey = $_POST['admin_key'] ?? '';

    if (!in_array($role, ['student', 'admin'], true)) {
        $role = 'student';
    }

    if (
        $name === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        strlen($password) < 8
    ) {
        $error = 'Please enter valid details. Password must be at least 8 characters.';

    } elseif (
        $role === 'admin' &&
        !hash_equals(ADMIN_REGISTRATION_KEY, $adminKey)
    ) {
        $error = 'Invalid Admin Registration Key.';

    } else {
        try {
            $stmt = db()->prepare(
                'INSERT INTO users (name, email, phone, password, role)
                 VALUES (?, ?, ?, ?, ?)'
            );

            $stmt->execute([
                $name,
                $email,
                $phone,
                password_hash($password, PASSWORD_DEFAULT),
                $role
            ]);

            flash(
                'success',
                'Registration successful! Please login to continue.'
            );

            redirect('login.php');

        } catch (PDOException $ex) {
            $error = $ex->getCode() === '23000'
                ? 'This email address is already registered.'
                : 'Could not create your account. Please try again.';
        }
    }
}

require __DIR__ . '/includes/header.php';
?>

<section class="form-page">
    <div class="container">
        <div class="form-shell">

            <div class="eyebrow">Join CampusBridge</div>
            <h1>Create your account</h1>
            <p class="form-intro">
                Register as a Student or Administrator.
            </p>

            <?php if ($error): ?>
                <div class="alert error" style="width:100%;margin:0 0 15px">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form method="post">

                <input type="hidden" name="csrf"
                       value="<?= e(csrf_token()) ?>">

                <div class="field">
                    <label>Register as</label>
                    <select name="role" id="accountRole" required
                            onchange="toggleAdminKey()">
                        <option value="student"
                            <?= ($_POST['role'] ?? 'student') === 'student' ? 'selected' : '' ?>>
                            Student
                        </option>

                        <option value="admin"
                            <?= ($_POST['role'] ?? '') === 'admin' ? 'selected' : '' ?>>
                            Administrator
                        </option>
                    </select>
                </div>

                <div class="field">
                    <label>Full name</label>
                    <input type="text" name="name" required maxlength="100"
                           value="<?= e($_POST['name'] ?? '') ?>"
                           placeholder="Your full name">
                </div>

                <div class="field">
                    <label>Email address</label>
                    <input type="email" name="email" required
                           value="<?= e($_POST['email'] ?? '') ?>"
                           placeholder="you@example.com">
                </div>

                <div class="field">
                    <label>Phone number</label>
                    <input type="text" name="phone" maxlength="20"
                           value="<?= e($_POST['phone'] ?? '') ?>"
                           placeholder="Your contact number">
                </div>

                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password"
                           required minlength="8"
                           placeholder="At least 8 characters">
                </div>

                <div class="field" id="adminKeyField" style="display:none">
                    <label>Admin Registration Key</label>
                    <input type="password" name="admin_key"
                           id="adminKey"
                           placeholder="Enter Admin Secret Key">
                </div>

                <button class="btn form-submit" type="submit">
                    Create Account
                </button>

            </form>

            <div class="form-foot">
                Already registered?
                <a href="<?= BASE_URL ?>/login.php">Login here</a>
            </div>

        </div>
    </div>
</section>

<script>
function toggleAdminKey() {
    const role = document.getElementById('accountRole').value;
    const keyField = document.getElementById('adminKeyField');
    const keyInput = document.getElementById('adminKey');

    keyField.style.display = role === 'admin' ? 'block' : 'none';
    keyInput.required = role === 'admin';
}

toggleAdminKey();
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
