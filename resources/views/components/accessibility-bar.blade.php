<div id="accessibility-bar">
    <button id="font-decrease" type="button" title="Réduire le texte">A-</button>
    <button id="font-reset" type="button" title="Taille normale">A</button>
    <button id="font-increase" type="button" title="Agrandir le texte">A+</button>
</div>

<style>
#accessibility-bar {
    position: fixed;
    top: 50%;
    right: 0;
    transform: translateY(-50%);
    background: #1f2d3d;
    border-radius: 10px 0 0 10px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 10px 8px;
    z-index: 9998;
    box-shadow: -2px 0 10px rgba(0,0,0,0.2);
}
#accessibility-bar button {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 6px;
    background: #ffffff;
    color: #1f2d3d;
    font-weight: 700;
    cursor: pointer;
    font-size: 14px;
}
#accessibility-bar button:hover {
    background: #f2a154;
    color: #fff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const root = document.documentElement;
    const STORAGE_KEY = 'carvix_font_scale';
    const MIN_SCALE = 80;
    const MAX_SCALE = 150;
    const STEP = 10;

    let scale = parseInt(localStorage.getItem(STORAGE_KEY)) || 100;
    applyScale(scale);

    function applyScale(value) {
        scale = Math.min(MAX_SCALE, Math.max(MIN_SCALE, value));
        root.style.fontSize = scale + '%';
        localStorage.setItem(STORAGE_KEY, scale);
    }

    document.getElementById('font-increase').addEventListener('click', function () {
        applyScale(scale + STEP);
    });

    document.getElementById('font-decrease').addEventListener('click', function () {
        applyScale(scale - STEP);
    });

    document.getElementById('font-reset').addEventListener('click', function () {
        applyScale(100);
    });
});
</script>