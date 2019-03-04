; (($) => {

    $(document).ready(() => {

        $('.quicktags-toolbar').remove();

        $('#wp-content-editor-tools').remove();

        $('#post-status-info').remove();

        $('.wp-editor-area').each((i, e) => {

            CodeMirror.fromTextArea(e, {
                lineNumbers: true,
                autoCloseBrackets: true,
                matchBrackets: true,
                matchTags: true,
                autoCloseTags: true,
                mode: "application/x-httpd-php",
                theme: 'dracula',
                keyMap: 'sublime',
                viewportMargin: Infinity
            })

        });

    })

})(jQuery);