<?php
/**
 * Definition of Mantle's ResourceLoader modules.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgResourceModules = array_merge( $wgResourceModules, array(
	'ext.mantle' => $wgMantleResourceBoilerplate + array(
		'scripts' => array(
			'javascripts/common/main.js',
		),
	),
	'ext.mantle.modules' => $wgMantleResourceBoilerplate + array(
		'scripts' => array(
			'javascripts/common/modules.js',
		),
		'dependencies' => array(
			'ext.mantle',
		),
	),
	'ext.mantle.templates' => $wgMantleResourceBoilerplate + array(
		'dependencies' => array(
			'ext.mantle',
		),
		'scripts' => array(
			'javascripts/common/templates.js',
		),
	),
	'ext.mantle.hogan' => $wgMantleResourceBoilerplate + array(
		'dependencies' => array(
			'ext.mantle.templates',
		),
		'scripts' => array(
			'javascripts/externals/hogan.js',
			'javascripts/common/templates/hogan.js',
		),
	),
	'ext.mantle.handlebars' => $wgMantleResourceBoilerplate + array(
		'dependencies' => array(
			'ext.mantle.templates',
		),
		'scripts' => array(
			'javascripts/externals/handlebars.js',
			'javascripts/common/templates/handlebars.js',
		),
	),
	'ext.mantle.oo' => $wgMantleResourceBoilerplate + array(
		'dependencies' => array(
			'ext.mantle.modules',
			'oojs',
		),
		'scripts' => array(
			'javascripts/common/Class.js',
			'javascripts/common/eventemitter.js',
		),
	),
	'ext.mantle.views' => $wgMantleResourceBoilerplate + array(
		'dependencies' => array(
			'ext.mantle.oo',
			'ext.mantle.templates',
		),
		'scripts' => array(
			'javascripts/common/View.js',
		),
	),
) );
