$.trumbowyg.svgPath = '/images/icons.svg';
$(document).ready(function () {
    $('#trumbowyg-editor').trumbowyg({
        //lang: 'ja',
        btns: [
            ['foreColor', 'backColor', 'strong', 'em', 'underline', 'justifyLeft', 'justifyCenter', 'justifyRight', 'unorderedList', 'orderedList','btnExtra'],
        ],
        btnsDef: {
            btnExtra: {
                dropdown: ['undo', 'redo','formatting','createLink','unlink','removeformat','fullscreen', 'justifyFull'],
                title: 'Button Extra',
                ico: 'btnExtra',
                hasIcon: true
            }
        },
        autogrow: true
    });
});