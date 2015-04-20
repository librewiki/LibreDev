<?php
/**
 * Extension Mantle
 *
 * @file
 * @ingroup Extensions
 * @author Jon Robson
 * @licence GNU General Public Licence 2.0 or later
 */
// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Mantle',
	'author' => array( 'Jon Robson', 'Juliusz Gonera' ),
	'descriptionmsg' => 'mantle-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Mantle',
);

$wgMessagesDirs['Mantle'] = __DIR__ . '/i18n';

// autoload extension classes
$autoloadClasses = array (
	'MantleHooks' => 'Hooks',
	'ResourceLoaderTemplateModule' => 'ResourceLoaderTemplateModule',
);

foreach ( $autoloadClasses as $className => $classFilename ) {
	$wgAutoloadClasses[$className] = __DIR__ . "/includes/$classFilename.php";
}

// ResourceLoader modules
/**
 * A boilerplate for the MFResourceLoaderModule that supports templates
 */
$wgMantleResourceBoilerplate = array(
	'localBasePath' => __DIR__,
	'remoteExtPath' => 'Mantle',
	'targets' => array( 'mobile', 'desktop' ),
);
require_once __DIR__ . "/includes/Resources.php";

$wgHooks['UnitTestsList'][] = 'MantleHooks::onUnitTestsList';
$wgHooks['ResourceLoaderTestModules'][] = 'MantleHooks::onResourceLoaderTestModules';
