/**
 * Post management module.
 *
 * @module post
 * @requires module:request
 * @example
 * let { setHumanReadable } = peepso.modules.post;
 *
 * setHumanReadable( 99, 'lorem ipsum dolor sit amet' )
 *     .then( data => console.log( data ) )
 *     .catch( error => console.error( error ) );
 */
import { Promise } from 'peepso';
import { rest_url } from 'peepsodata';
import { get, post, _delete } from './request';

/**
 * Set raw, tags-stripped, unformatted human-readable version of a post.
 *
 * @param {number} postId
 * @param {string} content
 * @returns {Promise.<Object,?string>}
 */
export function setHumanReadable( postId, content ) {
	return new Promise( ( resolve, reject ) => {
		let endpoint = 'activity.set_human_friendly',
			id = `${ endpoint }_${ postId }`,
			params,
			promise;

		params = {
			post_id: postId,
			human_friendly: encodeURIComponent( content )
		};

		promise = post( id, endpoint, params );
		promise.then( json => {
			if ( json.success && ! json.error ) {
				resolve();
			} else {
				let error = ( json.errors && json.errors.join( '\n' ) ) || undefined;
				reject( error );
			}
		} );
		promise.catch( reject );
	} );
}

/**
 * Get or set saved state of a specific post.
 *
 * @param {number} id
 * @param {boolean|undefined} state
 * @returns {Promise.<Object,?string>}
 */
export function save( id, state ) {
	return new Promise( ( resolve, reject ) => {
		let endpoint = `${ rest_url }post_save`,
			endpoint_id = `${ endpoint }_${ id }`,
			params = { post_id: id },
			promise;

		if ( 'undefined' === typeof state ) {
			promise = get( endpoint_id, endpoint, params );
		} else if ( !! state ) {
			promise = post( endpoint_id, endpoint, params );
		} else {
			promise = _delete( endpoint_id, `${ endpoint }/${ id }` );
		}

		promise.then( json => resolve( json ) ).catch( reject );
	} );
}
