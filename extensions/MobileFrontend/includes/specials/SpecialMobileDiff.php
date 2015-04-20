<?php

class SpecialMobileDiff extends MobileSpecialPage {
	protected $hasDesktopVersion = true;
	private $revId;
	/** @var Revision */
	private $rev;
	/** @var Revision */
	private $prevRev;
	/** @var Title */
	private $targetTitle;
	/** @var boolean */
	private $useThanks = false;

	public function __construct() {
		parent::__construct( 'MobileDiff' );
	}

	public static function getRevision( $id ) {
		return Revision::newFromId( $id );
	}

	public function executeBadQuery() {
		wfHttpError( 404, $this->msg( 'mobile-frontend-diffview-404-title' )->text(),
			$this->msg( 'mobile-frontend-diffview-404-desc' )->text() );
	}

	/**
	 * Takes 2 ids/keywords and validates them returning respective revisions
	 *
	 * @param Array Array of revision ids currently limited to 2 elements
	 * @return Array of previous and next revision. The next revision is null if
	 *   a bad parameter is passed
	 */
	public function getRevisionsToCompare( $revids ) {
		$prev = null;
		$rev = null;

		// check 2 parameters are passed and are numbers
		if ( count( $revids ) === 2 && $revids[0] && $revids[1] ) {
			$id = intval( $revids[1] );
			$prevId = intval( $revids[0] );
			if ( $id && $prevId ) {
				$rev = static::getRevision( $id );
				// deal with identical ids
				if ( $id === $prevId ) {
					$rev = null;
				} elseif ( $rev ) {
					$prev = static::getRevision( $prevId );
					if ( !$prev ) {
						$rev = null;
					}
				} else {
					$rev = null;
				}
			}
		} elseif ( count( $revids ) === 1 ) {
			$id = intval( $revids[0] );
			if ( $id ) {
				$rev = static::getRevision( $id );
				if ( $rev ) {
					$prev = $rev->getPrevious();
				}
			}
		}
		return array( $prev, $rev );
	}

	function executeWhenAvailable( $par ) {
		wfProfileIn( __METHOD__ );
		$ctx = MobileContext::singleton();
		$this->setHeaders();
		$output = $this->getOutput();

		// @FIXME add full support for git-style notation (eg ...123, 123...)
		$revisions = $this->getRevisionsToCompare( explode( '...', $par ) );
		$rev = $revisions[1];
		$prev = $revisions[0];

		if ( is_null( $rev ) ) {
			$this->executeBadQuery();
			wfProfileOut( __METHOD__ );
			return false;
		}
		$this->revId = $rev->getId();
		$this->rev = $rev;
		$this->prevRev = $prev;
		$this->targetTitle = $this->rev->getTitle();

		$output->setPageTitle( $this->msg(
			'mobile-frontend-diffview-title',
			$this->targetTitle->getPrefixedText()
		) );

		// @todo FIXME: Don't add these styles. This is only needed for the user
		// icon to the left of the username
		$output->addModuleStyles( 'mobile.special.pagefeed.styles' );

		// Allow other extensions to load more stuff here
		wfRunHooks( 'BeforeSpecialMobileDiffDisplay', array( &$output, $ctx, $revisions ) );

		$output->addHtml( '<div id="mw-mf-diffview"><div id="mw-mf-diffarea">' );

		$this->showHeader();
		$this->showDiff();
		$output->addHtml( '</div>' );

		$this->showFooter();

		$output->addHtml( '</div>' );
		wfProfileOut( __METHOD__ );
		return true;
	}

	function showHeader() {
		$title = $this->targetTitle;

		if ( $this->prevRev ) {
			$bytesChanged = $this->rev->getSize() - $this->prevRev->getSize();
		} else {
			$bytesChanged = $this->rev->getSize();
		}
		if ( $bytesChanged >= 0 ) {
			$changeMsg = 'mobile-frontend-diffview-bytesadded';
			$sizeClass = 'mw-mf-bytesadded meta';
		} else {
			$changeMsg = 'mobile-frontend-diffview-bytesremoved';
			$sizeClass = 'mw-mf-bytesremoved meta';
			$bytesChanged = abs( $bytesChanged );
		}

		$ts = new MWTimestamp( $this->rev->getTimestamp() );
		$this->getOutput()->addHtml(
			Html::openElement( 'div', array( 'id' => 'mw-mf-diff-info' ) ) .
				Html::openElement( 'h2', array() ) .
				Html::element( 'a',
					array(
						'href' => $title->getLocalURL(),
					),
					$title->getPrefixedText()
				).
				Html::closeElement( 'h2' ) .
				Html::element( 'span', array( 'class' => $sizeClass ),
					$this->msg( $changeMsg )->numParams( $bytesChanged )->text()
				) .
				$this->msg( 'comma-separator' )->text() .
				Html::element( 'span', array( 'class' => 'mw-mf-diff-date meta' ), $ts->getHumanTimestamp() ) .
			Html::closeElement( 'div' ) .
			Html::element( 'div', array( 'id' => 'mw-mf-diff-comment' ), $this->rev->getComment() )
		);
	}

	function showDiff() {
		$ctx = MobileContext::singleton();

		$prevId = $this->prevRev ? $this->prevRev->getId() : 0;
		$unhide = (bool)$this->getRequest()->getVal( 'unhide' );
		$contentHandler = $this->rev->getContentHandler();
		$de = $contentHandler->createDifferenceEngine( $this->getContext(), $prevId, $this->revId );
		// HACK:
		if ( get_class( $de ) == 'DifferenceEngine' ) {
			$de = new InlineDifferenceEngine(
				$this->getContext(),
				$prevId,
				$this->revId,
				0,
				false,
				$unhide
			);
		}
		$diff = $de->getDiffBody();
		if ( !$prevId ) {
			$audience = $unhide ? Revision::FOR_THIS_USER : Revision::FOR_PUBLIC;
			$diff = '<ins>'
				. nl2br( htmlspecialchars( $this->rev->getText( $audience ) ) )
				. '</ins>';
		}

		$warnings = $de->getWarningMessageText();
		if ( $warnings ) {
			$warnings = Html::openElement( 'div',
				array(
					'class' => 'warning alert',
				) ) .
				$warnings .
				Html::closeElement( 'div' );
		}
		$this->getOutput()->addHtml(
			$warnings .
			'<div id="mw-mf-minidiff">' .
			$diff .
			'</div>'
		);
		$prev = $this->rev->getPrevious();
		$next = $this->rev->getNext();
		if ( $ctx->isBetaGroupMember() && (  $prev || $next ) ) {
			$history = Html::openElement( 'ul', array( 'class' => 'hlist revision-history-links' ) );
			if ( $prev ) {
				$history .= Html::openElement( 'li' ) .
					Html::element( 'a', array(
						'href' => SpecialPage::getTitleFor( 'MobileDiff', $prev->getId() )->getLocalUrl()
					), $this->msg( 'previousdiff' ) ) . Html::closeElement( 'li' );
			}
			if ( $next ) {
				$history .= Html::openElement( 'li' ) .
					Html::element( 'a', array(
						'href' => SpecialPage::getTitleFor( 'MobileDiff', $next->getId() )->getLocalUrl()
					), $this->msg( 'nextdiff' ) ) . Html::closeElement( 'li' );
			}
			$history .= Html::closeElement( 'ul' );
			$this->getOutput()->addHtml( $history );
		}
	}

	function showFooter() {
		$output = $this->getOutput();

		$output->addHtml(
			Html::openElement( 'div', array( 'id' => 'mw-mf-userinfo',
				'class' => 'buttonBar position-fixed' ) )
		);

		$userId = $this->rev->getUser();
		if ( $userId ) {
			$user = User::newFromId( $userId );
			$edits = $user->getEditCount();
			$attrs = array(
				'class' => 'mw-mf-user',
				'data-revision-id' => $this->revId,
				'data-user-name' => $user->getName(),
				'data-user-gender' => $user->getOption( 'gender' ),
			);
			$inBeta = MobileContext::singleton()->isBetaGroupMember();
			$userLink = $inBeta
				? SpecialPage::getTitleFor( 'UserProfile', $user->getName() )
				: $user->getUserPage();
			$output->addHtml(
				Html::openElement( 'div', $attrs ) .
				Linker::link(
					$userLink,
					htmlspecialchars( $user->getName() ),
					array( 'class' => 'mw-mf-user-link' )
				) .
				'</div>' .
				'<div class="mw-mf-roles meta">' .
					$this->listGroups( $user ) .
				'</div>' .
				'<div class="mw-mf-edit-count meta">' .
					$this->msg(
						'mobile-frontend-diffview-editcount',
						$this->getLanguage()->formatNum( $edits )
					)->parse() .
				'</div>'
			);
		} else {
			$ipAddr = $this->rev->getUserText();
			$userPage = Title::makeTitle( NS_USER, $ipAddr );
			$output->addHtml(
				'<div class="mw-mf-user mw-mf-anon">' .
					$this->msg( 'mobile-frontend-diffview-anonymous' )->escaped() .
				'</div>' .
				'<div>' .
					Linker::link( $userPage, htmlspecialchars( $ipAddr ) ) .
				'</div>'
			);
		}

		$output->addHtml(
			Html::closeElement( 'div' )
		);
	}

	function listGroups( User $user ) {
		# Get groups to which the user belongs
		$userGroups = $user->getGroups();
		$userMembers = array();
		foreach ( $userGroups as $n => $ug ) {
			$memberName = User::getGroupMember( $ug, $user->getName() );
			if ( $n == 0 ) {
				$memberName = $this->getLanguage()->ucfirst( $memberName );
			}
			$userMembers[] = User::makeGroupLinkHTML( $ug, $memberName );
		}

		return $this->getLanguage()->commaList( $userMembers );
	}

	public static function getMobileUrlFromDesktop() {
		$req = MobileContext::singleton()->getRequest();
		$rev2 = $req->getText( 'diff' );
		$rev1 = $req->getText( 'oldid' );
		// redirect requests to the diff page to mobile view
		if ( !$rev2 ) {
			if ( $rev1 ) {
				$rev2 = $rev1;
				$rev1 = '';
			} else {
				return false;
			}
		}

		if ( $rev1 ) {
			$rev = static::getRevision( $rev1 );
			if ( $rev ) {
				// the diff parameter could be the string prev or next - deal with these cases
				if ( $rev2 === 'prev' ) {
					$prev = $rev->getPrevious();
					// yes this is confusing - this is how it works arrgghh
					$rev2 = $rev1;
					$rev1 = $prev ? $prev->getId() : '';
				} elseif ( $rev2 === 'next' ) {
					$next = $rev->getNext();
					$rev2 = $next ? $next->getId() : '';
				} else {
					$rev2 = static::getRevision( $rev2 );
					$rev2 = $rev2 ? $rev2->getId() : '';
				}
			} else {
				$rev2 = '';
			}
		}

		if ( $rev2 ) {
			$subpage = $rev1 ? $rev1 . '...' . $rev2 : $rev2;
			$title = SpecialPage::getTitleFor( 'MobileDiff', $subpage );
			return $title->getLocalURL();
		}
		return false;
	}
}
