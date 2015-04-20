<?php
/**
 * iWiki 스킨입니다.
 *
 * Translated from gwicke's previous TAL template version to remove
 * dependency on PHPTAL.
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
 * @todo document
 * @file
 * @ingroup Skins
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( -1 );
}

/**
 * Inherit main code from SkinTemplate, set the CSS and template filter.
 * @todo document
 * @ingroup Skins
 */


class SkiniWiki extends SkinTemplate {
	/** Using iwiki. */
	var $skinname = 'iwiki', $stylename = 'iwiki',
		$template = 'iWikiTemplate', $useHeadElement = true;

	/**
	 * @param $out OutputPage
	 */

	public function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$out->addScriptFile('https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js');
		$out->addScriptFile( '../iwiki/bootstrap/js/bootstrap.min.js' );
		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1, maximum-scale=1' );
	}


	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( array( 'mediawiki.skinning.interface') );
		$out->addStyle( 'iwiki/bootstrap/css/bootstrap.min.css' );
		$out->addStyle( 'iwiki/iwiki.css?v=324' );
	}
}

/**
 * @todo document
 * @ingroup Skins
 */
class iWikiTemplate extends BaseTemplate {

	/**
	 * Template filter callback for iWiki skin.
	 * Takes an associative array of data set from a SkinTemplate-based
	 * class, and a wrapper for MediaWiki's localization database, and
	 * outputs a formatted page.
	 *
	 * @access private
	 */
	function execute() {
		global $wgUser;
		// Suppress warnings to prevent notices about missing indexes in $this->data
		wfSuppressWarnings();

		$userLinks = $this->getPersonalTools();
                $user = ( $wgUser->isLoggedIn() ) ? array_shift($userLinks) : array_pop($userLinks);
                $userLink = $user['links'][0];		

		$this->html( 'headelement' );
?>
<div style="width:100%;text-align:center;">
	<div class="navbar navbar-iWiki navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle navbar-left collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
				</button>

				<form class="navbar-form navbar-right navbar-small-form" action="<?php $this->text( 'wgScript' ) ?>">
					<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
					<?php echo $this->makeSearchInput( array( "id" => "searchInput", "class" => "form-control", "placeholder" => "검색어") ); ?>
							</form>

				<button type="button" class="navbar-toggle navbar-toogle-right collapsed" data-toggle="collapse" <?php
				if ( $wgUser->isLoggedIn() ) {
					?>data-target="#personalbar" <?php
				} else {
					?>onclick="location.href='<?php echo $userLink['href']; ?>'"<?php
				}
				?>aria-expanded="false" aria-controls="personalbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
							</button>


				<a class="navbar-brand" href="/wiki/FrontPage"><?php $this->msg( 'tagline' ) ?></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-left">
					<?php
					$this->customBox('navigaion', $this->data['sidebar']['navigation']);
					?>
				</ul>
				<?php
				if ( $wgUser->isLoggedIn() ) {
					?>
					<a class="btn btn-success loginbtn navbar-right" data-toggle="collapse" href="#personalbar" aria-expanded="false" aria-controls="personalbar">
					<?=$wgUser->getName();?>
					</a>
				<?php
				} else {
								echo Linker::linkKnown( SpecialPage::getTitleFor( 'Userlogin' ), wfMsg( 'login' ), array( 'class' => 'navbar-right btn btn-warning loginbtn ') );
				} 
				?>
				<form class="navbar-form navbar-right" action="<?php $this->text( 'wgScript' ) ?>">
					<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
					<?php echo $this->makeSearchInput( array( "id"=>"searchInput","class" => "form-control", "placeholder" => "검색어") ); ?>
				</form>
			</div>
			<div id="personalbar" class="navbar-personal collapse">
				<ul class="nav nav-stacked navbar-personalbar">
					<?php
					$user_icon = '<span class="user-icon"><img src="https://secure.gravatar.com/avatar/'.md5(strtolower( $wgUser->getEmail())).'.jpg?s=20&r=g"/></span>';
					$name = strtolower( $wgUser->getName() );
					$user_nav = $this->get_array_links( $this->data['personal_urls'], $user_icon . $name, 'user' );
					echo $user_nav;
					?>
							</ul>
			</div>
			
		</div>
	</div>
</div>
<div id="globalWrapper">
<div id="content" class="mw-body-primary" role="main">
	<div class="top_menu">
		<ul>
			<?php
			$title = $this->getSkin()->getTitle();
			if ( $title->getNamespace() != NS_SPECIAL ) {
				$companionTitle = $title->isTalkPage() ? $title->getSubjectPage() : $title->getTalkPage();
			} 
			?>
			<li><?php echo Linker::linkKnown( $title, '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 편집', null, array( 'action' => 'edit' ) ); ?></li>
			<li><?php echo Linker::linkKnown( $title, '<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span> 새문단', null, array( 'action' => 'edit', 'section' => 'new' ) ); ?></li>
			<li><?php echo Linker::linkKnown( $title, '<span class="glyphicon glyphicon-time" aria-hidden="true"></span> 기록', null, array( 'action' => 'history' ) ); ?></li>
			<?php 
			if ( $companionTitle ) { ?>
				<li><?php echo Linker::linkKnown( $companionTitle, '<span class="glyphicon glyphicon-fire" aria-hidden="true"></span> 토론', null ); ?></li>
			<?php
			} ?>
			<?php
			$mode = $this->getSkin()->getUser()->isWatched( $this->getSkin()->getRelevantTitle() ) ? 'unwatch' : 'watch';
			if ($mode != 'watch') {
				$watchname = '주시해제';
			} else {
				$watchname = '주시';
				$emptystar = '-empty';
			}
			?>
			<li><?php echo Linker::linkKnown( $title, '<span class="glyphicon glyphicon-star' . $emptystar . '" aria-hidden="true"></span> ' . $watchname, null, array( 'action' => $mode ) ); ?></li>
			<li><?php echo Linker::linkKnown( SpecialPage::getTitleFor( 'Movepage', $title ), '<span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> 옮기기' ); ?></li>
			<?php if ( $title->quickUserCan( 'protect', $user ) ) { ?>
			<li><?php echo Linker::linkKnown( $title, '<span class="glyphicon glyphicon-lock" aria-hidden="true"></span> 보호', null, array( 'action' => 'protect' ) ); ?></li>
			<?php } ?>
			<?php if ( $title->quickUserCan( 'delete', $user ) ) {
			?>
			<li><?php echo Linker::linkKnown( $title, '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 삭제', null, array( 'action' => 'delete' ) ); ?></li>
			<?php }
			?>
		</ul>
	</div>
	<?php if ( $this->data['sitenotice'] ) { ?><div id="siteNotice"><?php $this->html( 'sitenotice' ) ?></div><?php } ?>

	<h1 id="firstHeading" class="firstHeading" lang="<?php
		$this->data['pageLanguage'] = $this->getSkin()->getTitle()->getPageViewLanguage()->getHtmlCode();
		$this->text( 'pageLanguage' );
	?>"><span dir="auto"><?php $this->html( 'title' ) ?></span></h1>
	<div id="bodyContent" class="mw-body">
		<div id="contentSub"<?php $this->html( 'userlangattributes' ) ?>><?php $this->html( 'subtitle' ) ?></div>
<?php if ( $this->data['undelete'] ) { ?>
		<div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
<?php } ?><?php if ( $this->data['newtalk'] ) { ?>
		<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
<?php } ?>
		<div id="jump-to-nav" class="mw-jump"><?php $this->msg( 'jumpto' ) ?> <a href="#column-one"><?php $this->msg( 'jumptonavigation' ) ?></a><?php $this->msg( 'comma-separator' ) ?><a href="#searchInput"><?php $this->msg( 'jumptosearch' ) ?></a></div>

		<!-- start content -->
<?php $this->html( 'bodytext' ) ?>
		<?php if ( $this->data['catlinks'] ) { $this->html( 'catlinks' ); } ?>
		<!-- end content -->
		<?php if ( $this->data['dataAfterContent'] ) { $this->html( 'dataAfterContent' ); } ?>
		<div class="visualClear"></div>
	</div>
</div>
<div class="visualClear"></div>
<?php
	$validFooterIcons = $this->getFooterIcons( "icononly" );
	$validFooterLinks = $this->getFooterLinks( "flat" ); // Additional footer links

	if ( count( $validFooterIcons ) + count( $validFooterLinks ) > 0 ) { ?>
<div id="footer" role="contentinfo"<?php $this->html( 'userlangattributes' ) ?>>
<?php
		$footerEnd = '</div>';
	} else {
		$footerEnd = '';
	}
	foreach ( $validFooterIcons as $blockName => $footerIcons ) { ?>
	<div id="f-<?php echo htmlspecialchars( $blockName ); ?>ico">
<?php foreach ( $footerIcons as $icon ) { ?>
		<?php echo $this->getSkin()->makeFooterIcon( $icon ); ?>

<?php }
?>
	</div>
<?php }

		if ( count( $validFooterLinks ) > 0 ) {
?>	<ul id="f-list">
<?php
			foreach ( $validFooterLinks as $aLink ) { ?>
		<li id="<?php echo $aLink ?>"><?php $this->html( $aLink ) ?></li>
<?php
			}
?>
	</ul>
<?php	}
echo $footerEnd;
?>

</div>
<?php
		$this->printTrail();
		echo Html::closeElement( 'body' );
		echo Html::closeElement( 'html' );
		wfRestoreWarnings();
	} // end of execute() method

	/*************************************************************************************************/

	/**
	 * @param $sidebar array
	 */
	protected function renderPortals( $sidebar ) {
		if ( !isset( $sidebar['SEARCH'] ) ) {
			$sidebar['SEARCH'] = true;
		}
		if ( !isset( $sidebar['TOOLBOX'] ) ) {
			$sidebar['TOOLBOX'] = true;
		}
		if ( !isset( $sidebar['LANGUAGES'] ) ) {
			$sidebar['LANGUAGES'] = true;
		}

		foreach ( $sidebar as $boxName => $content ) {
			if ( $content === false ) {
				continue;
			}
		
			if ( $boxName == 'SEARCH' ) {
				$this->searchBox();
			} elseif ( $boxName == 'TOOLBOX' ) {
				$this->toolbox();
			} elseif ( $boxName == 'LANGUAGES' ) {
				$this->languageBox();
			} else {
				$this->customBox( $boxName, $content );
			}
		}
	}

	function searchBox() {
		global $wgUseTwoButtonsSearchForm;
?>
	<div id="p-search" class="portlet" role="search">
		<h3><label for="searchInput"><?php $this->msg( 'search' ) ?></label></h3>
		<div id="searchBody" class="pBody">
			<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
				<input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>"/>
				<?php echo $this->makeSearchInput( array( "id" => "searchInput" ) ); ?>

				<?php echo $this->makeSearchButton( "go", array( "id" => "searchGoButton", "class" => "searchButton" ) );
				if ( $wgUseTwoButtonsSearchForm ) { ?>&#160;
				<?php echo $this->makeSearchButton( "fulltext", array( "id" => "mw-searchButton", "class" => "searchButton" ) );
				} else { ?>

				<div><a href="<?php $this->text( 'searchaction' ) ?>" rel="search"><?php $this->msg( 'powersearch-legend' ) ?></a></div><?php
				} ?>

			</form>

			<?php $this->renderAfterPortlet( 'search' ); ?>
		</div>
	</div>
<?php
	}

	/**
	 * Prints the cactions bar.
	 * Shared between iWiki and Modern
	 */
	function cactions() {
		foreach ( $this->data['content_actions'] as $key => $tab ) {
		echo $key . '?';
		}

	}
	/*************************************************************************************************/
	function toolbox() {
?>
	<div class="portlet" id="p-tb" role="navigation">
		<h3><?php $this->msg( 'toolbox' ) ?></h3>
		<div class="pBody">
			<ul>
<?php
		foreach ( $this->getToolbox() as $key => $tbitem ) { ?>
				<?php echo $this->makeListItem( $key, $tbitem ); ?>

<?php
		}
		wfRunHooks( 'iWikiTemplateToolboxEnd', array( &$this ) );
		wfRunHooks( 'SkinTemplateToolboxEnd', array( &$this, true ) );
?>
			</ul>
<?php		$this->renderAfterPortlet( 'tb' ); ?>
		</div>
	</div>
<?php
	}

	/*************************************************************************************************/
	function languageBox() {
		if ( $this->data['language_urls'] !== false ) {
?>
	<div id="p-lang" class="portlet" role="navigation">
		<h3<?php $this->html( 'userlangattributes' ) ?>><?php $this->msg( 'otherlanguages' ) ?></h3>
		<div class="pBody">
			<ul>
<?php		foreach ( $this->data['language_urls'] as $key => $langlink ) { ?>
				<?php echo $this->makeListItem( $key, $langlink ); ?>

<?php		} ?>
			</ul>

<?php		$this->renderAfterPortlet( 'lang' ); ?>
		</div>
	</div>
<?php
		}
	}

	/*************************************************************************************************/
	/**
	 * @param $bar string
	 * @param $cont array|string
	 */
	function customBox( $bar, $cont ) {
		$msgObj = wfMessage( $bar );
		if ( is_array( $cont ) ) { 
			foreach ( $cont as $key => $val ) { 
				echo $this->makeListItem( $key, $val );
			}
		} else {
			print $cont;
		}
		$this->renderAfterPortlet( $bar );
	}

	private function nav( $nav ) {
		$output = '';
		foreach ( $nav as $topItem ) {
			$pageTitle = Title::newFromText( $topItem['link'] ?: $topItem['title'] );
			if ( array_key_exists( 'sublinks', $topItem ) ) {
				foreach ( $topItem['sublinks'] as $subLink ) {
					if ( 'divider' == $subLink ) {
						$output .= "<li class='divider'></li>\n";
					} elseif ( $subLink['textonly'] ) {
						$output .= "<li class='nav-header'>{$subLink['title']}</li>\n";
					} else {
						if( $subLink['local'] && $pageTitle = Title::newFromText( $subLink['link'] ) ) {
							$href = $pageTitle->getLocalURL();
						} else {
							$href = $subLink['link'];
						}//end else
						$slug = strtolower( str_replace(' ', '-', preg_replace( '/[^a-zA-Z0-9 ]/', '', trim( strip_tags( $subLink['title'] ) ) ) ) );
						$output .= "<li {$subLink['attributes']}><a href='{$href}' class='{$subLink['class']} {$slug}'>{$subLink['title']}</a>";
					}//end else
				}
			} else {
				if( $pageTitle ) {
					$output .= '<li' . ($this->data['title'] == $topItem['title'] ? ' class="active"' : '') . '><a href="' . ( $topItem['external'] ? $topItem['link'] : $pageTitle->getLocalURL() ) . '">' . $topItem['title'] . '</a></li>';
				}//end if
			}//end else
		}//end foreach
		return $output;
	}//end nav

	function get_array_links( $array, $title, $which ) {
		$nav = array();
		$nav[] = array('title' => $title );
		foreach( $array as $key => $item ) {
			$link = array(
				'id' => Sanitizer::escapeId( $key ),
				'attributes' => $item['attributes'],
				'link' => htmlspecialchars( $item['href'] ),
				'key' => $item['key'],
				'class' => htmlspecialchars( $item['class'] ),
				'title' => htmlspecialchars( $item['text'] ),
			);
			if( 'page' == $which ) {
				switch( $link['title'] ) {
				case 'Page': $icon = 'file'; break;
				case 'Discussion': $icon = 'comment'; break;
				case 'Edit': $icon = 'pencil'; break;
				case 'History': $icon = 'clock-o'; break;
				case 'Delete': $icon = 'remove'; break;
				case 'Move': $icon = 'arrows'; break;
				case 'Protect': $icon = 'lock'; break;
				case 'Watch': $icon = 'eye-open'; break;
				case 'Unwatch': $icon = 'eye-slash'; break;
				}//end switch
				$link['title'] = '<i class="fa fa-' . $icon . '"></i> ' . $link['title'];
			} elseif( 'user' == $which ) {
				switch( $link['title'] ) {
				case 'My talk': $icon = 'comment'; break;
				case 'My preferences': $icon = 'cog'; break;
				case 'My watchlist': $icon = 'eye-close'; break;
				case 'My contributions': $icon = 'list-alt'; break;
				case 'Log out': $icon = 'off'; break;
				default: $icon = 'user'; break;
				}//end switch
				$link['title'] = '<i class="fa fa-' . $icon . '"></i> ' . $link['title'];
			}//end elseif
			$nav[0]['sublinks'][] = $link;
		}//end foreach
		return $this->nav( $nav );
	}

} // end of class
