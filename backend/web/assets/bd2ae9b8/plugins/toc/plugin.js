(function()
{
	// Title tags which been counted as content level marks .
	var titleTags = { h1:1, h2:1, h3:1, h4:1, h5:1, h6:1 };
	
	// Retrieve all level marks within the whole document.
	function findAllTitles( document )
	{
		var docRange = new CKEDITOR.dom.range(),
			walker = new CKEDITOR.dom.walker( docRange ),
			next,
			titles = [];
		docRange.selectNodeContents( document.getBody() );
		walker.evaluator = function( node )
		{
			if ( node.getName
				&& node.getName() in titleTags
				&& CKEDITOR.tools.trim( node.getText() ) )
				titles.push( node );
		};
		while ( ( next = walker.next() ) )
		{}
		return titles.length ? titles : null;
	}
	
	function findLastBigger( list, level )
	{
		for ( var i = list.length-1 ; i >= 0 ; i-- )
		{
			// Previous bigger header has been found.
			if ( list[ i ].level < level )
				return list[ i ];
			// We've reached top item, stop searching.
			if ( list[ i ].indent == 0 )
				break;
		}
	}
	
	CKEDITOR.plugins.add( 'toc',
	{
		requires : [ 'list' ],
		
		init : function( editor )
		{
			// Load skin definiton.
			CKEDITOR.skins.load( editor, 'toc' );
			
			// Adding as an editor command.
			editor.addCommand( 'toc',
			{
				exec : function( editor )
				{
					var list = [],
						// Create an ordered list as FAKE root node.
						root = new CKEDITOR.dom.element( 'ol', editor.document ),
						nodes = findAllTitles( editor.document );
					
					if ( !nodes )
					{
						alert( editor.lang.contentsTable.promptNoTitles );
						return;
					}
					
					for ( var i = 0 ; i < nodes.length ; i++ )
					{
						var node = nodes[ i ],
							level = parseInt( node.getName().substr( 1 ) ) - 1,
							indent = level,
							// Last bigger header (with lower level) in the list.
							lastBigger = findLastBigger( list, level ),
							length = list.length;
						
						// First list item always at level 0.
						if ( !length || !lastBigger )
							indent = 0;
						else
							indent = lastBigger.indent + 1;

						var text = new CKEDITOR.dom.text( 
							CKEDITOR.tools.trim( node.getText() ), editor.document
						);
						
						list.push( 
						{
							contents : [
								text
							],
							indent : indent,
							parent : root,
							// The real level of the item, despite of it's indent.
							level : level
						});
					}

					// Convert array to list using list plugin.
					list = CKEDITOR.plugins.list.arrayToList( list );					
					// DocumentFragment hold the generated list.
					var listRoot = list.listNode.getFirst();
					// XXX root.equals(listRoot) == false
					// Insert the list into editor at the schema-corrected positon.
					editor.insertElement( listRoot );
				}
			});
			
			// Registering the button UI.
			editor.ui.addButton( 'ContentsTable',
			{
				label : editor.lang.contentsTable.toolbar,
				command : 'toc'
			});
		}
	});
})();
