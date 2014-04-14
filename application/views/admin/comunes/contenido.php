            <div class="row">
				<div class="col-md-12 quicktasks">
                	<ul class="list-unstyled pull-left">
                        <?php
                        foreach ($constantData['botones_l'] as $boton => $info) {
                            $href=base_url_admin($constantData['ruta'].'/'.$info['href']);
                            echo '<li><a class="btn btn-default '.$info['css-class'].'" href="'.$href.'" title="'.$info['text'].'">'.$info['icon'].' <span>'.$info['text'].'</span></a></li>';
                        }
                        ?>
                    </ul>
					<ul class="list-unstyled pull-right">
                    	<?php
                        foreach ($constantData['botones_r'] as $boton => $info) {
                            $href=base_url_admin($constantData['ruta'].'/'.$info['href']);
                            echo '<li><a class="btn btn-default '.$info['css-class'].'" href="'.$href.'" title="'.$info['text'].'">'.$info['icon'].' <span>'.$info['text'].'</span></a></li>';
                        }
                        ?>
                    </ul>
                </div>
			</div>
			<?=$grid?>
            <!--<pre><?php /*print_r($constantData,true)*/ ?></pre>-->