<?php

/**
 * Database mapper for EchoTargetPage model
 */
class EchoTargetPageMapper extends EchoAbstractMapper {

	/**
	 * List of db fields used to construct an EchoTargetPage model
	 * @var string[]
	 */
	protected static $fields = array(
		'etp_user',
		'etp_page',
		'etp_event'
	);

	/**
	 * Fetch an EchoTargetPage instance by user & page_id
	 *
	 * @param User $user
	 * @param int $pageId
	 * @return EchoTargetPage[]|boolean
	 */
	public function fetchByUserPageId( User $user, $pageId ) {
		$dbr = $this->dbFactory->getEchoDb( DB_SLAVE );

		$res = $dbr->select(
			array( 'echo_target_page' ),
			self::$fields,
			array(
				'etp_user' => $user->getId(),
				'etp_page' => $pageId
			),
			__METHOD__
		);
		if ( $res ) {
			$targetPages = array();
			foreach ( $res as $row ) {
				$targetPages[] = EchoTargetPage::newFromRow( $row );
			}
			return $targetPages;
		} else {
			return false;
		}
	}

	/**
	 * Fetch EchoTargetPage records by user and set of event_id
	 *
	 * @param User $user
	 * @param int[] $eventIds
	 * @return EchoTargetPage[]|boolean
	 */
	public function fetchByUserEventIds( User $user, array $eventIds ) {
		if ( !$eventIds ) {
			return array();
		}
		$dbr = $this->dbFactory->getEchoDb( DB_SLAVE );

		$res = $dbr->select(
			array( 'echo_target_page' ),
			self::$fields,
			array(
				'etp_user' => $user->getId(),
				'etp_event' => $eventIds
			),
			__METHOD__
		);
		if ( $res ) {
			$targetPages = array();
			foreach ( $res as $row ) {
				$targetPages[] = EchoTargetPage::newFromRow( $row );
			}
			return $targetPages;
		} else {
			return false;
		}
	}

	/**
	 * Insert an EchoTargetPage instance into the database
	 *
	 * @param EchoTargetPage $targetPage
	 * @return boolean
	 */
	public function insert( EchoTargetPage $targetPage ) {
		$dbw = $this->dbFactory->getEchoDb( DB_MASTER );

		$row = $targetPage->toDbArray();

		$res = $dbw->insert( 'echo_target_page', $row, __METHOD__ );

		return $res;
	}

	/**
	 * Delete an EchoTargetPage instance from the database
	 *
	 * @param EchoTargetPage
	 * @return boolean
	 */
	public function delete( EchoTargetPage $targetPage ) {
		$dbw = $this->dbFactory->getEchoDb( DB_MASTER );

		$res = $dbw->delete(
			'echo_target_page',
			array(
				'etp_user' => $targetPage->getUser()->getId(),
				'etp_page' => $targetPage->getPageId(),
				'etp_event' => $targetPage->getEventId()
			),
			__METHOD__
		);
		return $res;
	}

	/**
	 * Delete multiple EchoTargetPage records by user & set of event_id
	 *
	 * @param User $user
	 * @param int[] $eventIds
	 * @return boolean
	 */
	public function deleteByUserEvents( User $user, array $eventIds ) {
		if ( !$eventIds ) {
			return true;
		}

		$dbw = $this->dbFactory->getEchoDb( DB_MASTER );

		$res = $dbw->delete(
			'echo_target_page',
			array(
				'etp_user' => $user->getId(),
				'etp_event' => $eventIds
			),
			__METHOD__
		);
		return $res;
	}

	/**
	 * Delete multiple EchoTargetPage records by user
	 *
	 * @param User $user
	 * @return boolean
	 */
	public function deleteByUser( User $user ) {
		$dbw = $this->dbFactory->getEchoDb( DB_MASTER );

		$res = $dbw->delete(
			'echo_target_page',
			array(
				'etp_user' => $user->getId()
			),
			__METHOD__
		);
		return $res;
	}

}
