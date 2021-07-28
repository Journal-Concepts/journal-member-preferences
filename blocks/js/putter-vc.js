( function() { 
	const { registerBlockType } = wp.blocks;
	const { createElement } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'journal-member-preferences/putter-vc', {
		title: __( 'Putter VC' ), // Block title.
		category:  __( 'circ-management' ), //category
		attributes:  {},
		edit: props => {
			const { attributes, setAttributes } = props;

			return createElement( 'div', {}, [
			    'Putter VC'])
		}, 
		save(){
			return null;
		}
	})
})();