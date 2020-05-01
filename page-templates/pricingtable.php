<?php

/**
 * Template Name: Pricing Table
 */
get_header();
$pricing  = get_post_meta(get_the_ID(), "_alpha_pt_pricing_table", true);
$services = get_post_meta(get_the_ID(), "_alpha_service", true);
?>
<?php
?>
<div class="container">
    <div class="row">
        <?php
        foreach ($pricing as $ptc) :
        ?>
            <div class="col-md-4">
                <h2><?php echo esc_html($ptc['_alpha_pt_pricing_caption']) ?></h2>
                <ul>
                    <?php
                    foreach ($ptc['_alpha_pt_pricing_option'] as $pto) :
                    ?>
                        <li><?php echo esc_html($pto); ?></li>
                    <?php
                    endforeach;
                    ?>
                </ul>
                <h3><?php echo esc_html($ptc['_alpha_pt_price']) ?></h3>
            </div>

        <?php
        endforeach;
        ?>
    </div>


</div>
<?php
get_footer();
