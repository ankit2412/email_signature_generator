<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://riopromo.com/
 * @since      1.0.0
 *
 * @package    Email_signature_generator
 * @subpackage Email_signature_generator/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Email_signature_generator
 * @subpackage Email_signature_generator/public
 * @author     Rio Promo <info@riopromo.com>
 */
class Email_signature_generator_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        if (is_page('email-signature-generator') || is_page('email-signature-preview')) {
            wp_enqueue_style($this->plugin_name . '-bootstrap-style', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-cropper-style', plugin_dir_url(__FILE__) . 'css/cropper.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-jquery-ui', plugin_dir_url(__FILE__) . 'css/jquery-ui.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-fontawesome-style', plugin_dir_url(__FILE__) . 'css/font-awesome/css/font-awesome.min.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name . '-pspectrum-style', plugin_dir_url(__FILE__) . 'css/spectrum.css', array(), $this->version, 'all');
            wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/email_signature_generator-public.css', array(), $this->version, 'all');
        }
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        if (is_page('email-signature-generator') || is_page('email-signature-preview')) {
            wp_enqueue_script($this->plugin_name . '-bootstrap-script', plugin_dir_url(__FILE__) . 'js/bootstrap.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name . '-cropper-script', plugin_dir_url(__FILE__) . 'js/cropper.min.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name . '-jquery-ui', plugin_dir_url(__FILE__) . 'js/jquery-ui.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name . '-pspectrum', plugin_dir_url(__FILE__) . 'js/spectrum.js', array('jquery'), $this->version, true);
            wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/email_signature_generator-public.js', array('jquery'), $this->version, true);
            wp_localize_script($this->plugin_name, 'ajax_url', array('url' => admin_url('admin-ajax.php')));
            wp_localize_script($this->plugin_name, 'site_url', array('url' => site_url('/')));
        }
    }

    /*
     * Create Email Singature Generator Page
     * 
     *  @since    1.0.0
     */

    public function create_generator_page() {
        // Create Email Signature Generator page
        $check_page_exist = get_page_by_title('Email Signature Generator');
        if (empty($check_page_exist)) {
            $page_id = wp_insert_post(
                    array(
                        'comment_status' => 'close',
                        'ping_status' => 'close',
                        'post_author' => 1,
                        'post_title' => ucwords('Email Signature Generator'),
                        'post_name' => strtolower(str_replace(' ', '-', trim('Email Signature Generator'))),
                        'post_status' => 'publish',
                        'post_content' => '',
                        'post_type' => 'page'
                    )
            );
        }

        // Create Email Signature Preview page
        $check_page_exist = get_page_by_title('Email Signature Preview');
        if (empty($check_page_exist)) {
            $page_id = wp_insert_post(
                    array(
                        'comment_status' => 'close',
                        'ping_status' => 'close',
                        'post_author' => 1,
                        'post_title' => ucwords('Email Signature Preview'),
                        'post_name' => strtolower(str_replace(' ', '-', trim('Email Signature Preview'))),
                        'post_status' => 'publish',
                        'post_content' => '',
                        'post_type' => 'page'
                    )
            );
        }
    }

    //Load template from specific page
    public function load_page_template($page_template) {

        if (get_page_template_slug() == 'email-signature-generator.php' && is_page('email-signature-generator')) {
            $page_template = dirname(__FILE__) . '/partials/email-signature-generator.php';
        }

        if (get_page_template_slug() == 'email-signature-preview.php' && is_page('email-signature-preview')) {
            $page_template = dirname(__FILE__) . '/partials/email-signature-preview.php';
        }
        return $page_template;
    }

    /**
     * Add "Custom" template to page attribute template section.
     */
    function assign_page_template($post_templates, $wp_theme, $post, $post_type) {

        // Add custom template named template-custom.php to select dropdown 
        $post_templates['email-signature-generator.php'] = __('Email Signature Generator');
        $post_templates['email-signature-preview.php'] = __('Email Signature Preview');

        return $post_templates;
    }

    /*
     * Show template 
     */

    function email_gen_page_template($template) {

        if (is_page('email-signature-generator')) {
            $new_template = dirname(__FILE__) . '/partials/email-signature-generator.php';
            if ('' != $new_template) {
                return $new_template;
            }
        }

        if (is_page('email-signature-preview')) {
            $new_template = dirname(__FILE__) . '/partials/email-signature-preview.php';
            if ('' != $new_template) {
                return $new_template;
            }
        }

        return $template;
    }

    /*
     * Prepare Email Signature
     */

    public function create_email_signature() {

        $final_data = array();
        if (!empty($_POST['data'])) {

            $final_data['data'] = $_POST['data'];

            if (get_option('email_aurthor_image') != '') {
                $final_data['data']['image']['AvtarImageWidth'] = 100;
                $final_data['data']['image']['AvtarImageShape'] = 10;
                $final_data['data']['image']['full_path'] = get_option('email_aurthor_image');
            }

            if ($_POST['data']['general']['InputWebsite'] != "") {
                $parsed = parse_url($_POST['data']['general']['InputWebsite']);
                if (empty($parsed['scheme'])) {
                    $final_data['data']['general']['InputWebsite'] = 'https://' . ltrim($_POST['data']['general']['InputWebsite'], '/');
                } else {
                    $final_data['data']['general']['InputWebsite'] = $_POST['data']['general']['InputWebsite'];
                }
            } else if (get_option('email_website') != "") {

                $parsed = parse_url(get_option('email_website'));
                if (empty($parsed['scheme'])) {
                    $final_data['data']['general']['InputWebsite'] = 'https://' . ltrim(get_option('email_website'), '/');
                } else {
                    $final_data['data']['general']['InputWebsite'] = get_option('email_website');
                }
            }

            foreach ($final_data['data']['social'] as $key => $sdata) {
                if ($sdata['link'] != '') {
                    $final_data['data']['social'][$key]['link'] = $sdata['link'];
                } else {
                    if ($sdata['social_type'] == "facebook") {
                        $final_data['data']['social'][$key]['link'] = get_option('email_social_link_facebook');
                    }
                    if ($sdata['social_type'] == "twitter") {
                        $final_data['data']['social'][$key]['link'] = get_option('email_social_link_twitter');
                    }
                    if ($sdata['social_type'] == "linkedin") {
                        $final_data['data']['social'][$key]['link'] = get_option('email_social_link_linkedin');
                    }
                }
            }
        } else {

            $final_data['data']['image']['AvtarImageWidth'] = 100;
            $final_data['data']['image']['AvtarImageShape'] = 10;

            if (get_option('email_aurthor_image') != '') {
                $final_data['data']['image']['full_path'] = get_option('email_aurthor_image');
            } else {
                $final_data['data']['image']['full_path'] = plugin_dir_url(__FILE__) . 'images/user_dummy.png';
            }

            $final_data['data']['general']['InputName'] = 'John Doe';
            $final_data['data']['general']['InputCompany'] = 'ABC Ltd.';
            $final_data['data']['general']['InputPosition'] = 'Manager';
            $final_data['data']['general']['InputDepartment'] = 'Development';
            $final_data['data']['general']['InputMobile'] = '9876543211';

            if (get_option('email_website') != '') {
                $final_data['data']['general']['InputWebsite'] = get_option('email_website');
            } else {
                $final_data['data']['general']['InputWebsite'] = 'https://www.john-doe.com';
            }

            $final_data['data']['general']['InputEmail'] = 'john-doe@gmail.com';
            $final_data['data']['general']['InputAddress'] = '123, Test Street, UK';

            if (get_option('email_social_link_facebook') != '') {
                $final_data['data']['social'][1]['link'] = get_option('email_social_link_facebook');
                $final_data['data']['social'][1]['social_type'] = 'facebook';
                $final_data['data']['social'][1]['caption'] = 'Follow Me';
            } else {
                $final_data['data']['social'][1]['link'] = 'https://www.facebook.com/id';
                $final_data['data']['social'][1]['social_type'] = 'facebook';
                $final_data['data']['social'][1]['caption'] = 'Follow Me';
            }

            if (get_option('email_social_link_twitter') != '') {
                $final_data['data']['social'][2]['link'] = get_option('email_social_link_twitter');
                $final_data['data']['social'][2]['social_type'] = 'twitter';
                $final_data['data']['social'][2]['caption'] = 'Follow Me';
            } else {
                $final_data['data']['social'][2]['link'] = 'https://www.twitter.com/id';
                $final_data['data']['social'][2]['social_type'] = 'twitter';
                $final_data['data']['social'][2]['caption'] = 'Follow Me';
            }

            if (get_option('email_social_link_linkedin') != '') {
                $final_data['data']['social'][3]['link'] = get_option('email_social_link_linkedin');
                $final_data['data']['social'][3]['social_type'] = 'linkedin';
                $final_data['data']['social'][3]['caption'] = 'Follow Me';
            }

            $final_data['data']['design']['FontSize'] = 90;

            if (get_option('email_font_color') != '') {
                $final_data['data']['design']['FontColor'] = get_option('email_font_color');
            } else {
                $final_data['data']['design']['FontColor'] = '#000000';
            }

            $final_data['data']['design']['FontFamily'] = "Verdana, Geneva, sans-serif";
        }

        if (!empty($final_data)) {
            date_default_timezone_set("America/New_York");
            echo '<table data-mysignature-date="' . date("Y-m-d H:i:s") . '" width="500" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><table cellspacing="0" cellpadding="0" border="0"><tbody><tr>';
            if (!empty($final_data['data']['image'])) {
                echo '<td valign="top" width="' . $final_data['data']['image']['AvtarImageWidth'] . '" style="padding:0 8px 0 0;vertical-align: top;"> <img alt="created with Email Signature Generator" width="' . $final_data['data']['image']['AvtarImageWidth'] . '" style="width:' . $final_data['data']['image']['AvtarImageWidth'] . 'px;moz-border-radius:' . $final_data['data']['image']['AvtarImageShape'] . '%;khtml-border-radius:' . $final_data['data']['image']['AvtarImageShape'] . '%;o-border-radius:' . $final_data['data']['image']['AvtarImageShape'] . '%;webkit-border-radius:' . $final_data['data']['image']['AvtarImageShape'] . '%;ms-border-radius:' . $final_data['data']['image']['AvtarImageShape'] . '%;border-radius:' . $_POST['data']['image']['AvtarImageShape'] . '%;" src="' . $final_data['data']['image']['full_path'] . '"> </td>';
            }
            if (!empty($final_data['data']['general'])) {
                echo '<td style="font-size:1em;padding:0 15px 0 8px;vertical-align: top;" valign="top"><table cellspacing="0" cellpadding="0" border="0" style="line-height: 1.4;font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';font-size:' . $final_data['data']['design']['FontSize'] . '%;color: #000001;"><tbody>';

                foreach ($final_data['data'] as $key => $data) {
                    if (!$data['image'] || !$data['social']) {
                        if ($data['InputName'] != "") {
                            echo '<tr><td><div style="font: 1.2em ' . stripslashes($final_data['data']['design']['FontFamily']) . ';color:#000001;">' . $data['InputName'] . '</div></td></tr>';
                        }
                        if ($data['InputCompany'] || $data['InputPosition'] || $data['InputDepartment']) {
                            echo '<tr><td style="padding: 4px 0;"><div style="color:#000001;font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';">';
                            if ($data['InputCompany'] != "" && $data['InputPosition'] != "" && $data['InputDepartment'] != "") {
                                echo $data['InputPosition'] . ' | ' . $data['InputCompany'] . ' | ' . $data['InputDepartment'];
                            } else if ($data['InputCompany'] != "" && $data['InputPosition'] != '' && $data['InputDepartment'] == '') {
                                echo $data['InputPosition'] . ' | ' . $data['InputCompany'];
                            } else if ($data['InputCompany'] != "" && $data['InputPosition'] == '' && $data['InputDepartment'] != '') {
                                echo $data['InputCompany'] . ' | ' . $data['InputDepartment'];
                            } else if ($data['InputCompany'] == "" && $data['InputPosition'] != "" && $data['InputDepartment'] != '') {
                                echo $data['InputPosition'] . ' | ' . $data['InputDepartment'];
                            } else if ($data['InputCompany'] != "" && $data['InputPosition'] == "" && $data['InputDepartment'] == "") {
                                echo $data['InputCompany'];
                            } else if ($data['InputCompany'] == "" && $data['InputPosition'] != "" && $data['InputDepartment'] == "") {
                                echo $data['InputPosition'];
                            } else if ($data['InputCompany'] == "" && $data['InputPosition'] == "" && $data['InputDepartment'] != "") {
                                echo $data['InputDepartment'];
                            }
                            echo '</div></td></tr>';
                        }
                        if ($data['InputPhone'] != "") {
                            echo '<tr><td ><span style="font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';color:' . $final_data['data']['design']['FontColor'] . '">phone:&nbsp;</span><span><a style="font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';color:#000001;" href="tel:' . $data['InputPhone'] . '">' . $data['InputPhone'] . '</a></span></div></td></tr>';
                        }
                        if ($data['InputMobile'] != "") {
                            echo '<tr><td><span style="font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';color:' . $final_data['data']['design']['FontColor'] . '">mobile:&nbsp;</span><span><a style="font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';color:#000001;" href="tel:' . $data['InputMobile'] . '">' . $data['InputMobile'] . '</a></span></div></td></tr>';
                        }
                        if ($data['InputWebsite'] != "") {
                            echo '<tr><td><span style="font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';color:' . $final_data['data']['design']['FontColor'] . '">site:&nbsp;</span><span style="font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';"><a href="' . $data['InputWebsite'] . '" style="color:#000001;" target="_blank">' . $data['InputWebsite'] . '</a></span></div></td></tr>';
                        }
                        if ($data['InputEmail'] != "") {
                            echo '<tr><td><span style="font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';color:' . $final_data['data']['design']['FontColor'] . '">email:&nbsp;</span><span><a href="mailto:' . $data['InputEmail'] . '" style="font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';color: #000001;">' . $data['InputEmail'] . '</a></span></div></td></tr>';
                        }

                        /* if ($data['InputSkype'] != "") {
                          echo '<tr><td><span style="font-family:'.stripslashes($final_data['data']['design']['FontFamily']).';color:'.$final_data['data']['design']['FontColor'].'">skype:&nbsp;</span><span><a href="skype:' . $data['InputSkype'] . '?chat" style="font-family:'.stripslashes($final_data['data']['design']['FontFamily']).';color: #000001;">' . $data['InputSkype'] . '</a></span></div></td></tr>';
                          } */

                        if ($data['InputAddress'] != "") {
                            echo '<tr><td ><span style="font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';color:' . $final_data['data']['design']['FontColor'] . '">address:&nbsp;</span><span style="font-family:' . stripslashes($final_data['data']['design']['FontFamily']) . ';color:#000001;">' . $data['InputAddress'] . '</span></div></td></tr>';
                        }
                    }
                }
                echo '</tbody></table></td>';
            }
            if (!empty($final_data['data']['social'])) {
                echo '<td style="border-left:3px solid;vertical-align:middle;padding:0 0 3px 6px;font-family: Arial;border-color:' . $final_data['data']['design']['FontColor'] . '" valign="middle"><table cellspacing="0" cellpadding="0" border="0" style="line-height: 1;"><tbody>';
                foreach ($final_data['data']['social'] as $key => $social_data) {
                    if ($social_data['link'] != "") {
                        $catption = ($social_data['caption']) ? $social_data['caption'] : '';
                        echo '<tr><td style="padding: 4px 0 0 0;">
                                <a target="_blank" class="social_link ' . $social_data['social_type'] . '" href="' . $social_data['link'] . '" style="display: block;border-radius: 6%;width:22px;height:22px;text-align: center;background-color: ' . $final_data['data']['design']['FontColor'] . '" title="' . $catption . '"><i style="padding: 4px 0 0 1px;font-size:14px;color: #ffffff;" class="fa fa-' . $social_data['social_type'] . '"></i></a>';
                        echo '</td></tr>';
                    }
                }
                echo '</tbody></table></td>';
            }
            echo '</tr></tbody></table></td></tr></tbody></table><table class="branding" cellspacing="0" cellpadding="0" border="0"> <tbody><tr><td style="display:block;padding:15px 0 0 0;"></td></tr> <tr> <td style="border-top: 1px solid #eeeeee;padding-top: 5px;font-size:10px;font-family: Arial;"> <a href="#" style="color: #000001; text-decoration: none" target="_blank">Create your own signature</a> </td> </tr></tbody></table>';
            die();
        }
    }

    public function upload_avtar() {
        if (isset($_POST) && !empty($_FILES['avatar'])) {
            $avtar = $_FILES['avatar'];
            $path_parts = pathinfo($avtar["name"]);
            $extension = $path_parts['extension'];
            $upload_dir = wp_upload_dir();

            if (!file_exists($upload_dir['basedir'] . '/email_generator_avtar')) {
                mkdir($upload_dir['basedir'] . '/email_generator_avtar', 0777, true);
            }
            $new_name = 'avtar-' . time() . '.' . $extension;
            $path = $upload_dir['basedir'] . '/email_generator_avtar/' . $new_name;
            if (move_uploaded_file($avtar['tmp_name'], $path)) {
                $full_image_path = $upload_dir['baseurl'] . '/email_generator_avtar/' . $new_name;
                echo json_encode(array('full_image_path' => $full_image_path));
                die();
            }
        }
        die();
    }

}
