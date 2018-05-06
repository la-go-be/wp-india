<?php
/*
template name: Seller Login
*/
?>
<?php get_header('seller'); ?>
<?php
   
if($_POST) 
{  
   
    global $wpdb;  
   
    //We shall SQL escape all inputs  
    $username = $wpdb->escape($_REQUEST['username']);  
    $password = $wpdb->escape($_REQUEST['password']);  
    $remember = $wpdb->escape($_REQUEST['rememberme']);  
   
    if($remember) $remember = "true";  
    else $remember = "false";  
   
    $login_data = array();  
    $login_data['user_login'] = $username;  
    $login_data['user_password'] = $password;  
    $login_data['remember'] = $remember;  
   
    $user_verify = wp_signon( $login_data, false );   
   
    if (is_wp_error($user_verify))   
    {  
        $error = "<span><strong>Login failed</strong> Username or password are not correct.</span><p>Please try again or register account.</p>";  
       // Note, I have created a page called "Error" that is a child of the login page to handle errors. This can be anything, but it seemed a good way to me to handle errors.  
     } else
    {    
       echo "<script type='text/javascript'>window.location.href='". home_url() ."'</script>";  
       exit();  
     }  
   
} else 
{  
    // No login details entered - you should probably add some more user feedback here, but this does the bare minimum  
    //echo "Invalid login details";  
}  
?>
<div class="seller-login">
  <div class="right-sec">
  	<h2>Login</h2>
	<a href="#" class="btn">Click here to Sign Up</a>
	
	<?php if($error != "") {?>
	<div class="login-error">
		<?php echo $error; ?>
	</div>
	<?php } ?>
	
	<div class="login-form">
	<form id="login1" name="form" action="<?php echo home_url(); ?>/seller-login/" method="post">  
        <input id="username" type="text" placeholder="Username" name="username"><br>  
        <input id="password" type="password" placeholder="Password" name="password">  
        <input id="submit" type="submit" name="submit" value="Login">  
		<div><input type="checkbox" name="rememberme" id="remember"/>
		<label for="remember-me">Remember me</label>
		</div>
		<a href="<?php echo site_url(); ?>/lost-password">? Forgot Password</a>
	</form>   	
	</div>
  </div>
</div>
<?php get_footer();  ?>
