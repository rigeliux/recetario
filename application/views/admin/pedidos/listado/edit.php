<div id="high-cont">
	<form method="post" class="target">
		<input type="hidden" name="funcion" id="funcion" value="edit">
    	<div class="loading" style="width:100%; height:100%;"></div>
		<div id="contenido">
			<ul>
				<li><a href="<?=$constant['site_url']?>#tabs-1">General</a></li>
			</ul>
            <div class="items">
            
                <div id="tabs-1">
                	<div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="control-group">
                                <label>Usuario</label>
                            </div>
                            <?php
                            $usuario = unserialize(base64_decode($data['pedido_usuario_info']));
                            ?>
                            <p>
                                <strong>Nombre:</strong> <?=$usuario[nombre]?><br>
                                <strong>E-mail:</strong> <?=$usuario[email]?><br>
                                <strong>Teléfono:</strong> <?=$usuario[tel]?><br>
                                <strong>Información extra:</strong> <?=nl2br($usuario[mensaje])?><br>
                            </p>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="control-group">
                                <label>Lista de items Solicitados</label>
                            </div>
                            <table class="table table-striped table-media table-bordered thead text-10">
                                <thead>
                                    <tr>
                                        <th class="valing-middle c20">CLAVE</th>
                                        <th class="valing-middle c50">PRODUCTO</th>
                                        <th class="valing-middle c10">CANTIDAD</th>
                                        <th class="valing-middle c20">P.Unitario</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="slim">
                                <table class="table table-striped table-media table-bordered tbody text-10">
                                    <?php 
                                    $items = unserialize(base64_decode($data['pedido_carrito']));
                                    foreach ($items as $key => $item):?>
                                    <tr>
                                        <td class="c20"><?=$item['id']?></td>
                                        <td class="c50"><?=substr(strip_tags($item['name']),0,60).(strlen($item['name'])>60 ? '...':'')?></td>
                                        <td class="c10"><?=$item['quantity']?></td>
                                        <td class="text-center c20">$<?=number_format($item['price'],2)?> MNX</td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td class="c80 text-right" colspan="3"><h5>TOTAL</h5></td>
                                        <td class="c20"><strong>$ <?=number_format($data['pedido_total'],2)?></strong></td>
                                    </tr>
                                </table>
                            </div>
                                
                        </div>
                    </div>

                </div>
			</div>
		</div>
        <div class="clearfix"></div>
        <div class="well">
			<div class="pull-right">
                <button type="button" class="btn btn cerrar" data-identificador='{"seccion":"pedidos"}'>Cerrar</button>
            </div>
        </div>
	</form>
</div>