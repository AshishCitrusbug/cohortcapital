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
      <div class="team__main">
        <div class="team__main--inner">
          <div class="team__main--inner-title">
            <h2>'.$team_main_title.'</h2>
            <p>'.$team_main_content.'</p>
          </div>
        </div>';
    while ( $team_query->have_posts() ) {
      $team_query->the_post();
      $team_designation = get_field('designation');
      $team_output .= '
      <div class="team__main--inner">
        <div class="team__main--inner-main">
          <div class="team__main--inner-img">
            <img src="'.get_the_post_thumbnail_url().'" alt="'.get_the_title().'" />
          </div>
          <div class="team__main--inner-author">
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
    }
    $team_output .= '</div></section>';
  }
  // Restore original Post Data.
  wp_reset_postdata($team_output);

  return $team_output;

}
add_shortcode( 'team_member', 'team_member_shortcode' );