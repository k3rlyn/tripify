<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TripKuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Poppins', sans-serif;
            padding: 20px 0;
        }
        .brand-name {
            color: #1a237e;
            font-size: clamp(2rem, 5vw, 2.5rem);
            font-weight: 700;
            font-family: 'Shrikhand', cursive;
            text-align: center;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
            background: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
        }
        .card-header {
            background: transparent;
            border-bottom: none;
            padding-top: 2rem;
            text-align: center;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            box-shadow: none;
        }
        .form-control:focus {
            border-color: #1a237e;
            box-shadow: 0 0 0 0.2rem rgba(26,35,126,0.25);
        }
        .btn-register {
            background: #1a237e;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            color: white !important;
        }
        .btn-register:hover,
        .btn-register:active,
        .btn-register:focus {
            background: #0d1757;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white !important;
        }
        .login-link {
            color: #1a237e;
            text-decoration: none;
            font-weight: 500;
        }
        .login-link:hover {
            color: #0d1757;
            text-decoration: underline;
        }
        .register-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            .card {
                margin: 0 10px;
            }
            .card-body {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 480px) {
            .brand-name {
                margin-bottom: 0.5rem;
            }
            .card-body {
                padding: 1rem;
            }
            .btn-register {
                padding: 10px;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Shrikhand&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                <div class="brand-name">
                    TripKuy
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Please Create an Account</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        
                        <form action="<?= base_url('kerlyn/register_action') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?= old('username') ?>" required 
                                       placeholder="Choose a username">
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       value="<?= old('nama') ?>" required 
                                       placeholder="Enter your full name">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required 
                                       placeholder="Create a password">
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" 
                                       name="confirm_password" required 
                                       placeholder="Confirm your password">
                            </div>
                            <button type="submit" class="btn btn-register w-100">
                                Register
                            </button>
                        </form>
                        <div class="register-footer">
                            Already have an account? 
                            <a href="<?= base_url('kerlyn/login') ?>" class="login-link">
                                Login here
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>