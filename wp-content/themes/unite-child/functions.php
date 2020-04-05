<?php

add_action('wp_enqueue_scripts', 'enqueue_child_theme_styles', PHP_INT_MAX);

/**
 *  Inherit theme
 */
function enqueue_child_theme_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

/**
 * Return transient name for real_estate_posts
 *
 * @param null $agency_id
 * @return string
 */
function get_real_estate_transient_name($agency_id = null)
{
	return $agency_id === null || !isset($agency_id) || $agency_id === '' ? 'real_estate_posts' : 'real_estate_posts_' . $agency_id;
}

/**
 * update transient for specific agency and for all agencies
 *
 * @param null $agency_id
 */
function update_real_estate_transient($agency_id = null)
{
	if ($agency_id !== null || $agency_id !== '') {
		delete_transient(get_real_estate_transient_name($agency_id));
		$query = new WP_Query([
			'post_type' => 'real_estate',
			'meta_key' => '_agency',
			'meta_value' => $_POST['agency']
		]);
		set_transient(get_real_estate_transient_name($agency_id), $query->posts, 60 * 60 * 12);
	}

	delete_transient(get_real_estate_transient_name());
	$query = new WP_Query(['post_type' => 'real_estate']);
	set_transient(get_real_estate_transient_name(), $query->posts, 60 * 60 * 12);
}

add_action('admin_init', 'add_meta_boxes');

/**
 *  Add meta field to real estate posts
 */
function add_meta_boxes()
{
	add_meta_box('agency', 'Agency Relationship', 'agency_field', 'real_estate');
}

/**
 *  Print select box in real estate post type
 */
function agency_field()
{
	global $post;
	$selected_agency = get_post_meta($post->ID, '_agency', true);
	$all_agencies = get_posts(array(
		'post_type' => 'agency',
		'numberposts' => -1,
		'orderby' => 'post_title',
		'order' => 'ASC'
	));
	?>
    <input type="hidden" name="agency_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>"/>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">
                <label for="agency">Agencies</label>
            </th>
            <td>
                <select name="agency">
					<?php foreach ($all_agencies as $agency) : ?>
                        <option value="<?php echo $agency->ID; ?>"<?= $agency->ID == $selected_agency ? ' selected="selected"' : ''; ?>><?php echo $agency->post_title; ?></option>
					<?php endforeach; ?>
                </select>
            </td>
        </tr>
    </table>
<?php }

add_action('save_post', 'save_agency_field');

/**
 * Saves agency ID as in _agency field
 * Delete tranient for all / last agency / new agency
 *
 * @param $post_id
 * @return mixed
 */
function save_agency_field($post_id)
{

	if ('real_estate' != get_post_type($post_id))
	return $post_id;

	if (empty($_POST['agency_nonce']) || !wp_verify_nonce($_POST['agency_nonce'], basename(__FILE__)))
	return $post_id;

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	return $post_id;

	if (!current_user_can('edit_post', $post_id))
	return $post_id;

	$last_agency = get_post_meta($post_id, '_agency')[0];
	update_post_meta($post_id, '_agency', intval($_POST['agency']));

	if ($last_agency != intval($_POST['agency'])) {
		delete_transient(get_real_estate_transient_name(intval($_POST['agency'])));
		delete_transient(get_real_estate_transient_name($last_agency));
		delete_transient(get_real_estate_transient_name());
	}
}

/**
 * Function for template
 * $data is from get_post_meta
 * key => [0] => value, ...
 *
 * $attributes as
 * key => value , ...
 *
 * @param array $data
 * @param array $attributes
 */
function print_attributes(array $data, array $attributes)
{
	echo "<ul>";
	foreach ($attributes as $attribute => $label) {
		if (isset($data[$attribute][0]) && $data[$attribute][0] !== '') {
			echo "<li>" . $label . ": " . $data[$attribute][0] . "</li>";
		}
	}
	echo "</ul>";
}

/**
 * Returns real_estates array
 *
 * @return mixed
 */
function get_real_estates()
{
	$transient_name = get_real_estate_transient_name($_POST['agency']);

	if ($transient = get_transient($transient_name)) {
		return $transient;
	} else {
		update_real_estate_transient($_POST['agency']);
		return get_real_estates();
	}
}

/**
 * Print given posts
 *
 * @param array $posts
 */
function print_posts(array $posts)
{
	foreach ($posts as $post) {
		$post->meta = get_post_meta($post->ID);
		if (isset($post->meta['_agency'][0]))
			$post->meta += array('agency' => [0 => get_post($post->meta['_agency'][0])->post_title]);
		?>
        <article>
            <h2><?= $post->post_title ?></h2>
			<?php if (isset($post->meta->cost_of[0])) : ?>
                <h3 class="cost-of"><?= $post->meta->cost_of[0] ?></h3>
			<?php endif ?>
			<?php
			print_attributes(
				$post->meta,
				[
					'adress' => 'Adress',
					'area' => 'Area',
					'living_area' => 'Living area',
					'floor' => 'Floor',
					'agency' => 'Agency'
				]);
			?>
        </article>
	<?php }
}

add_action('widgets_init', 'register_agency');

/**
 *  Create widget for agency
 */
function register_agency()
{
	require_once 'Agency_Widget.php';
	register_widget('Agency_Widget');
}

add_action('wp_enqueue_scripts', 'add_theme_scripts');

/**
 *  Adds script to homepage
 */
function add_theme_scripts()
{
	if (is_home()) {
		wp_enqueue_script("jquery");
		wp_enqueue_script('script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '', true);
		wp_localize_script('script', 'real_estate_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
	}
}

add_action('wp_ajax_get_real_estate', 'get_real_estate');
add_action('wp_ajax_nopriv_get_real_estate', 'get_real_estate');

/**
 *  Return post to AJAX POST request
 */
function get_real_estate()
{
	$posts = get_real_estates();
	print_posts($posts);
	die();
}