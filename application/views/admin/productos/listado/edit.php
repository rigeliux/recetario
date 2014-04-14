<div id="high-cont">
	<form method="post" class="target" action="<?=site_url("admin/funcion/doUpdate")?>">
		<input type="hidden" name="funcion" id="funcion" value="edit">
        <input type="hidden" name="info" id="info" value="producto_listado">
        <input type="hidden" name="producto[id]" id="id" value="<?=$data[producto_id]?>">
    	<div class="loading" style="width:100%; height:100%;"></div>
		<div id="contenido">
			<ul>
				<li><a href="<?=$constant['site_url']?>#tabs-1">General</a></li>
                <li><a href="<?=$constant['site_url']?>#tabs-2">Imagen</a></li>
			</ul>
            <div class="items">
            
                <div id="tabs-1">
                	<div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="control-group">
                                <label>Nombre</label>
                                <input type="text" placeholder="Nombre del producto" class="span12" name="producto[nombre]" data-rule-required="true" value="<?=$data[producto_nombre]?>">
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label>Clave del producto</label>
                                <input type="text" placeholder="Clave del producto" class="span12" name="producto[clave]" data-rule-required="true" value="<?=$data[producto_clave]?>">
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label>Precio</label>
                                <div class="input-prepend input-append">
                                    <span class="add-on">$</span>
                                    <input type="text" class="span9" name="producto[precio]" data-rule-required="true" value="<?=number_format($data[producto_precio],0)?>">
                                    <span class="add-on">.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="span4">
                            <div class="control-group">
                                <label>Destacado</label>
                                <div class="rButton">
                                    <input type="radio" id="radio1" name="producto[destacado]" <?=($data['producto_destacado']==1 ? 'checked="checked"':'')?> value="1" class="btn btn-primary"><label for="radio1">Si</label>
                                    <input type="radio" id="radio2" name="producto[destacado]" <?=($data['producto_destacado']==0 ? 'checked="checked"':'')?> value="0" class="btn" ><label for="radio2">No</label>
                                </div>
                            </div>
                        </div>
					</div>
                    
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label>Clasificación</label>
                                <div class="raty" data-score="<?=$data[producto_rating]?>" data-name="producto[rating]"></div>
                            </div>
                        </div>
                        <div class="span8">
                            <div class="control-group">
                                <label>Etiquetas</label>
                                <input type="hidden" class="available" value="<?=base64_encode(json_encode($categoria['list']))?>">
                                <input type="text" placeholder="Etiquetas" class="span12 selectTags" name="producto[tags]" value="<?=$categoria['select']?>">
                            </div>
                        </div>
					</div>
                    
                    <div class="row-fluid">
                    	<div class="span12">
                            <div class="control-group">
                                <label>Detalles</label>
                                <textarea class="span12" rows="5" name="producto[detalles]" placeholder="Características del producto"><?=$data[producto_detalles]?></textarea>
                            </div>
                        </div>
					</div>

                    <div class="row-fluid">
                        <div class="span12">
                            <div class="control-group">
                                <label>Datos Técnicos (uno por linea)</label>
                                <textarea class="span12" rows="5" name="producto[datos_tecnicos]" placeholder="Datos Técnicos (uno por linea)"><?=$data[producto_datos_tecnicos]?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="tabs-2">
                	<div class="clearfix"></div>
                    <div class="row-fluid">
                    	<div class="span12">
                            <div class="control-group" style="position:relative;">
                                <label class="label-img">Imagen</label>
                                <input id="upfotos" type="hidden" name="producto[imagenes]">
                                <input id="productofoto" type="file" ><a href="#" class="fotos-btn btn">Subir</a>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                    	<div class="span12">
                            <div id="upload-queue" class="clearfix"></div>
                        </div>
                    </div>
                    <div class="row-fluid">
                    	<div class="span12">
                            <div id="fotos-lista">
                                <ul id="sortable">
                                <?php foreach ($images as $image): 
                                    list($nombre,$extencion) = explode('.', $image['image_nombre']);
                                    if($image['image_nombre']!='' && file_exists('assets/images/productos/thumb-80x80/'.$image['image_nombre'])):
                                ?>
                                    <li id="<?=$nombre?>">
                                        <div class="fotos-lista">
                                            <div class="eliminaImg"><a href="#<?=$image['image_nombre']?>"></a></div>
                                            <img src="assets/images/productos/thumb-80x80/<?=$image['image_nombre']?>" data-esvideo="false" class="fotos-img">
                                        </div>
                                    </li>
                                <?php endif;
                                    endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    
				</div>
               
			</div>
		</div>
        <div class="clearfix"></div>
        <div class="well">
			<div class="pull-right">
            	<button type="submit" id="guardar" class="btn btn-primary"><i class="icon-ok icon-white"></i> Guardar</button>
                <button type="button" id="" class="btn btn-danger cancelar" data-identificador='{"seccion":"listado"}'><i class="icon-remove icon-white"></i> Cancelar</button>
            </div>
        </div>
	</form>
</div>