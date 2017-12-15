<?php
/**
 * Template part for displaying course multiple choise
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MLAShure
 */
 $totalQuestions = count(get_field('questions'));
 if( have_rows('questions') ): ?>
 <div class="multiple-choice">
     <form class="" action="" method="post">
      <?php while ( have_rows('questions') ) : the_row(); $uniq = uniqid(); ?>
        <div class="ui segment vertical">
          <span class="m-item"><?php echo get_row_index(); ?></span>
          <h3><?php the_sub_field('question'); ?></h3>
          <?php
          if( have_rows('choices') ):
          ?>
          <div class="ui three column grid stackable centered">
              <?php while ( have_rows('choices') ) : the_row(); ?>
                <?php if (get_row_index() == 3): ?>
                  <div class="row">
                <?php endif; ?>
                <div class="column">
                  <div class="ui checkbox">
                    <input type="radio" name="<?php echo $uniq; ?>-quiz" value="<?php echo (get_sub_field('correct') ? 1 : 0); ?>">
                    <label for="q1b"><?php the_sub_field('choice'); ?></label>
                  </div>
                </div>
                <?php if (get_row_index() == 4): ?>
                </div>
                <?php endif; ?>
              <?php  endwhile; ?>
            </div>
          <?php  endif; ?>
        </div>
      <?php  endwhile; ?>
    <div class="ui hidden divider"></div>

    <div class="text-center">
      <br>
      <button type="submit" class="ui button primary huge" id="submit-quiz">SUBMIT ANSWERS</button>
      <h3 class="answer-status" style="display: none; padding: 0;"></h3>
    </div>
 </div>
 </form>
<?php  endif; ?>


<script type="text/javascript">
  jQuery(document).ready(function($) {
    var correct = [];
    $('#submit-quiz').click( function(e){
      e.preventDefault();

      $('.multiple-choice input:radio').each(function () {

        if ($(this).val() == 1) {
          $(this).parent('.checkbox').addClass('correct');
        } else {
          $(this).parent('.checkbox').addClass('wrong');
        }

        if ($(this).prop('checked') && $(this).val() == 1) {
          correct.push($(this).val());
        }
      });
      $(this).hide();
      $('.answer-status').show().text('Your Score is ' + correct.length +'/<?php echo $totalQuestions; ?>');
    })
  });

</script>
