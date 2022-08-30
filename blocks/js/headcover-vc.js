{
	( function() { 
	const { registerBlockType } = wp.blocks;
	const { createElement } = wp.element;
	const { __ } = wp.i18n;

	registerBlockType( 'journal-member-preferences/headcover-vc', {
		title: __( 'Headcover VC' ), // Block title.
		category:  __( 'common' ), //category
		attributes:  {},
		edit: props => {
			const { attributes, setAttributes } = props;

			return createElement( 'div', {}, [
			    'Headcover VC'])
		}, 
		save(){
			return null;
		}
	})
})();
}