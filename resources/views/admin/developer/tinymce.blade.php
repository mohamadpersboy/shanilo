{{-- Tinymce 4.6.1 (2017-05-10) --}}
{{-- https://www.tinymce.com/ --}}
{{-- http://www.roxyfileman.com/ --}}
{{-- http://www.roxyfileman.com/TinyMCE-file-browser --}}

<!-- Tinymce Editor -->
<script type="text/javascript" src="{{asset('assets/admin/_plugins/editors/tinymce/tinymce.min.js')}}"></script>
<script type="text/javascript">
    var rootName = WEBSITE_BASE_URL;
    $(document).ready(function(){
        tinyMCE.baseURL = rootName + "assets/admin/_plugins/editors/tinymce";
        // TINYMCE
        tinymce.init({
            selector: "[data-tinymce]",
            theme: 'modern',
            statusbar: false,
            menubar:false,
            toolbar_items_size: 'small',
            directionality: '{{__('content.direction')}}',
            language: '{{__('content.tinymce_lang')}}',
            content_css: rootName + 'assets/front/_css/tinymce.css?v=14',
            relative_urls : false,
            convert_urls: false,
//            force_br_newlines : true,
//            force_p_newlines : false,
//            forced_root_block : '',

            plugins: [
                'autoresize advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template textcolor paste'
            ],

            /*formatselect*/
            // toolbar1: " fullscreen | bold italic underline strikethrough | ltr rtl | outdent indent | alignjustify alignleft aligncenter alignright | fontselect fontsizeselect | styleselect removeformat ",
            toolbar1: " fullscreen | bold italic underline strikethrough | ltr rtl | outdent indent | alignjustify alignleft aligncenter alignright | styleselect removeformat ",
            //toolbar2: " bullist | link unlink | table | forecolor | subscript superscript | charmap | searchreplace code print | image", /*| table | image   numlist*/
            toolbar2: " bullist | link unlink | searchreplace code print | image", /*| table | image   numlist*/

            /*fonts*/
            fontsize_formats: "10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px",
            font_formats: "{{__('content.farsi')}}='at1';{{__('content.english')}}=sans-serif",

            /*list*/
            advlist_bullet_styles: "default",

            /*style formats*/
            style_formats: [
    //          { title:'متن ویژه 1', block:'div', classes:'quote', wrapper:true },
    //          { title:'لینک follow', selector:'a', classes:'link' },
    //          { title:'لینک nofollow', selector:'a', classes:'link', attributes : {rel : 'nofollow'} },
    //            {title: 'عنوان', items: [
    //                { title:'عنوان راست', block:'h3', classes:'title' },
    //                { title:'عنوان وسط', block:'div', classes:'title center', wrapper:true },
    //            ]},
                // {title: 'عنوان', items: [
                //     { title:'عنوان راست', block:'p', classes:'title right' },
                //     { title:'عنوان چپ', block:'p', classes:'title left' },
                //     { title:'عنوان وسط', block:'p', classes:'title center' }
                // ]},
                // {title: 'متن', items: [
                //     { title:'متن فارسی', block:'p', classes:'fa' },
                //     { title:'متن انگلیسی', block:'p', classes:'en' }
                // ]},
                {title:'عنوان', block:'h3', classes:'title' },
                {title: 'تصویر', items: [
                    { title:'تصویر راست', selector:'img', classes:'right' },
                    { title:'تصویر چپ', selector:'img', classes:'left' }
                ]},
                {title: 'لیست آیکن دار', items: [
                    { title:'دلار', selector:'ul,ol', classes:'list_content_style1' },
                    { title:'ترازو', selector:'ul,ol', classes:'list_content_style2' }
                ]}
            ],

            style_formats_autohide: false,

            /*autosize*/
            autoresize_on_init: true,
            autoresize_min_height: 200,
            autoresize_bottom_margin: 15,
            autoresize_overflow_padding: 15,

            /*paste*/
            paste_data_images: true,

            /*imagetools*/
            imagetools_cors_hosts: ['localhost', 'gowebsite.ir'],

            /*form validation*/
            setup: function(editor) {
                editor.on('keyup', function(e) {
                    var inputname = $(tinyMCE.activeEditor.getElement()).attr('data-inputname');
                    if(tinyMCE.activeEditor.getContent({format : 'text'}).trim() != ""){
                        $("input[name="+inputname+"]").val('1');
                    }else{
                        $("input[name="+inputname+"]").val('');
                    }
                });
            },

            /*roxy file browser*/
            file_browser_callback: RoxyFileBrowser,
            // auto_focus: "description_tiny",

            /*colors*/
            /*textcolor_map: [
             "000000", "Black",
             "CC99FF", "Plum"
             ]*/
        });

        // TINYMCE WITHOUT IMAGE
        tinymce.init({
            selector: "[data-tinymce-no-image]",
            theme: 'modern',
            statusbar: false,
            menubar:false,
            toolbar_items_size: 'small',
            directionality: '{{__('content.direction')}}',
            language: '{{__('content.tinymce_lang')}}',
            content_css: rootName + 'assets/front/_css/tinymce.css?v=13',
            relative_urls : false,
            convert_urls: false,
//            force_br_newlines : true,
//            force_p_newlines : false,
//            forced_root_block : '',

            plugins: [
                'autoresize advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template textcolor paste'
            ],

            /*formatselect*/
            // toolbar1: " fullscreen | bold italic underline strikethrough | ltr rtl | outdent indent | alignjustify alignleft aligncenter alignright | fontselect fontsizeselect | styleselect removeformat ",
            toolbar1: " fullscreen | bold italic underline strikethrough | ltr rtl | outdent indent | alignjustify alignleft aligncenter alignright | styleselect removeformat ",
            //toolbar2: " bullist | link unlink | table | forecolor | subscript superscript | charmap | searchreplace code print | image", /*| table | image   numlist*/
            toolbar2: " bullist | link unlink | searchreplace code print", /*| table | image   numlist*/

            /*fonts*/
            fontsize_formats: "10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px",
            font_formats: "{{__('content.farsi')}}='at1';{{__('content.english')}}=sans-serif",

            /*list*/
            advlist_bullet_styles: "default",

            /*style formats*/
            style_formats: [
                //          { title:'متن ویژه 1', block:'div', classes:'quote', wrapper:true },
                //          { title:'لینک follow', selector:'a', classes:'link' },
                //          { title:'لینک nofollow', selector:'a', classes:'link', attributes : {rel : 'nofollow'} },
                //            {title: 'عنوان', items: [
                //                { title:'عنوان راست', block:'h3', classes:'title' },
                //                { title:'عنوان وسط', block:'div', classes:'title center', wrapper:true },
                //            ]},
                // {title: 'عنوان', items: [
                //     { title:'عنوان راست', block:'p', classes:'title right' },
                //     { title:'عنوان چپ', block:'p', classes:'title left' },
                //     { title:'عنوان وسط', block:'p', classes:'title center' }
                // ]},
                // {title: 'متن', items: [
                //     { title:'متن فارسی', block:'p', classes:'fa' },
                //     { title:'متن انگلیسی', block:'p', classes:'en' }
                // ]},
                {title:'عنوان', block:'h3', classes:'title' },
                {title:'عنوان قوانین', block:'h3', classes:'title1' },
                {title: 'تصویر', items: [
                    { title:'تصویر راست', selector:'img', classes:'right' },
                    { title:'تصویر چپ', selector:'img', classes:'left' }
                ]},
                {title: 'لیست آیکن دار', items: [
                    { title:'لیست راهنما', selector:'ul,ol', classes:'list1' },
                ]},
            ],

            style_formats_autohide: false,

            /*autosize*/
            autoresize_on_init: true,
            autoresize_min_height: 200,
            autoresize_bottom_margin: 15,
            autoresize_overflow_padding: 15,

            /*paste*/
            paste_data_images: true,

            /*imagetools*/
            imagetools_cors_hosts: ['localhost', 'gowebsite.ir'],

            /*form validation*/
            setup: function(editor) {
                editor.on('keyup', function(e) {
                    var inputname = $(tinyMCE.activeEditor.getElement()).attr('data-inputname');
                    if(tinyMCE.activeEditor.getContent({format : 'text'}).trim() != ""){
                        $("input[name="+inputname+"]").val('1');
                    }else{
                        $("input[name="+inputname+"]").val('');
                    }
                });
            },

            /*roxy file browser*/
            file_browser_callback: RoxyFileBrowser,
            // auto_focus: "description_tiny",

            /*colors*/
            /*textcolor_map: [
             "000000", "Black",
             "CC99FF", "Plum"
             ]*/
        });

    });//document ready

    function RoxyFileBrowser(field_name, url, type, win) {
        var roxyFileman = rootName + "assets/admin/_plugins/editors/tinymce/fileman/index.html";
        if (roxyFileman.indexOf("?") < 0) {
            roxyFileman += "?type=" + type;
        }
        else {
            roxyFileman += "&type=" + type;
        }
        roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
        if(tinyMCE.activeEditor.settings.language){
            roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
        }
        tinyMCE.activeEditor.windowManager.open({
            file: roxyFileman,
            title: 'Roxy Fileman',
            width: 850,
            height: 650,
            resizable: "yes",
            plugins: "media",
            inline: "yes",
            close_previous: "no"
        }, {     window: win,     input: field_name    });
        return false;
    }//function
</script>
<!-- End Tinymce Editor -->
