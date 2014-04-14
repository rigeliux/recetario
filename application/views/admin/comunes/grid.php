<div class="row">
	<div class="col-md-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?=$titulo?></h3>
			</div>
			<div class="panel-body">
				<form id="form1" class="form_Kool" method="post">
					<?php 
					echo $gridd[koolajax]->Render();
					echo $gridd[grid]->Render();
					?>
				</form>
			</div>
		</div>
	</div>
</div>