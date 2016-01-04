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
htmlMarkitupSettings = {
    nameSpace: 'html',
	onShiftEnter:	{keepDefault:false, replaceWith:'<br />\n'},
	onCtrlEnter:	{keepDefault:false, openWith:'\n<p>', closeWith:'</p>\n'},
	onTab:			{keepDefault:false, openWith:'	 '},
    previewInWindow: 'width=1000, height=600, resizable=yes, scrollbars=yes',
    previewParserPath: '~/../../../../index.php?url=/staticpage/preview',
    previewAutorefresh: false,
	markupSet: [
		{name:'Heading 1', key:'1', openWith:'<h1(!( class="[![Class]!]")!)>', closeWith:'</h1>', placeHolder:'Your title here...' },
		{name:'Heading 2', key:'2', openWith:'<h2(!( class="[![Class]!]")!)>', closeWith:'</h2>', placeHolder:'Your title here...' },
		{name:'Heading 3', key:'3', openWith:'<h3(!( class="[![Class]!]")!)>', closeWith:'</h3>', placeHolder:'Your title here...' },
		{name:'Heading 4', key:'4', openWith:'<h4(!( class="[![Class]!]")!)>', closeWith:'</h4>', placeHolder:'Your title here...' },
		{name:'Heading 5', key:'5', openWith:'<h5(!( class="[![Class]!]")!)>', closeWith:'</h5>', placeHolder:'Your title here...' },
		{name:'Heading 6', key:'6', openWith:'<h6(!( class="[![Class]!]")!)>', closeWith:'</h6>', placeHolder:'Your title here...' },
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
		{name:'Picture', key:'P', replaceWith:'<img src="[![Source:!:http://]!]" alt="[![Alternative text]!]" />' },
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
		{name:'Preview', className:'preview', call:'preview' },
        {separator:'---------------' },
        {name:'Save', className:'save', beforeInsert:function(markItUp) { miu.save(markItUp) } }
	]
};

// mIu nameSpace to avoid conflict.
miu = {
    save: function(markItUp) {
        data = markItUp.textarea.value;
        ok = confirm("Save the content?");
        if (!ok) {
            return false;
        }
        $.post(markItUp.root+"/../../../../../index.php?url=/settings/save", markItUp.textarea.name+"="+data, function(response) {
                if(response === "MIU:OK") {
                    alert("Saved!");
                }
                else if(response === "MIU:DISABLED") {
                    alert("It is disabled in the demo version to save this field!");
                }
            }
        );
    }    
};
