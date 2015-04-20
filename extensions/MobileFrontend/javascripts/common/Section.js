( function( M, $ ) {

	var
		View = M.require( 'View' ),
		Section;

	/**
	 * @class
	 * @extends View
	 * @name Section
	 */
	Section = View.extend( {
		template: mw.template.get( 'section' ),
		defaults: {
			line: '',
			text: '',
			editLabel: mw.msg( 'mobile-frontend-editor-edit' )
		},
		initialize: function( options ) {
			var self = this;
			this.line = options.line;
			this.text = options.text;
			this.hasReferences = options.hasReferences || false;
			this.id = options.id || null;
			this.anchor = options.anchor;
			this.children = [];
			$.each( options.children || [], function() {
				self.children.push( new Section( this ) );
			} );
			this._super( options );
		}
	} );
	M.define( 'Section', Section );

}( mw.mobileFrontend, jQuery ) );
