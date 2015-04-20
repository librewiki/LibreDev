( function( M, $ ) {

	var
		View = M.require( 'View' ),
		Section = M.require( 'Section' ),
		Page;

	/**
	 * @class
	 * @extends View
	 * @name Page
	 */
	Page = View.extend( {
		template: mw.template.get( 'page' ),
		defaults: {
			// id defaults to 0 which represents a new page. Be sure to override to avoid side effects.
			id: 0,
			/**
			 * Includes prefix where needed and is human readable.
			 * e.g. Talk:The man who lived
			 * @string
			 */
			title: '',
			displayTitle: '',
			lead: '',
			protection: {
				edit: [ '*' ]
			},
			inBetaOrAlpha: M.isBetaGroupMember(),
			isMainPage: false,
			talkLabel: mw.msg( 'mobile-frontend-talk-overlay-header' ),
			editLabel: mw.msg( 'mobile-frontend-editor-edit' ),
			languageLabel: mw.msg( 'mobile-frontend-language-article-heading' )
		},

		initialize: function( options ) {
			// Fallback if no displayTitle provided
			options.displayTitle = options.displayTitle || options.title;
			// Surface the display title for M.reloadPage
			this.displayTitle = options.displayTitle;
			options.languageUrl = mw.util.getUrl( 'Special:MobileLanguages/' + options.title );
			this._super( options );
		},

		/**
		 * @name Page.prototype.isWikiText
		 * @function
		 * FIXME: Make this update with ajax page loads
		 * @return {Boolean}
		 */
		isWikiText: function() {
			return mw.config.get( 'wgPageContentModel' ) === 'wikitext';
		},

		/**
		 * @name Page.prototype.isMainPage
		 * @function
		 * @return {Boolean}
		 */
		isMainPage: function() {
			return this.options.isMainPage;
		},

		/**
		 * Checks whether the given user can edit the page.
		 * @name Page.prototype.isEditable
		 * @function
		 * @param {mw.user} Object representing a user
		 * @return {jQuery.deferred} With parameter boolean
		 */
		isEditable: function( user ) {
			var editProtection = this.options.protection.edit,
				resp = $.Deferred();

			user.getGroups().done( function( groups ) {
				var editable = false;
				$.each( groups, function( i, group ) {
					if ( editProtection.indexOf( group ) > -1 ) {
						editable = true;
						return false;
					}
				} );
				resp.resolve( editable );
			} );
			return resp;
		},

		// FIXME: This assumes only one page can be rendered at one time - emits a page-loaded event and sets wgArticleId
		render: function( options ) {
			var pageTitle = options.title, self = this,
				$el = this.$el, _super = self._super;
			// prevent talk icon being re-rendered after an edit to a talk page
			options.isTalkPage = self.isTalkPage();

			// FIXME: this is horrible, because it makes preRender run _during_ render...
			if ( !options.sections ) {
				$el.empty().addClass( 'spinner loading' );
				// FIXME: api response should also return last modified timestamp and page_top_level_section_count property
				M.pageApi.getPage( pageTitle ).done( function( pageData ) {
					options = $.extend( options, pageData );
					options.hasLanguages = pageData.languageCount > 0 || pageData.hasVariants;
					// Resurface the display title for M.reloadPage
					self.displayTitle = options.displayTitle;

					_super.call( self, options );

					// reset loader
					$el.removeClass( 'spinner loading' );

					self.emit( 'ready', self );
				} ).fail( $.proxy( self, 'emit', 'error' ) );
			} else {
				self._super( options );
			}
		},

		/**
		 * Return the latest revision id for this page
		 * @name Page.prototype.getRevisionId
		 * @function
		 * @return {Integer}
		 */
		getRevisionId: function() {
			return this.options.revId;
		},

		/**
		 * @name Page.prototype.getId
		 * @function
		 * @return {Integer}
		 */
		getId: function() {
			return this.options.id;
		},

		/**
		 * @name Page.prototype.getNamespaceId
		 * @function
		 * @return {Integer} namespace number
		 */
		getNamespaceId: function() {
			var args = this.options.title.split( ':' ), nsId;
			if ( args[1] ) {
				nsId = mw.config.get( 'wgNamespaceIds' )[ args[0].toLowerCase().replace( ' ', '_' ) ] || 0;
			} else {
				nsId = 0;
			}
			return nsId;
		},

		/**
		 * @name Page.prototype.isTalkPage
		 * @function
		 * @return {Boolean} Whether the page is a talk page or not
		 */
		isTalkPage: function() {
			var ns = this.getNamespaceId();
			// all talk pages are odd numbers (except the case of special pages)
			return ns > 0 && ns % 2 === 1;
		},

		preRender: function( options ) {
			var self = this;
			this.sections = [];
			this._sectionLookup = {};
			this.title = options.title;
			this.lead = options.lead;

			$.each( options.sections, function() {
				var section = new Section( this );
				self.sections.push( section );
				self._sectionLookup[section.id] = section;
			} );
		},

		/**
		 * @name Page.prototype.getReferenceSection
		 * @function
		 */
		getReferenceSection: function() {
			return this._referenceLookup;
		},

		/**
		 * FIXME: rename to getSection
		 * FIXME: Change function signature to take the anchor of the heading
		 * @name Page.prototype.getSubSection
		 * @function
		 * @return {Section}
		 */
		getSubSection: function( id ) {
			return this._sectionLookup[ id ];
		},

		/**
		 * FIXME: rename to getSections
		 *
		 * @name Page.prototype.getSubSections
		 * @function
		 * @return Array
		 */
		getSubSections: function() {
			return this.sections;
		}
	} );

	M.define( 'Page', Page );

}( mw.mobileFrontend, jQuery ) );
