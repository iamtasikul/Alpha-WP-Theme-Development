<?php get_header(); ?>

<body <?php body_class(); ?>>
    <?php get_template_part("hero"); ?>
    <div class="posts">
        <?php
        while (have_posts()) {
            the_post();
        ?>
            <div class="post" <?php post_class() ?>>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <p>
                                <strong><?php the_author(); ?></strong><br />
                                <?php echo get_the_date(); ?>
                                <?php get_the_tag_list("<ul class='list-unstyled'>", "<li></li>", "<li></ul>"); ?>
                            </p>
                            <?php get_the_tag_list(); ?>
                        </div>
                        <div class="col-md-8">
                            <p>
                                <?php if (has_post_thumbnail()) {
                                    // $thumbnail_url = get_the_post_thumbnail_url(null, "large");
                                    // echo '<a href="%s" data-featherlight="image">';
                                    echo '<a class="popup" href="#" data-featherlight="image">';
                                    the_post_thumbnail("large", "class='img-fluid'");
                                    echo '</a>';
                                } ?>
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
        <?php get_footer(); ?>