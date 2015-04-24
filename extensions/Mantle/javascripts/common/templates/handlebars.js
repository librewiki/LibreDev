/**
 * Register the Handlebars compiler with MediaWiki.
 */
mw.mantle.template.registerCompiler( 'handlebars', {
	/**
	 * Registers a partial internally in the compiler.
	 *
	 * @method
	 * @param {String} name Name of the template
	 * @param {HandleBars.Template} partial
	 */
	registerPartial: function( name, template ) {
		Handlebars.partials[ name ] = template.render;
	},
	/**
	 * Compiler source code into a template object
	 *
	 * @method
	 * @param {String} src the source of a template
	 * @return {HandleBars.Template} template object
	 */
	compile: function( src ) {
		return {
			/** @param {*} data */
			render: Handlebars.compile( src )
		};
	}
}, true );
