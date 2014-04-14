	<div id="contenido" class="ultimo">
        <div class="">
        	<div class="container">
				<!-- SLIDER 
	    		***************************-->
                <div class="row">
                    <div class="span12 theme-default">
                        <div id="slider" class="nivoSlider">
                        <?php foreach($images as $image): ?>
                            <img src="assets/images/slides/thumb-940x440/<?=$image['image_nombre']?>" alt="" >
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="span12">
                		<hr class="bc-azul">
                	</div>
                </div>
            </div>
		</div>
    </div>