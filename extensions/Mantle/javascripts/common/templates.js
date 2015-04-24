/**
 * @singleton
 * @class mw.mantle.template
 */
( function( $ ) {
var
	templates = {}, template;
	template = {
		_compilers: {},
		registerCompiler: function( name, obj, isDefault ) {
			if ( obj.compile ) {
				this._compilers[name] = obj;
			} else {
				throw new Error( 'Template compiler must implement compile function.' );
			}
			if ( isDefault ) {
				this._compilerDefault = name;
			}
		},
		/**
		 * Define a template. Compiles newly added templates based on
		 * the file extension of name and the available compilers.
		 * @method
		 * @param {String} name Name of template to add including file extension
		 * @param {String} markup Associated markup (html)
		 */
		add: function( name, markup ) {
			var templateParts = name.split( '.' ), ext,
				compiler;

			if ( templateParts.length > 1 ) {
				ext = templateParts[ templateParts.length - 1 ];
				if ( this._compilers[ ext ] ) {
					compiler = this._compilers[ ext ];
				} else {
					throw new Error( 'Template compiler not found for: ' + ext );
				}
			} else {
				throw new Error( 'Template has no suffix. Unable to identify compiler.' );
			}
			templates[ name ] = compiler.compile( markup );
			compiler.registerPartial( templateParts[0], templates[ name ] );
		},
		/**
		 * Retrieve defined template
		 *
		 * @method
		 * @param {String} name Name of template to be retrieved
		 * @return {Hogan.Template}
		 * accepts template data object as its argument.
		 */
		get: function( name ) {
			if ( !templates[ name ] ) {
				throw new Error( 'Template not found: ' + name );
			}
			return templates[ name ];
		},
		/**
		 * Wraps our template engine of choice
		 * @method
		 * @param {string} templateBody Template body.
		 * @param {string} compilerName The name of a registered compiler
		 * @return {mixed} template interface
		 * accepts template data object as its argument.
		 */
		compile: function( templateBody, compilerName ) {
			var compiler = this._compilers[ compilerName ];
			if ( !compiler ) {
				throw new Error( 'Unknown compiler ' + compilerName );
			}
			return compiler.compile( templateBody );
		}
	};

	$.extend( mw.mantle, {
		template: template
	} );

}( jQuery ) );
