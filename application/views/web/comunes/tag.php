<div class="pa-l-2x">
    <p class="tag-sugeridos m-v-small">Tags sugeridos:
		<?php 
		foreach ($tags as $tag) {
    		$txt.='<a href="'.site_url('etiqueta/'.$tag['categoria_slug']).'">'.$tag['categoria_nombre'].'</a> | ';
   		}
   		echo substr($txt,0,strlen($txt)-2);
   		?>
    </p>
</div>