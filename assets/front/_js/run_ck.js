$(document).ready(function(e) {
    $("textarea#ckeditor").ckeditor({ customConfig: '',
		font_names: 'at1;'+'Tahoma;'+'B Nazanin;',
		contentsLangDirection: 'rtl',
		language:'fa',
		toolbar:[
			{ name: 'paragraph', groups: [ 'list', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },					
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },		
			{ name: 'links', items: [ 'Link', 'Unlink'] },
			{ name: 'insert', items: [ 'Image','Table', 'HorizontalRule', 'SpecialChar' ] },
			{ name: 'tools', items: [ 'Maximize','-','NewPage','-','Print','-','Preview'] },
			'/',
			{ name: 'styles', items: [ 'Styles', 'Format', 'FontSize' ] },
			{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },		
			{ name: 'others', items: [ '-','CharCount'] },
		],
	});
	CKFinder.setupCKEditor(null, $froot+'_plugins/CKEditor_CKFinder/script/ckfinder/');
	
	
});//document ready