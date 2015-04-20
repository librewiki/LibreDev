( function( M ) {
	var ContentOverlay = M.require( 'modules/tutorials/ContentOverlay' ),
		PageActionOverlay;

	PageActionOverlay = ContentOverlay.extend( {
		template: M.template.get( 'modules/tutorials/PageActionOverlay' ),
		defaults: {
			cancelMsg: mw.msg( 'cancel' )
		}
	} );

	M.define( 'modules/tutorials/PageActionOverlay', PageActionOverlay );

}( mw.mobileFrontend ) );
