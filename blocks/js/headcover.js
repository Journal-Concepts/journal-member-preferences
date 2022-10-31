( function() { 
	const { registerBlockType } = wp.blocks;
	const { createElement, Component } = wp.element;
	const { __ } = wp.i18n;
	const { InspectorControls } = wp.blockEditor; //Block inspector wrapper
	const { SelectControl } = wp.components; //WordPress form inputs and server-side renderer
	const { serverSideRender } = wp;
	const { withSelect, select } = wp.data;

	class HeadcoverEdit extends Component {

		constructor() {
			super( ...arguments );
			this.state = {
				editMode: true
			}
		}

		render() {
			
			const { attributes, setAttributes } = this.props;

			let choices = [];
			if (this.props.posts) {
				choices.push({ value: 0, label: __('Select a page', 'headcover') });
				this.props.posts.forEach(post => {
					choices.push({ value: post.id, label: post.title.rendered });
				});
			} else {
				choices.push({ value: 0, label: __('Loading...', 'headcover') })
			}

			//Display block preview and UI
			return createElement('div', {}, [
				//Preview a block with a PHP render callback
				createElement( serverSideRender, {
					block: 'journal-member-preferences/headcover',
					attributes: attributes
				} ),
				//Block inspector
				createElement( InspectorControls, {},
					createElement( 'div', {
						className: 'journal-member-preferences-headcover' }, 
					[
						createElement( SelectControl, {
							value: attributes.setPage,
							options: choices,
							label: __( 'Preference Set Page' ),
							type: 'number',
							onChange: value => setAttributes( {
								setPage: parseInt( value )
							})
						})
					] )
				)

			] );

		}
	}
	registerBlockType( 'journal-member-preferences/headcover', {
		title: __( 'Headcover Form' ), // Block title.
		category:  __( 'common' ), //category
		attributes:  {
			setPage: {
				type: 'number'
			}
		},
		edit: withSelect( select => {
			const query = {
				per_page: -1,
				orderby: 'title',
				order: 'asc'
			}

			return {
				posts: select( 'core' ).getEntityRecords( 'postType', 'page', query )
			}
		})(HeadcoverEdit), 
		save(){
			return null; //save has to exist. This all we need
		}
	})
})();