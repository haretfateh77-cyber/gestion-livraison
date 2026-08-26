<div id="cookie-banner" style="
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 1000px;
    background: white;
    color: #111;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.25);
    z-index: 999999;
    font-family: Arial, sans-serif;
">

    <h3 style="margin: 0 0 10px;">
        🍪 Gestion des cookies
    </h3>

    <p style="margin: 0 0 20px;">
        Ce site utilise des cookies nécessaires à son fonctionnement.
        Vous pouvez accepter ou refuser les cookies non essentiels.
    </p>

    <button id="accept-cookies" type="button" style="
        padding: 12px 25px;
        background: #0047bb;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        margin-right: 10px;
    ">
        Accepter
    </button>

    <button id="refuse-cookies" type="button" style="
        padding: 12px 25px;
        background: white;
        color: #111;
        border: 1px solid #ccc;
        border-radius: 8px;
        cursor: pointer;
    ">
        Refuser
    </button>

</div>

<script>
(function () {

    const banner = document.getElementById('cookie-banner');
    const acceptButton = document.getElementById('accept-cookies');
    const refuseButton = document.getElementById('refuse-cookies');

    if (!banner) {
        return;
    }

    const consent = localStorage.getItem('cookie_consent');

    if (consent === 'accepted' || consent === 'refused') {
        banner.style.display = 'none';
    }

    acceptButton.addEventListener('click', function () {
        localStorage.setItem('cookie_consent', 'accepted');
        banner.style.display = 'none';
    });

    refuseButton.addEventListener('click', function () {
        localStorage.setItem('cookie_consent', 'refused');
        banner.style.display = 'none';
    });

})();
</script>