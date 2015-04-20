( function( M, $ ) {

	var Class = M.require( 'Class' ), EventEmitter;

	function callbackProxy( callback ) {
		return function() {
			var args = Array.prototype.slice.call( arguments, 1 );
			callback.apply( callback, args );
		};
	}

	/**
	 * @name EventEmitter
	 * @class
	 * @extends Class
	 */
	EventEmitter = Class.extend( {
		/**
		 * Bind a callback to the event.
		 *
		 * @name EventEmitter.prototype.on
		 * @function
		 * @param {string} event Event name.
		 * @param {Function} callback Callback to be bound.
		 */
		on: function( event, callback ) {
			$( this ).on( event, callbackProxy( callback ) );
			return this;
		},

		/**
		 * Bind a callback to the event and run it only once.
		 *
		 * @name EventEmitter.prototype.one
		 * @function
		 * @param {string} event Event name.
		 * @param {Function} callback Callback to be bound.
		 */
		one: function( event, callback ) {
			$( this ).one( event, callbackProxy( callback ) );
			return this;
		},

		/**
		 * Emit an event. This causes all bound callbacks to be run.
		 *
		 * @name EventEmitter.prototype.emit
		 * @function
		 * @param {string} event Event name.
		 * @param {*} [arguments] Optional arguments to be passed to callbacks.
		 */
		emit: function( event /* , arg1, arg2, ... */ ) {
			var args = Array.prototype.slice.call( arguments, 1 );
			// use .triggerHandler() for emitting events to avoid accidentally
			// invoking object's functions, e.g. don't call obj.something() when
			// doing obj.emit( 'something' )
			$( this ).triggerHandler( event, args );
			return this;
		}
	} );

	M.define( 'eventemitter', EventEmitter );
	// FIXME: if we want more of M's functionality in loaded in <head>,
	// move this to a separate file
	$.extend( M, new EventEmitter() );

}( mw.mobileFrontend, jQuery ) );
