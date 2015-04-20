<?php

class SkinMinervaBeta extends SkinMinerva {
	public $template = 'MinervaTemplateBeta';
	protected $mode = 'beta';

	/**
	 * Initializes output page and sets up skin-specific parameters
	 * @param $out OutputPage object to initialize
	 */
	public function initPage( OutputPage $out ) {
		parent::initPage( $out );
		// Enable search header in beta
		if ( $this->getTitle()->isSpecialPage() ) {
			$out->setProperty( 'disableSearchAndFooter', false );
		}
	}

	public function outputPage( OutputPage $out = null ) {
		wfProfileIn( __METHOD__ );
		if ( !$out ) {
			$out = $this->getOutput();
		}
		# Replace page content before DOMParse to make sure images are scrubbed
		# and Zero transformations are applied.
		$this->handleNewPages( $out );
		$this->prepareResponsiveStyles();
		parent::outputPage( $out );
	}

	/**
	 * Prepares head items that add conditionally loaded responsive styles.
	 * FIXME: Review this approach thoroughly before pushing to stable.
	 * Loosely based on:
	 *   http://christianheilmann.com/2012/12/19/conditional-loading-of-resources-with-mediaqueries/
	 */
	protected function prepareResponsiveStyles() {
		global $wgMFDeviceWidthTablet;

		$url = ResourceLoader::makeLoaderURL(
			array( 'tablet.styles' ),
			$this->getLanguage()->getCode(),
			$this->getSkinName(),
			null,
			null,
			ResourceLoader::inDebugMode(),
			'styles'
		);
		$attrs = array(
			'data-href' => $url,
			'data-media' => '(min-width: ' . $wgMFDeviceWidthTablet .'px)'
		);
		$out = $this->getOutput();
		$out->addHeadItem( 'responsiveStyles', Html::element( 'style', $attrs ) );
		$out->addHeadItem( 'responsiveScript', Html::inlineScript(
			"jQuery.matchMedia();"
		) );
	}

	protected function getSearchPlaceHolderText() {
		return wfMessage( 'mobile-frontend-placeholder-beta' )->text();
	}

	protected function getSkinStyles() {
		$title = $this->getTitle();

		$styles = parent::getSkinStyles();
		$styles[] = 'mobile.styles.beta';
		if ( $title->isMainPage() ) {
			$styles[] = 'mobile.styles.mainpage';
		}
		if ( $title->isSpecialPage() ) {
			$styles['special'] = 'skins.minerva.special.styles';
		}

		$key = array_search( 'skins.minerva.buttons.styles', $styles );
		unset( $styles[$key] );
		$styles[] = 'mediawiki.ui.button';

		return $styles;
	}

	protected function prepareQuickTemplate() {
		$tpl = parent::prepareQuickTemplate();
		// Move last modified link to top as long as it is not the main page
		$tpl->set( '_lastModifiedAbove', !$this->getTitle()->isMainPage() );
		return $tpl;
	}

	protected function getHistoryLink( Title $title ) {
		$link = parent::getHistoryLink( $title );
		if ( !$title->isMainPage() ) {
			$link['class'] = 'top-bar truncated-text';
		}
		$link['href'] = SpecialPage::getTitleFor( 'History', $title )->getLocalURL();
		return $link;
	}

	public function getSkinConfigVariables() {
		$vars = parent::getSkinConfigVariables();
		// Kill this when we fix the functionality in PageApi.js
		$user = $this->getUser();
		if ( $user->isLoggedIn() ) {
			$vars['wgMFUserGender'] = $this->getUser()->getOption( 'gender' );
		} else {
			$vars['wgMFUserGender'] = 'unknown';
		}
		return $vars;
	}

	public function getDefaultModules() {
		$modules = parent::getDefaultModules();
		$modules['mobile'][] = 'mobile.head.beta';
		$modules['talk'] = array( 'mobile.talk' );
		$modules['beta'] = array( 'mobile.beta' );
		$modules['beta'][] = 'mobile.geonotahack';
		$modules['toggling'] = array( 'mobile.toggling.beta' );
		// turn off stable only modules
		$modules['stableonly'] = array();
		wfRunHooks( 'SkinMinervaDefaultModules', array( $this, &$modules ) );
		return $modules;
	}

	/**
	 * Creates a login or logout button
	 * @return Array: Representation of button with text and href keys
	*/
	protected function getLogInOutLink() {
		$loginLogoutLink = parent::getLoginOutLink();
		$user = $this->getUser();
		if ( $user->isLoggedIn() ) {
			$loginLogoutLink['class'] = 'icon-secondary icon-secondary-logout';
			$name = $user->getName();
			$loginLogoutLink = array(
				'links' => array(
					array(
						'text' => $name,
						'href' => SpecialPage::getTitleFor( 'UserProfile', $name )->getLocalUrl(),
						'class' => 'icon-profile truncated-text',
					),
					$loginLogoutLink
				),
			);
			$loginLogoutLink['class'] = 'icon-user';
		} else {
			$loginLogoutLink['class'] = 'icon-anon';
		}
		return $loginLogoutLink;
	}

	protected function prepareBanners( BaseTemplate $tpl ) {
		global $wgMFKeepGoing;

		wfProfileIn( __METHOD__ );
		parent::prepareBanners( $tpl );
		$user = $this->getUser();
		$msg = $this->msg( 'mobilefrontend-keepgoing-wikify-category' )->inContentLanguage();
		if ( $wgMFKeepGoing && $this->getTitle()->isMainPage()
			&& $user->isLoggedIn()
			&& $user->getEditCount() > 1
			&& !$msg->isDisabled()
		) {
			$category = Title::newFromText( $msg->text(), NS_CATEGORY );
			if ( !$category ) {
				wfProfileOut( __METHOD__ );
				return;
			}
			// Weird stuff like Category:Wikipedia:Foo
			if ( !$category->inNamespace( NS_CATEGORY ) ) {
				$category = Title::makeTitleSafe( NS_CATEGORY, $category->getText() );
			}
			$rc = new SpecialRandomInCategory();
			$rc->setCategory( $category );
			$title = $rc->getRandomTitle();
			if ( !$title ) {
				wfProfileOut( __METHOD__ );
				return;
			}
			$page = new MobilePage( $title );
			$thumb = $page->getSmallThumbnailHtml( true );
			$html = Html::openElement(
					'ul',
					array( 'class' => 'page-list page-banner' . ( $thumb ? ' thumbs' : '' ) )
				) .
				Html::openElement( 'li', array( 'class' => 'title' ) ) .
				$thumb .
				Html::element( 'h2', array(), $title->getPrefixedText() ) .
				Html::element( 'p', array( 'class' => 'content component' ),
					$this->msg( 'mobile-frontend-mainpage-cta-prompt' )->text() ) .
				Html::openElement( 'p', array( 'class' => 'content component' ) ) .
				Html::element( 'a', array(
					'class' => 'mw-ui-button mw-ui-progressive button',
					'href' => $title->getLocalUrl(
						array( 'campaign' => 'mobile-mainpage-keepgoing-links'  )
					),
				), $this->msg( 'mobile-frontend-mainpage-cta-button' )->text() ) .
				Html::closeElement( 'p' ) .
				Html::closeElement( 'li' ) .
				Html::closeElement( 'ul' );
			$tpl->set( 'internalBanner', $html );
		}
		wfProfileOut( __METHOD__ );
	}

	protected function handleNewPages( OutputPage $out ) {
		# Show error message
		$title = $this->getTitle();
		if ( !$title->exists()
			&& !$title->isSpecialPage()
			&& $title->userCan( 'create', $this->getUser() )
			&& $title->getNamespace() !== NS_FILE
		) {
			$out->clearHTML();
			$out->addHTML(
				Html::openElement( 'div', array( 'id' => 'mw-mf-newpage' ) )
				. wfMessage( 'mobile-frontend-editor-newpage-prompt' )->parse()
				. Html::closeElement( 'div' )
			);
		}
	}

	protected function prepareWarnings( BaseTemplate $tpl ) {
		parent::prepareWarnings( $tpl );
		$out = $this->getOutput();
		if ( $out->getRequest()->getText( 'oldid' ) ) {
			$subtitle = $out->getSubtitle();
			$tpl->set( '_old_revision_warning',
				Html::openElement( 'div', array( 'class' => 'alert warning' ) ) .
				Html::openElement( 'p', array() ).
					Html::element( 'a', array( 'href' => '#editor/0' ),
					$this->msg( 'mobile-frontend-view-source' )->text() ) .
				Html::closeElement( 'p' ) .
				$subtitle .
				Html::closeElement( 'div' ) );
		}
	}

	protected function prepareHeaderAndFooter( BaseTemplate $tpl ) {
		parent::prepareHeaderAndFooter( $tpl );
		$preBodyText = Html::rawElement( 'h1', array( 'id' => 'section_0' ),
			$this->getOutput()->getPageTitle() );
		$tpl->set( 'prebodytext', $preBodyText );
	}
}
