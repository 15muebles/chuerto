<?php get_header();

// pt vars
//global $pt;
$pt = $wp_query->query_vars['post_type'];

// section vars
$band_tit = $wp_post_types[$pt]->labels->parent;
$band_subtit = $wp_post_types[$pt]->labels->name;
$band_desc = $wp_post_types[$pt]->description;
$band_class = $pt;

// vars depending on the custom post type
if ( $pt == 'itinerario' ) {
	$single_subtit = "";
	$single_date_begin = "";
	$single_date_end = "";
	$single_info_out = "";
	$single_icon_id = get_post_meta( $post->ID, '_chuerto_icono_id',true );	
	if ( $single_icon_id != '' ) {
		$single_icon = wp_get_attachment_image( $single_icon_id, 'icon' );
		$single_icons_out = "<ul class='list-inline'><li>" .$single_icon. "</li></ul>";
	}
	$single_img_size = "small";
	$single_material_out = "";
	$single_como_out = "";
	$single_earners_out = "";

} elseif ( $pt == 'badge' ) {
	$single_subtit = get_post_meta( $post->ID, '_chuerto_subtit', true );
	$single_date_begin = "";
	$single_date_end = "";
	$single_info = "";

	$second_loop_args = array(
		'post_type' => 'itinerario',
		'meta_query' => array(
			array(
				'key' => '_chuerto_badges',
				'value' => '"' .$post->ID. '"',
				'compare' => 'LIKE'
			)
		)
	);
	$itinerarios = get_posts($second_loop_args);
	if ( count($itinerarios) > 0 ) {
		$single_icons_out = "<ul class='list-inline single-icons'>";
		foreach ( $itinerarios as $itinerario ) {
			$itinerario_icon_id = get_post_meta( $itinerario->ID, '_chuerto_icono_id',true );
			if ( $itinerario_icon_id != '' ) {
				$itinerario_perma = get_permalink( $itinerario->ID );
				$itinerario_tit = get_the_title( $itinerario->ID );
				$single_icons_out .= "<li><a href='" .$itinerario_perma. "' title='Itinerario: " .$itinerario_tit. "'>" .wp_get_attachment_image( $itinerario_icon_id, 'icon' ). "</a></li>";
			}
		}
		$single_icons_out .= "</ul>";
	} else { $single_icons_out = ""; }

	$single_img_size = "small";
	$single_material = get_post_meta( $post->ID, '_chuerto_material',true );
	if ( $single_material != '' ) {
		$single_material_out = "<h2>Material de trabajo</h2>" .apply_filters( 'the_content', $single_material );
	}
	else { $single_material_out = ""; }

	$single_como = get_post_meta( $post->ID, '_chuerto_badge_como',true );
	if ( $single_como != '' ) {
		$single_como_out =
			"<h2>Cómo ganar el badge</h2>"
			.apply_filters( 'the_content', $single_como );
	} else { $single_como_out = ''; }

	$single_info_out = "";

	$earners = chuerto_get_earners( get_post_meta($post->ID,'_chuerto_quincem_badge',true) );

	if ( array_key_exists('data',$earners) && $earners['data']['status'] == '404' || $earners == '' ) {
	//if ( is_wp_error($earners['data']['status']) == '404' || $earners == '' ) {
		//echo $earners->get_error_message();
		$single_earners_out = ""; 
	} else {
		$single_earners_out = "<ul class='list-inline'>";
		$earners_script = "";
		$id_count = 0;
		foreach ( $earners as $id => $e ) {
			$id_count++;
			$earner_avatar = "<img src='" .$e['avatar']. "' alt='Avatar del usuario' />";
			$earner_name = $e['name'];
			$earner_date = $e['date'];
			$earner_material = $e['material'];
			$earner_actividad = $e['actividad'];
			$single_earners_out .= "<li><a id='earner-" .$id_count. "' class='earner-click' title='" .$earner_name. "'>" .$earner_avatar. "</a></li>";
			$earners_script .= "
				jQuery('#earner-$id_count').popover({
					trigger: 'manual',
					placement: 'right',
					html: 'true',
					content: 'Fecha: " .$earner_date. "<br />Actividad realizada: " .$earner_actividad. "<br /><a href=\'" .$earner_material. "\'>Material producido</a>',
				});

			";
		}
		$single_earners_out .= "</ul>";
	}

	$solicita_out = "
		<div class='single-aside'>
			<h3>Solicitar el badge</h3>
			<p>Si has participado en alguna de las actividades asociadas a este badge puedes solicitar este badge para añadirlo a <a href='http://backpack.openbadges.org'>tu backpack</a>.</p>
			<p><a class='btn-cescuela' href='http://ciudad-escuela.org/solicita-tu-badge/?ref=chuerto'>Solicita este badge</a></p>
		</div>
	";

} elseif ( $pt == 'actividad' ) {
	$single_subtit = get_post_meta( $post->ID, '_chuerto_escenario', true );

	$single_date_begin = get_post_meta( $post->ID, '_chuerto_date_begin', true );
	$single_date_end = get_post_meta( $post->ID, '_chuerto_date_end', true );
	$single_date_begin_human = date('d\/m',$single_date_begin);
	$single_date_end_human = date('d\/m',$single_date_end);
	if ( $single_date_begin_human == $single_date_end_human ) {
		$single_date_out = $single_date_begin_human;
	} else {
		$single_date_out = $single_date_begin_human. "-" .$single_date_end_human;
	}
	$single_info = get_post_meta( $post->ID, '_chuerto_contacto', true );
	if ( $single_info != '' ) { $single_info_out = apply_filters( 'the_content', $single_info ); }
	else { $single_info_out = ""; }

	$second_loop_args = array(
		'post_type' => 'badge',
		'meta_query' => array(
			array(
				'key' => '_chuerto_actividades',
				'value' => '"' .$post->ID. '"',
				'compare' => 'LIKE'
			)
		)
	);
	$badges = get_posts($second_loop_args);
	if ( count($badges) > 0 ) {
		$single_icons_out = "<ul class='list-inline single-icons'>";
		foreach ( $badges as $badge ) {
			$badge_icon_id = get_post_meta( $badge->ID, '_chuerto_icono_id',true );
			if ( $badge_icon_id != '' ) {
				$badge_perma = get_permalink( $badge->ID );
				$badge_tit = get_the_title( $badge->ID );
				$single_icons_out .= "<li><a href='" .$badge_perma. "' title='Badge: " .$badge_tit. "'>" .wp_get_attachment_image( $badge_icon_id, 'icon' ). "</a></li>";
			}
		}
		$single_icons_out .= "</ul>";
	 } else { $single_icons_out = ""; }

	$single_img_size = "medium";
	$single_material_out = "";
	$single_como_out = "";
	$single_earners_out = "";

} // end vars depending on post type

// common vars for all post types
if ( has_post_thumbnail() ) { $single_logo = get_the_post_thumbnail($post->ID,$single_img_size,array('class' => 'img-responsive')); } else { $single_logo = ""; }
?>

<div id="<?php echo $band_class; ?>" class="container-full">
<div class="container">
	<div class="sec-header row hair">
	<div class="col-md-12 col-sm-12">
		<div class="sec-tit">
			<h2><?php echo $band_tit; ?></h2>
			<div class="sec-subtit"><?php echo $band_subtit; ?></div>
		</div>
		<div class="sec-desc"><p><?php echo $band_desc; ?></p></div>
	</div>
	</div><!-- .sec-header .row .hair-->

	<?php while ( have_posts() ) : the_post(); ?>
	<article class="row hentry">
	<div class="col-md-4 col-sm-4">
		<header class="thumbnail">
			<?php echo $single_logo; ?>
			<div class="caption aligncenter">
			<h1 class="single-tit"><?php the_title(); ?></h1>
			<?php //subtit
			if ( $single_subtit != '' ) { echo "<div class='single-subtit'>" .$single_subtit. "</div>"; }

			// date
			if ( $single_date_begin != '' && $single_date_end != '' ) { echo "<div class='single-date'>" .$single_date_out. "</div>"; }

			// icons
			if ( $single_icons_out != '' ) { echo $single_icons_out; }
			?>
			</div>
		</header>

		<?php // contact info
		if ( $single_info_out != '' ) { ?>
		<section class="single-contacto row hair">
			<div class="col-md-12 col-sd-12">
				<header><h2>Contacto</h2></header>			
				<div class="single-contacto-desc"><?php echo $single_info_out; ?></div>
			</div>
		</section>
		<?php } ?>

		<?php // earners list
		if ( $single_earners_out != '' ) { ?>
		<section class="single-earners row hair">
			<div class="col-md-12 col-sd-12">
				<header><h2>Ganaron el badge</h2></header>			
				<script type='text/javascript'>
					jQuery(document).ready(function(){
						jQuery(".earner-click").on('click', function() {
							if ( jQuery(this).hasClass("earner-active") ) {
								jQuery(this).popover("hide").toggleClass("earner-active");
							} else {
								jQuery(".earner-active").popover("hide").toggleClass("earner-active");
								jQuery(this).popover("show").addClass("earner-active");
							}
						});
						<?php echo $earners_script; ?>
					});
				</script>
				<?php echo $single_earners_out; ?>
			</div>
		</section>
		<?php } ?>

		<?php // related content
		if ( $pt == 'itinerario' ) {
			$rel_tit = "Badges del itinerario";
			$rel_array = get_post_meta( $post->ID, '_chuerto_badges', false );
			if ( count($rel_array) > 0 ) {
				$rel_ids = implode(",",$rel_array[0]);
				$args = array(
					'post_type' => 'badge',
					'posts_per_page' => -1,
					'orderby' => 'title',
					'include' => $rel_ids
				);
			}
			$rel_item_class = "col-md-4 col-sm-4 col-xs-6";
			$rel_item_img_size = "thumbnail";

		} elseif ( $pt == 'badge' ) {
			$rel_tit = "Actividades posibles";
			$rel_array = get_post_meta( $post->ID, '_chuerto_actividades', false );
			if ( count($rel_array) > 0 ) {
				$rel_ids = implode(",",$rel_array[0]);
				$args = array(
					'post_type' => 'actividad',
					'posts_per_page' => -1,
					'orderby' => 'title',
					'include' => $rel_ids
				);
			}
			$rel_item_class = "col-md-6 col-sm-6";
			$rel_item_img_size = "small";

		} elseif ( $pt == 'actividad' ) {
			$rel_tit = "Badges de la actividad";
			$rel_array = get_post_meta( $post->ID, '_chuerto_badges', false );
			if ( count($rel_array) > 0 ) {
				$rel_ids = implode(",",$rel_array[0]);
				$args = array(
					'post_type' => 'badge',
					'posts_per_page' => -1,
					'orderby' => 'title',
					'include' => $rel_ids
				);
			}
			$rel_item_class = "col-md-4 col-sm-4 col-xs-6";
			$rel_item_img_size = "thumbnail";

		}

		if ( count($rel_array) > 0 ) {
			$rel_items = get_posts($args);
//		if ( count($rel_items) > 0 ) { ?>

		<section>
			<header>
				<h2><?php echo $rel_tit; ?></h2>
			</header>
			<div class="mosac row hair">

			<?php // related content loop
			$mobile_count = 0;
			$tablet_count = 0;
			$desktop_count = 0;
			foreach ( $rel_items as $rel ) {
				if ( $pt == 'itinerario' && $mobile_count == 2 || $pt == 'actividad' && $mobile_count == 2 ) { $mobile_count = 0; echo '<div class="clearfix visible-xs"></div>';  }

				if ( $pt == 'itinerario' && $tablet_count == 3 || $pt == 'actividad' && $tablet_count == 2 ) { $tablet_count = 0; echo '<div class="clearfix visible-sm"></div>';  }
				elseif ( $pt == 'badge' && $tablet_count == 2 ) { $tablet_count = 0; echo '<div class="clearfix visible-sm"></div>';  }
				
				if ( $pt == 'itinerario' && $desktop_count == 3 || $pt == 'actividad' && $tablet_count == 3 ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
				elseif ( $pt == 'badge' && $desktop_count == 2 ) { $desktop_count = 0; echo '<div class="clearfix visible-md visible-lg"></div>';  }
				$tablet_count++;
				$desktop_count++;

				include "loop-related.php";
			} ?>

			</div><!-- .mosac .row .hair -->
		</section>

	<?php } // end if related content
	?>

	</div><!-- .col-md-4 .col-sm-4  -->

	<div class="col-md-5 col-sm-5">
		<section class="single-desc">
		<?php the_content();
		echo $single_como_out;
		echo $single_material_out; ?>
		</section>

	</div><!-- .col-md-6 .col-sm-7 -->


	<?php if( $pt == 'badge' ) { ?>
	<aside class="col-md-3 col-sm-3">
		<?php echo $solicita_out ?>
	</aside><!-- .col-md-2 .col-sm-2 -->
	<?php } ?>

	</article><!-- .mosac .row .hair -->

	<?php endwhile; // end main loop ?>

</div><!-- .container -->
</div><!-- .container-full -->

<?php get_footer(); ?>
