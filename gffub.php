<?php
/*
Plugin Name: Gravity Forms FUB Integration Add-On
Plugin URI: https://github.com/jeremycaris/gf-fub
Description: A Gravity Forms add-on to assign a custom lead source and tags utilizing the Follow Up Boss Open API and to easily integrate the Follow Up Boss Pixel.
Version: 0.12
Author: Jeremy Caris
Author URI: https://github.com/jeremycaris

------------------------------------------------------------------------

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

define( 'GF_FUB_VERSION', '0.12' );

add_action( 'gform_loaded', array( 'GF_FollowUpBoss_Bootstrap', 'load' ), 5 );

class GF_FollowUpBoss_Bootstrap {

    public static function load() {

        if ( ! method_exists( 'GFForms', 'include_feed_addon_framework' ) ) {
            return;
        }

        require_once( 'class-gffub.php' );

        GFAddOn::register( 'GFFollowUpBoss' );
    }

}

function gf_followupboss() {
    return GFFollowUpBoss::get_instance();
}



/* Load update checker */
require 'inc/plugin-update-checker-5.3/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
    'https://github.com/714Web/gf-fub/',
    __FILE__,
    'gf-fub'
);
$myUpdateChecker->getVcsApi()->enableReleaseAssets();
