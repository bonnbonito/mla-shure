<?php

// update_user_meta(get_current_user_id(), 'enrolled_courses', '');

$courses = get_user_meta(get_current_user_id(), 'enrolled_courses', true);

if ($courses) :

$args = array(
  'post_type' => 'course_tree',
  'post__in' => $courses
);

$the_query = new WP_Query( $args );

 if ( $the_query->have_posts() ) : ?>
 <div class="ui vertical segment nb0">
   <div class="ui container">
     <div class="ui grid stackable">
     <?php while ( $the_query->have_posts() ) : $the_query->the_post();

     $totalVids = shure_total_course_videos($post->ID);
     $finishedVideos = get_user_finish_course_videos($post->ID);
     $percent =  ($finishedVideos/$totalVids) * 100;
     $color = get_field('color');
     $lighten = luminance($color, -0.15);
     $darken = luminance($color, -0.35);

     ?>
     <style media="screen">
       .ui.grid > .teal.course-wrap-<?php echo $the_query->current_post; ?> {
         background: <?php echo $color; ?> !important;
       }
       .ui.teal.progress.courseprogress-<?php echo $the_query->current_post; ?> .bar {
         background: <?php echo $color; ?>; /* Old browsers */
         background: -moz-linear-gradient(left, <?php echo $lighten; ?> 0%, <?php echo $darken; ?> 100%); /* FF3.6-15 */
         background: -webkit-linear-gradient(left, <?php echo $lighten; ?> 0%,<?php echo $darken; ?> 100%); /* Chrome10-25,Safari5.1-6 */
         background: linear-gradient(to right, <?php echo $lighten; ?> 0%,<?php echo $darken; ?> 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
         filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $lighten; ?>', endColorstr='<?php echo $darken; ?>',GradientType=1 ); /* IE6-9 */
       }
     </style>
       <div class="four wide column teal course-wrap-<?php echo $the_query->current_post; ?>">
         <div class="course-dashboard-wrap">
           <figure>
             <img src="<?php echo get_stylesheet_directory_uri() . '/img/icon-white.png'; ?>" alt="">
           </figure>
           <h3><?php the_title(); ?></h3>
           <div class="ui progress teal courseprogress-<?php echo $the_query->current_post; ?>" id="course-progress-<?php echo $the_query->current_post; ?>">
             <div class="bar">
               <div class="progress"></div>
             </div>
           </div>
           <script type="text/javascript">
             jQuery(document).ready(function($) {
               $('#course-progress-<?php echo $the_query->current_post; ?>').progress({
                 percent: <?php echo ceil($percent); ?>
               });
             });
           </script>
           <div class="ui hidden divider"></div>

           <?php
             $continue = shure_course_continue($post->ID);

             // echo $continue;

             if (!empty($continue)) { ?>
               <a href="<?php echo get_permalink($continue); ?>" class="ui button fluid big"><?php echo (ceil($percent) <= 0 ? 'START' : 'CONTINUE'); ?></a>
             <?php } else { ?>
               <a href="<?php echo get_permalink(shure_first_video($post->ID)); ?>" class="ui button fluid big"><?php echo (ceil($percent) <= 0 ? 'START' : 'CONTINUE'); ?></a>
           <?php } ?>
         </div>
       </div>
    <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</div>
<?php endif;
else :
?>

<div class="ui container">
  <div class="ui icon error message">
    <i class="attention circle icon"></i> No enrolled courses yet. Please enroll&nbsp;<a href="<?php bloginfo('url') ?>/select-courses/">here</a>.
  </div>
</div>
&nbsp;
&nbsp;

<?php endif;
