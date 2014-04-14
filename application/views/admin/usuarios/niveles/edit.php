<div id="high-cont">
	<form method="post" class="target" action="<?=site_url("admin/funcion/doUpdate")?>">
		<input type="hidden" name="funcion" id="funcion" value="edit"/>
        <input type="hidden" name="info" id="info" value="usuario_nivel"/>
        <input type="hidden" name="nivel[id]" id="id" value="<?=$data[ugrp_id]?>"/>
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
                                <input type="text" placeholder="Nombre del nivel" class="span12" name="nivel[nombre]" data-rule-required="true" value="<?=$data[ugrp_name]?>">
                            </div>
                        </div>
                        <div class="span6">
                            <div class="control-group">
                                <label>Descripción</label>
                                <input type="text" placeholder="Descripción del nivel" class="span12" name="nivel[desc]" data-rule-required="true" value="<?=$data[ugrp_desc]?>">
                            </div>
                        </div>
					</div>
                    <div class="row-fluid">
                        <div class="span12">
                        	<div class="control-group">
                                <label>Privilegios</label>
							</div>
                            <table class="table table-striped table-media table-bordered thead">
                                <thead>
                                    <tr>
                                        <th class="valing-middle c40">Sección</th>
                                        <th class="c10">
                                            <span class="icon-stack" title="VER">
                                              <i class="icon-check-empty icon-stack-base icon-2x"></i>
                                              <i class="icon-eye-open icon-2x"></i>
                                            </span>
                                        </th>
                                        <th class="c10"><i class="icon-plus-sign-alt icon-2x" title="INSERTAR"></i></th>
                                        <th class="c10"><i class="icon-edit-sign icon-2x" title="EDITAR"></i></th>
                                        <th class="c10"><i class="icon-minus-sign-alt icon-2x" title="ELIMINAR"></i></th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="slim">
                                <?=$privileges?>
                            </div>
						</div>
					</div>
					<?php //echo '<pre>'.print_r($privileges,true).'</pre>'; ?>
                    
                </div>
               
			</div>
		</div>
        <div class="clearfix"></div>
        <div class="well">
			<div class="pull-right">
            	<button type="submit" id="guardar" class="btn btn-primary"><i class="icon-ok icon-white"></i> Guardar</button>
                <button type="button" id="" class="btn btn-danger cancelar" data-identificador='{"seccion":"usuarios"}'><i class="icon-remove icon-white"></i> Cancelar</button>
            </div>
        </div>
	</form>
</div>