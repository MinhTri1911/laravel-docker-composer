var ObjCommon = {
    /**
     * Function init for multi scroll height
     *
     * @param {*} arrIds
     * @return void
     */
    initScrollForMultiTable: function (arrIds) {
        const table = document.querySelector('.tbody-scroll');
        const ps = new PerfectScrollbar(table, function () {
            table.style.height = '50px'
        });

        for (var i = 0; i < arrIds.length; i++) {
            var obj = document.querySelector(arrIds[i]);
            var psRender = new PerfectScrollbar(obj, function () {
                obj.style.height = '500px'
            });
        }
    },

    /**
     * Function call ajax common
     * @param string dom
     * @param {*} parent
     * @param {*} data
     * @param callback callbackSuccress
     * @param callback callbackError
     * @returns void
     */
    ajaxSearchCommon: function (dom, parent, data, callbackSuccess, callbackError) {
        $(dom).bind('click', {parentObject: parent, content: data}, function (event) {
            let parentObj = event.data.parentObject;
            let data = event.data.content;

            let query = data.query;

            let param = {};
            for (var par in query) {
                param[par] = $(query[par]).val();
            }

            $.get(data.url, param, function (res) {
                if (res.code === HTTP_SUCCESS) {
                    callbackSuccess(res.data, parentObj);
                } else {
                    callbackError(res.message, parentObj);
                }
            });
        });
    },
}
