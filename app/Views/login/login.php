<script>
    var baseUrl = "<?= base_url(); ?>";
    var siteUrl = "<?= site_url(); ?>";
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Panel</title>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/all.css'>
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css'>
    <link rel="stylesheet" href="<?= base_url('assets/loginDoc/style.css') ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url('assets/loginDoc/index.js') ?>"></script>
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="container">
        <div class="screen">
            <div class="screen__content">
                <form id="login_form" method="post" class="login">
                    <div class="login__field">
                        <i class="login__icon fas fa-user"></i>
                        <input type="text" class="login__input" name="emp_email" id="emp_email"
                            placeholder="User name / Email">
                        <div id="val_email">
                            Please provide a valid email.
                        </div>
                    </div>
                    <div class="login__field">
                        <i class="login__icon fas fa-lock"></i>
                        <input type="password" class="login__input" name="emp_password" id="emp_password"
                            placeholder="Password">
                        <div id="val_password">
                            Please provide a valid password.
                        </div>
                    </div>
                    <button class="button login__submit">
                        <span class="button__text">Log In Now</span>
                        <i class="button__icon fas fa-chevron-right"></i>
                    </button>
                </form>
                <div class="social-login">
                    <h3>log in via</h3>
                    <div class="social-icons">
                        <a href="" class="social-login__icon fab fa-google"></a>
                        <a href="#" class="social-login__icon fab fa-facebook"></a>
                    </div>
                </div>
            </div>
            <div class="screen__background">
                <span class="screen__background__shape screen__background__shape4"></span>
                <span class="screen__background__shape screen__background__shape3"></span>
                <span class="screen__background__shape screen__background__shape2"></span>
                <span class="screen__background__shape screen__background__shape1"></span>
            </div>
        </div>
    </div>
    <!-- partial -->

</body>

</html>