<div class="ultimo" id="contenido">
	<div>
		<div class="container">
			<div class="row">
				<div class="span8 offset2">
					<div class="row">
						<div class="span2 offset6 text-right pa-b">
							<a href="<?=site_url($volver_href)?>" title="Regresar al Catálogo" class="c-azul"><i class="fa fa-reply"></i> Regresar al catálogo</a>
						</div>
					</div>
					<div class="galeria">
					<?php 
					if(count($item['images'])>0):
						foreach($item['images'] as $image): ?>
						<a href="assets/images/productos/thumb-620x320/<?=$image['image_nombre']?>" title=""><img src="assets/images/productos/thumb-80x80/<?=$image['image_nombre']?>" data-big="assets/images/productos/<?=$image['image_nombre']?>" alt=""></a>
					<?php 
						endforeach;
					else: ?>
						<a href="assets/images/extras/no-disp.jpg" title=""><img src="assets/images/extras/no-disp-80.jpg" alt=""></a>
					<?php endif; ?>
						
					</div>
					<div class="row">
						<div class="span8">
							<h4 class="semi c-azul"><?=$item['producto_nombre']?></h4>
							<hr class="bc-azul">
							<?=nl2p($item['producto_detalles'],false)?>
							<div class="row">
								<div class="span4">
									<p>Datos técnicos:</p>
									<ul>
										<?=nl2li($item['producto_datos_tecnicos'])?>
									</ul>
								</div>
								<div class="span4">
									<div class="text-right">
										<a href="#" rel="nofollow" data-item="<?=ltrim($item['producto_id'],0)?>" class="btn btn-large add-carrito btn-azul">Añadir <i class="fa fa-lg fa-shopping-cart"></i></a><br><br>
										<a href="<?=site_url($volver_href)?>" title="Regresar al Catálogo" class="c-azul"><i class="fa fa-reply"></i> Regresar al catálogo</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>