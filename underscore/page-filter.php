<?php
/**
 * Template Name: Page Filter
 *
 */
get_header();
?>

<div class="container px-4">
<section class="hero" style="background-image: url('<?php echo esc_url(get_field('hero_image')); ?>');">
    <div class="hero-box">
        <h1><?php echo esc_html(get_field('hero_title')); ?></h1>
        <p><?php echo esc_html(get_field('hero_description')); ?></p>
    </div>
</section>


    <!-- Locations goes here ;) -->
    <section class="the-row">
        <div id="sidebar">
            <h3>Filter by County</h3>
            <ul id="taxonomy-terms">
                <?php
                // Define the custom taxonomy name
                $taxonomy = 'county';

                // Get all terms in the taxonomy
                $terms = get_terms(array(
                    'taxonomy' => $taxonomy,
                    'hide_empty' => false,
                ));

                if (!empty($terms) && !is_wp_error($terms)) :
                    foreach ($terms as $term) :
                        echo '<li><a href="#" data-term-id="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</a></li>';
                    endforeach;
                endif;
                ?>
            </ul>
        </div>

        <section class="locations">
            <div id="locations-container">
              
            </div>
        </section>
    </section>
</div>

<?php get_footer(); ?>
