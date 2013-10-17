CKEDITOR.plugins.add('metrofiles',
{
	init : function(editor)
	{
		// Add the link and unlink buttons.
		CKEDITOR.dialog.addIframe('metrofiles_dialog', 'Files', SITE_URL + 'admin/wysiwyg/files_wysiwyg',700,400);
		editor.addCommand('metrofiles', {exec:metrofiles_onclick} );
		editor.ui.addButton('metrofiles',{ label:'Upload or insert files from library.', command:'metrofiles', icon:this.path+'images/icon.png' });

		// Register selection change handler for the unlink button.
		editor.on( 'selectionChange', function( evt )
		{
			/*
			 * Despite our initial hope, files.queryCommandEnabled() does not work
			 * for this in Firefox. So we must detect the state by element paths.
			 */
			var command = editor.getCommand( 'metrofiles' ),
				element = evt.data.path.lastElement.getAscendant( 'a', true );

			// If nothing or a valid files
			if ( ! element || (element.getName() == 'a' && ! element.hasClass('metro-files')))
			{
				command.setState(CKEDITOR.TRISTATE_OFF);
			}

			else
			{
				command.setState(CKEDITOR.TRISTATE_DISABLED);
			}
		});

	}
} );

function metrofiles_onclick(e)
{
	update_instance();
    // run when metro button is clicked]
    CKEDITOR.currentInstance.openDialog('metrofiles_dialog')
}