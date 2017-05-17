/**
 * This file for register button insert shortcode to TinyMCE.
 *
 * @since  1.0
 * @author webarts.io
 * @link   http://www.webarts.io
 */
 
(function() {
	return;
	tinymce.create('tinymce.plugins.webarts_pre_shortcodes_button', {
		init : function(ed, url) {
			title = 'webarts_pre_shortcodes_button';
			tinymce.plugins.webarts_pre_shortcodes_button.theurl = url;
			ed.addButton('webarts_pre_shortcodes_button', {
				title	:	'Insert artcloud Shortcode',
				icon	:	'icon artcloud',
						
								onclick: function() {
									ed.windowManager.open( {
										title: 'Artcloud',
										body: [
											{type : 'listbox', name : 'type', label	:	'Type', 'values': [{text: 'Art', value: 'art'}, {text: 'Artists', value: 'artists'}, {text: 'Artist', value: 'artist'}, {text: 'Exhibition', value: 'lists'}]},
											{type : 'listbox', name : 'theme', label:	'Theme', 'values': [{text: 'Masonry', value: 'masonry'}, {text: 'Grid', value: 'grid'}]},
											{type : 'textbox', name : 'artist', label:	'Link Artist', value : ''},
											{type : 'textbox', name : 'min_price', label:	'Min Price', value : ''},
											{type : 'textbox', name : 'max_price', label:	'Max Price', value : ''},
											{type : 'textbox', name : 'tag', label:	'Tags', value : ''}
										
											
										],	
										onsubmit: function(e){
											ed.insertContent( '[artcloud type="'+ e.data.type  +'" theme="'+ e.data.theme +'" artist="'+ e.data.artist+'" min_price="'+ e.data.min_price+'" max_price="'+e.data.max_price+'" tag="'+ e.data.tag+'"][/artcloud]');
										}
									});
								}
								
			});

		},
		createControl : function(n, cm) {
			return null;
		}
	});

	tinymce.PluginManager.add('webarts_pre_shortcodes_button', tinymce.plugins.webarts_pre_shortcodes_button);

})();