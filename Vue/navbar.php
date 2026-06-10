<nav id="navbar">
    <img src="/Vue/img/CookWithSoumi-logo.png"
        alt="Cook With Soumi"
        class="nav-logo"
        onerror="this.style.display='none'; document.getElementById('navTitle').style.display='block';" />
    <span id="navTitle" style="display:none">Cook With <span>Soumi</span></span>
    <ul class="nav-links">
        <li><a href="#recettes">Recettes</a></li>
        <li><a href="#categories">Catégories</a></li>
        <li><a href="#about">À propos</a></li>

        <?php if (!empty($_SESSION['user_id'])): ?>
            <li><a href="/titre/?page=profile">👤 <?= htmlspecialchars($_SESSION['prenom'] ?? 'Profil') ?></a></li>
            <li><a href="/titre/?page=logout" class="nav-cta">Se déconnecter</a></li>
        <?php else: ?>
            <li><a href="/titre/?page=login" class="nav-cta">Se connecter</a></li>
        <?php endif; ?>
    </ul>
</nav>