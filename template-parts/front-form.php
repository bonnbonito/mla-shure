<div class="register-form">
  <div class="register-form-header text-center">
    <?php echo (is_user_logged_in() ? 'Logout' : 'Login Now!'); ?>
  </div>
  <div class="register-form-content">
    <div id="login-status"></div>
    <?php if (!is_user_logged_in()): ?>
      <form class="ui form" id="login-form" name="login-form" action="#" method="post">
        <?php wp_nonce_field( 'shure_login' ); ?>
        <div class="two fields">
          <div class="field">
            <label>Email Address</label>
            <input type="email" placeholder="Enter your email" name="email" id="login-form-email">
          </div>
          <div class="field">
            <label>Password</label>
            <input type="password" placeholder="Enter your password" name="password" id="login-form-password">
          </div>
        </div>
        <button type="submit" class="ui button fluid primary">Login</button>
        <p class="small text-center">Or Create an account <a href="<?php bloginfo('url'); ?>/select-courses/">here</a></p>
      </form>
      <?php else: ?>
        <div class="ui form">
          <div class="two fields">
            <div class="field">
              <a class="ui button huge green fluid" href="<?php bloginfo('url') ?>/dashboard/"><i class="icon dashboard"></i>Dashboard</a>
            </div>
            <div class="field">
              <?php wp_nonce_field('ajax_nonce'); ?>
              <button class="ui button huge red fluid" id="logout-btn"><i class="icon sign out"></i>Logout</button>
            </div>
          </div>

        </div>
    <?php endif; ?>

  </div>
</div>
