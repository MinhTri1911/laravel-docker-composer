/**
 * Set square
 * @returns {undefined}
 */
$.fn.square = function (func) {
    function _resize(instance){
        $(instance).each(function(){
            $(this).height($(this).width());
        });
        
        if(func != undefined){
            func(this);
        }
    }
    
    var ins = this;
    $(window).resize(function(){
        _resize(ins);
    });
    
    _resize(this);
};
(function ($) {
    /**
     * Instance method
     * @param el
     * @param options
     * @returns KeepRatio
     */
    function KeepRatio(el, options) {
        var defaultOptions = {
            ratio: [4, 3],
            delay: 100,
            resizer: null
        };
        this.el = $(el);
        this.el.data('KeepRatio', this);
        this.options = $.extend({}, defaultOptions, options);
        this.parseOptions();
        this.init();
    }
    $.extend(KeepRatio.prototype, {
        /**
         * Parse options for correct usage
         * @returns void
         */
        parseOptions: function () {
            // parse ratio
            if (typeof this.options.ratio === 'string') {
                this.options.ratio = this.options.ratio.split(/[\:\/\-]/);
            }
            // parse delay
            this.options.delay = parseInt(this.options.delay);
            if (isNaN(this.options.delay) || this.options.delay <= 0) {
                this.options.delay = 100;
            }
        },
        /**
         * Set or get value of an option
         * @param string name
         * @param mixed value
         * @returns mixed
         */
        option: function (name, value) {
            if (value) {
                this.options[name] = value;
                this.parseOptions();
            }
            return this.options[name];
        },
        /**
         * Resize the element
         * @returns void
         */
        resize: function () {
            var w = this.el.width(), h;
            h = w * this.options.ratio[1] / this.options.ratio[0];
            this.el.css('height', h + 'px');
        },
        /**
         * Init the window resize event
         * @returns void
         */
        init: function () {
            var _timer, t = this, el = this.el;
            $(window).on('resize.keepratio', function() {
                clearTimeout(_timer);
                _timer = setTimeout(function() {
                    if (typeof t.options.resizer === 'function') {
                        t.options.resizer.call(el, t, t.options.ratio);
                    } else {
                        t.resize();
                    }
                }, t.options.delay);
            }).trigger('resize.keepratio');
        },
        /**
         * Get this object instance
         * @returns KeepRatio
         */
        getInstance: function () {
            return this;
        },
        destroy: function () {
            // off resize
            $(window).off('resize.keepratio');
            // remove instance from dataset
            this.el.data('KeepRatio', null);
        }
    });
    $.fn.keepRatio = function (opts) {
        // call method
        // eg: $('.keep-ratio').keepRatio('getInstance')
        if (typeof opts === 'string') {
            var instance = $(this).data('KeepRatio');
            if (instance && typeof KeepRatio.prototype[opts] === 'function') {
                var args = Array.prototype.slice.call(arguments, 1);
                return instance[opts].apply(instance, args);
            }
            throw 'Method not allowed or inexisted';
        } else {
            // instantiate
            return this.each(function() {
                var instance = new KeepRatio(this, opts);
                console.log(instance);
            });
        }
    };    
})(jQuery);
