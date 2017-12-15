<?php
/**
 * The template for displaying video course
 * Template Name: Course
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MLAShure
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
      <?php
			while ( have_posts() ) : the_post(); ?>
      <div class="ui segment vertical nb0">
        <div class="ui container">
          <div class="ui grid">
            <div class="eleven wide column pt0">
              <div class="videowrapper">
                <div id="player"></div>
              </div>

              <script>
              // 2. This code loads the IFrame Player API code asynchronously.
              var tag = document.createElement('script');

              tag.src = "https://www.youtube.com/iframe_api";
              var firstScriptTag = document.getElementsByTagName('script')[0];
              firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

              // 3. This function creates an <iframe> (and YouTube player)
              //    after the API code downloads.
              var player;
              function onYouTubeIframeAPIReady() {
                player = new YT.Player('player', {
                  height: '390',
                  width: '640',
                  videoId: 'M7lc1UVf-VE',
                  events: {
                    'onReady': onPlayerReady,
                    'onStateChange': onPlayerStateChange
                  }
                });
              }

              // 4. The API will call this function when the video player is ready.
              function onPlayerReady(event) {
                event.target.playVideo();
              }

              // 5. The API calls this function when the player's state changes.
              //    The function indicates that when playing a video (state=1),
              //    the player should play for six seconds and then stop.
              function onPlayerStateChange(event) {
                if (event.data == YT.PlayerState.ENDED) {
                  alert('yes');
                }
              }
              function stopVideo() {
                player.stopVideo();
              }
            </script>

            <div class="ui segment">
              <div class="ui secondary pointing blue menu course-tabs">
                <a class="item active" data-tab="description">DESCRIPTION</a>
                <a class="item" data-tab="notes">NOTES</a>
                <a class="item" data-tab="multichoice">MULTIPLE CHOICE</a>
                <div class="right menu">
                  <div class="item">
                    <div class="ui form">
                      <div class="inline fields mb0">
                        <label>Done Watching?</label>
                        <div class="field">
                          <input type="checkbox" value="1">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ui active tab padded segment nobordershadow" data-tab="description">
                <p>Lorem ipsum dolor sit amet, ne denique delicata mel, eros quidam disputationi an est. Usu porro nostro luptatum et, possim aliquip appetere est eu, vel nisl malis te. Eam ad case everti placerat. Et sed aperiam labitur nostrum. Mea fastidii suavitate ea.</p>

<p>Alia accusam ponderum nam ut, perpetua constituto vituperata mea in, ea prima possit vim. Aeque omnesque salutatus cu qui, utroque consetetur in eos. Est eu tritani accusam prodesset. Veritus corpora mei no. Has ei euripidis intellegam.</p>

<p>Te eruditi recusabo partiendo qui, dicam aliquip electram mel te, per ei prima bonorum oportere. Ea ocurreret salutatus repudiare sed. Option docendi instructior nam cu, decore diceret neglegentur cu vim. Eu tale vulputate eam, eu malis dolorum admodum ius.</p>

<p>Mea an veritus offendit. Pri ut dicunt offendit, incorrupte reformidans philosophia per ne. Primis numquam mel at, ex labitur accusam percipit vis. Persius facilisi mediocritatem cu sit, sit persius ponderum definitionem et.</p>

<p>In vel nisl alia euripidis, vix meis errem ea. Ei sit vidit numquam. Et mollis laboramus sadipscing sed. Mea affert imperdiet ut, eos an omittam sententiae, te ipsum conceptam complectitur quo. In mollis nonumes vix, ius ei choro incorrupte sadipscing, in vel omnes aperiam voluptua.</p>
              </div>
              <div class="ui tab padded segment nobordershadow" data-tab="notes">
                5
              </div>
              <div class="ui tab padded segment nobordershadow" data-tab="multichoice">
                <?php get_template_part('template-parts/course','exam'); ?>
              </div>
            </div>

            </div>
            <div class="five wide column course-sidebar-wrap">
              <?php get_template_part( 'template-parts/course', 'sidebar' ) ?>
            </div>
          </div>
        </div>
      </div>

      <?php endwhile; // End of the loop. ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
