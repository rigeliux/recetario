<div id="high-cont">
	<form method="post" class="target" action="<?=site_url("admin/funcion/doUpdate")?>">
		<input type="hidden" name="funcion" id="funcion" value="edit">
        <input type="hidden" name="info" id="info" value="producto_categoria">
        <input type="hidden" name="categoria[id]" id="id" value="<?=$data[categoria_id]?>">
    	<div class="loading" style="width:100%; height:100%;"></div>
		<div id="contenido">
			<ul>
				<li><a href="<?=$constant['site_url']?>#tabs-1">General</a></li>
			</ul>
            <div class="items">
            
                <div id="tabs-1">
                	<div class="clearfix"></div>
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <label>Nombre</label>
                                <input type="text" placeholder="Nombre del genero" class="span12 strtoslugText" name="categoria[nombre]" data-rule-required="true" value="<?=$data['categoria_nombre']?>">
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label>Slug</label>
                                <input type="text" placeholder="URL slug" class="span12 strtoslugSlug" name="categoria[slug]" data-rule-required="true" value="<?=$data['categoria_slug']?>">
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
                <button type="button" id="" class="btn btn-danger cancelar" data-identificador='{"seccion":"categorias"}'><i class="icon-remove icon-white"></i> Cancelar</button>
            </div>
        </div>
	</form>
</div>