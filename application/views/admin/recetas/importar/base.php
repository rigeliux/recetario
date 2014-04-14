            <link rel="stylesheet" href="assets/css/uploadifive.css">
			<script src='assets/js/jquery.uploadifive.min.js' type='text/javascript'></script>
			<script src='assets/js/updater.js' type='text/javascript'></script>
            <div class="row-fluid no-margin">
				<div class="span12">
					<div class="box">
                    	<div class="box-head"><h4><?php echo $titulo;?></h4></div>
                        <div class="box-content">
							<p>Seleccione un archivo a subir, <strong>tiene que ser ZIP</strong>.</p>
                            <p>Presione el botón subir.</p><br>
                            <div>
                                <input type="text" id="files" name="files" >
                                <div class="clear"></div>
                            </div>
                            <div class="clearfix"></div>
                            <button type="button" id="subir" class="btn btn-primary">Subir</button>
                            <br><br>
                            <div id="progressbar"></div>
                            <div id="respuesta">
                            	
                            </div>
                        </div>
                    </div>
                </div>
			</div>