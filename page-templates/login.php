<?php

/**
 * Template Name: Login
 */

get_header();

if ( is_user_logged_in() ) { ?>

	<div class="box-banner-login">
		<h2 class="title color-brand-1 mb-15 wow animate__animated animate__fadeIn" data-wow-delay=".0s"><?php echo esc_html__( 'You must login now', 'iori' ); ?></h2>
		<p class="font-md color-grey-500 wow animate__animated animate__fadeIn" data-wow-delay=".2s"><?php echo esc_html__( 'You must login to access the dashboard.', 'iori' ); ?></p>
		<div class="line-login mt-25 mb-50"></div>
		<div class="row wow animate__animated animate__fadeIn" data-wow-delay=".4s">
			<div class="col-lg-12">
				<div class="form-group mb-25">
					<a class="logged-btn" href="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>"><?php echo esc_html__( 'Go To Login Page', 'iori' ); ?></a>
				</div>
			</div>
		</div>
	</div>
	<?php
} else {

	// Check if the user submitted the login form
	if ( isset( $_POST['submit'] ) ) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		$credentials = array(
			'user_login'    => $username,
			'user_password' => $password,
			'remember'      => isset( $_POST['remember'] ),
		);

		$user = wp_signon( $credentials );
		if ( is_wp_error( $user ) ) {
			// Display error message
			echo '<div class="error">Invalid username or password.</div>';
		} else {
			// Redirect the user to the homepage or a custom page
			wp_redirect( home_url() );
			exit;
		}
	}
	?>

	<div class="box-banner-login">
		<h2 class="color-brand-1 mb-15 wow animate__animated animate__fadeIn" data-wow-delay=".0s"> <?php echo esc_html__( 'Welcome back', 'iori' ); ?></h2>
		<p class="font-md color-grey-500 wow animate__animated animate__fadeIn" data-wow-delay=".2s"><?php echo esc_html__( ' Fill your email address and password to sign in.', 'iori' ); ?></p>
		<div class="line-login mt-25 mb-50"></div>
		<div class="row wow animate__animated animate__fadeIn" data-wow-delay=".4s">
			<div class="col-lg-12">
				<div class="form-group mb-25">
					<form method="post" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
						<div class="row wow animate__ animate__fadeIn animated" data-wow-delay=".4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
							<div class="col-lg-12">
								<div class="form-group mb-25">
									<input class="form-control icon-user" type="text" name="log" placeholder="Username">
								</div>
							</div>

							<div class="col-lg-12">
								<div class="form-group mb-25">
									<input class="form-control icon-password" type="password" name="pwd" placeholder="Password">
								</div>
							</div>

							<div class="col-lg-6 col-6 mt-15">
								<div class="form-group mb-25">
									<label class="cb-container">
										<input type="checkbox" name="rememberme" value="forever" checked="checked"><span class="text-small">Remember me</span><span class="checkmark"></span>
									</label>
								</div>
							</div>
							<div class="col-lg-6 col-6 mt-15">
								<div class="form-group mb-25 text-end">
									<a class="font-xs color-grey-500" href="<?php echo esc_url( wp_lostpassword_url() ); ?>" alt="<?php esc_attr_e( 'Lost Password', 'iori' ); ?>">
										<?php esc_html_e( 'Lost Password', 'iori' ); ?>
									</a>
								</div>
							</div>
							<div class="form-group mb-25">
								<button class="btn btn-brand-lg btn-full font-md-bold" type="submit" name="submit"><?php esc_html_e( 'Sign in', 'iori' ); ?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-12"><span class="color-grey-500 d-inline-block align-middle font-sm">
					Don’t have an account?
				</span><a class="d-inline-block align-middle color-success ml-3" href="<?php echo esc_url( '/register' ); ?>"> <?php echo esc_html_e( 'Sign up now', 'iori' ); ?></a>
			</div>
		</div>
	</div>

	<?php
}

get_footer(); ?>
