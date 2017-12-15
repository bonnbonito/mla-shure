<?php
/**
 * Template part for displaying page content in payment-template.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package MLAShure
 */
if (is_user_logged_in()) :
?>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<div id="post-<?php the_ID(); ?>" class="payment-banner">
  <div class="ui vertical segment nb0">
    <div class="ui container">
      <header class="entry-header text-center">
    		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    	</header><!-- .entry-header -->
      &nbsp;
      <div class="ui hidden divider"></div>
      <div class="ui grid stackable centered center aligned payment-grid">
        <div class="four wide column <?php echo (is_user_logged_in() ? 'hidden' : ''); ?>">
            <div class="ui button fluid lightblue" id="step1">Register</div>
        </div>
        <div class="row <?php echo (is_user_logged_in() ? '' : 'hidden'); ?>" id="step2">
          <?php $key_stages = get_terms( 'key_stage', array(
            'orderby'    => 'name',
            'hide_empty' => 0
        	));

          foreach ($key_stages as $key => $value ) { ?>
        		<div class="four wide column">
        				<button class="ui button fluid lightblue <?php echo $key; ?>" id="<?php echo $value->slug; ?>"><?php echo $value->name; ?></button>
        				<br>
        		</div>
        		<div class="column"></div>

        	<?php } ?>

        </div>
        <div class="row" id="step3">

        </div>
        <div id="step4">
          <div class="row">
            <div class="ui message">
              <h3>Total Price: <span id="tprice"></span></h3>
              <div id="paypal-button-container" style="display: none;"></div>
              <button class="ui button primary" id="enrollfreecourse" style="display: none;">Enroll Courses</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><!-- #post-<?php the_ID(); ?> -->

<?php endif; ?>

<div class="ui coupled modal opensignupmodal">
  <div class="content">
    <h2 class="ui dividing header">Create an Account</h2>
    <div id="register-status"></div>
    <form class="ui form" id="modal-signup">
      <div class="three fields">
        <div class="field">
          <label>First Name</label>
          <input type="text" name="fname" placeholder="First Name" id="register-form-fname" required>
        </div>
        <div class="field">
          <label>Last Name</label>
          <input type="text" name="lname" placeholder="Last Name" id="register-form-lname" required>
        </div>
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" placeholder="Email" id="register-form-email" required>
        </div>
      </div>
      <div class="fields">
        <div class="four wide field">
          <label>Password</label>
          <input type="password" name="password" placeholder="Password" id="register-form-password" required>
        </div>
        <div class="four wide field">
          <label>Retype Password</label>
          <input type="password" name="password-2" placeholder="Retype Password" id="register-form-repassword" required>
        </div>
        <div class="eight wide field">
          <div class="two fields">
            <div class="field">
              <label>&nbsp;</label>
              <button type="submit" class="ui button fluid lightyellow">Sign Up</button>
            </div>
            <div class="field">
              <label>&nbsp;</label>
              <button type="button" class="ui button fluid green openLoginModal">Have an Account?</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="ui coupled modal loginModal">
  <div class="content">
    <h2 class="ui dividing header">Login</h2>
    <div id="login-status"></div>
    <form class="ui form" id="modal-login">
      <?php wp_referer_field(); ?>
      <?php wp_nonce_field( 'shure_login' ); ?>
      <div class="two fields">
        <div class="field">
          <label>Email</label>
          <input type="email" name="email" placeholder="Email" required id="login-form-email">
        </div>
        <div class="field">
          <label>Password</label>
          <input type="password" name="password" placeholder="Password" required id="login-form-password">
        </div>
      </div>
      <div class="field">
        <label>&nbsp;</label>
        <button type="submit" class="ui button fluid lightyellow">Log In</button>
      </div>
      <div class="text-center">
        <a href="#" class="goback" style="color: #fff;">Back</a>
      </div>
    </form>
  </div>
</div>

<div class="ui modal enrolledModal">
  <div class="content">
    <h2 class="ui dividing header">Congratulations!</h2>
    <div class="ui icon success message">
      <i class="notched check icon"></i>
      <div class="content">
        <div class="header">Please wait while we redirect you...</div>
      </div>
    </div>
  </div>
</div>
