// ----------------------------------------------------------------------------
// markItUp!
// ----------------------------------------------------------------------------
// Copyright (C) 2008 Jay Salvat
// http://markitup.jaysalvat.com/
// ----------------------------------------------------------------------------
// Html tags
// http://en.wikipedia.org/wiki/html
// ----------------------------------------------------------------------------
// Basic set. Feel free to add more tags
// ----------------------------------------------------------------------------
ad_htmlMarkitupSettings = {
    nameSpace: 'html',
	onShiftEnter:	{keepDefault:false, replaceWith:'<br />\n'},
	onCtrlEnter:	{keepDefault:false, openWith:'\n<p>', closeWith:'</p>\n'},
	onTab:			{keepDefault:false, openWith:'	 '},
    previewInWindow: 'width=400, height=250, resizable=yes, scrollbars=yes',
    previewAutorefresh: false,
	markupSet: [
		{name:'Paragraph', openWith:'<p(!( class="[![Class]!]")!)>', closeWith:'</p>' },
		{separator:'---------------' },
		{name:'Bold', key:'B', openWith:'(!(<strong>|!|<b>)!)', closeWith:'(!(</strong>|!|</b>)!)' },
		{name:'Italic', key:'I', openWith:'(!(<em>|!|<i>)!)', closeWith:'(!(</em>|!|</i>)!)' },
		{name:'Stroke through', key:'S', openWith:'<del>', closeWith:'</del>' },
		{separator:'---------------' },
		{name:'Ul', openWith:'<ul>\n', closeWith:'</ul>\n' },
		{name:'Ol', openWith:'<ol>\n', closeWith:'</ol>\n' },
		{name:'Li', openWith:'<li>', closeWith:'</li>' },
		{separator:'---------------' },
		{name:'Link', key:'L', openWith:'<a href="[![Link:!:http://]!]"(!( title="[![Title]!]")!)>', closeWith:'</a>', placeHolder:'Your text to link...' },
		{separator:'---------------' },
		{	name:'Table generator', 
			className:'tablegenerator', 
			placeholder:"Your text here...",
			replaceWith:function(markItUp) {
				cols = prompt("How many cols?");
				rows = prompt("How many rows?");
				html = "<table>\n";
				if (markItUp.altKey) {
					html+= " <tr>\n";
					for (c = 0; c < cols; c++) {
						html += "! [![TH"+(c+1)+" text:]!]\n";	
					}
					html+= " </tr>\n";
				}
				for (r = 0; r < rows; r++) {
					html+= " <tr>\n";
					for (c = 0; c < cols; c++) {
						html += "  <td>"+(markItUp.placeholder||"")+"</td>\n";	
					}
					html+= " </tr>\n";
				}
				html+= "</table>\n";
				return html;
			}
		},
		{	name:'Tr',
			openWith:'<tr>',
			closeWith:'</tr>',
			placeHolder:"<(!(td|!|th)!)></(!(td|!|th)!)>",
			className:'table-col'
		},
		{	name:'Td/Th',
			openWith:'<(!(td|!|th)!)>', 
			closeWith:'</(!(td|!|th)!)>',
			className:'table-row' 
		},
		{separator:'---------------' },
		{name:'Clean', className:'clean', replaceWith:function(markitup) { return markitup.selection.replace(/<(.*?)>/g, "") } },
		{name:'Preview', className:'preview', call:'preview' }
	]
};

