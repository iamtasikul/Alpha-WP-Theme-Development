<?php
$alpha_layout_class = "col-md-8";
$alpha_text_class = " ";
if (!is_active_sidebar("sidebar-1")) {
    $alpha_layout_class = "col-md-10 offset-md-1";
    $alpha_text_class = "text-center";
}
?>
<?php get_header(); ?>

<body <?php body_class(); ?>>
    <?php get_template_part("/template-parts/common/hero"); ?>
    <div class="container">
        <div class="row">
            <div class="<?php echo $alpha_layout_class; ?>">
                <div class="posts">
                    <?php
                    while (have_posts()) {
                        the_post();
                    ?>
                        <div class="post" <?php post_class() ?>>
                            <div class="container ">
                                <div class="row">
                                    <div class="col-md-10 offset-md-1">
                                        <h2 class="post-title <?php echo $alpha_text_class; ?>"><?php the_title(); ?></h2>
                                        <p class="<?php echo $alpha_text_class; ?>">
                                            <strong><?php the_author_posts_link(); ?></strong><br />
                                            <?php echo get_the_date(); ?>
                                            <?php get_the_tag_list("<ul class='list-unstyled'>", "<li></li>", "<li></ul>"); ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class=" col-md-12">
                                        <div class="slider">
                                            <?php
                                            if (class_exists('Attachments')) {
                                                $attachments = new Attachments('slider');
                                                if ($attachments->exist()) {
                                                    while ($attachment = $attachments->get()) { ?>
                                                        <div>
                                                            <?php echo $attachments->image('large'); ?>
                                                        </div>
                                            <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div>
                                            <p>
                                                <?php
                                                if (!class_exists('Attachments')) {
                                                    if (has_post_thumbnail()) {
                                                        // $thumbnail_url = get_the_post_thumbnail_url(null, "large");
                                                        // echo '<a href="%s" data-featherlight="image">';
                                                        echo '<a class="popup" href="#" data-featherlight="image">';
                                                        the_post_thumbnail("large", "class='img-fluid'");
                                                        echo '</a>';
                                                    }
                                                } ?>
                                                <?php
                                                the_content();
                                                wp_link_pages();
                                                // next_post_link();
                                                // echo "<br/>";
                                                // previous_post_link();
                                                ?>
                                            </p>
                                        </div>
                                        <div class="authorsection">
                                            <div class="row">
                                                <div class="col-md-4 authorimage">
                                                    <?php echo get_avatar(get_the_author_meta("id")); ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <h4><?php echo get_the_author_meta("display_name"); ?></h4>
                                                    <p><?php echo get_the_author_meta("description"); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    <?php
                    }
                    ?>
                    <div class="container post-pagination">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <?php the_posts_pagination(array(
                                    "screen_reader_text" => " ",
                                    'prev_text' => "New Posts",
                                    'next_text' => "Old Posts"
                                )); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (is_active_sidebar("sidebar-1")) : ?>
                    <div class="col-md-4">
                        <?php
                        if (is_active_sidebar('sidebar-1')) {
                            dynamic_sidebar('sidebar-1');
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php get_footer(); ?>