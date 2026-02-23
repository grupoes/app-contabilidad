<ul class="metismenu" id="sidenav">
    <li>
        <a href="/home">
            <div class="parent-icon"><i class="material-icons-outlined">home</i>
            </div>
            <div class="menu-title">Inicio</div>
        </a>
    </li>

    <?php if (session()->get('user')['role'] === 'contribuyente'): ?>
        <li>
            <a href="/sello-firma">
                <div class="parent-icon"><i class="material-icons-outlined">fingerprint</i>
                </div>
                <div class="menu-title">Sello y Firma</div>
            </a>
        </li>
        <!--<li>
            <a href="/administrador-archivos">
                <div class="parent-icon"><i class="material-icons-outlined">folder</i>
                </div>
                <div class="menu-title">Administrador de Archivos</div>
            </a>
        </li>-->
    <?php endif; ?>
</ul>