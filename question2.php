<?php 

// in order to add social links to a post, we first have to get social links from the user/author.
// My first step is to create a WP hook that adds custom fields to the user profile page to collect this data.

// I would place the following code in the theme's functions.php file (or in a custom plugin):

// ************************************************
// User profile fields for social media contacts
// ************************************************

// add the custom function to the 'show_user_profile' and 'edit_user_profile' actions so that the fields exist when viewing or editing a user profile 
add_action( 'show_user_profile', 'cs_social_profile_fields' );
add_action( 'edit_user_profile', 'cs_social_profile_fields' );

function cs_social_profile_fields( $user ) { ?>
    <!-- Section title and instructions -->
    <h3><?php esc_html_e('Social Media Links', 'cs' ); ?></h3>
	<h4>Enter links to your social media profiles. Please include the "http://"</h4>
<?php
// variables to store user meta; populates field with current value if it exists
$linkedin = get_the_author_meta( 'linkedin', $user->ID );
$facebook = get_the_author_meta( 'facebook', $user->ID );
?>

<!-- input field for LinkedIn URL -->
<table class="form-table">
<tr>
<th><label for="linkedin"><?php esc_html_e( 'LinkedIn', 'cs' ); ?></label></th>
<td>
<input type="text"
       id="linkedin"
       name="linkedin"
       value="<?php echo esc_attr( $linkedin ); ?>"
       class="regular-text"
/>
</td>
</tr>

<!-- input field for Facebook URL -->
<tr>
<th><label for="facebook"><?php esc_html_e( 'Facebook', 'cs' ); ?></label></th>
<td>
<input type="text"
       id="facebook"
       name="facebook"
       value="<?php echo esc_attr( $facebook ); ?>"
       class="regular-text"
/>
</td>
</tr>
</table>
<?php
}

// Now we need to save the input data to the user meta for all user profiles (personal_options_update), and whenever they are edited (edit_user_profile_update) with the following action hooks

add_action( 'personal_options_update', 'cs_update_profile_fields' );
add_action( 'edit_user_profile_update', 'cs_update_profile_fields' );

function cs_update_profile_fields( $user_id ) {
    // only edit user meta if the current user has appropriate permissions
       if ( ! current_user_can( 'edit_user', $user_id ) ) {
              return false;
       }
    //    update the new value to the user meta
       update_user_meta( $user_id, 'linkedin', $_POST['linkedin'] );
	   update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
}

// Now that we have data to work with, we can add it to the title of posts this user has authored

// I did this by adding a hook to 'the_title' filter that appends the author's info:

// ************************************************
// Append social media links to post title
// ************************************************

// hooking in the custom function when the post title renders
add_filter( 'the_title', 'cs_insert_social_links' );

// the custom function takes in the post's title as an argument
function cs_insert_social_links( $title ) {
    // we only want to append the links on single.php, not in menus and archives, and we also only want it to appear on the title at the top on single.php, not in any navigation links.
    // this will only run if we are on single.php, and since the top title renders first, it will only run the first time 'the_title' runs on the page
	if ( is_single() AND did_filter('the_title') <= 2 ) {
        // variables to store the post author's social links
		$linkedin = get_the_author_meta('linkedin');
		$facebook = get_the_author_meta('facebook');
        // HTML to append to the links after the title
		$append_socials = '<span class="post-title-social-links"><a href="' . $linkedin . '" ><i class="fab fa-linkedin"></i></a><a href="' . $facebook . '" ><i class="fab fa-facebook"></i></a></span>';
        // append the custom HTML to the title and return
		$title .= $append_socials;
		return $title;
	} else {
        // if the first conditions are not met, simply return the title as normal
		return $title;
	}
} 
/?>

// I used free icons from my personal https://fontawesome.com/ kit, so I added a small script tag to footer.php in order to render the icons:

<script src="https://kit.fontawesome.com/myKitCode.js" crossorigin="anonymous"></script>

// and a little CSS to improve the styling (I tested this on the TwentyTwentyOne theme) in style.css 

.post-title-social-links a{
	font-size: 2rem;
	display: inline-block;
	padding:  0 1%;
}