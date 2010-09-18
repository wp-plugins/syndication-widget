<?php
/*
Plugin Name: syndication-widget
Plugin URI: http://wordpress.org/extend/plugins/syndication-widget/
Description: Adds a sidebar widget and display OPML, ATOM, RSS feed link for your WordPress blog.
Author: Md. Jamal Hossain Khan
Version: 1.1
Author URI: http://www.krishe.com/en

  
	Copyright 2010 Md. Jamal Hossain Khan (email : jamal_khanbd@yahoo.com)
 
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

### Syndication widget
// Begin Syndication widget plugin

$jk_sw = new Syndication_widget();

class Syndication_widget{
	
	public function __construct()
	{
	add_filter('plugin_row_meta', array(&$this,'jk_filter_plugin_links'), 10, 2);
	register_sidebar_widget('Syndication', array(&$this,'syndication_widget'));
	register_widget_control('Syndication', array(&$this,'syndication_widget_options'), 350, 120);
	}
	// Add donate and support information
	function jk_filter_plugin_links($links, $file)
	{
		if ( $file == plugin_basename(__FILE__) )
		{
		$links[] = '<a href="http://www.krishe.com/en/syndication-widget">' . __('Support') . '</a>';
		$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=NR7SVN2HFJXX4&lc=GB&item_name=Donation%20for%20Plugin%20Development&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted">' . __('Donate') . '</a>';
		}
		return $links;
	}

	function syndication_widget($args)
	{ 
		extract($args);
		$options = get_option('syndication_widget');
		$title = htmlspecialchars(stripslashes($options['title']));
		echo $before_widget.$before_title.$title.$after_title;
				echo "<ul>\n";
					echo "<li>\n";
					echo "<a  title='RSS Feed' href='".get_option( 'siteurl' )."/?feed=rss2'/>RSS</a>";
					echo "</li>\n";
					echo "<li>\n";
					echo "<a title='ATOM Feed' href='".get_option( 'siteurl' )."/?feed=atom'/>ATOM</a>";
					echo "</li>\n";
					echo "<li>\n";
					echo "<a title='POML Feed' href='".get_option( 'siteurl' )."/wp-links-opml.php'/>OPML</a>";
					echo "</li>\n";
				echo "</ul>\n";
		echo $after_widget;
	}


	### Syndication Widget Options
	
	function syndication_widget_options() 
	{
		$options = get_option('syndication_widget');
		if (!is_array($options)) {
			$options = array('title' => __('Syndication'));
		}
		if ($_POST['syndication_widget-submit']) {
			$options['title'] = strip_tags($_POST['syndication_widget-title']);
			update_option('syndication_widget', $options);
		}
		echo '<p style="text-align: left;"><label for="syndication_widget-title">'.__('Widget Title').':</label>&nbsp;&nbsp;&nbsp;<input type="text" id="syndication_widget-title" name="syndication_widget-title" value="'.htmlspecialchars(stripslashes($options['title'])).'" />';
		echo '<input type="hidden" id="syndication_widget-submit" name="syndication_widget-submit" value="1" />';
	}
}

?>