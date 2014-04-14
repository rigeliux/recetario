<?php
$cook_time = explode(' hr(s) ',$data['tiempo_preparacion']);
$hrs= $cook_time[0];
$min= str_replace(' min(s)','',$cook_time[1]);

$ingredientes='';
foreach ($data['ingredientes'] as $ingrediente) {
    $ingredientes.= $ingrediente["ingrediente"]."\n";
}
$ingredientes=substr($ingredientes,0,strlen($ingredientes)-1);

$img = 'assets/images/recetas/thumb-720x137/'.$data['imagen'];
if ($data['imagen']=='' || !file_exists($img)) {
     $img = 'assets/images/recetas/thumb-720x137/nodisp.jpg';
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 no-pa">
            <div id="high-cont">
            	<form method="post" class="target" action="<?=site_url("admin/funcion/doUpdate")?>">
            		<input type="hidden" name="funcion" id="funcion" value="edit"/>
            		<input type="hidden" name="info" id="info" value="receta_listado"/>
                    <input type="hidden" name="receta[id]" id="id" value="<?=$data['receta_id']?>">
                	<div class="loading" style="width:100%; height:100%;"></div>
            		<div id="contenido" class="clearfix">
            			<ul>
            				<li><a href="<?=$constant['site_url']?>#tabs-1">General</a></li>
                            <li><a href="<?=$constant['site_url']?>#tabs-2">Imagen</a></li>
            			</ul>
                        <div class="items">
                        
                            <div id="tabs-1">
                            	<div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Nombre</label>
                                            <input type="text" placeholder="Nombre de la receta" class="form-control" name="receta[nombre]" data-rule-required="true" value="<?=$data['receta_nombre']?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <label class="control-label">Tiempo de Preparación</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="hr(s)" class="col-md-9 spinnerhrs spin" name="receta[hrs]" data-rule-required="true"  value="<?=$hrs?>">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" placeholder="min(s)" class="col-md-9 spinnermins spin" name="receta[mins]" data-rule-required="true"  value="<?=$min?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Ingredientes (uno por linea)</label>
                                            <textarea class="form-control" rows="5" name="receta[ingredientes]" placeholder="Ingredientes (uno por linea)"><?=$ingredientes?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12">
                                                Preparación
                                                <button class="btn btn-default btn-xs add-input pull-right">
                                                    <span class="fa-stack">
                                                        <i class="fa fa-square-o fa-stack-2x"></i>
                                                        <i class="fa fa-plus fa-stack-1x"></i>
                                                    </span>
                                                </button>
                                            </label>
                                            <div class="col-md-12 input-recept">
                                                <?php foreach($data['instrucciones'] as $instruccion) : ?>
                                                <input type="text" class="form-control" name="receta[preparacion][]" value="<?=$instruccion['instruccion']?>">
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            
                            <div id="tabs-2">
                            	<div class="clearfix"></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="control-group" style="position:relative;">
                                            <label class="label-img">Imagen</label>
                                            <input id="upfotos" type="hidden" name="receta[imagen]" data-rule-required="true" value='<?=$data['imagen']?>'>
                                            <input id="bannerfoto" type="file" ><a href="#" class="fotos-btn btn btn-default">Subir</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="upload-queue" class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="fotos-lista">
                                            <img src="<?=$img?>">
                                        </div>
                                    </div>
                                </div>
            				</div>
                           
            			</div>
            		</div>
                    
                    <div class="well clearfix">
            			<div class="pull-right">
                        	<button type="submit" id="guardar" class="btn btn-primary"><i class="icon-ok icon-white"></i> Guardar</button>
                            <button type="button" id="" class="btn btn-danger cancelar" data-identificador='{"seccion":"listado"}'><i class="icon-remove icon-white"></i> Cancelar</button>
                        </div>
                    </div>
            	</form>
            </div>
        </div>
    </div>
</div>