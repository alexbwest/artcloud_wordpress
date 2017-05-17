jQuery(function($) {
    $(document).ready(function(){
           // $('#insert-my-media').click(open_media_window);
            $("#mceu_14 button").click();
        });
    
    function open_media_window() {
	    if (this.window === undefined) {
	        this.window = wp.media({
	                title: 'Insert a media',
	                library: {type: 'image'},
	                multiple: false,
	                button: {text: 'Insert'}
	            });

	        var self = this; // Needed to retrieve our variable in the anonymous function below
	        this.window.on('select', function() {
	                var first = self.window.state().get('selection').first().toJSON();
	                wp.media.editor.insert('[myshortcode id="' + first.id + '"]');
	            });
	    }

	    this.window.open();
	    return false;
	}

	/*window.on('select', function(){
        var selection = window.state().get('selection');
	});
*/

});


