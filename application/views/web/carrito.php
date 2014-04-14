<div class="ultimo" id="contenido">
	<div>
		<div class="container">
			<div class="row">
				<div class="span6">
					<form method="post" action="carrito/editar/" class="targetSimple">
						<table class="table table-hover cart">
							<thead>
								<tr>
									<th colspan="2" class="span3">Nombre</th>
									<th class="span1">Cantidad</th>
									<th class="span2 text-center">Precio Unitario</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								if (count($items)>0) :
									foreach ($items as $key => $item):?>
								<tr>
									<td><a href="carrito/eliminar/<?=$key?>" title="Eliminar"><i class="fa fa-times text-error"></i></a></td>
									<td><?=substr(strip_tags($item['name']),0,60).(strlen($item['name'])>60 ? '...':'')?></td>
									<td><input class="input-mini" type="text" name="item[<?=$key?>][qty]" value="<?=$item['quantity']?>" data-rule-required="true" data-rule-min="1"></td>
									<td class="text-center">$<?=number_format($item['price'],2)?> MNX</td>
								</tr>
								<?php endforeach; ?>
								<tr>
									<td colspan="3">
										<button type="submit" class="btn"><span class="fa fa-repeat"></span> Actualizar Carrito</button>
	                                    <a href="carrito/limpiar" class="btn btn-danger"><span class="fa fa-trash-o"></span> Limpiar Carrito</a>
									</td>
									<td colspan="2" class="text-right">
										<h5 class="c-azul">Total: $<?=number_format($total,2)?> MNX</h5>
									</td>
								</tr>

								<?php else : ?>
								<tr>
									<td colspan="4" class="text-center">
										<p class="no-margin"><strong>No hay nada en tu carrito</strong></p>
									</td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</form>
				</div>
				<div class="span6">
					<form class="target" method="post">
						<input type="hidden" name="funcion" value="pedido">
						<div class="control-group">
							<div class="controls">
								<p class="semi">Solicita tu pedido, sólo tienes que ingresar tus datos y en breve nos pondremos en contacto contigo. <input type="text" class="semi-hidden" data-rule-inCart="true"></p>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<input type="text" class="input-block-level" placeholder="Nombre completo" name="carrito[nombre]" data-rule-required="true">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<input type="text" class="input-block-level" placeholder="Teléfono" name="carrito[tel]">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<input type="text" class="input-block-level" placeholder="E-mail" name="carrito[email]" data-rule-required="true" data-rule-email="true" >
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<textarea class="input-block-level" rows="5" placeholder="Mensaje" name="carrito[mensaje]"></textarea>
							</div>
						</div>
						<button class="btn btn-azul btn-large">SOLICITAR PEDIDO</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>