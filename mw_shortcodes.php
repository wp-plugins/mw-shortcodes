<?php

/*
 * Plugin Name: MW Shortcodes
 * Description: ShortCodes para colunas de layout (Bootstrap Twitter)
 * Version: 1.0
 * Author: Missão Web
 * Author URI: http://www.missaoweb.com.br/
 */

/* Copyright 2013 Missão Web

  This program is a free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

class MWShortCodes
{

    public function init_mwshortcodes()
    {
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
            return;

        add_filter("mce_external_plugins", array($this, 'add_plugin'));
        add_filter('mce_buttons', array($this, 'register_button'));

        add_shortcode('mw-row-fluid', array($this, 'add_shortcode_row_fluid'));
        add_shortcode('mw-span-x', array($this, 'add_shortcode_span'));

        add_action('the_content', array($this, 'replace_line_break'));
    }

    function add_plugin($plugin_array)
    {
        $plugin_array['mw_row_fluid'] = plugin_dir_url(__FILE__) . '/mw_shortcodes.js';
        return $plugin_array;
    }

    public function register_button($buttons)
    {
        array_push($buttons, "|", "mw_row_fluid", '|', 'mw_add_spans');
        return $buttons;
    }

    public function add_shortcode_row_fluid($atts, $content = NULL)
    {
        return '<div class="row-fluid">' . do_shortcode($content) . '</div><hr />';
    }

    public function add_shortcode_span($atts, $content = NULL)
    {
        extract($atts);
        return '<div class="span' . $colunas . '">' . do_shortcode($content) . '</div>';
    }

    public function replace_line_break($content)
    {
        $content = preg_replace('/<br class="quebra" \/>/i', '', $content);
        return $content;
    }

}

// Initialize
add_action('init', array(new MWShortCodes(), 'init_mwshortcodes'));

add_action('wp_dashboard_setup', 'remove_dashboard_widgets');

function remove_dashboard_widgets()
{

    //Completely remove various dashboard widgets (remember they can also be HIDDEN from admin)
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');      //Quick Press widget
    remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');      //Recent Drafts
    remove_meta_box('dashboard_primary', 'dashboard', 'side');      //WordPress.com Blog
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');      //Other WordPress News
    remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');    //Incoming Links
    #remove_meta_box('dashboard_plugins', 'dashboard', 'normal');    //Plugins
    #remove_meta_box('dashboard_right_now', 'dashboard', 'normal');    //Plugins
    #remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');    //Plugins
}