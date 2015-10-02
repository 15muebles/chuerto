<?php
/* Template name: Home page */
get_header();

// custom post types info
global $wp_post_types;

// descubre, aprende, haz bands
$band_pts = array("badge","actividad","proyecto");
$band_tits = array("Itinerario","Agenda","Proyecto");
?>

<div id="top" class="container-full">
<div class="container">
<header class="aligncenter">
	<div class="row hair">
		<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
			<img id="chuerto-imago" src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-imago.star.png" alt="<?php echo CHUERTO_BLOGNAME. " | " . CHUERTO_BLOGDESC; ?>" />
			<h1 class="hideout"><?php echo CHUERTO_BLOGNAME ?></h1>
			<h2 id="main-subtit"><?php echo CHUERTO_BLOGDESC ?></h2>
			<div id="main-desc">Un itinerario formativo que recoge los aprendizajes y experiencias que se están poniendo en juego en los huertos urbanos comunitarios de la ciudad de Madrid.</div>
		</div>
	</div>
</header>
<section class="aligncenter">
	<div class="row hair">
		<div class="col-md-2 col-md-offset-5 chuerto-smooth">
			<a class="btn-chuerto" href="#proyecto">Proyecto</a>
		</div>
	</div>
	<div class="row patrocina">
		<div class="col-md-8 col-md-offset-2">
			<ul class="list-inline">
			<li><img class="patrocina-sec" src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-habitat-dark.png" alt="Hábitat Madrid" /></li>
			<li><img class="patrocina-main" src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-rehu-dark.png" alt="Red de Huertos Urbanos de Madrid" /></li>
			<li><img class="patrocina-ter" src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-cescuela-dark.png" alt="Museo Nacional Centro de Arte Reina Sofia" /></li>
			<li><img class="patrocina-sec" src="<?php echo CHUERTO_BLOGTHEME; ?>/images/chuerto-intermediae-dark.png" alt="Intermediae" /></li>
			</ul>
		</div>
	</div>
</section>
</div><!-- .container -->

</div><!-- .container-full -->

<?php
// BEGIN bands loop
$band_count = 0;
foreach ( $band_pts as $band_pt ) {

	// IF IS NOT PROJECT
	if ( $band_pt != 'proyecto') {
		// pt vars
		$band_tit = $wp_post_types[$band_pt]->labels->parent; 
		$band_subtit = $wp_post_types[$band_pt]->labels->name;
		$band_desc = $wp_post_types[$band_pt]->description;
	}

	// IF ITINERARIOS OR BADGES
	if ( $band_pt == 'itinerario' || $band_pt == 'badge' ) {

		// loop args
		if ( $band_pt == 'badge' )  {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => $band_pt,
			'orderby' => 'menu_order title',
			'order' => 'ASC',
		);

		} elseif ( $band_pt == 'itinerario' ) {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => $band_pt,
			'orderby' => 'menu_order',
			'order' => 'ASC',
		);
		}

		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) { ?>

		<div id="<?php echo $band_pt; ?>" class="container-full">
		<div class="container">
		<section>
			<header class="sec-header row hair">
			<div class="col-md-12 col-sm-12">
				<div class="sec-tit">
					<h2><?php echo $band_tit; ?></h2>
					<div class="sec-subtit"><?php echo $band_subtit; ?></div>
				</div>
				<div class="sec-desc"><p><?php echo $band_desc; ?></p></div>
			</div>
			</header><!-- .sec-header .row .hair-->
			<div class="mosac row hair">
			<?php
			// BEGIN *THIS* band loop
			$tablet_count = 0;
			$desktop_count = 0;
			while ( $the_query->have_posts() ) : $the_query->the_post();
				if ( $tablet_count == 4 ) { $tablet_count = 0; echo '<div class="clearfix visible-sm"></div>';  }
				if ( $desktop_count == 4 ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
				$tablet_count++; $desktop_count++;
				include "loop-mosac.php";

			endwhile;
			// END *THIS* band loop
			?>
			</div><!-- .mosac .row .hair -->

		</section>
		</div><!-- .container -->
		</div><!-- .container-full -->

		<?php } // end if have posts


	// IF ACTIVIDADES
	} elseif ( $band_pt == 'actividad' ) {
		$current = time();
		// future actividades
		$act_tits[] = "Actividades programadas";
		$act_args[] = array(
			'posts_per_page' => -1,
			'post_type' => $band_pt,
			'orderby' => 'meta_value_num',
			'meta_key' => '_chuerto_date_begin',
			'order' => 'ASC',
			'meta_query' => array(
				array(
					'key' => '_chuerto_date_begin',
					'value' => $current,
					'compare' => '>'
				)
			)
		);
		// current actividades
		$act_tits[] = "Actividades en curso";
		$act_args[] = array(
			'posts_per_page' => -1,
			'post_type' => $band_pt,
			'orderby' => 'meta_value_num',
			'meta_key' => '_chuerto_date_begin',
			'order' => 'ASC',
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => '_chuerto_date_begin',
					'value' => $current,
					'compare' => '<'
				),
				array(
					'key' => '_chuerto_date_end',
					'value' => $current,
					'compare' => '>'
				)
			)
		);
		// past actividades
		$act_tits[] = "Actividades finalizadas";
		$act_args[] = array(
			'posts_per_page' => -1,
			'post_type' => $band_pt,
			'orderby' => 'meta_value_num',
			'meta_key' => '_chuerto_date_begin',
			'order' => 'DESC',
			'meta_query' => array(
				array(
					'key' => '_chuerto_date_end',
					'value' => $current,
					'compare' => '<'
				)
			)
		); ?>


		<div id="<?php echo $band_pt; ?>" class="container-full">
		<div class="container">
			<header class="sec-header row hair">
			<div class="col-md-12 col-sm-12">
				<div class="sec-tit">
					<h2><?php echo $band_tit; ?></h2>
				</div>
				<div class="sec-desc"><p><?php echo $band_desc; ?></p></div>
			</div>
			</header><!-- .sec-header .row .hair-->

			<?php // actividades loops
			$act_count = 0;
			foreach ( $act_args as $args ) {

				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) { ?>

				<section>
				<div class="row">
					<header class="col-md-12 col-sm-12">
					<h3 class="sec-part-tit"><?php echo $act_tits[$act_count]; ?></h3>
					</header>
				</div><!-- .row .hair -->
				<div class="mosac row hair">
				<?php $tablet_count = 0;
				$desktop_count = 0;
				while ( $the_query->have_posts() ) : $the_query->the_post();
					if ( $tablet_count == 4 ) { $tablet_count = 0; echo '<div class="clearfix visible-sm"></div>';  }
					if ( $desktop_count == 4 ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
					$tablet_count++; $desktop_count++;
					include "loop-mosac.php";

				endwhile; ?>

				</div><!-- .mosac .row .hair -->
				</section>

			<?php 	} // end if have posts
				$act_count++;
			} // end actividades loop ?>

		</div><!-- .container -->
		</div><!-- .container-full -->

	<?php // IF PROYECTO PAGE
	} elseif ( $band_pt == 'proyecto' ) {
		// loop args
		$args = array(
			'post_type' => 'page',
			'pagename' => 'proyecto'
		);
		$page = get_posts($args);
		foreach ( $page as $post ) {
			setup_postdata($post);
			$band_tit = "Proyecto"; ?>

		<div id="<?php echo $band_pt; ?>" class="container-full">
		<div class="container">
		<section>
			<header class="sec-header row hair">
			<div class="col-md-12 col-sm-12">
				<div class="sec-tit">
					<h2><?php echo $band_tit; ?></h2>
					<div class="sec-subtit"><?php the_title(); ?></div>
				</div>
				<div class="sec-desc"><p><?php echo get_the_excerpt(); ?></p></div>
			</div>
			</header><!-- .sec-header .row .hair-->

			<div class="row hair">
				<div class="col-md-8 col-sm-8"><?php the_content(); ?></div>
			</div><!-- .row .hair -->
		</section>
		</div><!-- .container -->
		</div><!-- .container-full -->

		<?php } // end foreach
		wp_reset_postdata();

	} // END if PROYECTO PAGE

	$band_count++;
}
// END bands loop
?>

<?php get_footer(); ?>
