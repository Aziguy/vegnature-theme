<?php
class MemberCardShortcode {
    public function __construct() {
        add_shortcode('member_card', array($this, 'render_member_card'));
    }

    public function render_member_card($atts) {
        // Shortcode attributes
        $atts = shortcode_atts(array(
            'name' => 'Member name',
            'title' => 'Title of member',
            'image' => get_template_directory_uri() . '/assets/images/img-box/img-profile.png',
        ), $atts, 'member_card');

        // Output HTML for the member card
        ob_start();
        ?>
        <div class="veg-card veg-m-rl">
            <div class="veg-top-container">
                <img src="<?php echo esc_url($atts['image']); ?>" class="img-fluid veg-profile-image" width="70">
                <div class="veg-ml-3">
                    <h5 class="veg-name"><?php echo esc_html($atts['name']); ?></h5>
                    <p class="veg-title"><?php echo esc_html($atts['title']); ?></p>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

// Instantiate the class
new MemberCardShortcode();
