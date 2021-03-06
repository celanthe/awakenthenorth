/**
 * External dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import sharedConfig from '../shared/config';
import attributes from './attributes';
import edit from './edit';
import {
	BLOCK_TITLE as title,
	BLOCK_ICON as icon,
	BLOCK_DESCRIPTION as description,
} from './constants';

const blockConfig = {
	title,
	description,
	icon: {
		src: icon,
		foreground: '#7f54b3',
	},
	supports: {
		html: false,
	},
	attributes,
	edit,
};

registerBlockType( 'woocommerce/product-sale-badge', {
	...sharedConfig,
	...blockConfig,
} );
