<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			conf.php
//		Description:
//			This file configures the Wordpress Plugin - Automatic Video Posts Plugin
//		Copyright:
//			Copyright (c) 2021 Ternstyle LLC.
//		License:
//			This software is licensed under the terms of the End User License Agreement (EULA)
//			provided with this software. In the event the EULA is not present with this software
//			or you have not read it, please visit:
//			http://www.ternstyle.us/automatic-video-posts-plugin-for-wordpress/license.html
//
////////////////////////////////////////////////////////////////////////////////////////////////////

/****************************************Commence Script*******************************************/

use ternpress\ternWP;
use ternstyle\tern_select;
use ternstyle\tern_dir as tern_dir;
use ternpress\tern_option as tern_option;

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*------------------------------------------------------------------------------------------------
	Global Variables
------------------------------------------------------------------------------------------------*/

define('AYVPP_URL',plugin_dir_url('').'/automatic-youtube-video-posts');
define('AYVPP_ADMIN_URL',AYVPP_URL.'/admin');
define('AYVPP_PUBLIC_URL',AYVPP_URL.'/public');
define('AYVPP_ROOT',get_bloginfo('wpurl'));
define('AYVPP_DIR',dirname(__FILE__));
define('AYVPP_CLASS_DIR',dirname(__FILE__).'/class');
define('AYVPP_COMMON_DIR',dirname(__FILE__).'/common');
define('AYVPP_ADMIN_DIR',dirname(__FILE__).'/admin');
define('AYVPP_PUBLIC_DIR',dirname(__FILE__).'/public');
define('AYVPP_VERSION','5.2.3');
$ayvpp_version = [5,2,3];

$WP_ayvpp_options = [
	'updater_checked'			=>	0,
	'key'					=>	'',
	'channels'				=>	array(),
	'cron'					=>	6,
	'last_import'				=>	'',
	'content_display_meta'		=>	1,
	'content_truncate'			=>	1,
	'content_truncate_after'		=>	20,
	'content_top'				=>	0,

	'video_responsive'			=>	1,
	'video_responsive_ratio'		=>	'16:9',
	'video_dims'				=>	array(506,304),
	'video_related_show'		=>	0,
	'video_post_list_show'		=>	0,

	'video_autoplay'			=>	0,
	'video_cc_lang'			=>	'en',
	'video_cc_load'			=>	0,
	'video_color'				=>	0,
	'video_controls'			=>	1,
	//'video_disablekb'			=>	0,
	'video_fs'				=>	1,
	'video_lang'				=>	'en',
	//'video_iv_load'			=>	1,
	'video_loop'				=>	0,
	//'video_modestbranding'		=>	0,
	'video_rel'				=>	0,

	'thumbs_show'				=>	1,
	'verified'				=>	false,
	'serial'					=>	'',
	'admin_import'				=>	1,
	'import_thumbnails'			=>	1,
	'import_date'				=>	0,
	'cainfo'					=>	0,
];

$WP_ayvpp_lang_codes = [
    'ab' => 'Abkhazian',
    'aa' => 'Afar',
    'af' => 'Afrikaans',
    'ak' => 'Akan',
    'sq' => 'Albanian',
    'am' => 'Amharic',
    'ar' => 'Arabic',
    'an' => 'Aragonese',
    'hy' => 'Armenian',
    'as' => 'Assamese',
    'av' => 'Avaric',
    'ae' => 'Avestan',
    'ay' => 'Aymara',
    'az' => 'Azerbaijani',
    'bm' => 'Bambara',
    'ba' => 'Bashkir',
    'eu' => 'Basque',
    'be' => 'Belarusian',
    'bn' => 'Bengali',
    'bh' => 'Bihari languages',
    'bi' => 'Bislama',
    'bs' => 'Bosnian',
    'br' => 'Breton',
    'bg' => 'Bulgarian',
    'my' => 'Burmese',
    'ca' => 'Catalan, Valencian',
    'km' => 'Central Khmer',
    'ch' => 'Chamorro',
    'ce' => 'Chechen',
    'ny' => 'Chichewa, Chewa, Nyanja',
    'zh' => 'Chinese',
    'cu' => 'Church Slavonic, Old Bulgarian, Old Church Slavonic',
    'cv' => 'Chuvash',
    'kw' => 'Cornish',
    'co' => 'Corsican',
    'cr' => 'Cree',
    'hr' => 'Croatian',
    'cs' => 'Czech',
    'da' => 'Danish',
    'dv' => 'Divehi, Dhivehi, Maldivian',
    'nl' => 'Dutch, Flemish',
    'dz' => 'Dzongkha',
    'en' => 'English',
    'eo' => 'Esperanto',
    'et' => 'Estonian',
    'ee' => 'Ewe',
    'fo' => 'Faroese',
    'fj' => 'Fijian',
    'fi' => 'Finnish',
    'fr' => 'French',
    'ff' => 'Fulah',
    'gd' => 'Gaelic, Scottish Gaelic',
    'gl' => 'Galician',
    'lg' => 'Ganda',
    'ka' => 'Georgian',
    'de' => 'German',
    'ki' => 'Gikuyu, Kikuyu',
    'el' => 'Greek (Modern)',
    'kl' => 'Greenlandic, Kalaallisut',
    'gn' => 'Guarani',
    'gu' => 'Gujarati',
    'ht' => 'Haitian, Haitian Creole',
    'ha' => 'Hausa',
    'he' => 'Hebrew',
    'hz' => 'Herero',
    'hi' => 'Hindi',
    'ho' => 'Hiri Motu',
    'hu' => 'Hungarian',
    'is' => 'Icelandic',
    'io' => 'Ido',
    'ig' => 'Igbo',
    'id' => 'Indonesian',
    'ia' => 'Interlingua (International Auxiliary Language Association)',
    'ie' => 'Interlingue',
    'iu' => 'Inuktitut',
    'ik' => 'Inupiaq',
    'ga' => 'Irish',
    'it' => 'Italian',
    'ja' => 'Japanese',
    'jv' => 'Javanese',
    'kn' => 'Kannada',
    'kr' => 'Kanuri',
    'ks' => 'Kashmiri',
    'kk' => 'Kazakh',
    'rw' => 'Kinyarwanda',
    'kv' => 'Komi',
    'kg' => 'Kongo',
    'ko' => 'Korean',
    'kj' => 'Kwanyama, Kuanyama',
    'ku' => 'Kurdish',
    'ky' => 'Kyrgyz',
    'lo' => 'Lao',
    'la' => 'Latin',
    'lv' => 'Latvian',
    'lb' => 'Letzeburgesch, Luxembourgish',
    'li' => 'Limburgish, Limburgan, Limburger',
    'ln' => 'Lingala',
    'lt' => 'Lithuanian',
    'lu' => 'Luba-Katanga',
    'mk' => 'Macedonian',
    'mg' => 'Malagasy',
    'ms' => 'Malay',
    'ml' => 'Malayalam',
    'mt' => 'Maltese',
    'gv' => 'Manx',
    'mi' => 'Maori',
    'mr' => 'Marathi',
    'mh' => 'Marshallese',
    'ro' => 'Moldovan, Moldavian, Romanian',
    'mn' => 'Mongolian',
    'na' => 'Nauru',
    'nv' => 'Navajo, Navaho',
    'nd' => 'Northern Ndebele',
    'ng' => 'Ndonga',
    'ne' => 'Nepali',
    'se' => 'Northern Sami',
    'no' => 'Norwegian',
    'nb' => 'Norwegian Bokmål',
    'nn' => 'Norwegian Nynorsk',
    'ii' => 'Nuosu, Sichuan Yi',
    'oc' => 'Occitan (post 1500)',
    'oj' => 'Ojibwa',
    'or' => 'Oriya',
    'om' => 'Oromo',
    'os' => 'Ossetian, Ossetic',
    'pi' => 'Pali',
    'pa' => 'Panjabi, Punjabi',
    'ps' => 'Pashto, Pushto',
    'fa' => 'Persian',
    'pl' => 'Polish',
    'pt' => 'Portuguese',
    'qu' => 'Quechua',
    'rm' => 'Romansh',
    'rn' => 'Rundi',
    'ru' => 'Russian',
    'sm' => 'Samoan',
    'sg' => 'Sango',
    'sa' => 'Sanskrit',
    'sc' => 'Sardinian',
    'sr' => 'Serbian',
    'sn' => 'Shona',
    'sd' => 'Sindhi',
    'si' => 'Sinhala, Sinhalese',
    'sk' => 'Slovak',
    'sl' => 'Slovenian',
    'so' => 'Somali',
    'st' => 'Sotho, Southern',
    'nr' => 'South Ndebele',
    'es' => 'Spanish, Castilian',
    'su' => 'Sundanese',
    'sw' => 'Swahili',
    'ss' => 'Swati',
    'sv' => 'Swedish',
    'tl' => 'Tagalog',
    'ty' => 'Tahitian',
    'tg' => 'Tajik',
    'ta' => 'Tamil',
    'tt' => 'Tatar',
    'te' => 'Telugu',
    'th' => 'Thai',
    'bo' => 'Tibetan',
    'ti' => 'Tigrinya',
    'to' => 'Tonga (Tonga Islands)',
    'ts' => 'Tsonga',
    'tn' => 'Tswana',
    'tr' => 'Turkish',
    'tk' => 'Turkmen',
    'tw' => 'Twi',
    'ug' => 'Uighur, Uyghur',
    'uk' => 'Ukrainian',
    'ur' => 'Urdu',
    'uz' => 'Uzbek',
    've' => 'Venda',
    'vi' => 'Vietnamese',
    'vo' => 'Volap_k',
    'wa' => 'Walloon',
    'cy' => 'Welsh',
    'fy' => 'Western Frisian',
    'wo' => 'Wolof',
    'xh' => 'Xhosa',
    'yi' => 'Yiddish',
    'yo' => 'Yoruba',
    'za' => 'Zhuang, Chuang',
    'zu' => 'Zulu'
];

/*------------------------------------------------------------------------------------------------
	Vendors
------------------------------------------------------------------------------------------------*/

require_once(dirname(__FILE__).'/vendor/autoload.php');

/*------------------------------------------------------------------------------------------------
	Load Core Files
------------------------------------------------------------------------------------------------*/

(new tern_dir())->include(AYVPP_COMMON_DIR);
if(is_admin()) {
	(new tern_dir())->include(AYVPP_ADMIN_DIR);
}
else {
	(new tern_dir())->include(AYVPP_PUBLIC_DIR);
}

/*------------------------------------------------------------------------------------------------
	Plugin Settings
------------------------------------------------------------------------------------------------*/

add_action('init','WP_ayvpp_init',-9999);
function WP_ayvpp_init() {
	global $WP_ayvpp_options,$ayvpp_options,$getWP,$ternSel;
	$ayvpp_options = (new tern_option())->get('ayvpp_settings',$WP_ayvpp_options);

	//set-up global objects
	$getWP = new ternpress\ternWP;
	$ternSel = new ternstyle\tern_select;

}

/****************************************Terminate Script******************************************/
?>
