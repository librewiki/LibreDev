<?php
/**
  * Extension:Josa
  * Author: JuneHyeon Bae <devunt@gmail.com>
  * Original implementation by Park Shinjo <peremen@gmail.com>
  * Improve Extension:Hanp (bug: 13712)
  * License: MIT License
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a vaild entry point' );
}

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Josa',
	'author' => 'JuneHyeon Bae (devunt)',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Josa',
	'description' => 'Automates some part of Korean transliteration process.',
	'version'  => '0.1',
);
$wgHooks['ParserFirstCallInit'][] = 'JosaPFSetup';
$wgExtensionMessagesFiles['Josa'] = dirname( __FILE__ ) . '/Josa.i18n.php';

$Josa = array(
	'ER' => array( '을', '를', '을(를)' ),
	'EN' => array( '은', '는', '은(는)' ),
	'IG' => array( '이', '가', '이(가)' ),
	'GW' => array( '과', '와', '과(와)' ),
	'AY' => array( '아', '야', '아(야)' ),
	'I'  => array( '이', '', '(이)' ),
	'E'  => array( '으', '', '(으)' ),
);

function JosaPFSetup( &$parser ) {
	$parser->setFunctionHook( 'EulRuel', 'JosaRenderER' ); # 곶감을 / 사과를
	$parser->setFunctionHook( 'EunNeun', 'JosaRenderEN' ); # 곶감은 / 사과는
	$parser->setFunctionHook( 'IGa', 'JosaRenderIG' ); # 곶감이 / 사과가
	$parser->setFunctionHook( 'GwaWa', 'JosaRenderGW' ); # 곶감과 / 사과와
	$parser->setFunctionHook( 'AYa', 'JosaRenderAY' ); # 태준아 / 철수야
	$parser->setFunctionHook( 'I', 'JosaRenderI' ); # 태준이가 / 철수가
	$parser->setFunctionHook( 'Eu', 'JosaRenderE' ); # 집으로 / 학교로
	$parser->setFunctionHook( 'HaveTail', 'JosaRenderExist' );
	return true;
}

function _utf8_to_unicode( $str ) {
	$values = array();
	$lookingFor = 1;
	for ( $i = 0; $i < strlen( $str ); $i++ ) {
		$thisValue = ord( $str[ $i ] );
		if ( $thisValue < 128 ) return false;
		else {
			if ( count( $values ) == 0 ) $lookingFor = ( $thisValue < 224 ) ? 2 : 3;
			$values[] = $thisValue;
			if ( count( $values ) == $lookingFor ) {
				$number = ( $lookingFor == 3 ) ?
				( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ):
				( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64 );
				return $number;
			}
		}
	}
}

function _isHaveTail( $str, $isE = false ) {
	if ( mb_substr( $str, -2, 2, 'utf-8' ) == ']]' ) { # if end with internel link
		$str = mb_substr( $str, 0, -2, 'utf-8' );
	}
	$result = _utf8_to_unicode( mb_substr( $str, -1, 1, 'utf-8' ) );
	if ( !$result ) {
		return 2; # 한글이 아님
	} elseif ( ( $result - 0xAC00 ) % 28 == 0 ) {
		return 1; # 받침이 없음
	} elseif ( $isE && ( ( $result - 0xAC00 ) % 28 == 8 ) ) {
		return 1; # 받침이 ㄹ. 받침이 없는 것과 동일하게 처리 ((으) 일때만, ㄹ 변칙)
	} else {
		return 0; # 받침이 있음
	}
}

function getJosa( $type, $str ) {
	global $Josa;
	if ( $type == 'E' ) {
		$tail = _isHaveTail( $str, true );
	} else {
		$tail = _isHaveTail( $str );
	}
	return $Josa[$type][$tail];
}


function JosaRenderER( $parser, $str ) {
	return getJosa( 'ER', $str );
}

function JosaRenderEN( $parser, $str ) {
	return getJosa( 'EN', $str );
}

function JosaRenderIG( $parser, $str ) {
	return getJosa( 'IG', $str );
}

function JosaRenderGW( $parser, $str ) {
	return getJosa( 'GW', $str );
}

function JosaRenderAY( $parser, $str ) {
	return getJosa( 'AY', $str );
}

function JosaRenderI( $parser, $str ) {
	return getJosa( 'I', $str );
}

function JosaRenderE( $parser, $str ) {
	return getJosa( 'E', $str );
}

function JosaRenderExist( $parser, $str ) {
	return !_isHaveTail( $str );
}
