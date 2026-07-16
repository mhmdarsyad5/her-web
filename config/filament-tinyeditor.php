<?php

return [
    'version' => [
        'tiny' => '8.0.2',
        'language' => [
            // https://cdn.jsdelivr.net/npm/tinymce-i18n@latest/
            'version' => '25.8.4',
            'package' => 'langs8',
        ],
        'licence_key' => env('TINY_LICENSE_KEY', 'no-api-key'),
    ],
    'provider' => 'cloud', // cloud|vendor
    // 'direction' => 'rtl',

    /**
     * change darkMode: 'auto'|'force'|'class'|'media'|false|'custom'
     */
    'darkMode' => 'auto',

    /** cutsom */
    'skins' => [
        // oxide, oxide-dark, tinymce-5, tinymce-5-dark
        'ui' => 'oxide',

        // dark, default, document, tinymce-5, tinymce-5-dark, writer
        'content' => 'default',
    ],

    'profiles' => [
        'default' => [
            'plugins' => 'accordion codesample directionality advlist link image lists preview pagebreak searchreplace wordcount code fullscreen insertdatetime media table emoticons',
            'toolbar' => 'undo redo removeformat | fontfamily fontsize lineheight styles | bold italic underline | rtl ltr | alignjustify alignleft aligncenter alignright | numlist bullist outdent indent | forecolor backcolor | blockquote table toc hr | image link media codesample emoticons | wordcount fullscreen',
            'upload_directory' => 'tinymce/'.date('Y/F'),
            'custom_configs' => [
                'statusbar' => true,
                'resize' => true,
                'content_style' => '
                    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@300;400;500;600;700;800&display=swap");
                    body {
                        font-family: "Inter", sans-serif !important;
                        font-size: 15px;
                        line-height: 1.7;
                        color: #4b5563;
                        margin: 20px;
                    }
                    p {
                        margin-top: 0;
                        margin-bottom: 1.25rem;
                        text-align: justify;
                    }
                    h1, h2, h3, h4, h5, h6 {
                        font-weight: 800;
                        color: #09090b;
                        margin-top: 2rem;
                        margin-bottom: 0.875rem;
                        line-height: 1.3;
                        letter-spacing: -0.02em;
                    }
                    h1 { font-size: 2.25rem; }
                    h2 { font-size: 1.5rem; }
                    h3 { font-size: 1.25rem; font-weight: 700; color: #18181b; }
                    ul {
                        list-style-type: disc;
                        margin: 1.25rem 0;
                        padding-left: 1.25rem;
                    }
                    ol {
                        list-style-type: decimal;
                        margin: 1.25rem 0;
                        padding-left: 1.25rem;
                    }
                    li {
                        margin-bottom: 0.625rem;
                        line-height: 1.7;
                        color: #4b5563;
                    }
                ',
            ],
        ],

        'simple' => [
            'plugins' => 'autoresize directionality emoticons link wordcount',
            'toolbar' => 'removeformat | bold italic | rtl ltr | numlist bullist | link emoticons',
            'upload_directory' => 'tinymce/'.date('Y/F'),
        ],

        'minimal' => [
            'plugins' => 'link wordcount',
            'toolbar' => 'bold italic link numlist bullist',
            'upload_directory' => 'tinymce/'.date('Y/F'),
        ],

        'full' => [
            'plugins' => 'accordion autoresize codesample directionality advlist autolink link image lists charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media table emoticons help',
            'toolbar' => 'undo redo removeformat | fontfamily fontsize fontsizeinput font_size_formats styles | bold italic underline | rtl ltr | alignjustify alignright aligncenter alignleft | numlist bullist outdent indent accordion | forecolor backcolor | blockquote table toc hr | image link anchor media codesample emoticons | visualblocks print preview wordcount fullscreen help',
            'upload_directory' => 'tinymce/'.date('Y/F'),
        ],
    ],

    /**
     * this option will load optional language file based on you app locale
     * example:
     * languages => [
     *      'fa' => 'https://cdn.jsdelivr.net/npm/tinymce-i18n@25.8.4/langs7/fa.min.js',
     *      'es' => 'https://cdn.jsdelivr.net/npm/tinymce-i18n@25.8.4/langs7/es.min.js',
     *      'ja' => asset('assets/ja.min.js')
     * ]
     */
    'languages' => [],

    'extra' => [
        'toolbar' => [
            'fontfamily' => 'Inter=inter,sans-serif;Poppins=poppins,sans-serif;Arial=arial,helvetica,sans-serif;Georgia=georgia,palatino,serif;Times New Roman=times new roman,times,serif;Courier New=courier new,courier,monospace;',
        ],
    ],
];
