( function() { 
	const { registerBlockType } = wp.blocks;
	const { createElement } = wp.element;
	const { __ } = wp.i18n;
	const { TextControl } = wp.components;


	registerBlockType( 'journal-member-preferences/putter-type', {
		title: __( 'Putter Type Form' ), // Block title.
		category:  __( 'common' ), //category
		attributes:  {},
		edit: props => {
			const { attributes, setAttributes } = props;

			return createElement( 'div', {}, [
			'Putter Type Form'])
		}, 
		save(){
			return null;
		}
	})
})();