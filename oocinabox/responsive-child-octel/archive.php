<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @package        Responsive 
 * @author         Emil Uzelac 
 * @copyright      2003 - 2013 ThemeID
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/responsive/archive.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 1.0
 */
?>
<?php get_header(); ?>
        <div id="content-archive" class="grid col-620">
<?php 

$is_readerlite = false;

?>


<?php if (have_posts()) : ?>
<?php
ob_start();
responsive_breadcrumb_lists();
$breadcrumb = ob_get_contents();
ob_end_clean();
if (cat_is_ancestor_of(get_cat_id($root_cat), get_query_var('cat')) || is_category($root_cat)){
	$is_readerlite = true;
	$breadcrumb = str_replace("(Page 1)","",$breadcrumb);
}
?>
        
        <?php $options = get_option('responsive_theme_options'); ?>
		<?php if ($options['breadcrumb'] == 0): ?>
		<?php echo $breadcrumb; ?>
        <?php endif; ?>
        
		    <h6>
			    <?php if ( is_day() ) : ?>
				    <?php printf( __( 'Daily Archives: %s', 'responsive' ), '<span>' . get_the_date() . '</span>' ); ?>
				<?php elseif ( is_month() ) : ?>
					<?php printf( __( 'Monthly Archives: %s', 'responsive' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
				<?php elseif ( is_year() ) : ?>
					<?php printf( __( 'Yearly Archives: %s', 'responsive' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
                <?php elseif ( $is_readerlite ) : ?>
					<?php _e( 'Course Reader', 'responsive' ); ?>
				<?php else : ?>
					<?php _e( 'Blog Archives', 'responsive' ); 
					?>
				<?php endif; ?>
			</h6>
     <?php if ($is_readerlite || is_author() || is_day() || is_month() || is_year() ){ ?>
     <?php  echo '<script src="'.get_stylesheet_directory_uri().'/js/readerlite.js"></script>'; ?>
            <div id="content">  
            <?php if ( !is_user_logged_in() ) { ?>
            <p><strong>Note:</strong> You're not logged in so your favourites and read items will not be saved. <a href="/login/">Login</a> or <a href="/login/?action=register">Register</a></p>
            <?php }; ?>
            <p><small>Below is content posted outside the course on participants own blogs or to other social networks. Click on titles to load the content. If you would like your content added/removed from this please contact us.</small> <a href="#" onClick="_gaq.push(['_trackEvent', 'Videos', 'Play', 'Baby\'s First Birthday']);">Play</a></p> 
               <div id="accordionLoader" class="inifiniteLoader">Loading... </div>
              <div id="accordion">        
        <?php  
        	if(!$ajaxedload){
				get_template_part( 'content' );
			} else {
				get_template_part( 'content-ajaxed' );
			}
        ?> 
               </div>
            </div>
            <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
     <?php } else { ?>
     <?php while (have_posts()) : the_post(); ?>
        
            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__( 'Permanent Link to %s', 'responsive' ), the_title_attribute( 'echo=0' )); ?>"><?php the_title(); ?></a></h1>
                
                <div class="post-meta">
                <?php responsive_post_meta_data(); ?>
                
				    <?php if ( comments_open() ) : ?>
                        <span class="comments-link">
                        <span class="mdash">&mdash;</span>
                    <?php comments_popup_link(__('No Comments &darr;', 'responsive'), __('1 Comment &darr;', 'responsive'), __('% Comments &darr;', 'responsive')); ?>
                        </span>
                    <?php endif; ?> 
                </div><!-- end of .post-meta -->
                
                <div class="post-entry">
                    <?php if ( has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
                    <?php the_post_thumbnail('thumbnail', array('class' => 'alignleft')); ?>
                        </a>
                    <?php endif; ?>
                    <?php the_excerpt(); ?>
                    <?php wp_link_pages(array('before' => '<div class="pagination">' . __('Pages:', 'responsive'), 'after' => '</div>')); ?>
                </div><!-- end of .post-entry -->
                
                <div class="post-data">
				    <?php the_tags(__('Tagged with:', 'responsive') . ' ', ', ', '<br />'); ?> 
					<?php printf(__('Posted in %s', 'responsive'), get_the_category_list(', ')); ?>
                </div><!-- end of .post-data -->             

            <div class="post-edit"><?php edit_post_link(__('Edit', 'responsive')); ?></div>             
            </div><!-- end of #post-<?php the_ID(); ?> -->
            
            <?php comments_template( '', true ); ?>
            
        <?php endwhile; ?> 
        
        <?php if (  $wp_query->max_num_pages > 1 ) : ?>
        <div class="navigation">
			<div class="previous"><?php next_posts_link( __( '&#8249; Older posts', 'responsive' ) ); ?></div>
            <div class="next"><?php previous_posts_link( __( 'Newer posts &#8250;', 'responsive' ) ); ?></div>
		</div><!-- end of .navigation -->
        <?php endif; ?>
            <?php } ?>

	    <?php else : ?>

        <h1 class="title-404"><?php _e('404 &#8212; Fancy meeting you here!', 'responsive'); ?></h1>
                    
        <p><?php _e('Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive'); ?></p>
                    
        <h6><?php printf( __('You can return %s or search for the page you were looking for.', 'responsive'),
	            sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
		            esc_url( get_home_url() ),
		            esc_attr__('Home', 'responsive'),
		            esc_attr__('&larr; Home', 'responsive')
	                )); 
			 ?></h6>
                    
        <?php get_search_form(); ?>

<?php endif; ?>  
      
        </div><!-- end of #content-archive -->
        
<?php get_sidebar('archive'); ?>
<?php get_footer(); ?>