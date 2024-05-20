<?php
function team_member_shortcode() { 
  
  $team_args = array(
    'post_type' => 'team',
    'posts_per_page' => -1,
  );
  $team_query = new WP_Query( $team_args ); 

  $team_main_title = get_field('our_team_title',95);
  $team_main_content = get_field('our_team_content',95);
  
  if ( $team_query->have_posts() ) {
    $team_output = '
    <section class="team">
      <div class="team__main" id="team__main">
        <div class="team__main--inner " data-aos="fade-up" data-aos-duration="2000">
          <div class="team__main--inner-title ">
            <h2 class="">'.$team_main_title.'</h2>
            <p class="">'.$team_main_content.'</p>
          </div>
        </div>';
        $i = 600;
        $j = 1;
    while ( $team_query->have_posts() ) {
      $team_query->the_post();
      $team_designation = get_field('designation');
      $team_output .= '
      <div class="team__main--inner "  data-aos="fade-up" data-aos-once="true" data-aos-duration="1500"';
      
      if ($j < 4) {
        $team_output .= ' data-aos-delay="' . $i . '"';
    }
    $team_output .= '><div class="team__main--inner-main ">
          <div class="team__main--inner-img ">
            <img src="'.get_the_post_thumbnail_url().'" alt="'.get_the_title().'" />
          </div>
          <div class="team__main--inner-author ">
            <h4>'.get_the_title().'</h4>
            <p>'.$team_designation.'</p>
          </div>
          <div class="team__main--inner-over">
            <div class="team__main--inner-over--cont">'.apply_filters('the_content', get_the_content()).'</div>
            <div class="team__main--inner-over--author">
              <h3>'.get_the_title().'</h3>
              <p>'.$team_designation.'</p>
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
add_shortcode( 'team_member', 'team_member_shortcode' );
function transactions_field_loop()
{
    $args = array(
        'post_type'      => 'transaction',
        'posts_per_page' => -1,
    );

    $query = new WP_Query($args);

    ob_start();
    
    if ($query->have_posts()) {
        $loan             = get_field('loan');
        $term_outstanding = get_field('term_outstanding');
        $ltv              = get_field('ltv'); ?>

<div class="transactions">
    <div class="transactions__main">
        <div class="transactions__title">
            <h4><?php the_title(); ?></h4>
        </div>
        <div class="transactions__main--cont">
            <?php if (!empty($loan)) { ?>
            <div class="transactions__main--cont-data">
                <span class="transactions__main--cont-data--title">Loan:</span>
                <span class="transactions__main--cont-data--value"><?php echo $loan; ?></span>
            </div>
            <?php }; ?>
            <?php if (!empty($term_outstanding)) { ?>
            <div class="transactions__main--cont-data">
                <span class="transactions__main--cont-data--title">Term outstanding:</span>
                <span class="transactions__main--cont-data--value"><?php echo $term_outstanding; ?></span>
            </div>
            <?php } ?>
            <?php if (!empty($ltv)) { ?>
            <div class="transactions__main--cont-data">
                <span class="transactions__main--cont-data--title">LTV:</span>
                <span class="transactions__main--cont-data--value"><?php echo $ltv; ?></span>
            </div>
            <?php } ?>
        </div>
    </div>
    <div class="transactions__main--arrow">
        <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/images/trans-arrow.svg'); ?>"
            alt="trans-arrow">
    </div>
</div>

<?php wp_reset_postdata();
    }
    return ob_get_clean();
}
add_shortcode('transactions_details', 'transactions_field_loop');