<ul class="menu menu_hor menu_rojo clearfix">
    <li class="<?php echo ( ($seccionActiva=='' || $seccionActiva=='inicio') ? 'select':''); ?>"><a href="./" class="">Inicio</a></li>
    <li class="<?php echo ( ($seccionActiva!='' && $seccionActiva=='empresa') ? 'select':''); ?>"><a href="empresa/" class="">Empresa</a></li>
    <li class="<?php echo ( ($seccionActiva!='' && $seccionActiva=='pisos') ? 'select':''); ?>"><a href="pisos/" class="">Pisos</a></li>
    <li class="<?php echo ( ($seccionActiva!='' && $seccionActiva=='construccion') ? 'select':''); ?>"><a href="construccion/" class="">Construcción</a></li>
    <li class="<?php echo ( ($seccionActiva!='' && $seccionActiva=='galeria') ? 'select':''); ?>"><a href="galeria/" class="">Galería</a></li>
    <li class="last <?php echo ( ($seccionActiva!='' && $seccionActiva=='contacto') ? 'select':''); ?>"><a href="contacto/" class="">Contacto</a></li>
</ul>