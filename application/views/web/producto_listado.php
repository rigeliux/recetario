<?php if($a%3==0): ?>
<li class="clearfix"></li>
<?php endif; ?>
<li class="span4 pa-b <?=(( $a%3==0) ? 'no-m-left':'')?>">
	<div class="producto">
		<div class="producto-img p-r pa-b">
			<a href="#" rel="nofollow" data-item="<?=ltrim($producto_id,0)?>" class="add-carrito btn btn-azul" title="Agregar al carrito"><i class="fa fa-shopping-cart fa-2x c-crema"></i></a>
			<?php
			$img_src = "assets/images/productos/thumb-300x300/$imagen[image_nombre]";
			if (!is_file($img_src)) {
				$img_src = "assets/images/extras/no-disp.jpg";
			}
			?>
			<a href="<?=site_url('producto/'.$enlace)?>" title="<?=$cleanNombre?>"><img src="<?=$img_src?>" alt="<?=$cleanNombre?>"></a>
		</div>
		<div class="producto-info">
			<div class="producto-titulo">
				<a href="<?=site_url('producto/'.$enlace)?>" title="<?=$cleanNombre?>"><h4 class="semi-ital c-azul"><?=$producto_nombre?></h4></a>
			</div>
			<div class="producto-desc">
				<p><?=$producto_detalles[0]?></p>
			</div>
			<div class="producto-precio">
				<hr class="bc-azul">
				<div class="row">
					<div class="span2">
						<p class="c-azul"><strong>$<?=number_format($producto_precio,2)?> MXN</strong></p>
					</div>
					<div class="span2">
						<p class="text-right"><a href="<?=site_url('producto/'.$enlace)?>" title="<?=$cleanNombre?>" class="c-azul"><strong>Ver más &#x25B6;</strong></a></p>
					</div>
				</div>
				<hr class="bc-azul">
			</div>
		</div>
	</div>
</li>