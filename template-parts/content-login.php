<?php
/**
 * Template part for displaying page content in login-template.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MLAShure
 */

?>


<div id="post-<?php the_ID(); ?>" class="login-banner">
  <div class="ui vertical segment nb0">
    <div class="ui container">
      <header class="entry-header text-center">
    		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    	</header><!-- .entry-header -->
      <div class="ui grid stackable centered">
        <div class="six wide column">
          <div class="formwrap">
            <h3>Returning User</h3>
            <?php wp_nonce_field("shure_login", "_wpnonce", true, true); ?>
            <form action="" class="ui form">
              <div class="field">
                <input type="email" placeholder="Email Address">
              </div>
              <div class="field">
                <input type="password" placeholder="Password">
              </div>
              <button class="ui button submit fluid" type="submit">Login</button>
            </form>
          </div>
        </div>
        <div class="column"></div>
        <div class="six wide column">
          <div class="formwrap">
            <h3>New User</h3>
            <form action="" class="ui form">
              <div class="field">
                <input type="email" placeholder="Email Address">
              </div>
              <div class="field">
                <input type="password" placeholder="Password">
              </div>
              <div class="field">
                <input type="password" placeholder="Confirm Password">
              </div>
              <button class="ui button submit fluid" type="submit">Register</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- #post-<?php the_ID(); ?> -->
