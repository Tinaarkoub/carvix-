<div id="cookie-banner" class="cookie-banner" style="display: none;">
    <div class="cookie-banner-content">
        <h3>Nous utilisons des cookies</h3>
        <p>
            Nous utilisons des cookies essentiels au fonctionnement du site
            (connexion, panier, réservations) ainsi que des cookies optionnels
            pour améliorer votre expérience. Vous pouvez accepter ou refuser
            les cookies non essentiels.
        </p>
        <div class="cookie-banner-actions">
            <button id="cookie-refuse" class="btn-cookie btn-refuse">Refuser</button>
            <button id="cookie-accept" class="btn-cookie btn-accept">Accepter</button>
        </div>
    </div>
</div>

<style>
.cookie-banner {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #1f2d3d;
    color: #fff;
    padding: 20px 30px;
    z-index: 9999;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.2);
}
.cookie-banner-content {
    max-width: 900px;
    margin: 0 auto;
}
.cookie-banner h3 {
    margin: 0 0 8px;
    font-size: 18px;
}
.cookie-banner p {
    margin: 0 0 15px;
    font-size: 14px;
    line-height: 1.5;
    color: #d0d5db;
}
.cookie-banner-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}
.btn-cookie {
    padding: 10px 20px;
    border-radius: 6px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
}
.btn-refuse {
    background: #3a4756;
    color: #fff;
}
.btn-accept {
    background: #fff;
    color: #1f2d3d;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const banner = document.getElementById('cookie-banner');
    const consent = sessionStorage.getItem('cookie_consent');

    if (!consent) {
        banner.style.display = 'block';
    }

    document.getElementById('cookie-accept').addEventListener('click', function () {
        sessionStorage.setItem('cookie_consent', 'accepted');
        banner.style.display = 'none';
    });

    document.getElementById('cookie-refuse').addEventListener('click', function () {
        sessionStorage.setItem('cookie_consent', 'refused');
        banner.style.display = 'none';
    });
});
</script>