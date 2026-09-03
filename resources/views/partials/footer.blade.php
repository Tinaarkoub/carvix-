<div style="background:#232a24; border-radius:24px; margin:20px; padding:40px 40px 24px; font-family:Arial,Helvetica,sans-serif; color:#dfe3dc;">

    <div style="display:flex; flex-wrap:wrap; gap:32px; justify-content:space-between; margin-bottom:32px;">

        <div style="flex:1; min-width:200px;">
            <div style="font-weight:bold; font-size:20px; color:#fff; margin-bottom:10px;">carvix</div>
            <p style="font-size:13px; opacity:.75; line-height:1.6; max-width:240px; margin:0;">
                Louez la voiture parfaite en toute simplicité. Réservation rapide, prix transparents.
            </p>
        </div>

        <div style="flex:1; min-width:160px;">
            <div style="font-size:13px; font-weight:bold; color:#fff; margin-bottom:12px; opacity:.9;">Navigation</div>
            <div style="display:flex; flex-direction:column; gap:8px; font-size:13px;">
                <a href="{{ route('home') }}" style="color:#dfe3dc; opacity:.75; text-decoration:none;">Accueil</a>
                <a href="{{ route('catalogue.index') }}" style="color:#dfe3dc; opacity:.75; text-decoration:none;">Catalogue</a>
                <a href="mailto:carvixcarvix@gmail.com" style="color:#dfe3dc; opacity:.75; text-decoration:none;">Contacter l'administration</a>
            </div>
        </div>

        <div style="flex:1; min-width:160px;">
            <div style="font-size:13px; font-weight:bold; color:#fff; margin-bottom:12px; opacity:.9;">Contact</div>
            <div style="display:flex; flex-direction:column; gap:8px; font-size:13px; opacity:.75;">
                <span>carvixcarvix@gmail.com</span>
                <span>Paris, France</span>
            </div>
        </div>

    </div>

    <div style="border-top:1px solid rgba(255,255,255,.12); padding-top:16px; text-align:center; font-size:12px; opacity:.55;">
        © {{ date('Y') }} Carvix — Tous droits réservés
    </div>

</div>