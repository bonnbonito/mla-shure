<?php
/**
 * Template part for displaying a sidebar of course
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MLAShure
 */

?>

<aside class="course-video-lists">
  <?php
  $post_object = get_field('course_name');

  if( $post_object ):

  	// override $post
  	$post = $post_object;
  	setup_postdata( $post );

    $totalVids = shure_total_course_videos($post->ID);
    $finishedVideos = get_user_finish_course_videos($post->ID);
    $percent =  ($finishedVideos/$totalVids) * 100;
    $color = get_field('color');
    $lighten = luminance($color, -0.15);
    $darken = luminance($color, -0.35);
	?>
  <figure class="course-icon">
    <?php the_post_thumbnail('full'); ?>
  </figure>

  <h1 class="course-title"><?php the_title(); ?></h1>
  <h3 class="course-subtitle"><?php the_field('subtitle'); ?></h3>

  <style media="screen">
    .course-sidebar-wrap {
      background: <?php echo $color; ?>
    }
    .ui.teal.progress.courseprogress .bar {
      background: <?php echo $color; ?>; /* Old browsers */
      background: -moz-linear-gradient(left, <?php echo $lighten; ?> 0%, <?php echo $darken; ?> 100%); /* FF3.6-15 */
      background: -webkit-linear-gradient(left, <?php echo $lighten; ?> 0%,<?php echo $darken; ?> 100%); /* Chrome10-25,Safari5.1-6 */
      background: linear-gradient(to right, <?php echo $lighten; ?> 0%,<?php echo $darken; ?> 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $lighten; ?>', endColorstr='<?php echo $darken; ?>',GradientType=1 ); /* IE6-9 */
    }
  </style>

  <div class="ui progress teal courseprogress" id="course-progress">
    <div class="bar">
      <div class="progress"></div>
    </div>
  </div>

  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $('#course-progress').progress({
        percent: <?php echo ceil($percent); ?>
      });
    });
  </script>

  <?php
  if( have_rows('course_tree') ): ?>
    <?php while ( have_rows('course_tree') ) : the_row(); ?>
      <div class="ui accordion">
        <div class="title active">
          <i class="plus icon"></i>
          <?php echo get_row_index(); ?>. <?php the_sub_field('title'); ?>
        </div>
        <div class="content active">
          <?php
          if( have_rows('videos') ): ?>
          <div class="ui middle aligned divided list">
            <?php while ( have_rows('videos') ) : the_row(); ?>
              <?php $video_object = get_sub_field('course_video'); ?>
              <?php $finish = get_user_meta(get_current_user_id(), 'finish-' . $video_object->ID, true ); ?>
              <a class="<?php echo get_row_index(); ?> item <?php echo ($finish == 1 ? 'finish' : ''); ?>" href="<?php echo get_permalink($video_object->ID); ?>">
                <div class="right floated content">
                  <div>
                    <?php if ($finish == 1): ?>
                      <i class="checkmark icon"></i>
                    <?php else : ?>
                      <?php echo get_field('video_duration', $video_object->ID); ?>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="content">
                  <?php echo get_the_title($video_object->ID); ?>
                </div>
              </a>
            <?php endwhile;?>
          </div>
          <?php endif;
          ?>
        </div>
      </div>
    <?php endwhile;?>
  <?php endif;
  ?>
  <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
  <?php endif; ?>
</aside><!-- .no-results -->
