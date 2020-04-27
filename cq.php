<?php
/*
* Template Name: Custom Query
*/
?>

<?php get_header(); ?>

<body <?php body_class(); ?>>
    <?php get_template_part("/template-parts/common/hero"); ?>
    <div class="posts text-center">
        <?php
        $_p = get_posts(array(
            'post__in' => array(14, 17, 20, 5, 8, 11),
            'orderby' => 'post__in'
        ));
        foreach ($_p as $post) {
            setup_postdata($post);
        ?>
            <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>
    <?php get_footer(); ?>