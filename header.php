<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Tajawal:wght@300;400;500&display=swap');

.dola-header {
    background: #000;
    padding: 0 32px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    position: relative;
    overflow: visible;
}

.dola-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(
        90deg,
        transparent,
        #d4af37,
        #ffd700,
        transparent
    );
}

.dola-logo-area {
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
}

.dola-logo-icon {
    width: 58px;
    height: 58px;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: transparent;
}

.dola-logo-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.dola-logo-name {
    font-family: 'Orbitron', sans-serif;
    font-size: 20px;
    font-weight: 700;
    color: #ffd700;
    letter-spacing: 3px;
    display: block;
}

.dola-logo-sub {
    font-family: 'Tajawal', sans-serif;
    font-size: 10px;
    font-weight: 300;
    color: rgba(255, 215, 0, 0.7);
    letter-spacing: 2px;
    text-transform: uppercase;
    display: block;
}

.dola-nav-links {
    display: flex;
    gap: 4px;
    list-style: none;
    align-items: center;
    margin: 0;
    padding: 0;
}

.dola-nav-links li a {
    font-family: 'Tajawal', sans-serif;
    font-size: 14px;
    font-weight: 400;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    padding: 8px 14px;
    border-radius: 8px;
    transition: all 0.3s ease;
    display: block;
}

.dola-nav-links li a:hover {
    color: #ffd700;
    background: rgba(255, 215, 0, 0.08);
}

.dola-nav-actions {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-left: 12px;
}

.dola-glow-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #ffd700;
    box-shadow: 0 0 10px #ffd700;
    animation: dolapulse 2s infinite;
}

@keyframes dolapulse {
    0%,100% {
        opacity: 1;
    }
    50% {
        opacity: 0.3;
    }
}

.dola-divider {
    width: 1px;
    height: 20px;
    background: rgba(255, 215, 0, 0.2);
    margin: 0 4px;
}

.dola-btn-login,
.dola-btn-register,
.dola-btn-profile,
.dola-btn-dashboard,
.dola-btn-logout {
    font-family: 'Tajawal', sans-serif;
    font-size: 13px;
    font-weight: 500;
    padding: 8px 18px;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: 0.3s ease;
}

.dola-btn-login {
    color: #ffd700;
    background: transparent;
    border: 1px solid rgba(255, 215, 0, 0.5);
}

.dola-btn-login:hover {
    background: rgba(255, 215, 0, 0.1);
}

.dola-btn-register {
    color: black;
    background: linear-gradient(135deg, #ffd700, #d4af37);
    border: none;
}

.dola-btn-register:hover {
    opacity: 0.85;
}

.dola-btn-profile {
    color: white;
    background: rgba(255, 215, 0, 0.1);
    border: 1px solid rgba(255, 215, 0, 0.4);
}

.dola-btn-profile:hover {
    background: rgba(255, 215, 0, 0.2);
}

.dola-btn-dashboard {
    color: white;
    background: rgba(255, 215, 0, 0.1);
    border: 1px solid rgba(255, 215, 0, 0.4);
}

.dola-btn-dashboard:hover {
    background: rgba(255, 215, 0, 0.2);
}

.dola-btn-logout {
    color: white;
    background: rgba(220, 50, 50, 0.2);
    border: 1px solid rgba(220, 50, 50, 0.5);
}

.dola-btn-logout:hover {
    background: rgba(220, 50, 50, 0.4);
}

.dola-hamburger {
    display: none;
    flex-direction: column;
    gap: 5px;
    cursor: pointer;
    z-index: 1001;
    background: none;
    border: none;
    padding: 4px;
}

.dola-hamburger span {
    display: block;
    width: 25px;
    height: 3px;
    background: #ffd700;
    border-radius: 5px;
    transition: all 0.3s;
}

.dola-mobile-menu {
    display: none;
    position: absolute;
    top: 80px;
    left: 0;
    right: 0;
    background: #000;
    border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    padding: 16px 24px;
    z-index: 1000;
    flex-direction: column;
    gap: 8px;
}

.dola-mobile-menu.open {
    display: flex;
}

.dola-mobile-menu a {
    color: rgba(255,255,255,0.85);
    text-decoration: none;
    font-family: 'Tajawal', sans-serif;
    font-size: 15px;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}

.dola-mobile-menu a:hover {
    color: #ffd700;
}

@media (max-width: 768px) {

    .dola-header {
        padding: 0 16px;
    }

    .dola-nav-links {
        display: none;
    }

    .dola-nav-actions {
        display: none;
    }

    .dola-hamburger {
        display: flex;
    }

    .dola-logo-name {
        font-size: 16px;
    }

    .dola-logo-sub {
        font-size: 9px;
    }
}
</style>

<div class="dola-header">

    <a href="index.php" class="dola-logo-area">

        <div class="dola-logo-icon">
            <img src="assets/images/logo.jpeg" alt="Luxury Logo">
        </div>

        <div>
            <span class="dola-logo-name">LUXURY</span>
            <span class="dola-logo-sub">Premium Cars</span>
        </div>

    </a>

    <ul class="dola-nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="showroom.php">Showroom</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>

    <div class="dola-nav-actions">

        <div class="dola-glow-dot"></div>
        <div class="dola-divider"></div>

        <?php if (!isset($_SESSION['user_id'])): ?>

            <a href="auth/login.php" class="dola-btn-login">Login</a>
            <a href="auth/register.php" class="dola-btn-register">Register</a>

        <?php else: ?>

            <a href="profile.php" class="dola-btn-profile">My Profile</a>

            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="dashboard/index.php" class="dola-btn-dashboard">Dashboard</a>
            <?php endif; ?>

            <a href="auth/logout.php" class="dola-btn-logout">Logout</a>

        <?php endif; ?>

    </div>

    <button class="dola-hamburger" id="dolaHamburger">
        <span></span>
        <span></span>
        <span></span>
    </button>

</div>

<div class="dola-mobile-menu" id="dolaMobileMenu">

    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="showroom.php">Showroom</a>
    <a href="contact.php">Contact</a>

    <?php if (!isset($_SESSION['user_id'])): ?>

        <a href="auth/login.php">Login</a>
        <a href="auth/register.php">Register</a>

    <?php else: ?>

        <a href="profile.php">My Profile</a>

        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="dashboard/index.php">Dashboard</a>
        <?php endif; ?>

        <a href="auth/logout.php" style="color:#dc3545;">Logout</a>

    <?php endif; ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const hamburger = document.getElementById('dolaHamburger');
    const mobileMenu = document.getElementById('dolaMobileMenu');

    hamburger.addEventListener('click', function (e) {
        e.stopPropagation();
        mobileMenu.classList.toggle('open');
    });

    document.addEventListener('click', function () {
        mobileMenu.classList.remove('open');
    });

});
</script>