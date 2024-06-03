<?php
function team_member_shortcode()
{

    $team_args = array(
        'post_type' => 'team',
        'posts_per_page' => -1,
    );
    $team_query = new WP_Query($team_args);

    $team_main_title = get_field('our_team_title', 95);
    $team_main_content = get_field('our_team_content', 95);

    if ($team_query->have_posts()) {
        $team_output = '
    <section class="team">
      <div class="team__main" id="team__main">
        <div class="team__main--inner " data-aos="fade-up" data-aos-duration="1500">
          <div class="team__main--inner-title ">
            <h2 class="">' . $team_main_title . '</h2>
            <p class="">' . $team_main_content . '</p>
          </div>
        </div>';
        $i = 600;
        $j = 1;
        while ($team_query->have_posts()) {
            $team_query->the_post();
            $team_designation = get_field('designation');
            $team_output .= '
      <div class="team__main--inner "  data-aos="fade-up" data-aos-once="true" data-aos-duration="1500"';

            if ($j < 4) {
                $team_output .= ' data-aos-delay="' . $i . '"';
            }
            $team_output .= '><div class="team__main--inner-main ">
          <div class="team__main--inner-img ">
            <img src="' . get_the_post_thumbnail_url() . '" alt="' . get_the_title() . '" />
          </div>
          <div class="team__main--inner-author ">
            <h4>' . get_the_title() . '</h4>
            <p>' . $team_designation . '</p>
          </div>
          <div class="team__main--inner-over">
            <div class="team__main--inner-over--cont">' . apply_filters('the_content', get_the_content()) . '</div>
            <div class="team__main--inner-over--author">
              <h3>' . get_the_title() . '</h3>
              <p>' . $team_designation . '</p>
            </div>
          </div>
        </div>
      </div>';
            $i = $i + 300;
            if ($j % 4 == 0) {
                $j = 1; // Reset $j to 1 after every 4th item
                $i = 600;
            } else {
                $j++; // Increment $j otherwise
            }
        }
        $team_output .= '</div></section>';
    }
    // Restore original Post Data.
    wp_reset_postdata($team_output);

    return $team_output;
}
add_shortcode('team_member', 'team_member_shortcode');
function transactions_field_loop()
{

    $loan_num             = get_field('loan_num');
    $loan             = get_field('loan');
    $term_outstanding_num = get_field('term_outstanding_num');
    $term_outstanding = get_field('term_outstanding');
    $ltv_num              = get_field('ltv_num');
    $ltv              = get_field('ltv');


?>

    <div class="transactions">
        <div class="transactions__main">
            <div class="transactions__title">
                <h4><?php the_title(); ?></h4>
            </div>
            <div class="transactions__main--cont">
                <?php if (!empty($loan)) { ?>
                    <div class="transactions__main--cont-data">
                        <span class="transactions__main--cont-data--title">Loan:</span>
                        <span class="transactions__main--cont-data--value"><?php echo $loan_num; ?> <span><?php echo $loan; ?></span></span>
                    </div>
                <?php }; ?>
                <?php if (!empty($term_outstanding)) { ?>
                    <div class="transactions__main--cont-data">
                        <span class="transactions__main--cont-data--title">Term:</span>
                        <span class="transactions__main--cont-data--value"><?php echo $term_outstanding_num; ?><span><?php echo $term_outstanding; ?></span></span>
                    </div>
                <?php } ?>
                <?php if (!empty($ltv)) { ?>
                    <div class="transactions__main--cont-data">
                        <span class="transactions__main--cont-data--title">LTV:</span>
                        <span class="transactions__main--cont-data--value"><?php echo $ltv_num; ?><span><?php echo $ltv; ?></span></span>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="transactions__main--arrow">
            <a href="<?php echo get_permalink(); ?>"> <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/trans-arrow.svg'); ?>" alt="trans-arrow">
            </a>
        </div>
    </div>

    <?php

}
add_shortcode('transactions_details', 'transactions_field_loop');

/* Testimonials custom loop */

function testimonial_custom_loop($atts)
{
    ob_start();

    $args = array(
        'post_type' => 'testimonials',
        'posts_per_page' => -1,
    );

    $testimonial_query = new WP_Query($args);

    if ($testimonial_query->have_posts()) {
    ?>
        <div class="testimonial" data-testimonial>
            <div class="testimonial__main owl-carousel owl-theme">
                <?php
                $i = 0;
                while ($testimonial_query->have_posts()) : $testimonial_query->the_post();
                    $title = get_the_title();
                    $content = get_the_content();
                    $designation = get_field('testimonials_designation');
                    $company = get_field('testimonials_company');
                    $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                    $rating = get_field('testimonial_rating');

                    if ($i % 2 == 0) {
                        echo '<div class="testimonial__main--item">';
                    }
                ?>
                    <div class="testimonial__main--item-top">
                        <div class="testimonial__main--item-top-cont">
                            <?php if ($image_url) : ?>
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                            <?php endif; ?>
                            <?php if ($rating) { ?>
                                <ul>
                                    <?php for ($j = 0; $j < $rating; $j++) : ?>
                                        <li>
                                            <a href="#">
                                                <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/testinomial-rating.svg'); ?>" alt="Star Rating">
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                </ul>
                            <?php };
                            if (!empty($content)) {
                            ?>
                                <p><?php echo $content; ?></p>
                            <?php }; ?>
                        </div>
                        <div class="testimonial__main--item-top-auth">
                            <h4><?php echo $title; ?></h4>
                            <?php if (!empty($designation)) { ?>
                                <p><?php echo $designation; ?></p>
                            <?php }
                            if (!empty($company)) { ?>
                                <p><?php echo $company; ?></p>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                    $i++;
                    if ($i % 2 == 0) {
                        echo '</div>';
                    }
                endwhile;

                if ($i % 2 != 0) {
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    <?php
    }

    wp_reset_postdata();

    return ob_get_clean();
}

add_shortcode('testimonial_custom_loop_section', 'testimonial_custom_loop');


/* Home testimonials custom loop */

function testimonial_home_page($atts)
{
    ob_start();

    $args = array(
        'post_type' => 'testimonials',
        'posts_per_page' => -1,
    );

    $testimonial_query = new WP_Query($args);

    if ($testimonial_query->have_posts()) {
    ?>
        <div class="testimonial" data-testimonial>
            <div class="testimonial__main owl-carousel owl-theme">
                <?php while ($testimonial_query->have_posts()) : $testimonial_query->the_post(); ?>
                    <div class="testimonial__main--item">
                        <?php
                        $title = get_the_title();
                        $content = get_the_content();
                        $designation = get_field('testimonials_designation');
                        $company = get_field('testimonials_company');
                        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        $rating = get_field('testimonial_rating');
                        ?>
                        <div class="testimonial__main--item-top">
                            <div class="testimonial__main--item-top-cont">
                                <?php if ($image_url) : ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>">
                                <?php endif; ?>
                                <?php if (!empty($rating)) { ?>
                                    <ul>
                                        <?php for ($i = 0; $i < $rating; $i++) : ?>
                                            <li>
                                                <a href="#">
                                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/testinomial-rating.svg'); ?>" alt="Star Rating">
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                    </ul>
                                <?php };
                                if (!empty($content)) {
                                ?>
                                    <p><?php echo $content; ?></p>
                                <?php }; ?>
                            </div>
                            <div class="testimonial__main--item-top-auth">
                                <h4><?php echo $title; ?></h4>
                                <?php if (!empty($designation)) { ?>
                                    <p><?php echo $designation; ?></p>
                                <?php }
                                if (!empty($company)) { ?>
                                    <p><?php echo $company; ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php
    }

    wp_reset_postdata();

    return ob_get_clean();
}

add_shortcode('testimonial_home_page_section', 'testimonial_home_page');

/* Insights search articles section */

function insights_article_search($atts)
{
    ob_start();
    ?>

    <div class="insights">
        <div class="insights__main">

            <div class="insights__main--box">
                <div class="insights__main--box-img">
                    <img src="/cohortcapital/wp-content/uploads/2024/05/insights-img.png" alt="">
                </div>
                <div class="insights__main--box-cont">
                    <div class="insights__main--box-cont--title">
                        <h4>Discover the neighbourhood</h4>
                        <span>2 min read</span>
                    </div>
                    <div class="insights__main--box-cont--date">
                        <span>03 May 2024, by Author name</span>
                    </div>
                    <div class="insights__main--box-cont--content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
                    </div>
                    <a href="#" class="insights__main--box-cont--link">
                        Read Article
                        <img src="/cohortcapital/wp-content/uploads/2024/05/post-arrow.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="insights__main--box">
                <div class="insights__main--box-img">
                    <img src="/cohortcapital/wp-content/uploads/2024/05/insights-img.png" alt="">
                </div>
                <div class="insights__main--box-cont">
                    <div class="insights__main--box-cont--title">
                        <h4>Discover the neighbourhood</h4>
                        <span>2 min read</span>
                    </div>
                    <div class="insights__main--box-cont--date">
                        <span>03 May 2024, by Author name</span>
                    </div>
                    <div class="insights__main--box-cont--content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
                    </div>
                    <a href="#" class="insights__main--box-cont--link">
                        Read Article
                        <img src="/cohortcapital/wp-content/uploads/2024/05/post-arrow.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="insights__main--box">
                <div class="insights__main--box-img">
                    <img src="/cohortcapital/wp-content/uploads/2024/05/insights-img.png" alt="">
                </div>
                <div class="insights__main--box-cont">
                    <div class="insights__main--box-cont--title">
                        <h4>Discover the neighbourhood</h4>
                        <span>2 min read</span>
                    </div>
                    <div class="insights__main--box-cont--date">
                        <span>03 May 2024, by Author name</span>
                    </div>
                    <div class="insights__main--box-cont--content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
                    </div>
                    <a href="#" class="insights__main--box-cont--link">
                        Read Article
                        <img src="/cohortcapital/wp-content/uploads/2024/05/post-arrow.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="insights__main--box">
                <div class="insights__main--box-img">
                    <img src="/cohortcapital/wp-content/uploads/2024/05/insights-img.png" alt="">
                </div>
                <div class="insights__main--box-cont">
                    <div class="insights__main--box-cont--title">
                        <h4>Discover the neighbourhood</h4>
                        <span>2 min read</span>
                    </div>
                    <div class="insights__main--box-cont--date">
                        <span>03 May 2024, by Author name</span>
                    </div>
                    <div class="insights__main--box-cont--content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
                    </div>
                    <a href="#" class="insights__main--box-cont--link">
                        Read Article
                        <img src="/cohortcapital/wp-content/uploads/2024/05/post-arrow.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="insights__main--box">
                <div class="insights__main--box-img">
                    <img src="/cohortcapital/wp-content/uploads/2024/05/insights-img.png" alt="">
                </div>
                <div class="insights__main--box-cont">
                    <div class="insights__main--box-cont--title">
                        <h4>Discover the neighbourhood</h4>
                        <span>2 min read</span>
                    </div>
                    <div class="insights__main--box-cont--date">
                        <span>03 May 2024, by Author name</span>
                    </div>
                    <div class="insights__main--box-cont--content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
                    </div>
                    <a href="#" class="insights__main--box-cont--link">
                        Read Article
                        <img src="/cohortcapital/wp-content/uploads/2024/05/post-arrow.svg" alt="">
                    </a>
                </div>
            </div>

            <div class="insights__main--box">
                <div class="insights__main--box-img">
                    <img src="/cohortcapital/wp-content/uploads/2024/05/insights-img.png" alt="">
                </div>
                <div class="insights__main--box-cont">
                    <div class="insights__main--box-cont--title">
                        <h4>Discover the neighbourhood</h4>
                        <span>2 min read</span>
                    </div>
                    <div class="insights__main--box-cont--date">
                        <span>03 May 2024, by Author name</span>
                    </div>
                    <div class="insights__main--box-cont--content">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat</p>
                    </div>
                    <a href="#" class="insights__main--box-cont--link">
                        Read Article
                        <img src="/cohortcapital/wp-content/uploads/2024/05/post-arrow.svg" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php
    return ob_get_clean();
}

add_shortcode('insights_page_article_search_section', 'insights_article_search');
