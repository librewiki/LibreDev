( function( M ) {
	var
		PhotoUploaderButton = M.require( 'modules/uploads/PhotoUploaderButton' ),
		LeadPhotoUploaderButton;

	LeadPhotoUploaderButton = PhotoUploaderButton.extend( {
		template: M.template.get( 'uploads/LeadPhotoUploaderButton' ),
		className: 'enabled',

		defaults: {
			buttonCaption: mw.msg( 'mobile-frontend-photo-upload' ),
			insertInPage: true,
			el: '#ca-upload',
		},

		initialize: function( options ) {
			options.pageTitle = mw.config.get( 'wgPageName' );
			this._super( options );
		}
	} );

	LeadPhotoUploaderButton.isSupported = PhotoUploaderButton.isSupported;

	M.define( 'modules/uploads/LeadPhotoUploaderButton', LeadPhotoUploaderButton );

}( mw.mobileFrontend ) );
