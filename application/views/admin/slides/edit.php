<div id="high-cont">
	<form method="post" class="target" action="<?=site_url("admin/funcion/doUpdate")?>">
		<input type="hidden" name="funcion" id="funcion" value="edit"/>
		<input type="hidden" name="info" id="info" value="slide_listado"/>
		<input type="hidden" name="slide[id]" id="id" value="<?php echo $data['image_id']; ?>"/>
    	<div class="loading" style="width:100%; height:100%;"></div>
		<div id="contenido">
			<ul>
				<li><a href="<?=$constant['site_url_simple']?>#tabs-1">General</a></li>
			</ul>
            <div class="items">
            
                <div id="tabs-1">
                	<div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <label>Titulo</label>
                                <input type="text" placeholder="Titulo de la imagen" class="span12" name="slide[titulo]" value="<?php echo $data['image_titulo']; ?>" data-rule-required="true">
                            </div>
                        </div>
                         <div class="span6">
                            <div class="control-group">
                                <label>Enlace</label>
                                <input type="text" placeholder="Enlace / Link" class="span12" name="slide[link]" value="<?php echo $data['image_ref']; ?>">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <label>Orden</label>
                                <input type="text" placeholder="Posición en el slide" class="span12" name="slide[orden]" value="<?php echo $data['image_orden']; ?>" >
                            </div>
                        </div>
					</div>
                    
                    <div class="row-fluid">
                    	<div class="span12">
                            <div class="control-group" style="position:relative;">
                                <label class="label-img">Imagenes</label>
                                <input id="upfotos" type="hidden" name="slide[imagenes]" data-rule-required="true" value='<?php echo $data['image_nombre']; ?>'>
                                <input id="bannerfoto" type="file" ><a href="#" class="fotos-btn btn">Subir</a>
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
                            <div id="fotos-lista"><img src="assets/images/slides/thumb-720x137/<?php echo $data['image_nombre']; ?>"></div>
                        </div>
                    </div>
                </div>

			</div>
		</div>
        <div class="clearfix"></div>
        <div class="well">
			<div class="pull-right">
            	<button type="submit" id="guardar" class="btn btn-primary"><i class="icon-ok icon-white"></i> Guardar</button>
                <button type="button" id="" class="btn btn-danger cancelar" data-identificador='{"seccion":"slides" }'><i class="icon-remove icon-white"></i> Cancelar</button>
            </div>
        </div>
	</form>
</div>