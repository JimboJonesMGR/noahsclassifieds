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
headMarkitupSettings = {
    nameSpace: 'head',
	onTab:			{keepDefault:false, openWith:'	 '},
    previewInWindow: 'width=1000, height=600, resizable=yes, scrollbars=yes',
    previewParserPath: '~/../../../../index.php?url=/staticpage/preview',
    previewAutorefresh: false,
	markupSet: [
		{name:'JavaScript include', className:'jsinclude', replaceWith:'<script src="[![URL of the JavaScript file:!:]!]" type="text/javascript"></script>\n' },
		{name:'Insert JavaScript', openWith:'<script type="text/javascript">\n<!--\n', closeWith:'\n-->\n</script>', placeHolder:'Your script here...' },
		{name:'CSS include', replaceWith:'<link rel="StyleSheet" href="[![URL of the CSS file:!:]!]" type="text/css">\n' },
		{name:'Insert CSS', openWith:'<style type="text/css" media="screen">\n<!--\n', closeWith:'\n-->\n</style>', placeHolder:'Your CSS here...' },
		{separator:'---------------' },
		{name:'Preview', className:'preview', call:'preview' },
        {separator:'---------------' },
        {name:'Save', className:'save', beforeInsert:function(markItUp) { miu.save(markItUp) } }
	]
};