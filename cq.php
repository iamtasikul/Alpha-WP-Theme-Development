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
        $paged = get_query_var("paged") ? get_query_var("paged") : 1;
        $post_ids = array(14, 17, 20, 5, 8, 11);
        $posts_per_page = 2;
        $_p = get_posts(array(
            'post__in' => $post_ids,
            'posts_per_page' => $posts_per_page,
            'orderby' => 'post__in',
            'paged' => $paged,
        ));
        foreach ($_p as $p) {
        ?>
            <h2>
                <a href="<?php echo esc_url($p->guid); ?>"><?php echo apply_filters("the_title", $p->post_title); ?></a>
            </h2>
        <?php
        }
        ?>
        <div class="container post-pagination">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-8">
                    <?php
                    echo paginate_links(array('total' => ceil(count($post_ids) / $posts_per_page)));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php get_footer(); ?>