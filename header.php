<?php
/**
 * ici on mettra notre headerr
 */


?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class('full-layout'); ?> >
<div id="page" class="site body-wrapper">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'fox-shop' ); ?></a>

    	
	<header id="masthead" class="site-header yamm navbar basic default">

		<div class="navbar-header">
      		<div class="container">

			    <div class="site-branding basic-wrapper"> 
					<a class="btn responsive-menu pull-right" data-toggle="collapse" data-target=".navbar-collapse">
						<i class='fa fa-bars'></i>
					</a> 
					
					<?php fox_shop_display_logo();  ?>

				</div><!-- .site-branding -->
				
				<nav id="site-navigation" class="main-navigation collapse navbar-collapse pull-right">
				
					<?php
					if (has_nav_menu('menu-1')) {
						wp_nav_menu( array(
							'theme_location' => 'menu-1',
							'container' => false,
							'menu_class' => 'nav navbar-nav',
							'walker' => new Fox_Shop_Walker_Nav_Primary()
						) );
					}
					?>
					
					<div class="fox-shop-woocommerce-header-cart-link">
						<?php // display woocommerce cart link if defined
							if ( function_exists( 'fox_shop_woocommerce_cart_link' ) ) {
								fox_shop_woocommerce_cart_link();
							}
						?>
					</div>
					
				</nav><!-- #site-navigation -->
				

	  		</div>
		</div><!-- .navbar-header -->
		
	</header><!-- #masthead -->
	
		<?php if ( get_header_image() && is_front_page() ): // Display header image if it exists ?>
		<div class="offset"></div>
		<div class="header-hero">
          
		  <span class="hero-media">
			<?php the_header_image_tag(); ?>
		  </span>
		  
		  <div class="hero-info">
			
			<h1 class="hero-title" ><?php esc_html_e( 'Welcome to ', 'fox-shop' ); echo bloginfo( 'name' ); ?></h1>
			
			<?php 
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ):?>
			
			<p class="hero-description" >
				<?php
					echo esc_html( $description ); 
				?>
			</p>
			<?php else:?>
			<br/><br/>
			<?php endif; ?>
			
			<div class="hero-btn">
				<?php
					$display_cta_button = get_theme_mod( 'fox_shop_display_cta_button', true );
					$cta_button_url = get_theme_mod( 'fox_shop_cta_button_url', ( class_exists( 'WooCommerce' ) ) ? get_permalink( wc_get_page_id( 'shop' ) ) : '#' );
					$cta_button_text = get_theme_mod( 'fox_shop_cta_button_text', __( 'Shop Now', 'fox-shop' ) );
					
					if ( $display_cta_button ):
				?>
					<a href="<?php echo $cta_button_url ?>" class="btn btn-large fox-shop-cta-button"><?php echo esc_html( $cta_button_text ); ?></a>
				<?php endif; ?>
			</div>
		  
		  </div><!-- .hero-info -->
		  
		</div><!-- .header-hero -->
		<?php endif;?>
		
	
	<div id="content" class="site-content">
