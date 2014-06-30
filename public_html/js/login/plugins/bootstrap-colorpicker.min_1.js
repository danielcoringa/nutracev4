!function(e) {
    var t = function(e) {
        this.value = {h: 1, s: 1, b: 1, a: 1}, this.setColor(e)
    };
    t.prototype = {constructor: t, setColor: function(t) {
            t = t.toLowerCase();
            var a = this;
            e.each(i.stringParsers, function(e, o) {
                var n = o.re.exec(t), s = n && o.parse(n), r = o.space || "rgba";
                return s ? (a.value = "hsla" === r ? i.RGBtoHSB.apply(null, i.HSLtoRGB.apply(null, s)) : i.RGBtoHSB.apply(null, s), !1) : void 0
            })
        }, setHue: function(e) {
            this.value.h = 1 - e
        }, setSaturation: function(e) {
            this.value.s = e
        }, setLightness: function(e) {
            this.value.b = 1 - e
        }, setAlpha: function(e) {
            this.value.a = parseInt(100 * (1 - e), 10) / 100
        }, toRGB: function(e, t, a, i) {
            e || (e = this.value.h, t = this.value.s, a = this.value.b), e *= 360;
            var o, n, s, r, l;
            return e = e % 360 / 60, l = a * t, r = l * (1 - Math.abs(e % 2 - 1)), o = n = s = a - l, e = ~~e, o += [l, r, 0, 0, r, l][e], n += [r, l, l, r, 0, 0][e], s += [0, 0, r, l, l, r][e], {r: Math.round(255 * o), g: Math.round(255 * n), b: Math.round(255 * s), a: i || this.value.a}
        }, toHex: function(e, t, a, i) {
            var o = this.toRGB(e, t, a, i);
            return"#" + (1 << 24 | parseInt(o.r) << 16 | parseInt(o.g) << 8 | parseInt(o.b)).toString(16).substr(1)
        }, toHSL: function(e, t, a, i) {
            e || (e = this.value.h, t = this.value.s, a = this.value.b);
            var o = e, n = (2 - t) * a, s = t * a;
            return s /= n > 0 && 1 >= n ? n : 2 - n, n /= 2, s > 1 && (s = 1), {h: o, s: s, l: n, a: i || this.value.a}
        }};
    var a = function(t, a) {
        this.element = e(t);
        var o = a.format || this.element.data("color-format") || "hex";
        this.format = i.translateFormats[o], this.isInput = this.element.is("input"), this.component = this.element.is(".color") ? this.element.find(".add-on") : !1, this.picker = e(i.template).appendTo("body").on("mousedown", e.proxy(this.mousedown, this)), this.isInput ? this.element.on({focus: e.proxy(this.show, this), keyup: e.proxy(this.update, this)}) : this.component ? this.component.on({click: e.proxy(this.show, this)}) : this.element.on({click: e.proxy(this.show, this)}), ("rgba" === o || "hsla" === o) && (this.picker.addClass("alpha"), this.alpha = this.picker.find(".colorpicker-alpha")[0].style), this.component ? (this.picker.find(".colorpicker-color").hide(), this.preview = this.element.find("i")[0].style) : this.preview = this.picker.find("div:last")[0].style, this.base = this.picker.find("div:first")[0].style, this.update()
    };
    a.prototype = {constructor: a, show: function(t) {
            this.picker.show(), this.height = this.component ? this.component.outerHeight() : this.element.outerHeight(), this.place(), e(window).on("resize", e.proxy(this.place, this)), this.isInput || t && (t.stopPropagation(), t.preventDefault()), e(document).on({mousedown: e.proxy(this.hide, this)}), this.element.trigger({type: "show", color: this.color})
        }, update: function() {
            this.color = new t(this.isInput ? this.element.prop("value") : this.element.data("color")), this.picker.find("i").eq(0).css({left: 100 * this.color.value.s, top: 100 - 100 * this.color.value.b}).end().eq(1).css("top", 100 * (1 - this.color.value.h)).end().eq(2).css("top", 100 * (1 - this.color.value.a)), this.previewColor()
        }, setValue: function(e) {
            this.color = new t(e), this.picker.find("i").eq(0).css({left: 100 * this.color.value.s, top: 100 - 100 * this.color.value.b}).end().eq(1).css("top", 100 * (1 - this.color.value.h)).end().eq(2).css("top", 100 * (1 - this.color.value.a)), this.previewColor(), this.element.trigger({type: "changeColor", color: this.color})
        }, hide: function() {
            this.picker.hide(), e(window).off("resize", this.place), this.isInput ? this.element.prop("value", this.format.call(this)) : (e(document).off({mousedown: this.hide}), this.component && this.element.find("input").prop("value", this.format.call(this)), this.element.data("color", this.format.call(this))), this.element.trigger({type: "hide", color: this.color})
        }, place: function() {
            var e = this.component ? this.component.offset() : this.element.offset();
            this.picker.css({top: e.top + this.height, left: e.left})
        }, previewColor: function() {
            try {
                this.preview.backgroundColor = this.format.call(this)
            } catch (e) {
                this.preview.backgroundColor = this.color.toHex()
            }
            this.base.backgroundColor = this.color.toHex(this.color.value.h, 1, 1, 1), this.alpha && (this.alpha.backgroundColor = this.color.toHex())
        }, pointer: null, slider: null, mousedown: function(t) {
            t.stopPropagation(), t.preventDefault();
            var a = e(t.target), o = a.closest("div");
            if (!o.is(".colorpicker")) {
                if (o.is(".colorpicker-saturation"))
                    this.slider = e.extend({}, i.sliders.saturation);
                else if (o.is(".colorpicker-hue"))
                    this.slider = e.extend({}, i.sliders.hue);
                else {
                    if (!o.is(".colorpicker-alpha"))
                        return!1;
                    this.slider = e.extend({}, i.sliders.alpha)
                }
                var n = o.offset();
                this.slider.knob = o.find("i")[0].style, this.slider.left = t.pageX - n.left, this.slider.top = t.pageY - n.top, this.pointer = {left: t.pageX, top: t.pageY}, e(document).on({mousemove: e.proxy(this.mousemove, this), mouseup: e.proxy(this.mouseup, this)}).trigger("mousemove")
            }
            return!1
        }, mousemove: function(e) {
            e.stopPropagation(), e.preventDefault();
            var t = Math.max(0, Math.min(this.slider.maxLeft, this.slider.left + ((e.pageX || this.pointer.left) - this.pointer.left))), a = Math.max(0, Math.min(this.slider.maxTop, this.slider.top + ((e.pageY || this.pointer.top) - this.pointer.top)));
            return this.slider.knob.left = t + "px", this.slider.knob.top = a + "px", this.slider.callLeft && this.color[this.slider.callLeft].call(this.color, t / 100), this.slider.callTop && this.color[this.slider.callTop].call(this.color, a / 100), this.previewColor(), this.element.trigger({type: "changeColor", color: this.color}), !1
        }, mouseup: function(t) {
            return t.stopPropagation(), t.preventDefault(), e(document).off({mousemove: this.mousemove, mouseup: this.mouseup}), !1
        }}, e.fn.colorpicker = function(t, i) {
        return this.each(function() {
            var o = e(this), n = o.data("colorpicker"), s = "object" == typeof t && t;
            n || o.data("colorpicker", n = new a(this, e.extend({}, e.fn.colorpicker.defaults, s))), "string" == typeof t && n[t](i)
        })
    }, e.fn.colorpicker.defaults = {}, e.fn.colorpicker.Constructor = a;
    var i = {translateFormats: {rgb: function() {
                var e = this.color.toRGB();
                return"rgb(" + e.r + "," + e.g + "," + e.b + ")"
            }, rgba: function() {
                var e = this.color.toRGB();
                return"rgba(" + e.r + "," + e.g + "," + e.b + "," + e.a + ")"
            }, hsl: function() {
                var e = this.color.toHSL();
                return"hsl(" + Math.round(360 * e.h) + "," + Math.round(100 * e.s) + "%," + Math.round(100 * e.l) + "%)"
            }, hsla: function() {
                var e = this.color.toHSL();
                return"hsla(" + Math.round(360 * e.h) + "," + Math.round(100 * e.s) + "%," + Math.round(100 * e.l) + "%," + e.a + ")"
            }, hex: function() {
                return this.color.toHex()
            }}, sliders: {saturation: {maxLeft: 100, maxTop: 100, callLeft: "setSaturation", callTop: "setLightness"}, hue: {maxLeft: 0, maxTop: 100, callLeft: !1, callTop: "setHue"}, alpha: {maxLeft: 0, maxTop: 100, callLeft: !1, callTop: "setAlpha"}}, RGBtoHSB: function(e, t, a, i) {
            e /= 255, t /= 255, a /= 255;
            var o, n, s, r;
            return s = Math.max(e, t, a), r = s - Math.min(e, t, a), o = 0 === r ? null : s == e ? (t - a) / r : s == t ? (a - e) / r + 2 : (e - t) / r + 4, o = 60 * ((o + 360) % 6) / 360, n = 0 === r ? 0 : r / s, {h: o || 1, s: n, b: s, a: i || 1}
        }, HueToRGB: function(e, t, a) {
            return 0 > a ? a += 1 : a > 1 && (a -= 1), 1 > 6 * a ? e + 6 * (t - e) * a : 1 > 2 * a ? t : 2 > 3 * a ? e + 6 * (t - e) * (2 / 3 - a) : e
        }, HSLtoRGB: function(e, t, a, o) {
            0 > t && (t = 0);
            var n;
            n = .5 >= a ? a * (1 + t) : a + t - a * t;
            var s = 2 * a - n, r = e + 1 / 3, l = e, c = e - 1 / 3, h = Math.round(255 * i.HueToRGB(s, n, r)), d = Math.round(255 * i.HueToRGB(s, n, l)), u = Math.round(255 * i.HueToRGB(s, n, c));
            return[h, d, u, o || 1]
        }, stringParsers: [{re: /rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/, parse: function(e) {
                    return[e[1], e[2], e[3], e[4]]
                }}, {re: /rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/, parse: function(e) {
                    return[2.55 * e[1], 2.55 * e[2], 2.55 * e[3], e[4]]
                }}, {re: /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/, parse: function(e) {
                    return[parseInt(e[1], 16), parseInt(e[2], 16), parseInt(e[3], 16)]
                }}, {re: /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/, parse: function(e) {
                    return[parseInt(e[1] + e[1], 16), parseInt(e[2] + e[2], 16), parseInt(e[3] + e[3], 16)]
                }}, {re: /hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/, space: "hsla", parse: function(e) {
                    return[e[1] / 360, e[2] / 100, e[3] / 100, e[4]]
                }}], template: '<div class="colorpicker dropdown-menu"><div class="colorpicker-saturation"><i><b></b></i></div><div class="colorpicker-hue"><i></i></div><div class="colorpicker-alpha"><i></i></div><div class="colorpicker-color"><div /></div></div>'}
}(window.jQuery);