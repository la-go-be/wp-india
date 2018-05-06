// JavaScript Document
(function() {
    tinymce.PluginManager.add('ex_simplegrid_bt', function(editor, url) {
		editor.addButton('ex_simplegrid_bt', {
			text: '',
			tooltip: 'Simple Grid',
			id: 'ex_simplegrid_bt_id',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Unlimited timeline',
					body: [
						
						{type: 'textbox', name: 'heading', label: 'Heading'},

						{type: 'listbox',
							name: 'style',
							label: 'Style',
							'values': [
								{text: 'Simple', value: 'simple'},
								{text: 'Simple border', value: 'simple-border'},
								{text: 'Simple border no arrow', value: 'simple-border-no'},
								{text: 'Background image', value: 'background-image'},
							]
						},
						{type: 'listbox',
							name: 'alignment',
							label: 'Alignment',
							'values': [
								{text: 'Both Alignment', value: 'both-side'},
								{text: 'Left Alignment', value: 'left'},
								{text: 'Right Alignment', value: 'right'},
								{text: 'Center Alignment', value: 'center'},
							]
						},
						{type: 'textbox', name: 'post_type', label: 'Post type',  value: 'post'},
						{type: 'textbox', name: 'count', label: 'Count', value: '8'},
						{type: 'textbox', name: 'posts_per_page', label: 'Posts per page', value: '3'},
						{type: 'textbox', name: 'ids', label: 'IDs'},
						{type: 'textbox', name: 'exclude', label: 'Exclude (list of ignore IDs)'},
						{type: 'textbox', name: 'start_date', label: 'Start date (month/day/year)'},
						{type: 'textbox', name: 'end_date', label: 'End date (month/day/year)'},
						{type: 'textbox', name: 'cat', label: 'Categories'},
						{type: 'textbox', name: 'tag', label: 'Tags'},
						{type: 'textbox', name: 'texonomy', label: 'Texonomy'},
						{type: 'listbox',
							name: 'order',
							label: 'Order',
							'values': [
								{text: 'Descending', value: 'DESC'},
								{text: 'Ascending', value: 'ASC'}
							]
						},
						{type: 'listbox', 
							name: 'orderby', 
							label: 'Order by', 
							'values': [
								{text: 'Date', value: 'date'},
								{text: 'ID', value: 'ID'},
								{text: 'Author', value: 'author'},
								{text: 'Title', value: 'title'},
								{text: 'Name', value: 'name'},
								{text: 'Modified', value: 'modified'},
								{text: 'Parent', value: 'parent'},
								{text: 'Random', value: 'rand'},
								{text: 'Comment count', value: 'comment_count'},
								{text: 'Menu order', value: 'menu_order'},
								{text: 'Meta value', value: 'meta_value'},
								{text: 'Meta value num', value: 'meta_value_num'},
								{text: 'Post__in', value: 'post__in'},
								{text: 'None', value: 'none'}
							]
						},
						{type: 'textbox', name: 'meta_key', label: 'Meta key (Name of meta key for ordering)'},
						{type: 'listbox',
							name: 'hide_thumb',
							label: 'Hide thumbnails',
							'values': [
								{text: 'Yes', value: '1'},
								{text: 'No', value: '0'}
							]
						},

						{type: 'listbox',
							name: 'hide_share',
							label: 'Hide share button',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'}
							]
						},

						{type: 'listbox',
							name: 'time_since',
							label: 'Time since',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'}
							]
						},
					],
					onsubmit: function(e) {
						// Insert content when the window form is submitted
						 //var uID =  Math.floor((Math.random()*100)+1);
						 editor.insertContent('[unlimited-timeline heading="' + e.data.heading + '" style="' + e.data.style + '" alignment="' + e.data.alignment + '" post_type="' + e.data.post_type + '" count="' + e.data.count + '" posts_per_page="' + e.data.posts_per_page + '" ids="' + e.data.ids + '" exclude="' + e.data.exclude + '" start_date="' + e.data.start_date + '"  end_date="' + e.data.end_date + '"  cat="' + e.data.cat + '"  tag="' + e.data.tag + '"  order="' + e.data.order + '"  orderby="' + e.data.orderby + '" meta_key="' + e.data.meta_key + '" hide_thumb="' + e.data.hide_thumb + '" hide_share="' + e.data.hide_share + '" time_since="' + e.data.time_since + '"]');
					}
				});
			}
		});
	});
})();
