		<div class="navi">
			<ul class='main-nav'>
				<li class="<?=($padre=='inicio' || $padre=='') ? 'active':''?>">
					<a href="admin/" class='light'>
						<div class="ico"><i class="fa fa-home icon-white"></i></div>
						Inicio
					</a>
				</li>
                <li class="<?=($padre=='slides') ? 'active':''?>">
					<a href="admin/slides" class='light'>
						<div class="ico"><i class="fa fa-picture-o icon-white"></i></div>
						Slides
					</a>
				</li>
				<li class="<?=($padre=='productos' ? 'active open':'')?>">
					<a href="#" class='light toggle-collapsed'>
						<div class="ico"><i class="fa fa-th-list icon-white"></i></div>
						Productos
						<span class="icono menu subnav subnav-down"></span>
					</a>
					<ul class='collapsed-nav <?=($padre=='productos' ? 'open':'closed')?>'>
						<li class="<?=(($padre=='productos' && $hijo=='listado') ? 'active':'')?>"><a href="admin/productos/listado">Listado</a></li>
                        <li class="<?=(($padre=='productos' && $hijo=='categorias') ? 'active':'')?>"><a href="admin/productos/categorias">Categorias</a></li>
					</ul>
				</li>
                <li class="<?=($padre=='pedidos') ? 'active':''?>">
					<a href="admin/pedidos/listado" class='light'>
						<div class="ico"><i class="fa fa-credit-card icon-white"></i></div>
						Pedidos
					</a>
				</li>
				<li class="<?=($padre=='usuarios') ? 'active':''?>">
					<a href="#" class='light toggle-collapsed'>
						<div class="ico"><i class="fa fa-user icon-white"></i></div>
						Usuarios
						<span class="icono menu subnav subnav-down"></span>
					</a>
					<ul class='collapsed-nav <?=($padre=='usuarios' ? 'open':'closed')?>'>
						<li class="<?=(($padre=='usuarios' && $hijo=='listado') ? 'active':'')?>"><a href="admin/usuarios/listado">Listado</a></li>
					</ul>
				</li>
			</ul>
		</div>