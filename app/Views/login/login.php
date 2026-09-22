<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LablineSys Login</title>
    <link rel="stylesheet" href="<?= base_url('login_css/style.css') ?>">
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</head>
<body>
    <div style="position: fixed; top: 12px; left: 50%; transform: translateX(-50%); z-index: 1000; width: min(90vw, 520px);">
        <?php if (session()->getFlashdata('error')): ?>
            <div style="background: #ffe4e6; color: #991b1b; border: 1px solid #fecdd3; padding: 12px 16px; border-radius: 10px; margin-bottom: 12px; font-weight: 600;">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 10px; margin-bottom: 12px; font-weight: 600;">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>
    </div>

    <div id="container" class="container">
        <div class="row">
            <div class="col align-items-center flex-col sign-up">
                <div class="form-wrapper align-items-center">
                    <form class="form sign-up" action="<?= site_url('signup') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="input-group">
                             <img src="<?= base_url('img/logo.php') ?>" alt="LABLINE INC." style="height: 64px; width: auto; display: inline-block; filter: drop-shadow(0 0 10px rgba(60, 193, 163, 0.4));">
                            <i class='bx bxs-user'></i>
                            <input type="text" name="fname" placeholder="First name" value="<?= old('fname') ?>" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bxs-user'></i>
                            <input type="text" name="lname" placeholder="Last name" value="<?= old('lname') ?>" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bxs-user'></i>
                            <input type="text" name="username" placeholder="Username" value="<?= old('username') ?>" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bxs-lock-alt'></i>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bxs-lock-alt'></i>
                            <input type="password" name="confirm_password" placeholder="Confirm password" required>
                        </div>
                        <button type="submit">Sign up</button>
                        <p>
                            <span>Already have an account?</span>
                            <b onclick="toggle()" class="pointer">Sign in here</b>
                        </p>
                    </form>
                </div>
            </div>

            <div class="col align-items-center flex-col sign-in">
                <div class="form-wrapper align-items-center">
                    <form class="form sign-in" action="<?= site_url('login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="input-group">
                             <img src="<?= base_url('img/logo.php') ?>" alt="LABLINE INC." style="height: 64px; width: auto; display: inline-block; filter: drop-shadow(0 0 10px rgba(60, 193, 163, 0.4));">
                            <i class='bx bxs-user'></i>
                            <input type="text" name="username" placeholder="Username" value="<?= old('username') ?>" required>
                        </div>
                        <div class="input-group">
                            <i class='bx bxs-lock-alt'></i>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <button type="submit">Sign in</button>
                        <!-- <p><b>Forgot password?</b></p> -->
                        <p>
                            <span>Don't have an account?</span>
                            <b onclick="toggle()" class="pointer">Sign up here</b>
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <div class="row content-row">
            <div class="col align-items-center flex-col">
                <div class="text sign-in">
                    <h2>Welcome to</h2>
                    <h2>Labline</h2>
                </div>
                <div class="img sign-in"></div>
            </div>

            <div class="col align-items-center flex-col">
                <div class="img sign-up"></div>
                <div class="text sign-up">
                    <h2>Join with us</h2>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('container');

        function toggle() {
            container.classList.toggle('sign-in');
            container.classList.toggle('sign-up');
        }

        setTimeout(() => {
            container.classList.add('sign-in');
        }, 200);
    </script>
</body>
</html>
