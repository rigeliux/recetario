<!doctype html>
<html>
<head>
<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<base href="<?php echo base_url(); ?>" class="baseweb">
<title><?php echo $titulo.$siteName; ?></title>
<meta charset="utf-8">
<meta name="description" content="<?=$desc?>">
<meta name="keywords" content="<?=$keywords?>">
<!--<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />-->
<link rel="stylesheet" href="assets/css/font/opensans/stylesheet.css">
<link rel="stylesheet" href="assets/css/bootstrap.css">
<!--<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">-->
<link rel="stylesheet" href="assets/css/font/fontAwesome.4/font-awesome.min.css">
<link href="assets/css/flexslider.css" rel="stylesheet">
<?php echo $css; ?>
<link href="assets/css/loading.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
<link href="assets/css/bootstrap.custom.css" rel="stylesheet">

<!--[if lt IE 9]><link href='assets/css/style.ie.css' rel='stylesheet' type='text/css' ><![endif]-->
</head>

<body>
<div id="principal">
    <!-- HEADER 
    ***************************-->
    <div id="roof">
        <div class="bg-crema pa-v">
            <div class="container">
                <div class="row">
                    <div class="span3">
                        <div class="pa-l-2x">
                            <a href="http://www.facebook.com/Creatibooks" target="_blank" class="c-azul semi">
                                <i class="fa fa-facebook-square fa-lg"></i> Creatibooks Mérida
                            </a>
                        </div>
                    </div>
                    <div class="span5 offset4 text-right">
                        <div class="pa-r-2x">
                            <p class="no-margin semi">
                                <a href="carrito/" class="c-azul"><i class="fa fa-lg fa-shopping-cart"></i><span class="m-l">Ver pedido</span></a> |
                                <span class="total-cart c-azul"><?=$total_items?> libros: $<?=number_format($total,2)?></span> |
                                <a href="ayuda" class="c-azul">Ayuda</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- HEADER 
    ***************************-->
	<div id="top">
        
        <!-- MENU 
	    ***************************-->
        <div class="bg-azul pa-v">
            <div class="container">
                <div class="row">
                    <div class="span5">
                        <div class="pa-l-2x">
                            <a href="<?=site_url()?>"><img src="assets/images/logo.png" alt=""></a><br>
                            <ul class="menu inline m-t no-m-bottom">
                                 <li class="<?=(($padre=='home' || $padre=='')?'select':'')?>"><a href="<?=site_url()?>">INICIO</a></li
                                ><li class="<?=(($padre=='catalogo')?'select':'')?>"><a href="<?=site_url('catalogo')?>">CATÁLOGO</a></li
                                ><li class="<?=(($padre=='contacto')?'select':'')?>"><a href="<?=site_url('contacto')?>">CONTACTO</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="span2 offset5">
                        <div class="pa-r-2x text-right">
                            <img src="assets/images/logo-min.jpg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pa-v">
            <div class="container">
                <div class="row">
                    <div class="span8">
                        <?=$tagOrTitle?>
                    </div>
                    <div class="span4 text-right">
                        <div class="pa-r-2x">
                            <form action="buscar/" method="post" class="form-inline">
                                <input type="text" placeholder="Buscar" name="search" class="span3" value="<?=$query_string?>">
                                <button class="btn btn-azul pa-h-2x"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="span12">
                        <hr class="bc-azul no-m-top">
                    </div>
                </div>
            </div>
        </div>
        
    </div><!-- .end HEADER-->
    
