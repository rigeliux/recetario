<div class="ultimo" id="contenido">
	<div>
		<div class="container">
			<div class="row">
				<div class="span6 offset1">
					<p class="semi">¿Tienes dudas o comentarios?<br>Escríbenos y te responderemos en breve.</p>
					<form class="target" method="post">
						<input type="hidden" name="funcion" value="contacto">
						<div class="control-group">
							<div class="controls">
								<input name="contacto[nombre]" type="text" class="input-block-level" placeholder="Nombre completo" data-rule-required="true">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<input name="contacto[tel]" type="text" class="input-block-level" placeholder="Teléfono">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<input name="contacto[email]" type="text" class="input-block-level" placeholder="E-mail" data-rule-required="true" data-rule-email="true">
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<textarea name="contacto[mensaje]" name="" class="input-block-level" rows="5" placeholder="Mensaje" data-rule-required="true"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="span4">
								<p class="semi text-legal"><small>Sus datos serán usados de acuerdo a los <a href="<?=site_url('aviso')?>" class="">términos de la Ley Federal de Protección de Datos Personales</a></small></p>
							</div>
							<div class="span2">
								<button class="btn btn-azul btn-large input-block-level">ENVIAR</button>
							</div>
						</div>
					</form>
				</div>
				<div class="span4 c-azul">
					<h5 class="semi">Contáctanos:</h5>
					<hr class="bc-azul">
					<p class="semi">¿Deseas hablar directamente con nosotros?<br>¡Llámanos!</p>
					
					<p>Mónica Ramírez Sánchez / Representante.</p>
					<p>Celular: (044)9993 70 89 94<br>E-mail: <?=safe_mailto('info@creatibooks.com')?></p>
					<br>
					<p>Victor Ramos Ramírez / Representante.</p>
					<p>Celular: (044)9991 33 30 90<br>E-mail: <?=safe_mailto('info@creatibooks.com')?></p>

					<p>Síguenos en Facebook: <a class="" href="http://www.facebook.com/Creatibooks" target="_blank">Creatibooks</a></p>
				</div>
			</div>
		</div>
	</div>
</div>