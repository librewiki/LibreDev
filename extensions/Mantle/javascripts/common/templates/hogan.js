/**
 * Register the Hogan compiler with MediaWiki.
 */
mw.mantle.template.registerCompiler( 'hogan', {
	/**
	 * Registers a partial internally in the compiler.
	 * Not used in Hogan compiler
	 *
	 * @method
	 * @param {String} name Name of the template
	 * @param {HandleBars.Template} partial
	 */
	registerPartial: function( /* name, partial */ ) {},
	/**
	 * Compiler source code into a template object
	 *
	 * @method
	 * @param {String} src the source of a template
	 * @return {Hogan.Template} template object
	 */
	compile: function( src ) {
		return Hogan.compile( src );
	}
} );
