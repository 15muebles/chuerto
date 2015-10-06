<?php
if ( is_front_page() ) { $epi_class = "home"; }
elseif ( is_single() ) { $epi_class = get_post_type(); }
elseif ( is_page() ) { $epi_class = "about"; }
elseif ( is_404() ) { $epi_class = "e404"; }
else { $epi_class = "post"; }
?>

<footer class="aligncenter">
<div id="epi" class="container-full epi-<?php echo $epi_class; ?>">

<div class="container">
	<div class="row">
		<div class="col-md-2 col-md-offset-5 col-sm-2 col-sm-offset-5 col-xs-4 col-xs-offset-4">
			<img class="img-responsive" src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-imago.star.png" alt="<?php echo CHUERTO_BLOGNAME; ?>" />
		</div>
	</div><!-- .row -->
</div><!-- .container -->
</div><!-- .container-full -->

<div id="trasepi" class="container-full">
<div class="container">
	<div class="row patrocina">
	<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
		<ul class="list-inline">
			<li><a href="http://www.programadeactividadesambientales.com/" class="patrocina-sec"><img src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-habitat-light.png" alt="Hábitat Madrid" /></a></li>
			<li><a class="patrocina-main" href="https://redhuertosurbanosmadrid.wordpress.com/"><img src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-rehu-light.png" alt="Red de Huertos Urbanos de Madrid" /></a></li>
			<li><a class="patrocina-ter" href="http://ciudad-escuela.org/"><img src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-cescuela-light.png" alt="Ciudad Escuela. Pedagogía urbana open source" /></a></li>
			<li><a class="patrocina-sec" href="http://intermediae.es/"><img src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-intermediae-light.png" alt="Intermediae" /></a></li>
		</ul>
	</div>
	</div><!-- .row -->
	<div class="row explica">
	<div class="col-md-8 col-md-offset-2">
		<div><p><strong>El contenido de <?php echo CHUERTO_BLOGNAME; ?></strong>, a menos que se indique lo contrario, está disponible para su uso bajo las condiciones de la licencia <a href="http://creativecommons.org/licenses/by-sa/4.0/deed.es_ES">Creative Commons Reconocimiento-CompartirIgual 4.0 Internacional</a>. <strong>El código de la web de <?php echo CHUERTO_BLOGNAME; ?></strong> está igualmente disponible para su uso bajo las condiciones de una licencia <a href="https://github.com/15muebles/chuerto/blob/master/LICENSE">GPL2</a>, y puede <a href="https://github.com/15muebles/chuerto">descargarse libremente</a>. La web de <?php echo CHUERTO_BLOGNAME; ?> funciona usando <a href="http://wordpress.org">WordPress</a>.</p>
			<p><a href="http://openbadges.org"><img src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-openbadges.png" alt="Openbadges -- Mozilla Foundation" /></a></p>
		</div>
	</div>
	</div><!-- .row -->
</div><!-- .container -->

</div><!-- .container-full -->
</footer>

<?php
// get number of queries
//echo "<div style='display: none;'>".get_num_queries()."</div>";
wp_footer(); ?>

</body><!-- end body as main container --></html>
</html>
