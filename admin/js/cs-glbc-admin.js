(function( $ ) {
    'use strict';

    $(function(){

        var frame,
            imgUploadButton = $('#cs-glbc-upload_image_button'),
            imgContainer = $('#cs-glbc-upload_image_preview'),
            imgIdInput = $('#cs-glbc-image_id'),
            imgPreview = $('#cs-glbc-upload_image_preview'),
            imgDelButton = $('#cs-glbc-delete_image_button');

            // wp.media add Image
            imgUploadButton.on( 'click', function( event ){

                event.preventDefault();
                // If the media frame already exists, reopen it.
                if ( frame ) {
                    frame.open();
                    return;
                }

                // Create a new media frame
                frame = wp.media({
                    title: 'Select or Upload Media for your Business Image',
                    button: {
                    text: 'Use as my Business Image'
                },
                multiple: false  // Set to true to allow multiple files to be selected
                });
                // When an image is selected in the media frame...
                frame.on( 'select', function() {

                // Get media attachment details from the frame state
                var attachment = frame.state().get('selection').first().toJSON();

                // Send the attachment URL to our custom image input field.
                imgPreview.find( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );

                // Send the attachment id to our hidden input
                imgIdInput.val( attachment.id );

                // Unhide the remove image link
                imgPreview.removeClass( 'hidden' );
            });

        // Finally, open the modal on click
            frame.open();
        });

        // Erase image url and image preview
        imgDelButton.on('click', function(e){
            e.preventDefault();
            imgIdInput.val('');
            imgPreview.find( 'img' ).attr( 'src', '' );
            imgPreview.addClass('hidden');
        });

    }); // End of DOM Ready

})( jQuery );
