/**
 * @singleton
 * @class mw.mantle.template
 */
( function( $ ) {
var
	templates = {}, template;
	template = {
		_compilers: {},
		_getDefaultCompiler: function() {
			if ( this._compilerDefault && this._compilers[this._compilerDefault] ) {
				return this._compilers[this._compilerDefault];
			} else {
				throw new Error( 'Template default compiler not known.' );
			}
		},
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
		 * Define template using html. Compiles newly added templates
		 * @method
		 * @param {String} name Name of template to add
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
				compiler = this._getDefaultCompiler();
			}
			templates[ name ] = compiler.compile( markup, name );
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
		 * @param {string} compiler The name of a registered compiler
		 * @return {mixed} template interface
		 * accepts template data object as its argument.
		 */
		compile: function( templateBody, compiler ) {
			compiler = compiler ? this._compilers[ compiler ] : this._getDefaultCompiler();
			return compiler.compile( templateBody );
		}
	};

	$.extend( mw.mantle, {
		template: template
	} );

}( jQuery ) );
