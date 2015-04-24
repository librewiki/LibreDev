/*global OO */
( function( M, $, OO ) {

	var Class = M.require( 'Class' ), EventEmitter;

	// HACK: wrap around oojs's EventEmitter
	// This needs some hackery to make oojs's
	// and Mantle's different OO models get along,
	// and we need to alias one() to once().
	EventEmitter = Class.extend( $.extend( {
		initialize: OO.EventEmitter,
		one: OO.EventEmitter.prototype.once
	}, OO.EventEmitter.prototype ) );

	M.define( 'eventemitter', EventEmitter );
	// FIXME: if we want more of M's functionality in loaded in <head>,
	// move this to a separate file
	$.extend( mw.mantle, new EventEmitter() );

}( mw.mantle, jQuery, OO ) );
