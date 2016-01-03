<?php
// developed by Red V!per
class CMS_Detector
{
	public static function process($data)
	{
		$apps=array();
		
		//Meta tests
		$meta_tests = array(
			'Joomla'=> '/joomla/i',
			'vBulletin'=> '/vBulletin/i',
			'WordPress'=> '/wordPress/i',
			'XOOPS'=> '/xoops/i',
			'Plone'=> '/plone/i',
			'MediaWiki'=> '/MediaWiki/i',
			'CMSMadeSimple'=> '/CMS Made Simple/i',
			'SilverStripe'=> '/SilverStripe/i',
			'Movable Type'=> '/Movable Type/i',
			'Amiro.CMS'=> '/Amiro/i',
			'Koobi'=> '/koobi/i',
			'bbPress'=> '/bbPress/i',
			'DokuWiki'=> '/dokuWiki/i',
			'TYPO3'=> '/TYPO3/i',
			'PHP-Nuke'=> '/PHP-Nuke/i',
			'DotNetNuke'=> '/DotNetNuke/i',
			'Sitefinity'=> '/Sitefinity\s+(.*)/i',
			'WebGUI'=> '/WebGUI/i',
			'ez Publish'=> '/eZ\s*Publish/i',
			'BIGACE'=> '/BIGACE/i',
			'TypePad'=> '/typepad\.com/i',
			'Blogger'=> '/blogger/i',
			'PrestaShop'=> '/PrestaShop/i',
			'SharePoint'=> '/SharePoint/',
			'JaliosJCMS'=> '/Jalios JCMS/i',
			'ZenCart'=> '/zen-cart/i',
			'WPML'=> '/WPML/i',
			'PivotX'=> '/PivotX/i',
			'OpenACS'=> '/OpenACS/i',
			'phpBB'=> '/phpBB/i',
			//'Elgg'=> '/.+/',
			'Serendipity'=> '/Serendipity/i',
			'Avactis'=> '/Avactis Team/i'
		);
		
		$found=false;
		$i=strpos($data,"<meta ");
		while ($i!==false && $found==false)
		{
			$j=strpos($data,">",$i+1);
			if ($j===false)
			{
				$j=strlen($data)-1;
			}
			$meta_tag=substr($data,$i,$j-$i+1);
			
			foreach($meta_tests as $tag=>$regex)
			{
				preg_match($regex, $meta_tag, $matches);
				if (!empty($matches))
				{
					if (!in_array($tag,$apps))
					{
						array_push($apps,$tag);
					}
					$found=true;
					break;
				}
			}
			
			$i=strpos($data,"<meta ",$i+1);
		}
		
		//Script tests
		$script_tests = array(
			'Google Analytics'=> '/google-analytics.com\/(ga|urchin).js/i',
			'Quantcast'=> '/quantserve\.com\/quant\.js/i',
			'Prototype'=> '/prototype\.js/i',
			'jQuery'=> '/jquery[a-z.]*\.js/i',
			'Joomla'=> '/\/components\/com_/',
			'Ubercart'=> '/uc_cart/i',
			'Closure'=> '/\/goog\/base\.js/i',
			'MODx'=> '/\/min\/b=.*f=.*/',
			'MooTools'=> '/mootools/i',
			'Dojo'=> '/dojo(\.xd)?\.js/i',
			'script.aculo.us'=> '/scriptaculous\.js/i',
			'Disqus'=> '/disqus.com\/forums/i',
			'GetSatisfaction'=> '/getsatisfaction\.com\/feedback/i',
			'Wibiya'=> '/wibiya\.com\/Loaders\//i',
			'reCaptcha'=> '/api\.recaptcha\.net\//i',
			'Mollom'=> '/mollom\/mollom\.js/i', // only work on Drupal now
			'ZenPhoto'=> '/zp-core\/js/i',
			'Gallery2'=> '/main\.php\?.*g2_.*/i',
			'AdSense'=> '/pagead\/show_ads\.js/',
			'XenForo'=> '/js\/xenforo\//i',
			'Cappuccino'=> '/Frameworks\/Objective-J\/Objective-J\.js/',
			'Avactis'=> '/\/avactis-themes\//i',
			'Volusion'=> '/a\/j\/javascripts\.js/',
			'AddThis'=> '/addthis\.com\/js/',
			'DataLife'=> "/dle_root/i",
			'ExtJS'=> "/ext[a-z.]*\.js/i",
			'Drupal'=> "/Drupal\.settings/i",
			'MyBB'=> "/jscripts\/general\.js\?ver=/i"
		);
		
		$found=false;
		$i=strpos($data,"<script ");
		while ($i!==false && $found==false)
		{
			$j=strpos($data,"</script>",$i+9);
			if ($j===false)
			{
				$j=strlen($data)-1;
			}
			$meta_tag=substr($data,$i,$j-$i+9);
			foreach($script_tests as $tag=>$regex)
			{
				preg_match($regex, $meta_tag, $matches);
				if (!empty($matches))
				{
					if (!in_array($tag,$apps))
					{
						array_push($apps,$tag);
					}
					break;
				}
			}
			$i=strpos($data,"<script ",$i+1);
		}
		
		// detect by regexp
		$text_tests = array(
			'SMF'=> "/<script .+\s+var smf_/i",
			'Magento'=> "/var BLANK_URL = '[^>]+js\/blank\.html'/i",
			'Tumblr'=> "/<iframe src=(\"|')http:\/\/\S+\.tumblr\.com/i",
			'WordPress'=> "/<link rel=(\"|')stylesheet(\"|') [^>]+wp-content/i",
			'Closure'=> "/<script[^>]*>.*goog\.require/is",
			'Liferay'=> "/<script[^>]*>.*LifeRay\.currentURL/is",
			'vBulletin'=> "/vbmenu_control/i",
			'MODx'=> "/(<a[^>]+>Powered by MODx<\/a>|var el= \$\('modxhost'\);|<script type=(\"|')text\/javascript(\"|')>var MODX_MEDIA_PATH = \"media\";)/i",
			'miniBB'=> "/<a href=(\"|')[^>]+minibb.+\s*<!--End of copyright link/is",
			'GetSatisfaction'=> "/asset_host\s*\+\s*\"javascripts\/feedback.*\.js/im", // better recognization
			'Fatwire'=> "/\/Satellite\?|\/ContentServer\?/s",
			'Contao'=> "/powered by (TYPOlight|Contao)/is",
			'Moodle' => "/<link[^>]*\/theme\/standard\/styles.php\".*>/",
			'1c-bitrix' => "/<link[^>]*\/bitrix\/.*?>/i",
			'OpenCMS' => "/<link[^>]*\.opencms\..*?>/i",
			'GoogleFontApi'=> "/ref=[\"']?http:\/\/fonts.googleapis.com\//i",
			'Prostores' => "/-legacycss\/Asset\">/",
			'osCommerce'=> "/(product_info\.php\?products_id|_eof \/\/-->)/",
			'OpenCart'=> "/index\.php\?route=product\/product/i"
		);
		
		foreach($text_tests as $tag=>$regex)
		{
			preg_match($regex, $data, $matches);
			if (!empty($matches))
			{
				if (!in_array($tag,$apps))
				{
					array_push($apps,$tag);
				}
			}
		}
		
		return $apps;
	}
	
	public static function appToURL($app)
	{
		$apps = array(
			'Joomla'=> 'http://www.joomla.org',
			'vBulletin'=> 'http://www.vbulletin.com',
			'WordPress'=> 'http://www.wordpress.org',
			'XOOPS'=> 'http://www.xoops.org',
			'Plone'=> 'http://www.plone.org',
			'MediaWiki'=> 'http://www.mediawiki.org',
			'CMSMadeSimple'=> 'http://www.CMSMadeSimple.org',
			'SilverStripe'=> 'http://www.SilverStripe.org',
			'Movable Type'=> 'http://www.movabletype.org',
			'Amiro.CMS'=> 'http://www.amirocms.com',
			'Koobi'=> 'http://www.koobi.com',
			'bbPress'=> 'http://www.bbPress.org',
			'DokuWiki'=> 'http://www.dokuWiki.org',
			'TYPO3'=> 'http://www.typo3.com',
			'PHP-Nuke'=> 'http://phpnuke.org/',
			'DotNetNuke'=> 'http://www.dotnetnuke.com/',
			'Sitefinity'=> 'http://www.sitefinity.com/',
			'WebGUI'=> 'http://www.webgui.org/',
			'ez Publish'=> 'http://ez.no/',
			'BIGACE'=> 'http://www.bigace.de/',
			'TypePad'=> 'http://typepad.com',
			'Blogger'=> 'http://blogger.com',
			'PrestaShop'=> 'http://www.prestashop.com/',
			'SharePoint'=> 'http://sharepoint.microsoft.com',
			'JaliosJCMS'=> 'http://www.jalios.com',
			'ZenCart'=> 'http://www.zen-cart.com',
			'WPML'=> 'http://wpml.org/',
			'PivotX'=> 'http://pivotx.net',
			'OpenACS'=> 'http://openacs.org',
			'phpBB'=> 'http://www.phpbb.com',
			'Elgg'=> 'http://www.elgg.org/',
			'Serendipity'=> 'http://www.s9y.org/',
			'Avactis'=> 'http://www.avactis.com',
			'Drupal'=> "http://www.drupal.org/",
			
			'Google Analytics'=> 'http://www.google.com/analytics/',
			'Quantcast'=> 'http://www.quantcast.com/',
			'Prototype'=> 'http://www.prototypejs.org/',
			'Ubercart'=> 'http://www.ubercart.org/',
			'Closure'=> 'http://code.google.com/closure/',
			'MODx'=> 'http://modxcms.com/',
			'MooTools'=> 'http://mootools.net/',
			'Dojo'=> 'http://www.dojotoolkit.org/',
			'script.aculo.us'=> 'http://script.aculo.us/',
			'Disqus'=> 'http://disqus.com/',
			'GetSatisfaction'=> 'http://getsatisfaction.com',
			'Wibiya'=> 'http://wibiya.com/',
			'reCaptcha'=> 'http://recaptcha.net/',
			'Mollom'=> 'http://mollom.com', // only work on Drupal now
			'ZenPhoto'=> 'http://www.zenphoto.org',
			'Gallery2'=> 'http://gallery.menalto.com/',
			'AdSense'=> 'https://www.google.com/adsense',
			'XenForo'=> 'http://xenforo.com',
			'Cappuccino'=> 'http://cappuccino.org/',
			'Avactis'=> 'http://www.avactis.com',
			'Volusion'=> 'http://www.volusion.com',
			'AddThis'=> 'http://www.addthis.com',
			
			'SMF'=> "http://www.simplemachines.org/",
			'Magento'=> "http://www.magentocommerce.com/",
			'Tumblr'=> "http://tumblr.com",
			'Liferay'=> "http://www.liferay.com",
			'vBulletin'=> "http://www.vbulletin.com/",
			'miniBB'=> "http://www.minibb.com/",
			'Fatwire'=> "http://www.fatwire.com",
			'Contao'=> "http://www.contao.org",
			'Moodle' => "http://moodle.org",
			'1c-bitrix' => "http://www.1c-bitrix.ru/",
			'OpenCMS' => "http://www.opencms.org/",
			'GoogleFontApi'=> "http://code.google.com/apis/webfonts/",
			'Prostores' => "http://www.prostores.com",
			'osCommerce'=> "http://www.oscommerce.com",
			'OpenCart'=> "http://www.opencart.com",
			'MyBB'=> "http://www.mybb.com",
			
			'DataLife'=> "http://www.datalifeengine.ir/",
			'jQuery'=> "http://jquery.com/",
			'ExtJS'=> "http://sencha.com/",
		);
		
		return $apps[$app];
	}
}
?>
