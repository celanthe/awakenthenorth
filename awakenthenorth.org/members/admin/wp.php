<?
define("WPDIR", "/home/intheexp/atn.bigskyheathen.com/");
require_once(WPDIR.'wp-blog-header.php');
require_once(WPDIR.'wp-includes/registration.php');

$user_email="wizardeddas@gmail.com";
$user_login="wizardeddas123";
$user_pass="password";
if (email_exists($user_email)) {
	
	echo '<p>Email already registered: '. $user_email .'</p>';
	
} elseif (username_exists($user_login)) {
	
	echo '<p>Username already registered: '. $user_login .'</p>';
	
} else {
	
	//$user_pass = wp_generate_password(16, false);
	
	$user_id = wp_insert_user(
		array(
			'user_email' => $user_email,
			'user_login' => $user_login,
			'user_pass'  => $user_pass,
			'user_url'   => $user_url,
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'role'       => $role,
		)
	);
	echo "User Created";
}
?>