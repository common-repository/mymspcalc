<?php

/*
Plugin Name: myMSPCalc
Plugin URI: http://www.crazyiven.de/wordpress-plugins/mymspcalc/
Description: Calculate your Price per Microsoft Point. To show the calculator, put &lt;?php showmyMSPCalc(); ?&gt; in your sidebar template. To show on a page or in a single post, just write [mymspcalc]!
Version: 1.0
Author: Marcus Jaentsch
Author URI: http://www.crazyiven.de/

			**************************************************************************
			* Code starts here - NO TOUCHING! (If you don't know what you're doing!) *
			**************************************************************************
*/

	$myMSPCalcDBVersion 		= "001";
	$myMSPCalcPluginVersion = "1.0";
	$myMSPCalccurrency			= "Euro";
	$myMSPCalcTextdomain 		= "myMSPCalc";

	function myMSPCalc($content) {

		return preg_replace("/\[mymspcalc\]/",showmyMSPCalc(1),$content);

	}

	function showmyMSPCalc($ispage = false) {

		global $myMSPCalccurrency, $myMSPCalcTextdomain;

		if($ispage) { $width = "50%"; } else { $width = "100%"; }
		$returntext = "<form action=\"\" method=\"post\"><table width=\"".$width."\" cellpadding=\"\" cellspacing=\"\"><tr><td align=\"left\"><a href=\"http://www.crazyiven.de/wordpress-plugins/mymspcalc/\" target=\"_blank\"><b>".__("MS Points Calculator",$myMSPCalcTextdomain)."</b></a></td></tr><tr><td align=\"center\"><input type=\"text\" name=\"myMSPCalcprice\" value=\"".__("MS Points price",$myMSPCalcTextdomain)."\" style=\"width: 100%;\" onFocus=\"if(this.value==this.defaultValue) this.value='';\" onBlur=\"if(this.value=='') this.value=this.defaultValue;\" /></td></tr><tr><td align=\"center\"><input type=\"text\" name=\"myMSPCalcamount\" value=\"".__("purchased MS Points (amount)",$myMSPCalcTextdomain)."\" style=\"width: 100%;\" onFocus=\"if(this.value==this.defaultValue) this.value='';\" onBlur=\"if(this.value=='') this.value=this.defaultValue;\" /></td></tr><tr><td align=\"center\"><input type=\"text\" name=\"myMSPCalcused\" value=\"".__("used MS Points",$myMSPCalcTextdomain)."\" style=\"width: 100%;\" onFocus=\"if(this.value==this.defaultValue) this.value='';\" onBlur=\"if(this.value=='') this.value=this.defaultValue;\" /></td></tr><tr><td align=\"center\"><input type=\"submit\" value=\" ".__("calculate",$myMSPCalcTextdomain)." \" name=\"calc\" style=\"width: 100%;\" /></td></tr></table></form>";
		if(preg_match("/^([0-9]+)$/",$_POST[myMSPCalcamount]) && preg_match("/^([0-9,.]+)$/",$_POST[myMSPCalcprice])) {
			
			$price = ($_POST[myMSPCalcprice]/$_POST[myMSPCalcamount]);
			$returntext .= sprintf(__("<br />You've payed %s Dollar per MS Point, when you bought %s Points for %s Dollar.",$myMSPCalcTextdomain),number_format($price,4),$_POST[myMSPCalcamount],$_POST[myMSPCalcprice]);
			
			if(preg_match("/^([0-9]+)$/",$_POST[myMSPCalcused])) {
				
				$returntext .= sprintf(__("<br /><br />%s MS Points will cost you round about %s Dollar.",$myMSPCalcTextdomain),$_POST[myMSPCalcused],number_format(($price*$_POST[myMSPCalcused]),4));

			}

		}

		if($ispage) {

			return $returntext;

		} else {

			echo $returntext;

		}

	}

/*
* Add myMSPCalc to Wordpress
*/

	load_plugin_textdomain($myMSPCalcTextdomain,'wp-content/plugins/mymspcalc/language');
	add_filter('the_content','myMSPCalc'); 

?>