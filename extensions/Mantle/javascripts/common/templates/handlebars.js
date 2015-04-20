/**
 * Register the Handlebars compiler as a default
 */
mw.mantle.template.registerCompiler( 'handlebars', {
	compile: function( src, name ) {
		// Using this, we override Handlebars' partials by injecting our own partials within it without
		// having to register them manually
		name = name.replace( '.handlebars', '' );
		Handlebars.partials[ name ] = Handlebars.compile( src );

		return {
			/** @param {*} data */
			render: Handlebars.partials[ name ]
		};
	}
}, true );
