<?php
// app/Controllers/AuthController.php
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../../config/config.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    // GET login: mostra view
    public function showLogin()
    {
        require __DIR__ . '/../Views/auth/login.php';
    }

    // POST login: processa
    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // proteções básicas de sessão
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email']
            ];
            header("Location: " . BASE_URL . "/router.php?page=dashboard");
            exit;
        }

        $_SESSION['error'] = 'E-mail ou senha inválidos.';
        header("Location: " . BASE_URL . "/router.php?page=login");
        exit;
    }

    // GET registro
    public function showRegister()
    {
        require __DIR__ . '/../Views/auth/register.php';
    }

    // POST registro
    public function register($name, $email, $password)
    {
        if ($this->userModel->findByEmail($email)) {
            $_SESSION['error'] = "E-mail já cadastrado.";
            header("Location: " . BASE_URL . "/router.php?page=register");
            exit;
        }

        if ($this->userModel->create($name, $email, $password)) {
            $_SESSION['success'] = "Conta criada com sucesso. Faça login.";
            header("Location: " . BASE_URL . "/router.php?page=login");
            exit;
        }

        $_SESSION['error'] = "Erro ao criar usuário.";
        header("Location: " . BASE_URL . "/router.php?page=register");
        exit;
    }

    public function logout()
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
        header("Location: " . BASE_URL . "/router.php?page=login");
        exit;
    }

    // GET forgot: mostra view
    public function showForgot()
    {
        require __DIR__ . '/../Views/auth/forgot_password.php';
    }

    // POST forgot: gera token e redireciona automaticamente para reset
    public function forgotPassword($email)
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            $_SESSION['error'] = "E-mail não encontrado.";
            header("Location: " . BASE_URL . "/router.php?page=forgot");
            exit;
        }

        $token = bin2hex(random_bytes(16));
        $this->userModel->saveResetToken($email, $token);

        // requisito: levar direto à página de reset usando o token gerado
        header("Location: " . BASE_URL . "/router.php?page=reset&token=" . urlencode($token));
        exit;
    }

    // GET reset: mostra view
    public function resetPasswordPage($token)
    {
        // Apenas carrega a view; a view acessa $_GET['token']
        require __DIR__ . '/../Views/auth/reset_password.php';
    }

    // POST reset: aplica senha nova
    public function resetPassword($token, $password)
    {
        $user = $this->userModel->findByToken($token);
        if (!$user) {
            $_SESSION['error'] = "Token inválido.";
            header("Location: " . BASE_URL . "/router.php?page=forgot");
            exit;
        }

        $this->userModel->updatePassword($user['id'], $password);
        $this->userModel->clearToken($user['id']);

        $_SESSION['success'] = "Senha redefinida com sucesso. Faça login.";
        header("Location: " . BASE_URL . "/router.php?page=login");
        exit;
    }
}
