/*! 
 * Formstone v1.0.0 [2016-07-04] 
 * Formstone website. 
 * Ben Plum 
 */
! function() {
    window.console || (window.console = {});
    for (var a = "log info warn error debug trace dir group groupCollapsed groupEnd time timeEnd profile profileEnd dirxml assert count markTimeline timeStamp clear".split(" "), b = 0; b < a.length; b++) window.console[a[b]] || (window.console[a[b]] = function() {})
}(), Array.prototype.indexOf || (Array.prototype.indexOf = function(a) {
        var b = this.length >>> 0,
            c = Number(arguments[1]) || 0;
        for (c = 0 > c ? Math.ceil(c) : Math.floor(c), 0 > c && (c += b); b > c; c++)
            if (c in this && this[c] === a) return c;
        return -1
    }), Array.prototype.forEach || (Array.prototype.forEach = function(a, b) {
        for (var c = 0, d = this.length; d > c; c++) c in this && a.call(b, this[c], c, this)
    }), String.prototype.trim || (String.prototype.trim = function() {
        return this.replace(/^\s+|\s+$/g, "")
    }), ! function(a, b) {
        "object" == typeof module && "object" == typeof module.exports ? module.exports = a.document ? b(a, !0) : function(a) {
            if (!a.document) throw new Error("jQuery requires a window with a document");
            return b(a)
        } : b(a)
    }("undefined" != typeof window ? window : this, function(a, b) {
        function c(a) {
            var b = "length" in a && a.length,
                c = ea.type(a);
            return "function" === c || ea.isWindow(a) ? !1 : 1 === a.nodeType && b ? !0 : "array" === c || 0 === b || "number" == typeof b && b > 0 && b - 1 in a
        }

        function d(a, b, c) {
            if (ea.isFunction(b)) return ea.grep(a, function(a, d) {
                return !!b.call(a, d, a) !== c
            });
            if (b.nodeType) return ea.grep(a, function(a) {
                return a === b !== c
            });
            if ("string" == typeof b) {
                if (ma.test(b)) return ea.filter(b, a, c);
                b = ea.filter(b, a)
            }
            return ea.grep(a, function(a) {
                return ea.inArray(a, b) >= 0 !== c
            })
        }

        function e(a, b) {
            do a = a[b]; while (a && 1 !== a.nodeType);
            return a
        }

        function f(a) {
            var b = ua[a] = {};
            return ea.each(a.match(ta) || [], function(a, c) {
                b[c] = !0
            }), b
        }

        function g() {
            oa.addEventListener ? (oa.removeEventListener("DOMContentLoaded", h, !1), a.removeEventListener("load", h, !1)) : (oa.detachEvent("onreadystatechange", h), a.detachEvent("onload", h))
        }

        function h() {
            (oa.addEventListener || "load" === event.type || "complete" === oa.readyState) && (g(), ea.ready())
        }

        function i(a, b, c) {
            if (void 0 === c && 1 === a.nodeType) {
                var d = "data-" + b.replace(za, "-$1").toLowerCase();
                if (c = a.getAttribute(d), "string" == typeof c) {
                    try {
                        c = "true" === c ? !0 : "false" === c ? !1 : "null" === c ? null : +c + "" === c ? +c : ya.test(c) ? ea.parseJSON(c) : c
                    } catch (e) {}
                    ea.data(a, b, c)
                } else c = void 0
            }
            return c
        }

        function j(a) {
            var b;
            for (b in a)
                if (("data" !== b || !ea.isEmptyObject(a[b])) && "toJSON" !== b) return !1;
            return !0
        }

        function k(a, b, c, d) {
            if (ea.acceptData(a)) {
                var e, f, g = ea.expando,
                    h = a.nodeType,
                    i = h ? ea.cache : a,
                    j = h ? a[g] : a[g] && g;
                if (j && i[j] && (d || i[j].data) || void 0 !== c || "string" != typeof b) return j || (j = h ? a[g] = W.pop() || ea.guid++ : g), i[j] || (i[j] = h ? {} : {
                    toJSON: ea.noop
                }), ("object" == typeof b || "function" == typeof b) && (d ? i[j] = ea.extend(i[j], b) : i[j].data = ea.extend(i[j].data, b)), f = i[j], d || (f.data || (f.data = {}), f = f.data), void 0 !== c && (f[ea.camelCase(b)] = c), "string" == typeof b ? (e = f[b], null == e && (e = f[ea.camelCase(b)])) : e = f, e
            }
        }

        function l(a, b, c) {
            if (ea.acceptData(a)) {
                var d, e, f = a.nodeType,
                    g = f ? ea.cache : a,
                    h = f ? a[ea.expando] : ea.expando;
                if (g[h]) {
                    if (b && (d = c ? g[h] : g[h].data)) {
                        ea.isArray(b) ? b = b.concat(ea.map(b, ea.camelCase)) : b in d ? b = [b] : (b = ea.camelCase(b), b = b in d ? [b] : b.split(" ")), e = b.length;
                        for (; e--;) delete d[b[e]];
                        if (c ? !j(d) : !ea.isEmptyObject(d)) return
                    }(c || (delete g[h].data, j(g[h]))) && (f ? ea.cleanData([a], !0) : ca.deleteExpando || g != g.window ? delete g[h] : g[h] = null)
                }
            }
        }

        function m() {
            return !0
        }

        function n() {
            return !1
        }

        function o() {
            try {
                return oa.activeElement
            } catch (a) {}
        }

        function p(a) {
            var b = Ka.split("|"),
                c = a.createDocumentFragment();
            if (c.createElement)
                for (; b.length;) c.createElement(b.pop());
            return c
        }

        function q(a, b) {
            var c, d, e = 0,
                f = typeof a.getElementsByTagName !== xa ? a.getElementsByTagName(b || "*") : typeof a.querySelectorAll !== xa ? a.querySelectorAll(b || "*") : void 0;
            if (!f)
                for (f = [], c = a.childNodes || a; null != (d = c[e]); e++) !b || ea.nodeName(d, b) ? f.push(d) : ea.merge(f, q(d, b));
            return void 0 === b || b && ea.nodeName(a, b) ? ea.merge([a], f) : f
        }

        function r(a) {
            Ea.test(a.type) && (a.defaultChecked = a.checked)
        }

        function s(a, b) {
            return ea.nodeName(a, "table") && ea.nodeName(11 !== b.nodeType ? b : b.firstChild, "tr") ? a.getElementsByTagName("tbody")[0] || a.appendChild(a.ownerDocument.createElement("tbody")) : a
        }

        function t(a) {
            return a.type = (null !== ea.find.attr(a, "type")) + "/" + a.type, a
        }

        function u(a) {
            var b = Va.exec(a.type);
            return b ? a.type = b[1] : a.removeAttribute("type"), a
        }

        function v(a, b) {
            for (var c, d = 0; null != (c = a[d]); d++) ea._data(c, "globalEval", !b || ea._data(b[d], "globalEval"))
        }

        function w(a, b) {
            if (1 === b.nodeType && ea.hasData(a)) {
                var c, d, e, f = ea._data(a),
                    g = ea._data(b, f),
                    h = f.events;
                if (h) {
                    delete g.handle, g.events = {};
                    for (c in h)
                        for (d = 0, e = h[c].length; e > d; d++) ea.event.add(b, c, h[c][d])
                }
                g.data && (g.data = ea.extend({}, g.data))
            }
        }

        function x(a, b) {
            var c, d, e;
            if (1 === b.nodeType) {
                if (c = b.nodeName.toLowerCase(), !ca.noCloneEvent && b[ea.expando]) {
                    e = ea._data(b);
                    for (d in e.events) ea.removeEvent(b, d, e.handle);
                    b.removeAttribute(ea.expando)
                }
                "script" === c && b.text !== a.text ? (t(b).text = a.text, u(b)) : "object" === c ? (b.parentNode && (b.outerHTML = a.outerHTML), ca.html5Clone && a.innerHTML && !ea.trim(b.innerHTML) && (b.innerHTML = a.innerHTML)) : "input" === c && Ea.test(a.type) ? (b.defaultChecked = b.checked = a.checked, b.value !== a.value && (b.value = a.value)) : "option" === c ? b.defaultSelected = b.selected = a.defaultSelected : ("input" === c || "textarea" === c) && (b.defaultValue = a.defaultValue)
            }
        }

        function y(b, c) {
            var d, e = ea(c.createElement(b)).appendTo(c.body),
                f = a.getDefaultComputedStyle && (d = a.getDefaultComputedStyle(e[0])) ? d.display : ea.css(e[0], "display");
            return e.detach(), f
        }

        function z(a) {
            var b = oa,
                c = _a[a];
            return c || (c = y(a, b), "none" !== c && c || ($a = ($a || ea("<iframe frameborder='0' width='0' height='0'/>")).appendTo(b.documentElement), b = ($a[0].contentWindow || $a[0].contentDocument).document, b.write(), b.close(), c = y(a, b), $a.detach()), _a[a] = c), c
        }

        function A(a, b) {
            return {
                get: function() {
                    var c = a();
                    return null != c ? c ? void delete this.get : (this.get = b).apply(this, arguments) : void 0
                }
            }
        }

        function B(a, b) {
            if (b in a) return b;
            for (var c = b.charAt(0).toUpperCase() + b.slice(1), d = b, e = mb.length; e--;)
                if (b = mb[e] + c, b in a) return b;
            return d
        }

        function C(a, b) {
            for (var c, d, e, f = [], g = 0, h = a.length; h > g; g++) d = a[g], d.style && (f[g] = ea._data(d, "olddisplay"), c = d.style.display, b ? (f[g] || "none" !== c || (d.style.display = ""), "" === d.style.display && Ca(d) && (f[g] = ea._data(d, "olddisplay", z(d.nodeName)))) : (e = Ca(d), (c && "none" !== c || !e) && ea._data(d, "olddisplay", e ? c : ea.css(d, "display"))));
            for (g = 0; h > g; g++) d = a[g], d.style && (b && "none" !== d.style.display && "" !== d.style.display || (d.style.display = b ? f[g] || "" : "none"));
            return a
        }

        function D(a, b, c) {
            var d = ib.exec(b);
            return d ? Math.max(0, d[1] - (c || 0)) + (d[2] || "px") : b
        }

        function E(a, b, c, d, e) {
            for (var f = c === (d ? "border" : "content") ? 4 : "width" === b ? 1 : 0, g = 0; 4 > f; f += 2) "margin" === c && (g += ea.css(a, c + Ba[f], !0, e)), d ? ("content" === c && (g -= ea.css(a, "padding" + Ba[f], !0, e)), "margin" !== c && (g -= ea.css(a, "border" + Ba[f] + "Width", !0, e))) : (g += ea.css(a, "padding" + Ba[f], !0, e), "padding" !== c && (g += ea.css(a, "border" + Ba[f] + "Width", !0, e)));
            return g
        }

        function F(a, b, c) {
            var d = !0,
                e = "width" === b ? a.offsetWidth : a.offsetHeight,
                f = ab(a),
                g = ca.boxSizing && "border-box" === ea.css(a, "boxSizing", !1, f);
            if (0 >= e || null == e) {
                if (e = bb(a, b, f), (0 > e || null == e) && (e = a.style[b]), db.test(e)) return e;
                d = g && (ca.boxSizingReliable() || e === a.style[b]), e = parseFloat(e) || 0
            }
            return e + E(a, b, c || (g ? "border" : "content"), d, f) + "px"
        }

        function G(a, b, c, d, e) {
            return new G.prototype.init(a, b, c, d, e)
        }

        function H() {
            return setTimeout(function() {
                nb = void 0
            }), nb = ea.now()
        }

        function I(a, b) {
            var c, d = {
                    height: a
                },
                e = 0;
            for (b = b ? 1 : 0; 4 > e; e += 2 - b) c = Ba[e], d["margin" + c] = d["padding" + c] = a;
            return b && (d.opacity = d.width = a), d
        }

        function J(a, b, c) {
            for (var d, e = (tb[b] || []).concat(tb["*"]), f = 0, g = e.length; g > f; f++)
                if (d = e[f].call(c, b, a)) return d
        }

        function K(a, b, c) {
            var d, e, f, g, h, i, j, k, l = this,
                m = {},
                n = a.style,
                o = a.nodeType && Ca(a),
                p = ea._data(a, "fxshow");
            c.queue || (h = ea._queueHooks(a, "fx"), null == h.unqueued && (h.unqueued = 0, i = h.empty.fire, h.empty.fire = function() {
                h.unqueued || i()
            }), h.unqueued++, l.always(function() {
                l.always(function() {
                    h.unqueued--, ea.queue(a, "fx").length || h.empty.fire()
                })
            })), 1 === a.nodeType && ("height" in b || "width" in b) && (c.overflow = [n.overflow, n.overflowX, n.overflowY], j = ea.css(a, "display"), k = "none" === j ? ea._data(a, "olddisplay") || z(a.nodeName) : j, "inline" === k && "none" === ea.css(a, "float") && (ca.inlineBlockNeedsLayout && "inline" !== z(a.nodeName) ? n.zoom = 1 : n.display = "inline-block")), c.overflow && (n.overflow = "hidden", ca.shrinkWrapBlocks() || l.always(function() {
                n.overflow = c.overflow[0], n.overflowX = c.overflow[1], n.overflowY = c.overflow[2]
            }));
            for (d in b)
                if (e = b[d], pb.exec(e)) {
                    if (delete b[d], f = f || "toggle" === e, e === (o ? "hide" : "show")) {
                        if ("show" !== e || !p || void 0 === p[d]) continue;
                        o = !0
                    }
                    m[d] = p && p[d] || ea.style(a, d)
                } else j = void 0;
            if (ea.isEmptyObject(m)) "inline" === ("none" === j ? z(a.nodeName) : j) && (n.display = j);
            else {
                p ? "hidden" in p && (o = p.hidden) : p = ea._data(a, "fxshow", {}), f && (p.hidden = !o), o ? ea(a).show() : l.done(function() {
                    ea(a).hide()
                }), l.done(function() {
                    var b;
                    ea._removeData(a, "fxshow");
                    for (b in m) ea.style(a, b, m[b])
                });
                for (d in m) g = J(o ? p[d] : 0, d, l), d in p || (p[d] = g.start, o && (g.end = g.start, g.start = "width" === d || "height" === d ? 1 : 0))
            }
        }

        function L(a, b) {
            var c, d, e, f, g;
            for (c in a)
                if (d = ea.camelCase(c), e = b[d], f = a[c], ea.isArray(f) && (e = f[1], f = a[c] = f[0]), c !== d && (a[d] = f, delete a[c]), g = ea.cssHooks[d], g && "expand" in g) {
                    f = g.expand(f), delete a[d];
                    for (c in f) c in a || (a[c] = f[c], b[c] = e)
                } else b[d] = e
        }

        function M(a, b, c) {
            var d, e, f = 0,
                g = sb.length,
                h = ea.Deferred().always(function() {
                    delete i.elem
                }),
                i = function() {
                    if (e) return !1;
                    for (var b = nb || H(), c = Math.max(0, j.startTime + j.duration - b), d = c / j.duration || 0, f = 1 - d, g = 0, i = j.tweens.length; i > g; g++) j.tweens[g].run(f);
                    return h.notifyWith(a, [j, f, c]), 1 > f && i ? c : (h.resolveWith(a, [j]), !1)
                },
                j = h.promise({
                    elem: a,
                    props: ea.extend({}, b),
                    opts: ea.extend(!0, {
                        specialEasing: {}
                    }, c),
                    originalProperties: b,
                    originalOptions: c,
                    startTime: nb || H(),
                    duration: c.duration,
                    tweens: [],
                    createTween: function(b, c) {
                        var d = ea.Tween(a, j.opts, b, c, j.opts.specialEasing[b] || j.opts.easing);
                        return j.tweens.push(d), d
                    },
                    stop: function(b) {
                        var c = 0,
                            d = b ? j.tweens.length : 0;
                        if (e) return this;
                        for (e = !0; d > c; c++) j.tweens[c].run(1);
                        return b ? h.resolveWith(a, [j, b]) : h.rejectWith(a, [j, b]), this
                    }
                }),
                k = j.props;
            for (L(k, j.opts.specialEasing); g > f; f++)
                if (d = sb[f].call(j, a, k, j.opts)) return d;
            return ea.map(k, J, j), ea.isFunction(j.opts.start) && j.opts.start.call(a, j), ea.fx.timer(ea.extend(i, {
                elem: a,
                anim: j,
                queue: j.opts.queue
            })), j.progress(j.opts.progress).done(j.opts.done, j.opts.complete).fail(j.opts.fail).always(j.opts.always)
        }

        function N(a) {
            return function(b, c) {
                "string" != typeof b && (c = b, b = "*");
                var d, e = 0,
                    f = b.toLowerCase().match(ta) || [];
                if (ea.isFunction(c))
                    for (; d = f[e++];) "+" === d.charAt(0) ? (d = d.slice(1) || "*", (a[d] = a[d] || []).unshift(c)) : (a[d] = a[d] || []).push(c)
            }
        }

        function O(a, b, c, d) {
            function e(h) {
                var i;
                return f[h] = !0, ea.each(a[h] || [], function(a, h) {
                    var j = h(b, c, d);
                    return "string" != typeof j || g || f[j] ? g ? !(i = j) : void 0 : (b.dataTypes.unshift(j), e(j), !1)
                }), i
            }
            var f = {},
                g = a === Rb;
            return e(b.dataTypes[0]) || !f["*"] && e("*")
        }

        function P(a, b) {
            var c, d, e = ea.ajaxSettings.flatOptions || {};
            for (d in b) void 0 !== b[d] && ((e[d] ? a : c || (c = {}))[d] = b[d]);
            return c && ea.extend(!0, a, c), a
        }

        function Q(a, b, c) {
            for (var d, e, f, g, h = a.contents, i = a.dataTypes;
                "*" === i[0];) i.shift(), void 0 === e && (e = a.mimeType || b.getResponseHeader("Content-Type"));
            if (e)
                for (g in h)
                    if (h[g] && h[g].test(e)) {
                        i.unshift(g);
                        break
                    }
            if (i[0] in c) f = i[0];
            else {
                for (g in c) {
                    if (!i[0] || a.converters[g + " " + i[0]]) {
                        f = g;
                        break
                    }
                    d || (d = g)
                }
                f = f || d
            }
            return f ? (f !== i[0] && i.unshift(f), c[f]) : void 0
        }

        function R(a, b, c, d) {
            var e, f, g, h, i, j = {},
                k = a.dataTypes.slice();
            if (k[1])
                for (g in a.converters) j[g.toLowerCase()] = a.converters[g];
            for (f = k.shift(); f;)
                if (a.responseFields[f] && (c[a.responseFields[f]] = b), !i && d && a.dataFilter && (b = a.dataFilter(b, a.dataType)), i = f, f = k.shift())
                    if ("*" === f) f = i;
                    else if ("*" !== i && i !== f) {
                if (g = j[i + " " + f] || j["* " + f], !g)
                    for (e in j)
                        if (h = e.split(" "), h[1] === f && (g = j[i + " " + h[0]] || j["* " + h[0]])) {
                            g === !0 ? g = j[e] : j[e] !== !0 && (f = h[0], k.unshift(h[1]));
                            break
                        }
                if (g !== !0)
                    if (g && a["throws"]) b = g(b);
                    else try {
                        b = g(b)
                    } catch (l) {
                        return {
                            state: "parsererror",
                            error: g ? l : "No conversion from " + i + " to " + f
                        }
                    }
            }
            return {
                state: "success",
                data: b
            }
        }

        function S(a, b, c, d) {
            var e;
            if (ea.isArray(b)) ea.each(b, function(b, e) {
                c || Vb.test(a) ? d(a, e) : S(a + "[" + ("object" == typeof e ? b : "") + "]", e, c, d)
            });
            else if (c || "object" !== ea.type(b)) d(a, b);
            else
                for (e in b) S(a + "[" + e + "]", b[e], c, d)
        }

        function T() {
            try {
                return new a.XMLHttpRequest
            } catch (b) {}
        }

        function U() {
            try {
                return new a.ActiveXObject("Microsoft.XMLHTTP")
            } catch (b) {}
        }

        function V(a) {
            return ea.isWindow(a) ? a : 9 === a.nodeType ? a.defaultView || a.parentWindow : !1
        }
        var W = [],
            X = W.slice,
            Y = W.concat,
            Z = W.push,
            $ = W.indexOf,
            _ = {},
            aa = _.toString,
            ba = _.hasOwnProperty,
            ca = {},
            da = "1.11.3",
            ea = function(a, b) {
                return new ea.fn.init(a, b)
            },
            fa = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
            ga = /^-ms-/,
            ha = /-([\da-z])/gi,
            ia = function(a, b) {
                return b.toUpperCase()
            };
        ea.fn = ea.prototype = {
            jquery: da,
            constructor: ea,
            selector: "",
            length: 0,
            toArray: function() {
                return X.call(this)
            },
            get: function(a) {
                return null != a ? 0 > a ? this[a + this.length] : this[a] : X.call(this)
            },
            pushStack: function(a) {
                var b = ea.merge(this.constructor(), a);
                return b.prevObject = this, b.context = this.context, b
            },
            each: function(a, b) {
                return ea.each(this, a, b)
            },
            map: function(a) {
                return this.pushStack(ea.map(this, function(b, c) {
                    return a.call(b, c, b)
                }))
            },
            slice: function() {
                return this.pushStack(X.apply(this, arguments))
            },
            first: function() {
                return this.eq(0)
            },
            last: function() {
                return this.eq(-1)
            },
            eq: function(a) {
                var b = this.length,
                    c = +a + (0 > a ? b : 0);
                return this.pushStack(c >= 0 && b > c ? [this[c]] : [])
            },
            end: function() {
                return this.prevObject || this.constructor(null)
            },
            push: Z,
            sort: W.sort,
            splice: W.splice
        }, ea.extend = ea.fn.extend = function() {
            var a, b, c, d, e, f, g = arguments[0] || {},
                h = 1,
                i = arguments.length,
                j = !1;
            for ("boolean" == typeof g && (j = g, g = arguments[h] || {}, h++), "object" == typeof g || ea.isFunction(g) || (g = {}), h === i && (g = this, h--); i > h; h++)
                if (null != (e = arguments[h]))
                    for (d in e) a = g[d], c = e[d], g !== c && (j && c && (ea.isPlainObject(c) || (b = ea.isArray(c))) ? (b ? (b = !1, f = a && ea.isArray(a) ? a : []) : f = a && ea.isPlainObject(a) ? a : {}, g[d] = ea.extend(j, f, c)) : void 0 !== c && (g[d] = c));
            return g
        }, ea.extend({
            expando: "jQuery" + (da + Math.random()).replace(/\D/g, ""),
            isReady: !0,
            error: function(a) {
                throw new Error(a)
            },
            noop: function() {},
            isFunction: function(a) {
                return "function" === ea.type(a)
            },
            isArray: Array.isArray || function(a) {
                return "array" === ea.type(a)
            },
            isWindow: function(a) {
                return null != a && a == a.window
            },
            isNumeric: function(a) {
                return !ea.isArray(a) && a - parseFloat(a) + 1 >= 0
            },
            isEmptyObject: function(a) {
                var b;
                for (b in a) return !1;
                return !0
            },
            isPlainObject: function(a) {
                var b;
                if (!a || "object" !== ea.type(a) || a.nodeType || ea.isWindow(a)) return !1;
                try {
                    if (a.constructor && !ba.call(a, "constructor") && !ba.call(a.constructor.prototype, "isPrototypeOf")) return !1
                } catch (c) {
                    return !1
                }
                if (ca.ownLast)
                    for (b in a) return ba.call(a, b);
                for (b in a);
                return void 0 === b || ba.call(a, b)
            },
            type: function(a) {
                return null == a ? a + "" : "object" == typeof a || "function" == typeof a ? _[aa.call(a)] || "object" : typeof a
            },
            globalEval: function(b) {
                b && ea.trim(b) && (a.execScript || function(b) {
                    a.eval.call(a, b)
                })(b)
            },
            camelCase: function(a) {
                return a.replace(ga, "ms-").replace(ha, ia)
            },
            nodeName: function(a, b) {
                return a.nodeName && a.nodeName.toLowerCase() === b.toLowerCase()
            },
            each: function(a, b, d) {
                var e, f = 0,
                    g = a.length,
                    h = c(a);
                if (d) {
                    if (h)
                        for (; g > f && (e = b.apply(a[f], d), e !== !1); f++);
                    else
                        for (f in a)
                            if (e = b.apply(a[f], d), e === !1) break
                } else if (h)
                    for (; g > f && (e = b.call(a[f], f, a[f]), e !== !1); f++);
                else
                    for (f in a)
                        if (e = b.call(a[f], f, a[f]), e === !1) break; return a
            },
            trim: function(a) {
                return null == a ? "" : (a + "").replace(fa, "")
            },
            makeArray: function(a, b) {
                var d = b || [];
                return null != a && (c(Object(a)) ? ea.merge(d, "string" == typeof a ? [a] : a) : Z.call(d, a)), d
            },
            inArray: function(a, b, c) {
                var d;
                if (b) {
                    if ($) return $.call(b, a, c);
                    for (d = b.length, c = c ? 0 > c ? Math.max(0, d + c) : c : 0; d > c; c++)
                        if (c in b && b[c] === a) return c
                }
                return -1
            },
            merge: function(a, b) {
                for (var c = +b.length, d = 0, e = a.length; c > d;) a[e++] = b[d++];
                if (c !== c)
                    for (; void 0 !== b[d];) a[e++] = b[d++];
                return a.length = e, a
            },
            grep: function(a, b, c) {
                for (var d, e = [], f = 0, g = a.length, h = !c; g > f; f++) d = !b(a[f], f), d !== h && e.push(a[f]);
                return e
            },
            map: function(a, b, d) {
                var e, f = 0,
                    g = a.length,
                    h = c(a),
                    i = [];
                if (h)
                    for (; g > f; f++) e = b(a[f], f, d), null != e && i.push(e);
                else
                    for (f in a) e = b(a[f], f, d), null != e && i.push(e);
                return Y.apply([], i)
            },
            guid: 1,
            proxy: function(a, b) {
                var c, d, e;
                return "string" == typeof b && (e = a[b], b = a, a = e), ea.isFunction(a) ? (c = X.call(arguments, 2), d = function() {
                    return a.apply(b || this, c.concat(X.call(arguments)))
                }, d.guid = a.guid = a.guid || ea.guid++, d) : void 0
            },
            now: function() {
                return +new Date
            },
            support: ca
        }), ea.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function(a, b) {
            _["[object " + b + "]"] = b.toLowerCase()
        });
        var ja = function(a) {
            function b(a, b, c, d) {
                var e, f, g, h, i, j, l, n, o, p;
                if ((b ? b.ownerDocument || b : O) !== G && F(b), b = b || G, c = c || [], h = b.nodeType, "string" != typeof a || !a || 1 !== h && 9 !== h && 11 !== h) return c;
                if (!d && I) {
                    if (11 !== h && (e = sa.exec(a)))
                        if (g = e[1]) {
                            if (9 === h) {
                                if (f = b.getElementById(g), !f || !f.parentNode) return c;
                                if (f.id === g) return c.push(f), c
                            } else if (b.ownerDocument && (f = b.ownerDocument.getElementById(g)) && M(b, f) && f.id === g) return c.push(f), c
                        } else {
                            if (e[2]) return $.apply(c, b.getElementsByTagName(a)), c;
                            if ((g = e[3]) && v.getElementsByClassName) return $.apply(c, b.getElementsByClassName(g)), c
                        }
                    if (v.qsa && (!J || !J.test(a))) {
                        if (n = l = N, o = b, p = 1 !== h && a, 1 === h && "object" !== b.nodeName.toLowerCase()) {
                            for (j = z(a), (l = b.getAttribute("id")) ? n = l.replace(ua, "\\$&") : b.setAttribute("id", n), n = "[id='" + n + "'] ", i = j.length; i--;) j[i] = n + m(j[i]);
                            o = ta.test(a) && k(b.parentNode) || b, p = j.join(",")
                        }
                        if (p) try {
                            return $.apply(c, o.querySelectorAll(p)), c
                        } catch (q) {} finally {
                            l || b.removeAttribute("id")
                        }
                    }
                }
                return B(a.replace(ia, "$1"), b, c, d)
            }

            function c() {
                function a(c, d) {
                    return b.push(c + " ") > w.cacheLength && delete a[b.shift()], a[c + " "] = d
                }
                var b = [];
                return a
            }

            function d(a) {
                return a[N] = !0, a
            }

            function e(a) {
                var b = G.createElement("div");
                try {
                    return !!a(b)
                } catch (c) {
                    return !1
                } finally {
                    b.parentNode && b.parentNode.removeChild(b), b = null
                }
            }

            function f(a, b) {
                for (var c = a.split("|"), d = a.length; d--;) w.attrHandle[c[d]] = b
            }

            function g(a, b) {
                var c = b && a,
                    d = c && 1 === a.nodeType && 1 === b.nodeType && (~b.sourceIndex || V) - (~a.sourceIndex || V);
                if (d) return d;
                if (c)
                    for (; c = c.nextSibling;)
                        if (c === b) return -1;
                return a ? 1 : -1
            }

            function h(a) {
                return function(b) {
                    var c = b.nodeName.toLowerCase();
                    return "input" === c && b.type === a
                }
            }

            function i(a) {
                return function(b) {
                    var c = b.nodeName.toLowerCase();
                    return ("input" === c || "button" === c) && b.type === a
                }
            }

            function j(a) {
                return d(function(b) {
                    return b = +b, d(function(c, d) {
                        for (var e, f = a([], c.length, b), g = f.length; g--;) c[e = f[g]] && (c[e] = !(d[e] = c[e]))
                    })
                })
            }

            function k(a) {
                return a && "undefined" != typeof a.getElementsByTagName && a
            }

            function l() {}

            function m(a) {
                for (var b = 0, c = a.length, d = ""; c > b; b++) d += a[b].value;
                return d
            }

            function n(a, b, c) {
                var d = b.dir,
                    e = c && "parentNode" === d,
                    f = Q++;
                return b.first ? function(b, c, f) {
                    for (; b = b[d];)
                        if (1 === b.nodeType || e) return a(b, c, f)
                } : function(b, c, g) {
                    var h, i, j = [P, f];
                    if (g) {
                        for (; b = b[d];)
                            if ((1 === b.nodeType || e) && a(b, c, g)) return !0
                    } else
                        for (; b = b[d];)
                            if (1 === b.nodeType || e) {
                                if (i = b[N] || (b[N] = {}), (h = i[d]) && h[0] === P && h[1] === f) return j[2] = h[2];
                                if (i[d] = j, j[2] = a(b, c, g)) return !0
                            }
                }
            }

            function o(a) {
                return a.length > 1 ? function(b, c, d) {
                    for (var e = a.length; e--;)
                        if (!a[e](b, c, d)) return !1;
                    return !0
                } : a[0]
            }

            function p(a, c, d) {
                for (var e = 0, f = c.length; f > e; e++) b(a, c[e], d);
                return d
            }

            function q(a, b, c, d, e) {
                for (var f, g = [], h = 0, i = a.length, j = null != b; i > h; h++)(f = a[h]) && (!c || c(f, d, e)) && (g.push(f), j && b.push(h));
                return g
            }

            function r(a, b, c, e, f, g) {
                return e && !e[N] && (e = r(e)), f && !f[N] && (f = r(f, g)), d(function(d, g, h, i) {
                    var j, k, l, m = [],
                        n = [],
                        o = g.length,
                        r = d || p(b || "*", h.nodeType ? [h] : h, []),
                        s = !a || !d && b ? r : q(r, m, a, h, i),
                        t = c ? f || (d ? a : o || e) ? [] : g : s;
                    if (c && c(s, t, h, i), e)
                        for (j = q(t, n), e(j, [], h, i), k = j.length; k--;)(l = j[k]) && (t[n[k]] = !(s[n[k]] = l));
                    if (d) {
                        if (f || a) {
                            if (f) {
                                for (j = [], k = t.length; k--;)(l = t[k]) && j.push(s[k] = l);
                                f(null, t = [], j, i)
                            }
                            for (k = t.length; k--;)(l = t[k]) && (j = f ? aa(d, l) : m[k]) > -1 && (d[j] = !(g[j] = l))
                        }
                    } else t = q(t === g ? t.splice(o, t.length) : t), f ? f(null, g, t, i) : $.apply(g, t)
                })
            }

            function s(a) {
                for (var b, c, d, e = a.length, f = w.relative[a[0].type], g = f || w.relative[" "], h = f ? 1 : 0, i = n(function(a) {
                        return a === b
                    }, g, !0), j = n(function(a) {
                        return aa(b, a) > -1
                    }, g, !0), k = [function(a, c, d) {
                        var e = !f && (d || c !== C) || ((b = c).nodeType ? i(a, c, d) : j(a, c, d));
                        return b = null, e
                    }]; e > h; h++)
                    if (c = w.relative[a[h].type]) k = [n(o(k), c)];
                    else {
                        if (c = w.filter[a[h].type].apply(null, a[h].matches), c[N]) {
                            for (d = ++h; e > d && !w.relative[a[d].type]; d++);
                            return r(h > 1 && o(k), h > 1 && m(a.slice(0, h - 1).concat({
                                value: " " === a[h - 2].type ? "*" : ""
                            })).replace(ia, "$1"), c, d > h && s(a.slice(h, d)), e > d && s(a = a.slice(d)), e > d && m(a))
                        }
                        k.push(c)
                    }
                return o(k)
            }

            function t(a, c) {
                var e = c.length > 0,
                    f = a.length > 0,
                    g = function(d, g, h, i, j) {
                        var k, l, m, n = 0,
                            o = "0",
                            p = d && [],
                            r = [],
                            s = C,
                            t = d || f && w.find.TAG("*", j),
                            u = P += null == s ? 1 : Math.random() || .1,
                            v = t.length;
                        for (j && (C = g !== G && g); o !== v && null != (k = t[o]); o++) {
                            if (f && k) {
                                for (l = 0; m = a[l++];)
                                    if (m(k, g, h)) {
                                        i.push(k);
                                        break
                                    }
                                j && (P = u)
                            }
                            e && ((k = !m && k) && n--, d && p.push(k))
                        }
                        if (n += o, e && o !== n) {
                            for (l = 0; m = c[l++];) m(p, r, g, h);
                            if (d) {
                                if (n > 0)
                                    for (; o--;) p[o] || r[o] || (r[o] = Y.call(i));
                                r = q(r)
                            }
                            $.apply(i, r), j && !d && r.length > 0 && n + c.length > 1 && b.uniqueSort(i)
                        }
                        return j && (P = u, C = s), p
                    };
                return e ? d(g) : g
            }
            var u, v, w, x, y, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N = "sizzle" + 1 * new Date,
                O = a.document,
                P = 0,
                Q = 0,
                R = c(),
                S = c(),
                T = c(),
                U = function(a, b) {
                    return a === b && (E = !0), 0
                },
                V = 1 << 31,
                W = {}.hasOwnProperty,
                X = [],
                Y = X.pop,
                Z = X.push,
                $ = X.push,
                _ = X.slice,
                aa = function(a, b) {
                    for (var c = 0, d = a.length; d > c; c++)
                        if (a[c] === b) return c;
                    return -1
                },
                ba = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
                ca = "[\\x20\\t\\r\\n\\f]",
                da = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
                ea = da.replace("w", "w#"),
                fa = "\\[" + ca + "*(" + da + ")(?:" + ca + "*([*^$|!~]?=)" + ca + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + ea + "))|)" + ca + "*\\]",
                ga = ":(" + da + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + fa + ")*)|.*)\\)|)",
                ha = new RegExp(ca + "+", "g"),
                ia = new RegExp("^" + ca + "+|((?:^|[^\\\\])(?:\\\\.)*)" + ca + "+$", "g"),
                ja = new RegExp("^" + ca + "*," + ca + "*"),
                ka = new RegExp("^" + ca + "*([>+~]|" + ca + ")" + ca + "*"),
                la = new RegExp("=" + ca + "*([^\\]'\"]*?)" + ca + "*\\]", "g"),
                ma = new RegExp(ga),
                na = new RegExp("^" + ea + "$"),
                oa = {
                    ID: new RegExp("^#(" + da + ")"),
                    CLASS: new RegExp("^\\.(" + da + ")"),
                    TAG: new RegExp("^(" + da.replace("w", "w*") + ")"),
                    ATTR: new RegExp("^" + fa),
                    PSEUDO: new RegExp("^" + ga),
                    CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + ca + "*(even|odd|(([+-]|)(\\d*)n|)" + ca + "*(?:([+-]|)" + ca + "*(\\d+)|))" + ca + "*\\)|)", "i"),
                    bool: new RegExp("^(?:" + ba + ")$", "i"),
                    needsContext: new RegExp("^" + ca + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + ca + "*((?:-\\d)?\\d*)" + ca + "*\\)|)(?=[^-]|$)", "i")
                },
                pa = /^(?:input|select|textarea|button)$/i,
                qa = /^h\d$/i,
                ra = /^[^{]+\{\s*\[native \w/,
                sa = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
                ta = /[+~]/,
                ua = /'|\\/g,
                va = new RegExp("\\\\([\\da-f]{1,6}" + ca + "?|(" + ca + ")|.)", "ig"),
                wa = function(a, b, c) {
                    var d = "0x" + b - 65536;
                    return d !== d || c ? b : 0 > d ? String.fromCharCode(d + 65536) : String.fromCharCode(d >> 10 | 55296, 1023 & d | 56320)
                },
                xa = function() {
                    F()
                };
            try {
                $.apply(X = _.call(O.childNodes), O.childNodes), X[O.childNodes.length].nodeType
            } catch (ya) {
                $ = {
                    apply: X.length ? function(a, b) {
                        Z.apply(a, _.call(b))
                    } : function(a, b) {
                        for (var c = a.length, d = 0; a[c++] = b[d++];);
                        a.length = c - 1
                    }
                }
            }
            v = b.support = {}, y = b.isXML = function(a) {
                var b = a && (a.ownerDocument || a).documentElement;
                return b ? "HTML" !== b.nodeName : !1
            }, F = b.setDocument = function(a) {
                var b, c, d = a ? a.ownerDocument || a : O;
                return d !== G && 9 === d.nodeType && d.documentElement ? (G = d, H = d.documentElement, c = d.defaultView, c && c !== c.top && (c.addEventListener ? c.addEventListener("unload", xa, !1) : c.attachEvent && c.attachEvent("onunload", xa)), I = !y(d), v.attributes = e(function(a) {
                    return a.className = "i", !a.getAttribute("className")
                }), v.getElementsByTagName = e(function(a) {
                    return a.appendChild(d.createComment("")), !a.getElementsByTagName("*").length
                }), v.getElementsByClassName = ra.test(d.getElementsByClassName), v.getById = e(function(a) {
                    return H.appendChild(a).id = N, !d.getElementsByName || !d.getElementsByName(N).length
                }), v.getById ? (w.find.ID = function(a, b) {
                    if ("undefined" != typeof b.getElementById && I) {
                        var c = b.getElementById(a);
                        return c && c.parentNode ? [c] : []
                    }
                }, w.filter.ID = function(a) {
                    var b = a.replace(va, wa);
                    return function(a) {
                        return a.getAttribute("id") === b
                    }
                }) : (delete w.find.ID, w.filter.ID = function(a) {
                    var b = a.replace(va, wa);
                    return function(a) {
                        var c = "undefined" != typeof a.getAttributeNode && a.getAttributeNode("id");
                        return c && c.value === b
                    }
                }), w.find.TAG = v.getElementsByTagName ? function(a, b) {
                    return "undefined" != typeof b.getElementsByTagName ? b.getElementsByTagName(a) : v.qsa ? b.querySelectorAll(a) : void 0
                } : function(a, b) {
                    var c, d = [],
                        e = 0,
                        f = b.getElementsByTagName(a);
                    if ("*" === a) {
                        for (; c = f[e++];) 1 === c.nodeType && d.push(c);
                        return d
                    }
                    return f
                }, w.find.CLASS = v.getElementsByClassName && function(a, b) {
                    return I ? b.getElementsByClassName(a) : void 0
                }, K = [], J = [], (v.qsa = ra.test(d.querySelectorAll)) && (e(function(a) {
                    H.appendChild(a).innerHTML = "<a id='" + N + "'></a><select id='" + N + "-\f]' msallowcapture=''><option selected=''></option></select>", a.querySelectorAll("[msallowcapture^='']").length && J.push("[*^$]=" + ca + "*(?:''|\"\")"), a.querySelectorAll("[selected]").length || J.push("\\[" + ca + "*(?:value|" + ba + ")"), a.querySelectorAll("[id~=" + N + "-]").length || J.push("~="), a.querySelectorAll(":checked").length || J.push(":checked"), a.querySelectorAll("a#" + N + "+*").length || J.push(".#.+[+~]")
                }), e(function(a) {
                    var b = d.createElement("input");
                    b.setAttribute("type", "hidden"), a.appendChild(b).setAttribute("name", "D"), a.querySelectorAll("[name=d]").length && J.push("name" + ca + "*[*^$|!~]?="), a.querySelectorAll(":enabled").length || J.push(":enabled", ":disabled"), a.querySelectorAll("*,:x"), J.push(",.*:")
                })), (v.matchesSelector = ra.test(L = H.matches || H.webkitMatchesSelector || H.mozMatchesSelector || H.oMatchesSelector || H.msMatchesSelector)) && e(function(a) {
                    v.disconnectedMatch = L.call(a, "div"), L.call(a, "[s!='']:x"), K.push("!=", ga)
                }), J = J.length && new RegExp(J.join("|")), K = K.length && new RegExp(K.join("|")), b = ra.test(H.compareDocumentPosition), M = b || ra.test(H.contains) ? function(a, b) {
                    var c = 9 === a.nodeType ? a.documentElement : a,
                        d = b && b.parentNode;
                    return a === d || !(!d || 1 !== d.nodeType || !(c.contains ? c.contains(d) : a.compareDocumentPosition && 16 & a.compareDocumentPosition(d)))
                } : function(a, b) {
                    if (b)
                        for (; b = b.parentNode;)
                            if (b === a) return !0;
                    return !1
                }, U = b ? function(a, b) {
                    if (a === b) return E = !0, 0;
                    var c = !a.compareDocumentPosition - !b.compareDocumentPosition;
                    return c ? c : (c = (a.ownerDocument || a) === (b.ownerDocument || b) ? a.compareDocumentPosition(b) : 1, 1 & c || !v.sortDetached && b.compareDocumentPosition(a) === c ? a === d || a.ownerDocument === O && M(O, a) ? -1 : b === d || b.ownerDocument === O && M(O, b) ? 1 : D ? aa(D, a) - aa(D, b) : 0 : 4 & c ? -1 : 1)
                } : function(a, b) {
                    if (a === b) return E = !0, 0;
                    var c, e = 0,
                        f = a.parentNode,
                        h = b.parentNode,
                        i = [a],
                        j = [b];
                    if (!f || !h) return a === d ? -1 : b === d ? 1 : f ? -1 : h ? 1 : D ? aa(D, a) - aa(D, b) : 0;
                    if (f === h) return g(a, b);
                    for (c = a; c = c.parentNode;) i.unshift(c);
                    for (c = b; c = c.parentNode;) j.unshift(c);
                    for (; i[e] === j[e];) e++;
                    return e ? g(i[e], j[e]) : i[e] === O ? -1 : j[e] === O ? 1 : 0
                }, d) : G
            }, b.matches = function(a, c) {
                return b(a, null, null, c)
            }, b.matchesSelector = function(a, c) {
                if ((a.ownerDocument || a) !== G && F(a), c = c.replace(la, "='$1']"), !(!v.matchesSelector || !I || K && K.test(c) || J && J.test(c))) try {
                    var d = L.call(a, c);
                    if (d || v.disconnectedMatch || a.document && 11 !== a.document.nodeType) return d
                } catch (e) {}
                return b(c, G, null, [a]).length > 0
            }, b.contains = function(a, b) {
                return (a.ownerDocument || a) !== G && F(a), M(a, b)
            }, b.attr = function(a, b) {
                (a.ownerDocument || a) !== G && F(a);
                var c = w.attrHandle[b.toLowerCase()],
                    d = c && W.call(w.attrHandle, b.toLowerCase()) ? c(a, b, !I) : void 0;
                return void 0 !== d ? d : v.attributes || !I ? a.getAttribute(b) : (d = a.getAttributeNode(b)) && d.specified ? d.value : null
            }, b.error = function(a) {
                throw new Error("Syntax error, unrecognized expression: " + a)
            }, b.uniqueSort = function(a) {
                var b, c = [],
                    d = 0,
                    e = 0;
                if (E = !v.detectDuplicates, D = !v.sortStable && a.slice(0), a.sort(U), E) {
                    for (; b = a[e++];) b === a[e] && (d = c.push(e));
                    for (; d--;) a.splice(c[d], 1)
                }
                return D = null, a
            }, x = b.getText = function(a) {
                var b, c = "",
                    d = 0,
                    e = a.nodeType;
                if (e) {
                    if (1 === e || 9 === e || 11 === e) {
                        if ("string" == typeof a.textContent) return a.textContent;
                        for (a = a.firstChild; a; a = a.nextSibling) c += x(a)
                    } else if (3 === e || 4 === e) return a.nodeValue
                } else
                    for (; b = a[d++];) c += x(b);
                return c
            }, w = b.selectors = {
                cacheLength: 50,
                createPseudo: d,
                match: oa,
                attrHandle: {},
                find: {},
                relative: {
                    ">": {
                        dir: "parentNode",
                        first: !0
                    },
                    " ": {
                        dir: "parentNode"
                    },
                    "+": {
                        dir: "previousSibling",
                        first: !0
                    },
                    "~": {
                        dir: "previousSibling"
                    }
                },
                preFilter: {
                    ATTR: function(a) {
                        return a[1] = a[1].replace(va, wa), a[3] = (a[3] || a[4] || a[5] || "").replace(va, wa), "~=" === a[2] && (a[3] = " " + a[3] + " "), a.slice(0, 4)
                    },
                    CHILD: function(a) {
                        return a[1] = a[1].toLowerCase(), "nth" === a[1].slice(0, 3) ? (a[3] || b.error(a[0]), a[4] = +(a[4] ? a[5] + (a[6] || 1) : 2 * ("even" === a[3] || "odd" === a[3])), a[5] = +(a[7] + a[8] || "odd" === a[3])) : a[3] && b.error(a[0]), a
                    },
                    PSEUDO: function(a) {
                        var b, c = !a[6] && a[2];
                        return oa.CHILD.test(a[0]) ? null : (a[3] ? a[2] = a[4] || a[5] || "" : c && ma.test(c) && (b = z(c, !0)) && (b = c.indexOf(")", c.length - b) - c.length) && (a[0] = a[0].slice(0, b), a[2] = c.slice(0, b)), a.slice(0, 3))
                    }
                },
                filter: {
                    TAG: function(a) {
                        var b = a.replace(va, wa).toLowerCase();
                        return "*" === a ? function() {
                            return !0
                        } : function(a) {
                            return a.nodeName && a.nodeName.toLowerCase() === b
                        }
                    },
                    CLASS: function(a) {
                        var b = R[a + " "];
                        return b || (b = new RegExp("(^|" + ca + ")" + a + "(" + ca + "|$)")) && R(a, function(a) {
                            return b.test("string" == typeof a.className && a.className || "undefined" != typeof a.getAttribute && a.getAttribute("class") || "")
                        })
                    },
                    ATTR: function(a, c, d) {
                        return function(e) {
                            var f = b.attr(e, a);
                            return null == f ? "!=" === c : c ? (f += "", "=" === c ? f === d : "!=" === c ? f !== d : "^=" === c ? d && 0 === f.indexOf(d) : "*=" === c ? d && f.indexOf(d) > -1 : "$=" === c ? d && f.slice(-d.length) === d : "~=" === c ? (" " + f.replace(ha, " ") + " ").indexOf(d) > -1 : "|=" === c ? f === d || f.slice(0, d.length + 1) === d + "-" : !1) : !0
                        }
                    },
                    CHILD: function(a, b, c, d, e) {
                        var f = "nth" !== a.slice(0, 3),
                            g = "last" !== a.slice(-4),
                            h = "of-type" === b;
                        return 1 === d && 0 === e ? function(a) {
                            return !!a.parentNode
                        } : function(b, c, i) {
                            var j, k, l, m, n, o, p = f !== g ? "nextSibling" : "previousSibling",
                                q = b.parentNode,
                                r = h && b.nodeName.toLowerCase(),
                                s = !i && !h;
                            if (q) {
                                if (f) {
                                    for (; p;) {
                                        for (l = b; l = l[p];)
                                            if (h ? l.nodeName.toLowerCase() === r : 1 === l.nodeType) return !1;
                                        o = p = "only" === a && !o && "nextSibling"
                                    }
                                    return !0
                                }
                                if (o = [g ? q.firstChild : q.lastChild], g && s) {
                                    for (k = q[N] || (q[N] = {}), j = k[a] || [], n = j[0] === P && j[1], m = j[0] === P && j[2], l = n && q.childNodes[n]; l = ++n && l && l[p] || (m = n = 0) || o.pop();)
                                        if (1 === l.nodeType && ++m && l === b) {
                                            k[a] = [P, n, m];
                                            break
                                        }
                                } else if (s && (j = (b[N] || (b[N] = {}))[a]) && j[0] === P) m = j[1];
                                else
                                    for (;
                                        (l = ++n && l && l[p] || (m = n = 0) || o.pop()) && ((h ? l.nodeName.toLowerCase() !== r : 1 !== l.nodeType) || !++m || (s && ((l[N] || (l[N] = {}))[a] = [P, m]), l !== b)););
                                return m -= e, m === d || m % d === 0 && m / d >= 0
                            }
                        }
                    },
                    PSEUDO: function(a, c) {
                        var e, f = w.pseudos[a] || w.setFilters[a.toLowerCase()] || b.error("unsupported pseudo: " + a);
                        return f[N] ? f(c) : f.length > 1 ? (e = [a, a, "", c], w.setFilters.hasOwnProperty(a.toLowerCase()) ? d(function(a, b) {
                            for (var d, e = f(a, c), g = e.length; g--;) d = aa(a, e[g]), a[d] = !(b[d] = e[g])
                        }) : function(a) {
                            return f(a, 0, e)
                        }) : f
                    }
                },
                pseudos: {
                    not: d(function(a) {
                        var b = [],
                            c = [],
                            e = A(a.replace(ia, "$1"));
                        return e[N] ? d(function(a, b, c, d) {
                            for (var f, g = e(a, null, d, []), h = a.length; h--;)(f = g[h]) && (a[h] = !(b[h] = f))
                        }) : function(a, d, f) {
                            return b[0] = a, e(b, null, f, c), b[0] = null, !c.pop()
                        }
                    }),
                    has: d(function(a) {
                        return function(c) {
                            return b(a, c).length > 0
                        }
                    }),
                    contains: d(function(a) {
                        return a = a.replace(va, wa),
                            function(b) {
                                return (b.textContent || b.innerText || x(b)).indexOf(a) > -1
                            }
                    }),
                    lang: d(function(a) {
                        return na.test(a || "") || b.error("unsupported lang: " + a), a = a.replace(va, wa).toLowerCase(),
                            function(b) {
                                var c;
                                do
                                    if (c = I ? b.lang : b.getAttribute("xml:lang") || b.getAttribute("lang")) return c = c.toLowerCase(), c === a || 0 === c.indexOf(a + "-");
                                while ((b = b.parentNode) && 1 === b.nodeType);
                                return !1
                            }
                    }),
                    target: function(b) {
                        var c = a.location && a.location.hash;
                        return c && c.slice(1) === b.id
                    },
                    root: function(a) {
                        return a === H
                    },
                    focus: function(a) {
                        return a === G.activeElement && (!G.hasFocus || G.hasFocus()) && !!(a.type || a.href || ~a.tabIndex)
                    },
                    enabled: function(a) {
                        return a.disabled === !1
                    },
                    disabled: function(a) {
                        return a.disabled === !0
                    },
                    checked: function(a) {
                        var b = a.nodeName.toLowerCase();
                        return "input" === b && !!a.checked || "option" === b && !!a.selected
                    },
                    selected: function(a) {
                        return a.parentNode && a.parentNode.selectedIndex, a.selected === !0
                    },
                    empty: function(a) {
                        for (a = a.firstChild; a; a = a.nextSibling)
                            if (a.nodeType < 6) return !1;
                        return !0
                    },
                    parent: function(a) {
                        return !w.pseudos.empty(a)
                    },
                    header: function(a) {
                        return qa.test(a.nodeName)
                    },
                    input: function(a) {
                        return pa.test(a.nodeName)
                    },
                    button: function(a) {
                        var b = a.nodeName.toLowerCase();
                        return "input" === b && "button" === a.type || "button" === b
                    },
                    text: function(a) {
                        var b;
                        return "input" === a.nodeName.toLowerCase() && "text" === a.type && (null == (b = a.getAttribute("type")) || "text" === b.toLowerCase())
                    },
                    first: j(function() {
                        return [0]
                    }),
                    last: j(function(a, b) {
                        return [b - 1]
                    }),
                    eq: j(function(a, b, c) {
                        return [0 > c ? c + b : c]
                    }),
                    even: j(function(a, b) {
                        for (var c = 0; b > c; c += 2) a.push(c);
                        return a
                    }),
                    odd: j(function(a, b) {
                        for (var c = 1; b > c; c += 2) a.push(c);
                        return a
                    }),
                    lt: j(function(a, b, c) {
                        for (var d = 0 > c ? c + b : c; --d >= 0;) a.push(d);
                        return a
                    }),
                    gt: j(function(a, b, c) {
                        for (var d = 0 > c ? c + b : c; ++d < b;) a.push(d);
                        return a
                    })
                }
            }, w.pseudos.nth = w.pseudos.eq;
            for (u in {
                    radio: !0,
                    checkbox: !0,
                    file: !0,
                    password: !0,
                    image: !0
                }) w.pseudos[u] = h(u);
            for (u in {
                    submit: !0,
                    reset: !0
                }) w.pseudos[u] = i(u);
            return l.prototype = w.filters = w.pseudos, w.setFilters = new l, z = b.tokenize = function(a, c) {
                var d, e, f, g, h, i, j, k = S[a + " "];
                if (k) return c ? 0 : k.slice(0);
                for (h = a, i = [], j = w.preFilter; h;) {
                    (!d || (e = ja.exec(h))) && (e && (h = h.slice(e[0].length) || h), i.push(f = [])), d = !1, (e = ka.exec(h)) && (d = e.shift(), f.push({
                        value: d,
                        type: e[0].replace(ia, " ")
                    }), h = h.slice(d.length));
                    for (g in w.filter) !(e = oa[g].exec(h)) || j[g] && !(e = j[g](e)) || (d = e.shift(), f.push({
                        value: d,
                        type: g,
                        matches: e
                    }), h = h.slice(d.length));
                    if (!d) break
                }
                return c ? h.length : h ? b.error(a) : S(a, i).slice(0)
            }, A = b.compile = function(a, b) {
                var c, d = [],
                    e = [],
                    f = T[a + " "];
                if (!f) {
                    for (b || (b = z(a)), c = b.length; c--;) f = s(b[c]), f[N] ? d.push(f) : e.push(f);
                    f = T(a, t(e, d)), f.selector = a
                }
                return f
            }, B = b.select = function(a, b, c, d) {
                var e, f, g, h, i, j = "function" == typeof a && a,
                    l = !d && z(a = j.selector || a);
                if (c = c || [], 1 === l.length) {
                    if (f = l[0] = l[0].slice(0), f.length > 2 && "ID" === (g = f[0]).type && v.getById && 9 === b.nodeType && I && w.relative[f[1].type]) {
                        if (b = (w.find.ID(g.matches[0].replace(va, wa), b) || [])[0], !b) return c;
                        j && (b = b.parentNode), a = a.slice(f.shift().value.length)
                    }
                    for (e = oa.needsContext.test(a) ? 0 : f.length; e-- && (g = f[e], !w.relative[h = g.type]);)
                        if ((i = w.find[h]) && (d = i(g.matches[0].replace(va, wa), ta.test(f[0].type) && k(b.parentNode) || b))) {
                            if (f.splice(e, 1), a = d.length && m(f), !a) return $.apply(c, d), c;
                            break
                        }
                }
                return (j || A(a, l))(d, b, !I, c, ta.test(a) && k(b.parentNode) || b), c
            }, v.sortStable = N.split("").sort(U).join("") === N, v.detectDuplicates = !!E, F(), v.sortDetached = e(function(a) {
                return 1 & a.compareDocumentPosition(G.createElement("div"))
            }), e(function(a) {
                return a.innerHTML = "<a href='#'></a>", "#" === a.firstChild.getAttribute("href")
            }) || f("type|href|height|width", function(a, b, c) {
                return c ? void 0 : a.getAttribute(b, "type" === b.toLowerCase() ? 1 : 2)
            }), v.attributes && e(function(a) {
                return a.innerHTML = "<input/>", a.firstChild.setAttribute("value", ""), "" === a.firstChild.getAttribute("value")
            }) || f("value", function(a, b, c) {
                return c || "input" !== a.nodeName.toLowerCase() ? void 0 : a.defaultValue
            }), e(function(a) {
                return null == a.getAttribute("disabled")
            }) || f(ba, function(a, b, c) {
                var d;
                return c ? void 0 : a[b] === !0 ? b.toLowerCase() : (d = a.getAttributeNode(b)) && d.specified ? d.value : null
            }), b
        }(a);
        ea.find = ja, ea.expr = ja.selectors, ea.expr[":"] = ea.expr.pseudos, ea.unique = ja.uniqueSort, ea.text = ja.getText, ea.isXMLDoc = ja.isXML, ea.contains = ja.contains;
        var ka = ea.expr.match.needsContext,
            la = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
            ma = /^.[^:#\[\.,]*$/;
        ea.filter = function(a, b, c) {
            var d = b[0];
            return c && (a = ":not(" + a + ")"), 1 === b.length && 1 === d.nodeType ? ea.find.matchesSelector(d, a) ? [d] : [] : ea.find.matches(a, ea.grep(b, function(a) {
                return 1 === a.nodeType
            }))
        }, ea.fn.extend({
            find: function(a) {
                var b, c = [],
                    d = this,
                    e = d.length;
                if ("string" != typeof a) return this.pushStack(ea(a).filter(function() {
                    for (b = 0; e > b; b++)
                        if (ea.contains(d[b], this)) return !0
                }));
                for (b = 0; e > b; b++) ea.find(a, d[b], c);
                return c = this.pushStack(e > 1 ? ea.unique(c) : c), c.selector = this.selector ? this.selector + " " + a : a, c
            },
            filter: function(a) {
                return this.pushStack(d(this, a || [], !1))
            },
            not: function(a) {
                return this.pushStack(d(this, a || [], !0))
            },
            is: function(a) {
                return !!d(this, "string" == typeof a && ka.test(a) ? ea(a) : a || [], !1).length
            }
        });
        var na, oa = a.document,
            pa = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,
            qa = ea.fn.init = function(a, b) {
                var c, d;
                if (!a) return this;
                if ("string" == typeof a) {
                    if (c = "<" === a.charAt(0) && ">" === a.charAt(a.length - 1) && a.length >= 3 ? [null, a, null] : pa.exec(a), !c || !c[1] && b) return !b || b.jquery ? (b || na).find(a) : this.constructor(b).find(a);
                    if (c[1]) {
                        if (b = b instanceof ea ? b[0] : b, ea.merge(this, ea.parseHTML(c[1], b && b.nodeType ? b.ownerDocument || b : oa, !0)), la.test(c[1]) && ea.isPlainObject(b))
                            for (c in b) ea.isFunction(this[c]) ? this[c](b[c]) : this.attr(c, b[c]);
                        return this
                    }
                    if (d = oa.getElementById(c[2]), d && d.parentNode) {
                        if (d.id !== c[2]) return na.find(a);
                        this.length = 1, this[0] = d
                    }
                    return this.context = oa, this.selector = a, this
                }
                return a.nodeType ? (this.context = this[0] = a, this.length = 1, this) : ea.isFunction(a) ? "undefined" != typeof na.ready ? na.ready(a) : a(ea) : (void 0 !== a.selector && (this.selector = a.selector, this.context = a.context), ea.makeArray(a, this))
            };
        qa.prototype = ea.fn, na = ea(oa);
        var ra = /^(?:parents|prev(?:Until|All))/,
            sa = {
                children: !0,
                contents: !0,
                next: !0,
                prev: !0
            };
        ea.extend({
            dir: function(a, b, c) {
                for (var d = [], e = a[b]; e && 9 !== e.nodeType && (void 0 === c || 1 !== e.nodeType || !ea(e).is(c));) 1 === e.nodeType && d.push(e), e = e[b];
                return d
            },
            sibling: function(a, b) {
                for (var c = []; a; a = a.nextSibling) 1 === a.nodeType && a !== b && c.push(a);
                return c
            }
        }), ea.fn.extend({
            has: function(a) {
                var b, c = ea(a, this),
                    d = c.length;
                return this.filter(function() {
                    for (b = 0; d > b; b++)
                        if (ea.contains(this, c[b])) return !0
                })
            },
            closest: function(a, b) {
                for (var c, d = 0, e = this.length, f = [], g = ka.test(a) || "string" != typeof a ? ea(a, b || this.context) : 0; e > d; d++)
                    for (c = this[d]; c && c !== b; c = c.parentNode)
                        if (c.nodeType < 11 && (g ? g.index(c) > -1 : 1 === c.nodeType && ea.find.matchesSelector(c, a))) {
                            f.push(c);
                            break
                        }
                return this.pushStack(f.length > 1 ? ea.unique(f) : f)
            },
            index: function(a) {
                return a ? "string" == typeof a ? ea.inArray(this[0], ea(a)) : ea.inArray(a.jquery ? a[0] : a, this) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
            },
            add: function(a, b) {
                return this.pushStack(ea.unique(ea.merge(this.get(), ea(a, b))))
            },
            addBack: function(a) {
                return this.add(null == a ? this.prevObject : this.prevObject.filter(a))
            }
        }), ea.each({
            parent: function(a) {
                var b = a.parentNode;
                return b && 11 !== b.nodeType ? b : null
            },
            parents: function(a) {
                return ea.dir(a, "parentNode")
            },
            parentsUntil: function(a, b, c) {
                return ea.dir(a, "parentNode", c)
            },
            next: function(a) {
                return e(a, "nextSibling")
            },
            prev: function(a) {
                return e(a, "previousSibling")
            },
            nextAll: function(a) {
                return ea.dir(a, "nextSibling")
            },
            prevAll: function(a) {
                return ea.dir(a, "previousSibling")
            },
            nextUntil: function(a, b, c) {
                return ea.dir(a, "nextSibling", c)
            },
            prevUntil: function(a, b, c) {
                return ea.dir(a, "previousSibling", c)
            },
            siblings: function(a) {
                return ea.sibling((a.parentNode || {}).firstChild, a)
            },
            children: function(a) {
                return ea.sibling(a.firstChild)
            },
            contents: function(a) {
                return ea.nodeName(a, "iframe") ? a.contentDocument || a.contentWindow.document : ea.merge([], a.childNodes)
            }
        }, function(a, b) {
            ea.fn[a] = function(c, d) {
                var e = ea.map(this, b, c);
                return "Until" !== a.slice(-5) && (d = c), d && "string" == typeof d && (e = ea.filter(d, e)), this.length > 1 && (sa[a] || (e = ea.unique(e)), ra.test(a) && (e = e.reverse())), this.pushStack(e)
            }
        });
        var ta = /\S+/g,
            ua = {};
        ea.Callbacks = function(a) {
            a = "string" == typeof a ? ua[a] || f(a) : ea.extend({}, a);
            var b, c, d, e, g, h, i = [],
                j = !a.once && [],
                k = function(f) {
                    for (c = a.memory && f, d = !0, g = h || 0, h = 0, e = i.length, b = !0; i && e > g; g++)
                        if (i[g].apply(f[0], f[1]) === !1 && a.stopOnFalse) {
                            c = !1;
                            break
                        }
                    b = !1, i && (j ? j.length && k(j.shift()) : c ? i = [] : l.disable())
                },
                l = {
                    add: function() {
                        if (i) {
                            var d = i.length;
                            ! function f(b) {
                                ea.each(b, function(b, c) {
                                    var d = ea.type(c);
                                    "function" === d ? a.unique && l.has(c) || i.push(c) : c && c.length && "string" !== d && f(c)
                                })
                            }(arguments), b ? e = i.length : c && (h = d, k(c))
                        }
                        return this
                    },
                    remove: function() {
                        return i && ea.each(arguments, function(a, c) {
                            for (var d;
                                (d = ea.inArray(c, i, d)) > -1;) i.splice(d, 1), b && (e >= d && e--, g >= d && g--)
                        }), this
                    },
                    has: function(a) {
                        return a ? ea.inArray(a, i) > -1 : !(!i || !i.length)
                    },
                    empty: function() {
                        return i = [], e = 0, this
                    },
                    disable: function() {
                        return i = j = c = void 0, this
                    },
                    disabled: function() {
                        return !i
                    },
                    lock: function() {
                        return j = void 0, c || l.disable(), this
                    },
                    locked: function() {
                        return !j
                    },
                    fireWith: function(a, c) {
                        return !i || d && !j || (c = c || [], c = [a, c.slice ? c.slice() : c], b ? j.push(c) : k(c)), this
                    },
                    fire: function() {
                        return l.fireWith(this, arguments), this
                    },
                    fired: function() {
                        return !!d
                    }
                };
            return l
        }, ea.extend({
            Deferred: function(a) {
                var b = [
                        ["resolve", "done", ea.Callbacks("once memory"), "resolved"],
                        ["reject", "fail", ea.Callbacks("once memory"), "rejected"],
                        ["notify", "progress", ea.Callbacks("memory")]
                    ],
                    c = "pending",
                    d = {
                        state: function() {
                            return c
                        },
                        always: function() {
                            return e.done(arguments).fail(arguments), this
                        },
                        then: function() {
                            var a = arguments;
                            return ea.Deferred(function(c) {
                                ea.each(b, function(b, f) {
                                    var g = ea.isFunction(a[b]) && a[b];
                                    e[f[1]](function() {
                                        var a = g && g.apply(this, arguments);
                                        a && ea.isFunction(a.promise) ? a.promise().done(c.resolve).fail(c.reject).progress(c.notify) : c[f[0] + "With"](this === d ? c.promise() : this, g ? [a] : arguments)
                                    })
                                }), a = null
                            }).promise()
                        },
                        promise: function(a) {
                            return null != a ? ea.extend(a, d) : d
                        }
                    },
                    e = {};
                return d.pipe = d.then, ea.each(b, function(a, f) {
                    var g = f[2],
                        h = f[3];
                    d[f[1]] = g.add, h && g.add(function() {
                        c = h
                    }, b[1 ^ a][2].disable, b[2][2].lock), e[f[0]] = function() {
                        return e[f[0] + "With"](this === e ? d : this, arguments), this
                    }, e[f[0] + "With"] = g.fireWith
                }), d.promise(e), a && a.call(e, e), e
            },
            when: function(a) {
                var b, c, d, e = 0,
                    f = X.call(arguments),
                    g = f.length,
                    h = 1 !== g || a && ea.isFunction(a.promise) ? g : 0,
                    i = 1 === h ? a : ea.Deferred(),
                    j = function(a, c, d) {
                        return function(e) {
                            c[a] = this, d[a] = arguments.length > 1 ? X.call(arguments) : e, d === b ? i.notifyWith(c, d) : --h || i.resolveWith(c, d)
                        }
                    };
                if (g > 1)
                    for (b = new Array(g), c = new Array(g), d = new Array(g); g > e; e++) f[e] && ea.isFunction(f[e].promise) ? f[e].promise().done(j(e, d, f)).fail(i.reject).progress(j(e, c, b)) : --h;
                return h || i.resolveWith(d, f), i.promise()
            }
        });
        var va;
        ea.fn.ready = function(a) {
            return ea.ready.promise().done(a), this
        }, ea.extend({
            isReady: !1,
            readyWait: 1,
            holdReady: function(a) {
                a ? ea.readyWait++ : ea.ready(!0)
            },
            ready: function(a) {
                if (a === !0 ? !--ea.readyWait : !ea.isReady) {
                    if (!oa.body) return setTimeout(ea.ready);
                    ea.isReady = !0, a !== !0 && --ea.readyWait > 0 || (va.resolveWith(oa, [ea]), ea.fn.triggerHandler && (ea(oa).triggerHandler("ready"), ea(oa).off("ready")))
                }
            }
        }), ea.ready.promise = function(b) {
            if (!va)
                if (va = ea.Deferred(), "complete" === oa.readyState) setTimeout(ea.ready);
                else if (oa.addEventListener) oa.addEventListener("DOMContentLoaded", h, !1), a.addEventListener("load", h, !1);
            else {
                oa.attachEvent("onreadystatechange", h), a.attachEvent("onload", h);
                var c = !1;
                try {
                    c = null == a.frameElement && oa.documentElement
                } catch (d) {}
                c && c.doScroll && ! function e() {
                    if (!ea.isReady) {
                        try {
                            c.doScroll("left")
                        } catch (a) {
                            return setTimeout(e, 50)
                        }
                        g(), ea.ready()
                    }
                }()
            }
            return va.promise(b)
        };
        var wa, xa = "undefined";
        for (wa in ea(ca)) break;
        ca.ownLast = "0" !== wa, ca.inlineBlockNeedsLayout = !1, ea(function() {
                var a, b, c, d;
                c = oa.getElementsByTagName("body")[0], c && c.style && (b = oa.createElement("div"), d = oa.createElement("div"), d.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", c.appendChild(d).appendChild(b), typeof b.style.zoom !== xa && (b.style.cssText = "display:inline;margin:0;border:0;padding:1px;width:1px;zoom:1", ca.inlineBlockNeedsLayout = a = 3 === b.offsetWidth, a && (c.style.zoom = 1)), c.removeChild(d))
            }),
            function() {
                var a = oa.createElement("div");
                if (null == ca.deleteExpando) {
                    ca.deleteExpando = !0;
                    try {
                        delete a.test
                    } catch (b) {
                        ca.deleteExpando = !1
                    }
                }
                a = null
            }(), ea.acceptData = function(a) {
                var b = ea.noData[(a.nodeName + " ").toLowerCase()],
                    c = +a.nodeType || 1;
                return 1 !== c && 9 !== c ? !1 : !b || b !== !0 && a.getAttribute("classid") === b
            };
        var ya = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
            za = /([A-Z])/g;
        ea.extend({
            cache: {},
            noData: {
                "applet ": !0,
                "embed ": !0,
                "object ": "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
            },
            hasData: function(a) {
                return a = a.nodeType ? ea.cache[a[ea.expando]] : a[ea.expando], !!a && !j(a)
            },
            data: function(a, b, c) {
                return k(a, b, c)
            },
            removeData: function(a, b) {
                return l(a, b)
            },
            _data: function(a, b, c) {
                return k(a, b, c, !0)
            },
            _removeData: function(a, b) {
                return l(a, b, !0)
            }
        }), ea.fn.extend({
            data: function(a, b) {
                var c, d, e, f = this[0],
                    g = f && f.attributes;
                if (void 0 === a) {
                    if (this.length && (e = ea.data(f), 1 === f.nodeType && !ea._data(f, "parsedAttrs"))) {
                        for (c = g.length; c--;) g[c] && (d = g[c].name, 0 === d.indexOf("data-") && (d = ea.camelCase(d.slice(5)), i(f, d, e[d])));
                        ea._data(f, "parsedAttrs", !0)
                    }
                    return e
                }
                return "object" == typeof a ? this.each(function() {
                    ea.data(this, a)
                }) : arguments.length > 1 ? this.each(function() {
                    ea.data(this, a, b)
                }) : f ? i(f, a, ea.data(f, a)) : void 0
            },
            removeData: function(a) {
                return this.each(function() {
                    ea.removeData(this, a)
                })
            }
        }), ea.extend({
            queue: function(a, b, c) {
                var d;
                return a ? (b = (b || "fx") + "queue", d = ea._data(a, b), c && (!d || ea.isArray(c) ? d = ea._data(a, b, ea.makeArray(c)) : d.push(c)), d || []) : void 0
            },
            dequeue: function(a, b) {
                b = b || "fx";
                var c = ea.queue(a, b),
                    d = c.length,
                    e = c.shift(),
                    f = ea._queueHooks(a, b),
                    g = function() {
                        ea.dequeue(a, b)
                    };
                "inprogress" === e && (e = c.shift(), d--), e && ("fx" === b && c.unshift("inprogress"), delete f.stop, e.call(a, g, f)), !d && f && f.empty.fire()
            },
            _queueHooks: function(a, b) {
                var c = b + "queueHooks";
                return ea._data(a, c) || ea._data(a, c, {
                    empty: ea.Callbacks("once memory").add(function() {
                        ea._removeData(a, b + "queue"), ea._removeData(a, c)
                    })
                })
            }
        }), ea.fn.extend({
            queue: function(a, b) {
                var c = 2;
                return "string" != typeof a && (b = a, a = "fx", c--), arguments.length < c ? ea.queue(this[0], a) : void 0 === b ? this : this.each(function() {
                    var c = ea.queue(this, a, b);
                    ea._queueHooks(this, a), "fx" === a && "inprogress" !== c[0] && ea.dequeue(this, a)
                })
            },
            dequeue: function(a) {
                return this.each(function() {
                    ea.dequeue(this, a)
                })
            },
            clearQueue: function(a) {
                return this.queue(a || "fx", [])
            },
            promise: function(a, b) {
                var c, d = 1,
                    e = ea.Deferred(),
                    f = this,
                    g = this.length,
                    h = function() {
                        --d || e.resolveWith(f, [f])
                    };
                for ("string" != typeof a && (b = a, a = void 0), a = a || "fx"; g--;) c = ea._data(f[g], a + "queueHooks"), c && c.empty && (d++, c.empty.add(h));
                return h(), e.promise(b)
            }
        });
        var Aa = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
            Ba = ["Top", "Right", "Bottom", "Left"],
            Ca = function(a, b) {
                return a = b || a, "none" === ea.css(a, "display") || !ea.contains(a.ownerDocument, a)
            },
            Da = ea.access = function(a, b, c, d, e, f, g) {
                var h = 0,
                    i = a.length,
                    j = null == c;
                if ("object" === ea.type(c)) {
                    e = !0;
                    for (h in c) ea.access(a, b, h, c[h], !0, f, g)
                } else if (void 0 !== d && (e = !0, ea.isFunction(d) || (g = !0), j && (g ? (b.call(a, d), b = null) : (j = b, b = function(a, b, c) {
                        return j.call(ea(a), c)
                    })), b))
                    for (; i > h; h++) b(a[h], c, g ? d : d.call(a[h], h, b(a[h], c)));
                return e ? a : j ? b.call(a) : i ? b(a[0], c) : f
            },
            Ea = /^(?:checkbox|radio)$/i;
        ! function() {
            var a = oa.createElement("input"),
                b = oa.createElement("div"),
                c = oa.createDocumentFragment();
            if (b.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", ca.leadingWhitespace = 3 === b.firstChild.nodeType, ca.tbody = !b.getElementsByTagName("tbody").length, ca.htmlSerialize = !!b.getElementsByTagName("link").length, ca.html5Clone = "<:nav></:nav>" !== oa.createElement("nav").cloneNode(!0).outerHTML, a.type = "checkbox", a.checked = !0, c.appendChild(a), ca.appendChecked = a.checked, b.innerHTML = "<textarea>x</textarea>", ca.noCloneChecked = !!b.cloneNode(!0).lastChild.defaultValue, c.appendChild(b), b.innerHTML = "<input type='radio' checked='checked' name='t'/>", ca.checkClone = b.cloneNode(!0).cloneNode(!0).lastChild.checked, ca.noCloneEvent = !0, b.attachEvent && (b.attachEvent("onclick", function() {
                    ca.noCloneEvent = !1
                }), b.cloneNode(!0).click()), null == ca.deleteExpando) {
                ca.deleteExpando = !0;
                try {
                    delete b.test
                } catch (d) {
                    ca.deleteExpando = !1
                }
            }
        }(),
        function() {
            var b, c, d = oa.createElement("div");
            for (b in {
                    submit: !0,
                    change: !0,
                    focusin: !0
                }) c = "on" + b, (ca[b + "Bubbles"] = c in a) || (d.setAttribute(c, "t"), ca[b + "Bubbles"] = d.attributes[c].expando === !1);
            d = null
        }();
        var Fa = /^(?:input|select|textarea)$/i,
            Ga = /^key/,
            Ha = /^(?:mouse|pointer|contextmenu)|click/,
            Ia = /^(?:focusinfocus|focusoutblur)$/,
            Ja = /^([^.]*)(?:\.(.+)|)$/;
        ea.event = {
            global: {},
            add: function(a, b, c, d, e) {
                var f, g, h, i, j, k, l, m, n, o, p, q = ea._data(a);
                if (q) {
                    for (c.handler && (i = c, c = i.handler, e = i.selector), c.guid || (c.guid = ea.guid++), (g = q.events) || (g = q.events = {}), (k = q.handle) || (k = q.handle = function(a) {
                            return typeof ea === xa || a && ea.event.triggered === a.type ? void 0 : ea.event.dispatch.apply(k.elem, arguments)
                        }, k.elem = a), b = (b || "").match(ta) || [""], h = b.length; h--;) f = Ja.exec(b[h]) || [], n = p = f[1], o = (f[2] || "").split(".").sort(), n && (j = ea.event.special[n] || {}, n = (e ? j.delegateType : j.bindType) || n, j = ea.event.special[n] || {}, l = ea.extend({
                        type: n,
                        origType: p,
                        data: d,
                        handler: c,
                        guid: c.guid,
                        selector: e,
                        needsContext: e && ea.expr.match.needsContext.test(e),
                        namespace: o.join(".")
                    }, i), (m = g[n]) || (m = g[n] = [], m.delegateCount = 0, j.setup && j.setup.call(a, d, o, k) !== !1 || (a.addEventListener ? a.addEventListener(n, k, !1) : a.attachEvent && a.attachEvent("on" + n, k))), j.add && (j.add.call(a, l), l.handler.guid || (l.handler.guid = c.guid)), e ? m.splice(m.delegateCount++, 0, l) : m.push(l), ea.event.global[n] = !0);
                    a = null
                }
            },
            remove: function(a, b, c, d, e) {
                var f, g, h, i, j, k, l, m, n, o, p, q = ea.hasData(a) && ea._data(a);
                if (q && (k = q.events)) {
                    for (b = (b || "").match(ta) || [""], j = b.length; j--;)
                        if (h = Ja.exec(b[j]) || [], n = p = h[1], o = (h[2] || "").split(".").sort(), n) {
                            for (l = ea.event.special[n] || {}, n = (d ? l.delegateType : l.bindType) || n, m = k[n] || [], h = h[2] && new RegExp("(^|\\.)" + o.join("\\.(?:.*\\.|)") + "(\\.|$)"), i = f = m.length; f--;) g = m[f], !e && p !== g.origType || c && c.guid !== g.guid || h && !h.test(g.namespace) || d && d !== g.selector && ("**" !== d || !g.selector) || (m.splice(f, 1), g.selector && m.delegateCount--, l.remove && l.remove.call(a, g));
                            i && !m.length && (l.teardown && l.teardown.call(a, o, q.handle) !== !1 || ea.removeEvent(a, n, q.handle), delete k[n])
                        } else
                            for (n in k) ea.event.remove(a, n + b[j], c, d, !0);
                    ea.isEmptyObject(k) && (delete q.handle, ea._removeData(a, "events"))
                }
            },
            trigger: function(b, c, d, e) {
                var f, g, h, i, j, k, l, m = [d || oa],
                    n = ba.call(b, "type") ? b.type : b,
                    o = ba.call(b, "namespace") ? b.namespace.split(".") : [];
                if (h = k = d = d || oa, 3 !== d.nodeType && 8 !== d.nodeType && !Ia.test(n + ea.event.triggered) && (n.indexOf(".") >= 0 && (o = n.split("."), n = o.shift(), o.sort()), g = n.indexOf(":") < 0 && "on" + n, b = b[ea.expando] ? b : new ea.Event(n, "object" == typeof b && b), b.isTrigger = e ? 2 : 3, b.namespace = o.join("."), b.namespace_re = b.namespace ? new RegExp("(^|\\.)" + o.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, b.result = void 0, b.target || (b.target = d), c = null == c ? [b] : ea.makeArray(c, [b]), j = ea.event.special[n] || {}, e || !j.trigger || j.trigger.apply(d, c) !== !1)) {
                    if (!e && !j.noBubble && !ea.isWindow(d)) {
                        for (i = j.delegateType || n, Ia.test(i + n) || (h = h.parentNode); h; h = h.parentNode) m.push(h), k = h;
                        k === (d.ownerDocument || oa) && m.push(k.defaultView || k.parentWindow || a)
                    }
                    for (l = 0;
                        (h = m[l++]) && !b.isPropagationStopped();) b.type = l > 1 ? i : j.bindType || n, f = (ea._data(h, "events") || {})[b.type] && ea._data(h, "handle"), f && f.apply(h, c), f = g && h[g], f && f.apply && ea.acceptData(h) && (b.result = f.apply(h, c), b.result === !1 && b.preventDefault());
                    if (b.type = n, !e && !b.isDefaultPrevented() && (!j._default || j._default.apply(m.pop(), c) === !1) && ea.acceptData(d) && g && d[n] && !ea.isWindow(d)) {
                        k = d[g], k && (d[g] = null), ea.event.triggered = n;
                        try {
                            d[n]()
                        } catch (p) {}
                        ea.event.triggered = void 0, k && (d[g] = k)
                    }
                    return b.result
                }
            },
            dispatch: function(a) {
                a = ea.event.fix(a);
                var b, c, d, e, f, g = [],
                    h = X.call(arguments),
                    i = (ea._data(this, "events") || {})[a.type] || [],
                    j = ea.event.special[a.type] || {};
                if (h[0] = a, a.delegateTarget = this, !j.preDispatch || j.preDispatch.call(this, a) !== !1) {
                    for (g = ea.event.handlers.call(this, a, i), b = 0;
                        (e = g[b++]) && !a.isPropagationStopped();)
                        for (a.currentTarget = e.elem, f = 0;
                            (d = e.handlers[f++]) && !a.isImmediatePropagationStopped();)(!a.namespace_re || a.namespace_re.test(d.namespace)) && (a.handleObj = d, a.data = d.data, c = ((ea.event.special[d.origType] || {}).handle || d.handler).apply(e.elem, h), void 0 !== c && (a.result = c) === !1 && (a.preventDefault(), a.stopPropagation()));
                    return j.postDispatch && j.postDispatch.call(this, a), a.result
                }
            },
            handlers: function(a, b) {
                var c, d, e, f, g = [],
                    h = b.delegateCount,
                    i = a.target;
                if (h && i.nodeType && (!a.button || "click" !== a.type))
                    for (; i != this; i = i.parentNode || this)
                        if (1 === i.nodeType && (i.disabled !== !0 || "click" !== a.type)) {
                            for (e = [], f = 0; h > f; f++) d = b[f], c = d.selector + " ", void 0 === e[c] && (e[c] = d.needsContext ? ea(c, this).index(i) >= 0 : ea.find(c, this, null, [i]).length), e[c] && e.push(d);
                            e.length && g.push({
                                elem: i,
                                handlers: e
                            })
                        }
                return h < b.length && g.push({
                    elem: this,
                    handlers: b.slice(h)
                }), g
            },
            fix: function(a) {
                if (a[ea.expando]) return a;
                var b, c, d, e = a.type,
                    f = a,
                    g = this.fixHooks[e];
                for (g || (this.fixHooks[e] = g = Ha.test(e) ? this.mouseHooks : Ga.test(e) ? this.keyHooks : {}), d = g.props ? this.props.concat(g.props) : this.props, a = new ea.Event(f), b = d.length; b--;) c = d[b], a[c] = f[c];
                return a.target || (a.target = f.srcElement || oa), 3 === a.target.nodeType && (a.target = a.target.parentNode), a.metaKey = !!a.metaKey, g.filter ? g.filter(a, f) : a
            },
            props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
            fixHooks: {},
            keyHooks: {
                props: "char charCode key keyCode".split(" "),
                filter: function(a, b) {
                    return null == a.which && (a.which = null != b.charCode ? b.charCode : b.keyCode), a
                }
            },
            mouseHooks: {
                props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
                filter: function(a, b) {
                    var c, d, e, f = b.button,
                        g = b.fromElement;
                    return null == a.pageX && null != b.clientX && (d = a.target.ownerDocument || oa, e = d.documentElement, c = d.body, a.pageX = b.clientX + (e && e.scrollLeft || c && c.scrollLeft || 0) - (e && e.clientLeft || c && c.clientLeft || 0), a.pageY = b.clientY + (e && e.scrollTop || c && c.scrollTop || 0) - (e && e.clientTop || c && c.clientTop || 0)), !a.relatedTarget && g && (a.relatedTarget = g === a.target ? b.toElement : g), a.which || void 0 === f || (a.which = 1 & f ? 1 : 2 & f ? 3 : 4 & f ? 2 : 0), a
                }
            },
            special: {
                load: {
                    noBubble: !0
                },
                focus: {
                    trigger: function() {
                        if (this !== o() && this.focus) try {
                            return this.focus(), !1
                        } catch (a) {}
                    },
                    delegateType: "focusin"
                },
                blur: {
                    trigger: function() {
                        return this === o() && this.blur ? (this.blur(), !1) : void 0
                    },
                    delegateType: "focusout"
                },
                click: {
                    trigger: function() {
                        return ea.nodeName(this, "input") && "checkbox" === this.type && this.click ? (this.click(), !1) : void 0
                    },
                    _default: function(a) {
                        return ea.nodeName(a.target, "a")
                    }
                },
                beforeunload: {
                    postDispatch: function(a) {
                        void 0 !== a.result && a.originalEvent && (a.originalEvent.returnValue = a.result)
                    }
                }
            },
            simulate: function(a, b, c, d) {
                var e = ea.extend(new ea.Event, c, {
                    type: a,
                    isSimulated: !0,
                    originalEvent: {}
                });
                d ? ea.event.trigger(e, null, b) : ea.event.dispatch.call(b, e), e.isDefaultPrevented() && c.preventDefault()
            }
        }, ea.removeEvent = oa.removeEventListener ? function(a, b, c) {
            a.removeEventListener && a.removeEventListener(b, c, !1)
        } : function(a, b, c) {
            var d = "on" + b;
            a.detachEvent && (typeof a[d] === xa && (a[d] = null), a.detachEvent(d, c))
        }, ea.Event = function(a, b) {
            return this instanceof ea.Event ? (a && a.type ? (this.originalEvent = a, this.type = a.type, this.isDefaultPrevented = a.defaultPrevented || void 0 === a.defaultPrevented && a.returnValue === !1 ? m : n) : this.type = a, b && ea.extend(this, b), this.timeStamp = a && a.timeStamp || ea.now(), void(this[ea.expando] = !0)) : new ea.Event(a, b)
        }, ea.Event.prototype = {
            isDefaultPrevented: n,
            isPropagationStopped: n,
            isImmediatePropagationStopped: n,
            preventDefault: function() {
                var a = this.originalEvent;
                this.isDefaultPrevented = m, a && (a.preventDefault ? a.preventDefault() : a.returnValue = !1)
            },
            stopPropagation: function() {
                var a = this.originalEvent;
                this.isPropagationStopped = m, a && (a.stopPropagation && a.stopPropagation(), a.cancelBubble = !0)
            },
            stopImmediatePropagation: function() {
                var a = this.originalEvent;
                this.isImmediatePropagationStopped = m, a && a.stopImmediatePropagation && a.stopImmediatePropagation(), this.stopPropagation()
            }
        }, ea.each({
            mouseenter: "mouseover",
            mouseleave: "mouseout",
            pointerenter: "pointerover",
            pointerleave: "pointerout"
        }, function(a, b) {
            ea.event.special[a] = {
                delegateType: b,
                bindType: b,
                handle: function(a) {
                    var c, d = this,
                        e = a.relatedTarget,
                        f = a.handleObj;
                    return (!e || e !== d && !ea.contains(d, e)) && (a.type = f.origType, c = f.handler.apply(this, arguments), a.type = b), c
                }
            }
        }), ca.submitBubbles || (ea.event.special.submit = {
            setup: function() {
                return ea.nodeName(this, "form") ? !1 : void ea.event.add(this, "click._submit keypress._submit", function(a) {
                    var b = a.target,
                        c = ea.nodeName(b, "input") || ea.nodeName(b, "button") ? b.form : void 0;
                    c && !ea._data(c, "submitBubbles") && (ea.event.add(c, "submit._submit", function(a) {
                        a._submit_bubble = !0
                    }), ea._data(c, "submitBubbles", !0))
                })
            },
            postDispatch: function(a) {
                a._submit_bubble && (delete a._submit_bubble, this.parentNode && !a.isTrigger && ea.event.simulate("submit", this.parentNode, a, !0))
            },
            teardown: function() {
                return ea.nodeName(this, "form") ? !1 : void ea.event.remove(this, "._submit")
            }
        }), ca.changeBubbles || (ea.event.special.change = {
            setup: function() {
                return Fa.test(this.nodeName) ? (("checkbox" === this.type || "radio" === this.type) && (ea.event.add(this, "propertychange._change", function(a) {
                    "checked" === a.originalEvent.propertyName && (this._just_changed = !0)
                }), ea.event.add(this, "click._change", function(a) {
                    this._just_changed && !a.isTrigger && (this._just_changed = !1), ea.event.simulate("change", this, a, !0)
                })), !1) : void ea.event.add(this, "beforeactivate._change", function(a) {
                    var b = a.target;
                    Fa.test(b.nodeName) && !ea._data(b, "changeBubbles") && (ea.event.add(b, "change._change", function(a) {
                        !this.parentNode || a.isSimulated || a.isTrigger || ea.event.simulate("change", this.parentNode, a, !0)
                    }), ea._data(b, "changeBubbles", !0))
                })
            },
            handle: function(a) {
                var b = a.target;
                return this !== b || a.isSimulated || a.isTrigger || "radio" !== b.type && "checkbox" !== b.type ? a.handleObj.handler.apply(this, arguments) : void 0
            },
            teardown: function() {
                return ea.event.remove(this, "._change"), !Fa.test(this.nodeName)
            }
        }), ca.focusinBubbles || ea.each({
            focus: "focusin",
            blur: "focusout"
        }, function(a, b) {
            var c = function(a) {
                ea.event.simulate(b, a.target, ea.event.fix(a), !0)
            };
            ea.event.special[b] = {
                setup: function() {
                    var d = this.ownerDocument || this,
                        e = ea._data(d, b);
                    e || d.addEventListener(a, c, !0), ea._data(d, b, (e || 0) + 1)
                },
                teardown: function() {
                    var d = this.ownerDocument || this,
                        e = ea._data(d, b) - 1;
                    e ? ea._data(d, b, e) : (d.removeEventListener(a, c, !0), ea._removeData(d, b))
                }
            }
        }), ea.fn.extend({
            on: function(a, b, c, d, e) {
                var f, g;
                if ("object" == typeof a) {
                    "string" != typeof b && (c = c || b, b = void 0);
                    for (f in a) this.on(f, b, c, a[f], e);
                    return this
                }
                if (null == c && null == d ? (d = b, c = b = void 0) : null == d && ("string" == typeof b ? (d = c, c = void 0) : (d = c, c = b, b = void 0)), d === !1) d = n;
                else if (!d) return this;
                return 1 === e && (g = d, d = function(a) {
                    return ea().off(a), g.apply(this, arguments)
                }, d.guid = g.guid || (g.guid = ea.guid++)), this.each(function() {
                    ea.event.add(this, a, d, c, b)
                })
            },
            one: function(a, b, c, d) {
                return this.on(a, b, c, d, 1)
            },
            off: function(a, b, c) {
                var d, e;
                if (a && a.preventDefault && a.handleObj) return d = a.handleObj, ea(a.delegateTarget).off(d.namespace ? d.origType + "." + d.namespace : d.origType, d.selector, d.handler), this;
                if ("object" == typeof a) {
                    for (e in a) this.off(e, b, a[e]);
                    return this
                }
                return (b === !1 || "function" == typeof b) && (c = b, b = void 0), c === !1 && (c = n), this.each(function() {
                    ea.event.remove(this, a, c, b)
                })
            },
            trigger: function(a, b) {
                return this.each(function() {
                    ea.event.trigger(a, b, this)
                })
            },
            triggerHandler: function(a, b) {
                var c = this[0];
                return c ? ea.event.trigger(a, b, c, !0) : void 0
            }
        });
        var Ka = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",
            La = / jQuery\d+="(?:null|\d+)"/g,
            Ma = new RegExp("<(?:" + Ka + ")[\\s/>]", "i"),
            Na = /^\s+/,
            Oa = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
            Pa = /<([\w:]+)/,
            Qa = /<tbody/i,
            Ra = /<|&#?\w+;/,
            Sa = /<(?:script|style|link)/i,
            Ta = /checked\s*(?:[^=]|=\s*.checked.)/i,
            Ua = /^$|\/(?:java|ecma)script/i,
            Va = /^true\/(.*)/,
            Wa = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,
            Xa = {
                option: [1, "<select multiple='multiple'>", "</select>"],
                legend: [1, "<fieldset>", "</fieldset>"],
                area: [1, "<map>", "</map>"],
                param: [1, "<object>", "</object>"],
                thead: [1, "<table>", "</table>"],
                tr: [2, "<table><tbody>", "</tbody></table>"],
                col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
                td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
                _default: ca.htmlSerialize ? [0, "", ""] : [1, "X<div>", "</div>"]
            },
            Ya = p(oa),
            Za = Ya.appendChild(oa.createElement("div"));
        Xa.optgroup = Xa.option, Xa.tbody = Xa.tfoot = Xa.colgroup = Xa.caption = Xa.thead, Xa.th = Xa.td, ea.extend({
            clone: function(a, b, c) {
                var d, e, f, g, h, i = ea.contains(a.ownerDocument, a);
                if (ca.html5Clone || ea.isXMLDoc(a) || !Ma.test("<" + a.nodeName + ">") ? f = a.cloneNode(!0) : (Za.innerHTML = a.outerHTML, Za.removeChild(f = Za.firstChild)), !(ca.noCloneEvent && ca.noCloneChecked || 1 !== a.nodeType && 11 !== a.nodeType || ea.isXMLDoc(a)))
                    for (d = q(f), h = q(a), g = 0; null != (e = h[g]); ++g) d[g] && x(e, d[g]);
                if (b)
                    if (c)
                        for (h = h || q(a), d = d || q(f), g = 0; null != (e = h[g]); g++) w(e, d[g]);
                    else w(a, f);
                return d = q(f, "script"), d.length > 0 && v(d, !i && q(a, "script")), d = h = e = null, f
            },
            buildFragment: function(a, b, c, d) {
                for (var e, f, g, h, i, j, k, l = a.length, m = p(b), n = [], o = 0; l > o; o++)
                    if (f = a[o], f || 0 === f)
                        if ("object" === ea.type(f)) ea.merge(n, f.nodeType ? [f] : f);
                        else if (Ra.test(f)) {
                    for (h = h || m.appendChild(b.createElement("div")), i = (Pa.exec(f) || ["", ""])[1].toLowerCase(), k = Xa[i] || Xa._default, h.innerHTML = k[1] + f.replace(Oa, "<$1></$2>") + k[2], e = k[0]; e--;) h = h.lastChild;
                    if (!ca.leadingWhitespace && Na.test(f) && n.push(b.createTextNode(Na.exec(f)[0])), !ca.tbody)
                        for (f = "table" !== i || Qa.test(f) ? "<table>" !== k[1] || Qa.test(f) ? 0 : h : h.firstChild, e = f && f.childNodes.length; e--;) ea.nodeName(j = f.childNodes[e], "tbody") && !j.childNodes.length && f.removeChild(j);
                    for (ea.merge(n, h.childNodes), h.textContent = ""; h.firstChild;) h.removeChild(h.firstChild);
                    h = m.lastChild
                } else n.push(b.createTextNode(f));
                for (h && m.removeChild(h), ca.appendChecked || ea.grep(q(n, "input"), r), o = 0; f = n[o++];)
                    if ((!d || -1 === ea.inArray(f, d)) && (g = ea.contains(f.ownerDocument, f), h = q(m.appendChild(f), "script"), g && v(h), c))
                        for (e = 0; f = h[e++];) Ua.test(f.type || "") && c.push(f);
                return h = null, m
            },
            cleanData: function(a, b) {
                for (var c, d, e, f, g = 0, h = ea.expando, i = ea.cache, j = ca.deleteExpando, k = ea.event.special; null != (c = a[g]); g++)
                    if ((b || ea.acceptData(c)) && (e = c[h], f = e && i[e])) {
                        if (f.events)
                            for (d in f.events) k[d] ? ea.event.remove(c, d) : ea.removeEvent(c, d, f.handle);
                        i[e] && (delete i[e], j ? delete c[h] : typeof c.removeAttribute !== xa ? c.removeAttribute(h) : c[h] = null, W.push(e))
                    }
            }
        }), ea.fn.extend({
            text: function(a) {
                return Da(this, function(a) {
                    return void 0 === a ? ea.text(this) : this.empty().append((this[0] && this[0].ownerDocument || oa).createTextNode(a))
                }, null, a, arguments.length)
            },
            append: function() {
                return this.domManip(arguments, function(a) {
                    if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                        var b = s(this, a);
                        b.appendChild(a)
                    }
                })
            },
            prepend: function() {
                return this.domManip(arguments, function(a) {
                    if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                        var b = s(this, a);
                        b.insertBefore(a, b.firstChild)
                    }
                })
            },
            before: function() {
                return this.domManip(arguments, function(a) {
                    this.parentNode && this.parentNode.insertBefore(a, this)
                })
            },
            after: function() {
                return this.domManip(arguments, function(a) {
                    this.parentNode && this.parentNode.insertBefore(a, this.nextSibling)
                })
            },
            remove: function(a, b) {
                for (var c, d = a ? ea.filter(a, this) : this, e = 0; null != (c = d[e]); e++) b || 1 !== c.nodeType || ea.cleanData(q(c)), c.parentNode && (b && ea.contains(c.ownerDocument, c) && v(q(c, "script")), c.parentNode.removeChild(c));
                return this
            },
            empty: function() {
                for (var a, b = 0; null != (a = this[b]); b++) {
                    for (1 === a.nodeType && ea.cleanData(q(a, !1)); a.firstChild;) a.removeChild(a.firstChild);
                    a.options && ea.nodeName(a, "select") && (a.options.length = 0)
                }
                return this
            },
            clone: function(a, b) {
                return a = null == a ? !1 : a, b = null == b ? a : b, this.map(function() {
                    return ea.clone(this, a, b)
                })
            },
            html: function(a) {
                return Da(this, function(a) {
                    var b = this[0] || {},
                        c = 0,
                        d = this.length;
                    if (void 0 === a) return 1 === b.nodeType ? b.innerHTML.replace(La, "") : void 0;
                    if (!("string" != typeof a || Sa.test(a) || !ca.htmlSerialize && Ma.test(a) || !ca.leadingWhitespace && Na.test(a) || Xa[(Pa.exec(a) || ["", ""])[1].toLowerCase()])) {
                        a = a.replace(Oa, "<$1></$2>");
                        try {
                            for (; d > c; c++) b = this[c] || {}, 1 === b.nodeType && (ea.cleanData(q(b, !1)), b.innerHTML = a);
                            b = 0
                        } catch (e) {}
                    }
                    b && this.empty().append(a)
                }, null, a, arguments.length)
            },
            replaceWith: function() {
                var a = arguments[0];
                return this.domManip(arguments, function(b) {
                    a = this.parentNode, ea.cleanData(q(this)), a && a.replaceChild(b, this)
                }), a && (a.length || a.nodeType) ? this : this.remove()
            },
            detach: function(a) {
                return this.remove(a, !0)
            },
            domManip: function(a, b) {
                a = Y.apply([], a);
                var c, d, e, f, g, h, i = 0,
                    j = this.length,
                    k = this,
                    l = j - 1,
                    m = a[0],
                    n = ea.isFunction(m);
                if (n || j > 1 && "string" == typeof m && !ca.checkClone && Ta.test(m)) return this.each(function(c) {
                    var d = k.eq(c);
                    n && (a[0] = m.call(this, c, d.html())), d.domManip(a, b)
                });
                if (j && (h = ea.buildFragment(a, this[0].ownerDocument, !1, this), c = h.firstChild, 1 === h.childNodes.length && (h = c), c)) {
                    for (f = ea.map(q(h, "script"), t), e = f.length; j > i; i++) d = h, i !== l && (d = ea.clone(d, !0, !0), e && ea.merge(f, q(d, "script"))), b.call(this[i], d, i);
                    if (e)
                        for (g = f[f.length - 1].ownerDocument, ea.map(f, u), i = 0; e > i; i++) d = f[i], Ua.test(d.type || "") && !ea._data(d, "globalEval") && ea.contains(g, d) && (d.src ? ea._evalUrl && ea._evalUrl(d.src) : ea.globalEval((d.text || d.textContent || d.innerHTML || "").replace(Wa, "")));
                    h = c = null
                }
                return this
            }
        }), ea.each({
            appendTo: "append",
            prependTo: "prepend",
            insertBefore: "before",
            insertAfter: "after",
            replaceAll: "replaceWith"
        }, function(a, b) {
            ea.fn[a] = function(a) {
                for (var c, d = 0, e = [], f = ea(a), g = f.length - 1; g >= d; d++) c = d === g ? this : this.clone(!0), ea(f[d])[b](c), Z.apply(e, c.get());
                return this.pushStack(e)
            }
        });
        var $a, _a = {};
        ! function() {
            var a;
            ca.shrinkWrapBlocks = function() {
                if (null != a) return a;
                a = !1;
                var b, c, d;
                return c = oa.getElementsByTagName("body")[0], c && c.style ? (b = oa.createElement("div"), d = oa.createElement("div"), d.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", c.appendChild(d).appendChild(b),
                    typeof b.style.zoom !== xa && (b.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:1px;width:1px;zoom:1", b.appendChild(oa.createElement("div")).style.width = "5px", a = 3 !== b.offsetWidth), c.removeChild(d), a) : void 0
            }
        }();
        var ab, bb, cb = /^margin/,
            db = new RegExp("^(" + Aa + ")(?!px)[a-z%]+$", "i"),
            eb = /^(top|right|bottom|left)$/;
        a.getComputedStyle ? (ab = function(b) {
            return b.ownerDocument.defaultView.opener ? b.ownerDocument.defaultView.getComputedStyle(b, null) : a.getComputedStyle(b, null)
        }, bb = function(a, b, c) {
            var d, e, f, g, h = a.style;
            return c = c || ab(a), g = c ? c.getPropertyValue(b) || c[b] : void 0, c && ("" !== g || ea.contains(a.ownerDocument, a) || (g = ea.style(a, b)), db.test(g) && cb.test(b) && (d = h.width, e = h.minWidth, f = h.maxWidth, h.minWidth = h.maxWidth = h.width = g, g = c.width, h.width = d, h.minWidth = e, h.maxWidth = f)), void 0 === g ? g : g + ""
        }) : oa.documentElement.currentStyle && (ab = function(a) {
            return a.currentStyle
        }, bb = function(a, b, c) {
            var d, e, f, g, h = a.style;
            return c = c || ab(a), g = c ? c[b] : void 0, null == g && h && h[b] && (g = h[b]), db.test(g) && !eb.test(b) && (d = h.left, e = a.runtimeStyle, f = e && e.left, f && (e.left = a.currentStyle.left), h.left = "fontSize" === b ? "1em" : g, g = h.pixelLeft + "px", h.left = d, f && (e.left = f)), void 0 === g ? g : g + "" || "auto"
        }), ! function() {
            function b() {
                var b, c, d, e;
                c = oa.getElementsByTagName("body")[0], c && c.style && (b = oa.createElement("div"), d = oa.createElement("div"), d.style.cssText = "position:absolute;border:0;width:0;height:0;top:0;left:-9999px", c.appendChild(d).appendChild(b), b.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;display:block;margin-top:1%;top:1%;border:1px;padding:1px;width:4px;position:absolute", f = g = !1, i = !0, a.getComputedStyle && (f = "1%" !== (a.getComputedStyle(b, null) || {}).top, g = "4px" === (a.getComputedStyle(b, null) || {
                    width: "4px"
                }).width, e = b.appendChild(oa.createElement("div")), e.style.cssText = b.style.cssText = "-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", e.style.marginRight = e.style.width = "0", b.style.width = "1px", i = !parseFloat((a.getComputedStyle(e, null) || {}).marginRight), b.removeChild(e)), b.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", e = b.getElementsByTagName("td"), e[0].style.cssText = "margin:0;border:0;padding:0;display:none", h = 0 === e[0].offsetHeight, h && (e[0].style.display = "", e[1].style.display = "none", h = 0 === e[0].offsetHeight), c.removeChild(d))
            }
            var c, d, e, f, g, h, i;
            c = oa.createElement("div"), c.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", e = c.getElementsByTagName("a")[0], (d = e && e.style) && (d.cssText = "float:left;opacity:.5", ca.opacity = "0.5" === d.opacity, ca.cssFloat = !!d.cssFloat, c.style.backgroundClip = "content-box", c.cloneNode(!0).style.backgroundClip = "", ca.clearCloneStyle = "content-box" === c.style.backgroundClip, ca.boxSizing = "" === d.boxSizing || "" === d.MozBoxSizing || "" === d.WebkitBoxSizing, ea.extend(ca, {
                reliableHiddenOffsets: function() {
                    return null == h && b(), h
                },
                boxSizingReliable: function() {
                    return null == g && b(), g
                },
                pixelPosition: function() {
                    return null == f && b(), f
                },
                reliableMarginRight: function() {
                    return null == i && b(), i
                }
            }))
        }(), ea.swap = function(a, b, c, d) {
            var e, f, g = {};
            for (f in b) g[f] = a.style[f], a.style[f] = b[f];
            e = c.apply(a, d || []);
            for (f in b) a.style[f] = g[f];
            return e
        };
        var fb = /alpha\([^)]*\)/i,
            gb = /opacity\s*=\s*([^)]*)/,
            hb = /^(none|table(?!-c[ea]).+)/,
            ib = new RegExp("^(" + Aa + ")(.*)$", "i"),
            jb = new RegExp("^([+-])=(" + Aa + ")", "i"),
            kb = {
                position: "absolute",
                visibility: "hidden",
                display: "block"
            },
            lb = {
                letterSpacing: "0",
                fontWeight: "400"
            },
            mb = ["Webkit", "O", "Moz", "ms"];
        ea.extend({
            cssHooks: {
                opacity: {
                    get: function(a, b) {
                        if (b) {
                            var c = bb(a, "opacity");
                            return "" === c ? "1" : c
                        }
                    }
                }
            },
            cssNumber: {
                columnCount: !0,
                fillOpacity: !0,
                flexGrow: !0,
                flexShrink: !0,
                fontWeight: !0,
                lineHeight: !0,
                opacity: !0,
                order: !0,
                orphans: !0,
                widows: !0,
                zIndex: !0,
                zoom: !0
            },
            cssProps: {
                "float": ca.cssFloat ? "cssFloat" : "styleFloat"
            },
            style: function(a, b, c, d) {
                if (a && 3 !== a.nodeType && 8 !== a.nodeType && a.style) {
                    var e, f, g, h = ea.camelCase(b),
                        i = a.style;
                    if (b = ea.cssProps[h] || (ea.cssProps[h] = B(i, h)), g = ea.cssHooks[b] || ea.cssHooks[h], void 0 === c) return g && "get" in g && void 0 !== (e = g.get(a, !1, d)) ? e : i[b];
                    if (f = typeof c, "string" === f && (e = jb.exec(c)) && (c = (e[1] + 1) * e[2] + parseFloat(ea.css(a, b)), f = "number"), null != c && c === c && ("number" !== f || ea.cssNumber[h] || (c += "px"), ca.clearCloneStyle || "" !== c || 0 !== b.indexOf("background") || (i[b] = "inherit"), !(g && "set" in g && void 0 === (c = g.set(a, c, d))))) try {
                        i[b] = c
                    } catch (j) {}
                }
            },
            css: function(a, b, c, d) {
                var e, f, g, h = ea.camelCase(b);
                return b = ea.cssProps[h] || (ea.cssProps[h] = B(a.style, h)), g = ea.cssHooks[b] || ea.cssHooks[h], g && "get" in g && (f = g.get(a, !0, c)), void 0 === f && (f = bb(a, b, d)), "normal" === f && b in lb && (f = lb[b]), "" === c || c ? (e = parseFloat(f), c === !0 || ea.isNumeric(e) ? e || 0 : f) : f
            }
        }), ea.each(["height", "width"], function(a, b) {
            ea.cssHooks[b] = {
                get: function(a, c, d) {
                    return c ? hb.test(ea.css(a, "display")) && 0 === a.offsetWidth ? ea.swap(a, kb, function() {
                        return F(a, b, d)
                    }) : F(a, b, d) : void 0
                },
                set: function(a, c, d) {
                    var e = d && ab(a);
                    return D(a, c, d ? E(a, b, d, ca.boxSizing && "border-box" === ea.css(a, "boxSizing", !1, e), e) : 0)
                }
            }
        }), ca.opacity || (ea.cssHooks.opacity = {
            get: function(a, b) {
                return gb.test((b && a.currentStyle ? a.currentStyle.filter : a.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : b ? "1" : ""
            },
            set: function(a, b) {
                var c = a.style,
                    d = a.currentStyle,
                    e = ea.isNumeric(b) ? "alpha(opacity=" + 100 * b + ")" : "",
                    f = d && d.filter || c.filter || "";
                c.zoom = 1, (b >= 1 || "" === b) && "" === ea.trim(f.replace(fb, "")) && c.removeAttribute && (c.removeAttribute("filter"), "" === b || d && !d.filter) || (c.filter = fb.test(f) ? f.replace(fb, e) : f + " " + e)
            }
        }), ea.cssHooks.marginRight = A(ca.reliableMarginRight, function(a, b) {
            return b ? ea.swap(a, {
                display: "inline-block"
            }, bb, [a, "marginRight"]) : void 0
        }), ea.each({
            margin: "",
            padding: "",
            border: "Width"
        }, function(a, b) {
            ea.cssHooks[a + b] = {
                expand: function(c) {
                    for (var d = 0, e = {}, f = "string" == typeof c ? c.split(" ") : [c]; 4 > d; d++) e[a + Ba[d] + b] = f[d] || f[d - 2] || f[0];
                    return e
                }
            }, cb.test(a) || (ea.cssHooks[a + b].set = D)
        }), ea.fn.extend({
            css: function(a, b) {
                return Da(this, function(a, b, c) {
                    var d, e, f = {},
                        g = 0;
                    if (ea.isArray(b)) {
                        for (d = ab(a), e = b.length; e > g; g++) f[b[g]] = ea.css(a, b[g], !1, d);
                        return f
                    }
                    return void 0 !== c ? ea.style(a, b, c) : ea.css(a, b)
                }, a, b, arguments.length > 1)
            },
            show: function() {
                return C(this, !0)
            },
            hide: function() {
                return C(this)
            },
            toggle: function(a) {
                return "boolean" == typeof a ? a ? this.show() : this.hide() : this.each(function() {
                    Ca(this) ? ea(this).show() : ea(this).hide()
                })
            }
        }), ea.Tween = G, G.prototype = {
            constructor: G,
            init: function(a, b, c, d, e, f) {
                this.elem = a, this.prop = c, this.easing = e || "swing", this.options = b, this.start = this.now = this.cur(), this.end = d, this.unit = f || (ea.cssNumber[c] ? "" : "px")
            },
            cur: function() {
                var a = G.propHooks[this.prop];
                return a && a.get ? a.get(this) : G.propHooks._default.get(this)
            },
            run: function(a) {
                var b, c = G.propHooks[this.prop];
                return this.options.duration ? this.pos = b = ea.easing[this.easing](a, this.options.duration * a, 0, 1, this.options.duration) : this.pos = b = a, this.now = (this.end - this.start) * b + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), c && c.set ? c.set(this) : G.propHooks._default.set(this), this
            }
        }, G.prototype.init.prototype = G.prototype, G.propHooks = {
            _default: {
                get: function(a) {
                    var b;
                    return null == a.elem[a.prop] || a.elem.style && null != a.elem.style[a.prop] ? (b = ea.css(a.elem, a.prop, ""), b && "auto" !== b ? b : 0) : a.elem[a.prop]
                },
                set: function(a) {
                    ea.fx.step[a.prop] ? ea.fx.step[a.prop](a) : a.elem.style && (null != a.elem.style[ea.cssProps[a.prop]] || ea.cssHooks[a.prop]) ? ea.style(a.elem, a.prop, a.now + a.unit) : a.elem[a.prop] = a.now
                }
            }
        }, G.propHooks.scrollTop = G.propHooks.scrollLeft = {
            set: function(a) {
                a.elem.nodeType && a.elem.parentNode && (a.elem[a.prop] = a.now)
            }
        }, ea.easing = {
            linear: function(a) {
                return a
            },
            swing: function(a) {
                return .5 - Math.cos(a * Math.PI) / 2
            }
        }, ea.fx = G.prototype.init, ea.fx.step = {};
        var nb, ob, pb = /^(?:toggle|show|hide)$/,
            qb = new RegExp("^(?:([+-])=|)(" + Aa + ")([a-z%]*)$", "i"),
            rb = /queueHooks$/,
            sb = [K],
            tb = {
                "*": [function(a, b) {
                    var c = this.createTween(a, b),
                        d = c.cur(),
                        e = qb.exec(b),
                        f = e && e[3] || (ea.cssNumber[a] ? "" : "px"),
                        g = (ea.cssNumber[a] || "px" !== f && +d) && qb.exec(ea.css(c.elem, a)),
                        h = 1,
                        i = 20;
                    if (g && g[3] !== f) {
                        f = f || g[3], e = e || [], g = +d || 1;
                        do h = h || ".5", g /= h, ea.style(c.elem, a, g + f); while (h !== (h = c.cur() / d) && 1 !== h && --i)
                    }
                    return e && (g = c.start = +g || +d || 0, c.unit = f, c.end = e[1] ? g + (e[1] + 1) * e[2] : +e[2]), c
                }]
            };
        ea.Animation = ea.extend(M, {
                tweener: function(a, b) {
                    ea.isFunction(a) ? (b = a, a = ["*"]) : a = a.split(" ");
                    for (var c, d = 0, e = a.length; e > d; d++) c = a[d], tb[c] = tb[c] || [], tb[c].unshift(b)
                },
                prefilter: function(a, b) {
                    b ? sb.unshift(a) : sb.push(a)
                }
            }), ea.speed = function(a, b, c) {
                var d = a && "object" == typeof a ? ea.extend({}, a) : {
                    complete: c || !c && b || ea.isFunction(a) && a,
                    duration: a,
                    easing: c && b || b && !ea.isFunction(b) && b
                };
                return d.duration = ea.fx.off ? 0 : "number" == typeof d.duration ? d.duration : d.duration in ea.fx.speeds ? ea.fx.speeds[d.duration] : ea.fx.speeds._default, (null == d.queue || d.queue === !0) && (d.queue = "fx"), d.old = d.complete, d.complete = function() {
                    ea.isFunction(d.old) && d.old.call(this), d.queue && ea.dequeue(this, d.queue)
                }, d
            }, ea.fn.extend({
                fadeTo: function(a, b, c, d) {
                    return this.filter(Ca).css("opacity", 0).show().end().animate({
                        opacity: b
                    }, a, c, d)
                },
                animate: function(a, b, c, d) {
                    var e = ea.isEmptyObject(a),
                        f = ea.speed(b, c, d),
                        g = function() {
                            var b = M(this, ea.extend({}, a), f);
                            (e || ea._data(this, "finish")) && b.stop(!0)
                        };
                    return g.finish = g, e || f.queue === !1 ? this.each(g) : this.queue(f.queue, g)
                },
                stop: function(a, b, c) {
                    var d = function(a) {
                        var b = a.stop;
                        delete a.stop, b(c)
                    };
                    return "string" != typeof a && (c = b, b = a, a = void 0), b && a !== !1 && this.queue(a || "fx", []), this.each(function() {
                        var b = !0,
                            e = null != a && a + "queueHooks",
                            f = ea.timers,
                            g = ea._data(this);
                        if (e) g[e] && g[e].stop && d(g[e]);
                        else
                            for (e in g) g[e] && g[e].stop && rb.test(e) && d(g[e]);
                        for (e = f.length; e--;) f[e].elem !== this || null != a && f[e].queue !== a || (f[e].anim.stop(c), b = !1, f.splice(e, 1));
                        (b || !c) && ea.dequeue(this, a)
                    })
                },
                finish: function(a) {
                    return a !== !1 && (a = a || "fx"), this.each(function() {
                        var b, c = ea._data(this),
                            d = c[a + "queue"],
                            e = c[a + "queueHooks"],
                            f = ea.timers,
                            g = d ? d.length : 0;
                        for (c.finish = !0, ea.queue(this, a, []), e && e.stop && e.stop.call(this, !0), b = f.length; b--;) f[b].elem === this && f[b].queue === a && (f[b].anim.stop(!0), f.splice(b, 1));
                        for (b = 0; g > b; b++) d[b] && d[b].finish && d[b].finish.call(this);
                        delete c.finish
                    })
                }
            }), ea.each(["toggle", "show", "hide"], function(a, b) {
                var c = ea.fn[b];
                ea.fn[b] = function(a, d, e) {
                    return null == a || "boolean" == typeof a ? c.apply(this, arguments) : this.animate(I(b, !0), a, d, e)
                }
            }), ea.each({
                slideDown: I("show"),
                slideUp: I("hide"),
                slideToggle: I("toggle"),
                fadeIn: {
                    opacity: "show"
                },
                fadeOut: {
                    opacity: "hide"
                },
                fadeToggle: {
                    opacity: "toggle"
                }
            }, function(a, b) {
                ea.fn[a] = function(a, c, d) {
                    return this.animate(b, a, c, d)
                }
            }), ea.timers = [], ea.fx.tick = function() {
                var a, b = ea.timers,
                    c = 0;
                for (nb = ea.now(); c < b.length; c++) a = b[c], a() || b[c] !== a || b.splice(c--, 1);
                b.length || ea.fx.stop(), nb = void 0
            }, ea.fx.timer = function(a) {
                ea.timers.push(a), a() ? ea.fx.start() : ea.timers.pop()
            }, ea.fx.interval = 13, ea.fx.start = function() {
                ob || (ob = setInterval(ea.fx.tick, ea.fx.interval))
            }, ea.fx.stop = function() {
                clearInterval(ob), ob = null
            }, ea.fx.speeds = {
                slow: 600,
                fast: 200,
                _default: 400
            }, ea.fn.delay = function(a, b) {
                return a = ea.fx ? ea.fx.speeds[a] || a : a, b = b || "fx", this.queue(b, function(b, c) {
                    var d = setTimeout(b, a);
                    c.stop = function() {
                        clearTimeout(d)
                    }
                })
            },
            function() {
                var a, b, c, d, e;
                b = oa.createElement("div"), b.setAttribute("className", "t"), b.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", d = b.getElementsByTagName("a")[0], c = oa.createElement("select"), e = c.appendChild(oa.createElement("option")), a = b.getElementsByTagName("input")[0], d.style.cssText = "top:1px", ca.getSetAttribute = "t" !== b.className, ca.style = /top/.test(d.getAttribute("style")), ca.hrefNormalized = "/a" === d.getAttribute("href"), ca.checkOn = !!a.value, ca.optSelected = e.selected, ca.enctype = !!oa.createElement("form").enctype, c.disabled = !0, ca.optDisabled = !e.disabled, a = oa.createElement("input"), a.setAttribute("value", ""), ca.input = "" === a.getAttribute("value"), a.value = "t", a.setAttribute("type", "radio"), ca.radioValue = "t" === a.value
            }();
        var ub = /\r/g;
        ea.fn.extend({
            val: function(a) {
                var b, c, d, e = this[0];
                return arguments.length ? (d = ea.isFunction(a), this.each(function(c) {
                    var e;
                    1 === this.nodeType && (e = d ? a.call(this, c, ea(this).val()) : a, null == e ? e = "" : "number" == typeof e ? e += "" : ea.isArray(e) && (e = ea.map(e, function(a) {
                        return null == a ? "" : a + ""
                    })), b = ea.valHooks[this.type] || ea.valHooks[this.nodeName.toLowerCase()], b && "set" in b && void 0 !== b.set(this, e, "value") || (this.value = e))
                })) : e ? (b = ea.valHooks[e.type] || ea.valHooks[e.nodeName.toLowerCase()], b && "get" in b && void 0 !== (c = b.get(e, "value")) ? c : (c = e.value, "string" == typeof c ? c.replace(ub, "") : null == c ? "" : c)) : void 0
            }
        }), ea.extend({
            valHooks: {
                option: {
                    get: function(a) {
                        var b = ea.find.attr(a, "value");
                        return null != b ? b : ea.trim(ea.text(a))
                    }
                },
                select: {
                    get: function(a) {
                        for (var b, c, d = a.options, e = a.selectedIndex, f = "select-one" === a.type || 0 > e, g = f ? null : [], h = f ? e + 1 : d.length, i = 0 > e ? h : f ? e : 0; h > i; i++)
                            if (c = d[i], !(!c.selected && i !== e || (ca.optDisabled ? c.disabled : null !== c.getAttribute("disabled")) || c.parentNode.disabled && ea.nodeName(c.parentNode, "optgroup"))) {
                                if (b = ea(c).val(), f) return b;
                                g.push(b)
                            }
                        return g
                    },
                    set: function(a, b) {
                        for (var c, d, e = a.options, f = ea.makeArray(b), g = e.length; g--;)
                            if (d = e[g], ea.inArray(ea.valHooks.option.get(d), f) >= 0) try {
                                d.selected = c = !0
                            } catch (h) {
                                d.scrollHeight
                            } else d.selected = !1;
                        return c || (a.selectedIndex = -1), e
                    }
                }
            }
        }), ea.each(["radio", "checkbox"], function() {
            ea.valHooks[this] = {
                set: function(a, b) {
                    return ea.isArray(b) ? a.checked = ea.inArray(ea(a).val(), b) >= 0 : void 0
                }
            }, ca.checkOn || (ea.valHooks[this].get = function(a) {
                return null === a.getAttribute("value") ? "on" : a.value
            })
        });
        var vb, wb, xb = ea.expr.attrHandle,
            yb = /^(?:checked|selected)$/i,
            zb = ca.getSetAttribute,
            Ab = ca.input;
        ea.fn.extend({
            attr: function(a, b) {
                return Da(this, ea.attr, a, b, arguments.length > 1)
            },
            removeAttr: function(a) {
                return this.each(function() {
                    ea.removeAttr(this, a)
                })
            }
        }), ea.extend({
            attr: function(a, b, c) {
                var d, e, f = a.nodeType;
                return a && 3 !== f && 8 !== f && 2 !== f ? typeof a.getAttribute === xa ? ea.prop(a, b, c) : (1 === f && ea.isXMLDoc(a) || (b = b.toLowerCase(), d = ea.attrHooks[b] || (ea.expr.match.bool.test(b) ? wb : vb)), void 0 === c ? d && "get" in d && null !== (e = d.get(a, b)) ? e : (e = ea.find.attr(a, b), null == e ? void 0 : e) : null !== c ? d && "set" in d && void 0 !== (e = d.set(a, c, b)) ? e : (a.setAttribute(b, c + ""), c) : void ea.removeAttr(a, b)) : void 0
            },
            removeAttr: function(a, b) {
                var c, d, e = 0,
                    f = b && b.match(ta);
                if (f && 1 === a.nodeType)
                    for (; c = f[e++];) d = ea.propFix[c] || c, ea.expr.match.bool.test(c) ? Ab && zb || !yb.test(c) ? a[d] = !1 : a[ea.camelCase("default-" + c)] = a[d] = !1 : ea.attr(a, c, ""), a.removeAttribute(zb ? c : d)
            },
            attrHooks: {
                type: {
                    set: function(a, b) {
                        if (!ca.radioValue && "radio" === b && ea.nodeName(a, "input")) {
                            var c = a.value;
                            return a.setAttribute("type", b), c && (a.value = c), b
                        }
                    }
                }
            }
        }), wb = {
            set: function(a, b, c) {
                return b === !1 ? ea.removeAttr(a, c) : Ab && zb || !yb.test(c) ? a.setAttribute(!zb && ea.propFix[c] || c, c) : a[ea.camelCase("default-" + c)] = a[c] = !0, c
            }
        }, ea.each(ea.expr.match.bool.source.match(/\w+/g), function(a, b) {
            var c = xb[b] || ea.find.attr;
            xb[b] = Ab && zb || !yb.test(b) ? function(a, b, d) {
                var e, f;
                return d || (f = xb[b], xb[b] = e, e = null != c(a, b, d) ? b.toLowerCase() : null, xb[b] = f), e
            } : function(a, b, c) {
                return c ? void 0 : a[ea.camelCase("default-" + b)] ? b.toLowerCase() : null
            }
        }), Ab && zb || (ea.attrHooks.value = {
            set: function(a, b, c) {
                return ea.nodeName(a, "input") ? void(a.defaultValue = b) : vb && vb.set(a, b, c)
            }
        }), zb || (vb = {
            set: function(a, b, c) {
                var d = a.getAttributeNode(c);
                return d || a.setAttributeNode(d = a.ownerDocument.createAttribute(c)), d.value = b += "", "value" === c || b === a.getAttribute(c) ? b : void 0
            }
        }, xb.id = xb.name = xb.coords = function(a, b, c) {
            var d;
            return c ? void 0 : (d = a.getAttributeNode(b)) && "" !== d.value ? d.value : null
        }, ea.valHooks.button = {
            get: function(a, b) {
                var c = a.getAttributeNode(b);
                return c && c.specified ? c.value : void 0
            },
            set: vb.set
        }, ea.attrHooks.contenteditable = {
            set: function(a, b, c) {
                vb.set(a, "" === b ? !1 : b, c)
            }
        }, ea.each(["width", "height"], function(a, b) {
            ea.attrHooks[b] = {
                set: function(a, c) {
                    return "" === c ? (a.setAttribute(b, "auto"), c) : void 0
                }
            }
        })), ca.style || (ea.attrHooks.style = {
            get: function(a) {
                return a.style.cssText || void 0
            },
            set: function(a, b) {
                return a.style.cssText = b + ""
            }
        });
        var Bb = /^(?:input|select|textarea|button|object)$/i,
            Cb = /^(?:a|area)$/i;
        ea.fn.extend({
            prop: function(a, b) {
                return Da(this, ea.prop, a, b, arguments.length > 1)
            },
            removeProp: function(a) {
                return a = ea.propFix[a] || a, this.each(function() {
                    try {
                        this[a] = void 0, delete this[a]
                    } catch (b) {}
                })
            }
        }), ea.extend({
            propFix: {
                "for": "htmlFor",
                "class": "className"
            },
            prop: function(a, b, c) {
                var d, e, f, g = a.nodeType;
                return a && 3 !== g && 8 !== g && 2 !== g ? (f = 1 !== g || !ea.isXMLDoc(a), f && (b = ea.propFix[b] || b, e = ea.propHooks[b]), void 0 !== c ? e && "set" in e && void 0 !== (d = e.set(a, c, b)) ? d : a[b] = c : e && "get" in e && null !== (d = e.get(a, b)) ? d : a[b]) : void 0
            },
            propHooks: {
                tabIndex: {
                    get: function(a) {
                        var b = ea.find.attr(a, "tabindex");
                        return b ? parseInt(b, 10) : Bb.test(a.nodeName) || Cb.test(a.nodeName) && a.href ? 0 : -1
                    }
                }
            }
        }), ca.hrefNormalized || ea.each(["href", "src"], function(a, b) {
            ea.propHooks[b] = {
                get: function(a) {
                    return a.getAttribute(b, 4)
                }
            }
        }), ca.optSelected || (ea.propHooks.selected = {
            get: function(a) {
                var b = a.parentNode;
                return b && (b.selectedIndex, b.parentNode && b.parentNode.selectedIndex), null
            }
        }), ea.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
            ea.propFix[this.toLowerCase()] = this
        }), ca.enctype || (ea.propFix.enctype = "encoding");
        var Db = /[\t\r\n\f]/g;
        ea.fn.extend({
            addClass: function(a) {
                var b, c, d, e, f, g, h = 0,
                    i = this.length,
                    j = "string" == typeof a && a;
                if (ea.isFunction(a)) return this.each(function(b) {
                    ea(this).addClass(a.call(this, b, this.className))
                });
                if (j)
                    for (b = (a || "").match(ta) || []; i > h; h++)
                        if (c = this[h], d = 1 === c.nodeType && (c.className ? (" " + c.className + " ").replace(Db, " ") : " ")) {
                            for (f = 0; e = b[f++];) d.indexOf(" " + e + " ") < 0 && (d += e + " ");
                            g = ea.trim(d), c.className !== g && (c.className = g)
                        }
                return this
            },
            removeClass: function(a) {
                var b, c, d, e, f, g, h = 0,
                    i = this.length,
                    j = 0 === arguments.length || "string" == typeof a && a;
                if (ea.isFunction(a)) return this.each(function(b) {
                    ea(this).removeClass(a.call(this, b, this.className))
                });
                if (j)
                    for (b = (a || "").match(ta) || []; i > h; h++)
                        if (c = this[h], d = 1 === c.nodeType && (c.className ? (" " + c.className + " ").replace(Db, " ") : "")) {
                            for (f = 0; e = b[f++];)
                                for (; d.indexOf(" " + e + " ") >= 0;) d = d.replace(" " + e + " ", " ");
                            g = a ? ea.trim(d) : "", c.className !== g && (c.className = g)
                        }
                return this
            },
            toggleClass: function(a, b) {
                var c = typeof a;
                return "boolean" == typeof b && "string" === c ? b ? this.addClass(a) : this.removeClass(a) : this.each(ea.isFunction(a) ? function(c) {
                    ea(this).toggleClass(a.call(this, c, this.className, b), b)
                } : function() {
                    if ("string" === c)
                        for (var b, d = 0, e = ea(this), f = a.match(ta) || []; b = f[d++];) e.hasClass(b) ? e.removeClass(b) : e.addClass(b);
                    else(c === xa || "boolean" === c) && (this.className && ea._data(this, "__className__", this.className), this.className = this.className || a === !1 ? "" : ea._data(this, "__className__") || "")
                })
            },
            hasClass: function(a) {
                for (var b = " " + a + " ", c = 0, d = this.length; d > c; c++)
                    if (1 === this[c].nodeType && (" " + this[c].className + " ").replace(Db, " ").indexOf(b) >= 0) return !0;
                return !1
            }
        }), ea.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function(a, b) {
            ea.fn[b] = function(a, c) {
                return arguments.length > 0 ? this.on(b, null, a, c) : this.trigger(b)
            }
        }), ea.fn.extend({
            hover: function(a, b) {
                return this.mouseenter(a).mouseleave(b || a)
            },
            bind: function(a, b, c) {
                return this.on(a, null, b, c)
            },
            unbind: function(a, b) {
                return this.off(a, null, b)
            },
            delegate: function(a, b, c, d) {
                return this.on(b, a, c, d)
            },
            undelegate: function(a, b, c) {
                return 1 === arguments.length ? this.off(a, "**") : this.off(b, a || "**", c)
            }
        });
        var Eb = ea.now(),
            Fb = /\?/,
            Gb = /(,)|(\[|{)|(}|])|"(?:[^"\\\r\n]|\\["\\\/bfnrt]|\\u[\da-fA-F]{4})*"\s*:?|true|false|null|-?(?!0\d)\d+(?:\.\d+|)(?:[eE][+-]?\d+|)/g;
        ea.parseJSON = function(b) {
            if (a.JSON && a.JSON.parse) return a.JSON.parse(b + "");
            var c, d = null,
                e = ea.trim(b + "");
            return e && !ea.trim(e.replace(Gb, function(a, b, e, f) {
                return c && b && (d = 0), 0 === d ? a : (c = e || b, d += !f - !e, "")
            })) ? Function("return " + e)() : ea.error("Invalid JSON: " + b)
        }, ea.parseXML = function(b) {
            var c, d;
            if (!b || "string" != typeof b) return null;
            try {
                a.DOMParser ? (d = new DOMParser, c = d.parseFromString(b, "text/xml")) : (c = new ActiveXObject("Microsoft.XMLDOM"), c.async = "false", c.loadXML(b))
            } catch (e) {
                c = void 0
            }
            return c && c.documentElement && !c.getElementsByTagName("parsererror").length || ea.error("Invalid XML: " + b), c
        };
        var Hb, Ib, Jb = /#.*$/,
            Kb = /([?&])_=[^&]*/,
            Lb = /^(.*?):[ \t]*([^\r\n]*)\r?$/gm,
            Mb = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
            Nb = /^(?:GET|HEAD)$/,
            Ob = /^\/\//,
            Pb = /^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,
            Qb = {},
            Rb = {},
            Sb = "*/".concat("*");
        try {
            Ib = location.href
        } catch (Tb) {
            Ib = oa.createElement("a"), Ib.href = "", Ib = Ib.href
        }
        Hb = Pb.exec(Ib.toLowerCase()) || [], ea.extend({
            active: 0,
            lastModified: {},
            etag: {},
            ajaxSettings: {
                url: Ib,
                type: "GET",
                isLocal: Mb.test(Hb[1]),
                global: !0,
                processData: !0,
                async: !0,
                contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                accepts: {
                    "*": Sb,
                    text: "text/plain",
                    html: "text/html",
                    xml: "application/xml, text/xml",
                    json: "application/json, text/javascript"
                },
                contents: {
                    xml: /xml/,
                    html: /html/,
                    json: /json/
                },
                responseFields: {
                    xml: "responseXML",
                    text: "responseText",
                    json: "responseJSON"
                },
                converters: {
                    "* text": String,
                    "text html": !0,
                    "text json": ea.parseJSON,
                    "text xml": ea.parseXML
                },
                flatOptions: {
                    url: !0,
                    context: !0
                }
            },
            ajaxSetup: function(a, b) {
                return b ? P(P(a, ea.ajaxSettings), b) : P(ea.ajaxSettings, a)
            },
            ajaxPrefilter: N(Qb),
            ajaxTransport: N(Rb),
            ajax: function(a, b) {
                function c(a, b, c, d) {
                    var e, k, r, s, u, w = b;
                    2 !== t && (t = 2, h && clearTimeout(h), j = void 0, g = d || "", v.readyState = a > 0 ? 4 : 0, e = a >= 200 && 300 > a || 304 === a, c && (s = Q(l, v, c)), s = R(l, s, v, e), e ? (l.ifModified && (u = v.getResponseHeader("Last-Modified"), u && (ea.lastModified[f] = u), u = v.getResponseHeader("etag"), u && (ea.etag[f] = u)), 204 === a || "HEAD" === l.type ? w = "nocontent" : 304 === a ? w = "notmodified" : (w = s.state, k = s.data, r = s.error, e = !r)) : (r = w, (a || !w) && (w = "error", 0 > a && (a = 0))), v.status = a, v.statusText = (b || w) + "", e ? o.resolveWith(m, [k, w, v]) : o.rejectWith(m, [v, w, r]), v.statusCode(q), q = void 0, i && n.trigger(e ? "ajaxSuccess" : "ajaxError", [v, l, e ? k : r]), p.fireWith(m, [v, w]), i && (n.trigger("ajaxComplete", [v, l]), --ea.active || ea.event.trigger("ajaxStop")))
                }
                "object" == typeof a && (b = a, a = void 0), b = b || {};
                var d, e, f, g, h, i, j, k, l = ea.ajaxSetup({}, b),
                    m = l.context || l,
                    n = l.context && (m.nodeType || m.jquery) ? ea(m) : ea.event,
                    o = ea.Deferred(),
                    p = ea.Callbacks("once memory"),
                    q = l.statusCode || {},
                    r = {},
                    s = {},
                    t = 0,
                    u = "canceled",
                    v = {
                        readyState: 0,
                        getResponseHeader: function(a) {
                            var b;
                            if (2 === t) {
                                if (!k)
                                    for (k = {}; b = Lb.exec(g);) k[b[1].toLowerCase()] = b[2];
                                b = k[a.toLowerCase()]
                            }
                            return null == b ? null : b
                        },
                        getAllResponseHeaders: function() {
                            return 2 === t ? g : null
                        },
                        setRequestHeader: function(a, b) {
                            var c = a.toLowerCase();
                            return t || (a = s[c] = s[c] || a, r[a] = b), this
                        },
                        overrideMimeType: function(a) {
                            return t || (l.mimeType = a), this
                        },
                        statusCode: function(a) {
                            var b;
                            if (a)
                                if (2 > t)
                                    for (b in a) q[b] = [q[b], a[b]];
                                else v.always(a[v.status]);
                            return this
                        },
                        abort: function(a) {
                            var b = a || u;
                            return j && j.abort(b), c(0, b), this
                        }
                    };
                if (o.promise(v).complete = p.add, v.success = v.done, v.error = v.fail, l.url = ((a || l.url || Ib) + "").replace(Jb, "").replace(Ob, Hb[1] + "//"), l.type = b.method || b.type || l.method || l.type, l.dataTypes = ea.trim(l.dataType || "*").toLowerCase().match(ta) || [""], null == l.crossDomain && (d = Pb.exec(l.url.toLowerCase()), l.crossDomain = !(!d || d[1] === Hb[1] && d[2] === Hb[2] && (d[3] || ("http:" === d[1] ? "80" : "443")) === (Hb[3] || ("http:" === Hb[1] ? "80" : "443")))), l.data && l.processData && "string" != typeof l.data && (l.data = ea.param(l.data, l.traditional)), O(Qb, l, b, v), 2 === t) return v;
                i = ea.event && l.global, i && 0 === ea.active++ && ea.event.trigger("ajaxStart"), l.type = l.type.toUpperCase(), l.hasContent = !Nb.test(l.type), f = l.url, l.hasContent || (l.data && (f = l.url += (Fb.test(f) ? "&" : "?") + l.data, delete l.data), l.cache === !1 && (l.url = Kb.test(f) ? f.replace(Kb, "$1_=" + Eb++) : f + (Fb.test(f) ? "&" : "?") + "_=" + Eb++)), l.ifModified && (ea.lastModified[f] && v.setRequestHeader("If-Modified-Since", ea.lastModified[f]), ea.etag[f] && v.setRequestHeader("If-None-Match", ea.etag[f])), (l.data && l.hasContent && l.contentType !== !1 || b.contentType) && v.setRequestHeader("Content-Type", l.contentType), v.setRequestHeader("Accept", l.dataTypes[0] && l.accepts[l.dataTypes[0]] ? l.accepts[l.dataTypes[0]] + ("*" !== l.dataTypes[0] ? ", " + Sb + "; q=0.01" : "") : l.accepts["*"]);
                for (e in l.headers) v.setRequestHeader(e, l.headers[e]);
                if (l.beforeSend && (l.beforeSend.call(m, v, l) === !1 || 2 === t)) return v.abort();
                u = "abort";
                for (e in {
                        success: 1,
                        error: 1,
                        complete: 1
                    }) v[e](l[e]);
                if (j = O(Rb, l, b, v)) {
                    v.readyState = 1, i && n.trigger("ajaxSend", [v, l]), l.async && l.timeout > 0 && (h = setTimeout(function() {
                        v.abort("timeout")
                    }, l.timeout));
                    try {
                        t = 1, j.send(r, c)
                    } catch (w) {
                        if (!(2 > t)) throw w;
                        c(-1, w)
                    }
                } else c(-1, "No Transport");
                return v
            },
            getJSON: function(a, b, c) {
                return ea.get(a, b, c, "json")
            },
            getScript: function(a, b) {
                return ea.get(a, void 0, b, "script")
            }
        }), ea.each(["get", "post"], function(a, b) {
            ea[b] = function(a, c, d, e) {
                return ea.isFunction(c) && (e = e || d, d = c, c = void 0), ea.ajax({
                    url: a,
                    type: b,
                    dataType: e,
                    data: c,
                    success: d
                })
            }
        }), ea._evalUrl = function(a) {
            return ea.ajax({
                url: a,
                type: "GET",
                dataType: "script",
                async: !1,
                global: !1,
                "throws": !0
            })
        }, ea.fn.extend({
            wrapAll: function(a) {
                if (ea.isFunction(a)) return this.each(function(b) {
                    ea(this).wrapAll(a.call(this, b))
                });
                if (this[0]) {
                    var b = ea(a, this[0].ownerDocument).eq(0).clone(!0);
                    this[0].parentNode && b.insertBefore(this[0]), b.map(function() {
                        for (var a = this; a.firstChild && 1 === a.firstChild.nodeType;) a = a.firstChild;
                        return a
                    }).append(this)
                }
                return this
            },
            wrapInner: function(a) {
                return this.each(ea.isFunction(a) ? function(b) {
                    ea(this).wrapInner(a.call(this, b))
                } : function() {
                    var b = ea(this),
                        c = b.contents();
                    c.length ? c.wrapAll(a) : b.append(a)
                })
            },
            wrap: function(a) {
                var b = ea.isFunction(a);
                return this.each(function(c) {
                    ea(this).wrapAll(b ? a.call(this, c) : a)
                })
            },
            unwrap: function() {
                return this.parent().each(function() {
                    ea.nodeName(this, "body") || ea(this).replaceWith(this.childNodes)
                }).end()
            }
        }), ea.expr.filters.hidden = function(a) {
            return a.offsetWidth <= 0 && a.offsetHeight <= 0 || !ca.reliableHiddenOffsets() && "none" === (a.style && a.style.display || ea.css(a, "display"))
        }, ea.expr.filters.visible = function(a) {
            return !ea.expr.filters.hidden(a)
        };
        var Ub = /%20/g,
            Vb = /\[\]$/,
            Wb = /\r?\n/g,
            Xb = /^(?:submit|button|image|reset|file)$/i,
            Yb = /^(?:input|select|textarea|keygen)/i;
        ea.param = function(a, b) {
            var c, d = [],
                e = function(a, b) {
                    b = ea.isFunction(b) ? b() : null == b ? "" : b, d[d.length] = encodeURIComponent(a) + "=" + encodeURIComponent(b)
                };
            if (void 0 === b && (b = ea.ajaxSettings && ea.ajaxSettings.traditional), ea.isArray(a) || a.jquery && !ea.isPlainObject(a)) ea.each(a, function() {
                e(this.name, this.value)
            });
            else
                for (c in a) S(c, a[c], b, e);
            return d.join("&").replace(Ub, "+")
        }, ea.fn.extend({
            serialize: function() {
                return ea.param(this.serializeArray())
            },
            serializeArray: function() {
                return this.map(function() {
                    var a = ea.prop(this, "elements");
                    return a ? ea.makeArray(a) : this
                }).filter(function() {
                    var a = this.type;
                    return this.name && !ea(this).is(":disabled") && Yb.test(this.nodeName) && !Xb.test(a) && (this.checked || !Ea.test(a))
                }).map(function(a, b) {
                    var c = ea(this).val();
                    return null == c ? null : ea.isArray(c) ? ea.map(c, function(a) {
                        return {
                            name: b.name,
                            value: a.replace(Wb, "\r\n")
                        }
                    }) : {
                        name: b.name,
                        value: c.replace(Wb, "\r\n")
                    }
                }).get()
            }
        }), ea.ajaxSettings.xhr = void 0 !== a.ActiveXObject ? function() {
            return !this.isLocal && /^(get|post|head|put|delete|options)$/i.test(this.type) && T() || U()
        } : T;
        var Zb = 0,
            $b = {},
            _b = ea.ajaxSettings.xhr();
        a.attachEvent && a.attachEvent("onunload", function() {
            for (var a in $b) $b[a](void 0, !0)
        }), ca.cors = !!_b && "withCredentials" in _b, _b = ca.ajax = !!_b, _b && ea.ajaxTransport(function(a) {
            if (!a.crossDomain || ca.cors) {
                var b;
                return {
                    send: function(c, d) {
                        var e, f = a.xhr(),
                            g = ++Zb;
                        if (f.open(a.type, a.url, a.async, a.username, a.password), a.xhrFields)
                            for (e in a.xhrFields) f[e] = a.xhrFields[e];
                        a.mimeType && f.overrideMimeType && f.overrideMimeType(a.mimeType), a.crossDomain || c["X-Requested-With"] || (c["X-Requested-With"] = "XMLHttpRequest");
                        for (e in c) void 0 !== c[e] && f.setRequestHeader(e, c[e] + "");
                        f.send(a.hasContent && a.data || null), b = function(c, e) {
                            var h, i, j;
                            if (b && (e || 4 === f.readyState))
                                if (delete $b[g], b = void 0, f.onreadystatechange = ea.noop, e) 4 !== f.readyState && f.abort();
                                else {
                                    j = {}, h = f.status, "string" == typeof f.responseText && (j.text = f.responseText);
                                    try {
                                        i = f.statusText
                                    } catch (k) {
                                        i = ""
                                    }
                                    h || !a.isLocal || a.crossDomain ? 1223 === h && (h = 204) : h = j.text ? 200 : 404
                                }
                            j && d(h, i, j, f.getAllResponseHeaders())
                        }, a.async ? 4 === f.readyState ? setTimeout(b) : f.onreadystatechange = $b[g] = b : b()
                    },
                    abort: function() {
                        b && b(void 0, !0)
                    }
                }
            }
        }), ea.ajaxSetup({
            accepts: {
                script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
            },
            contents: {
                script: /(?:java|ecma)script/
            },
            converters: {
                "text script": function(a) {
                    return ea.globalEval(a), a
                }
            }
        }), ea.ajaxPrefilter("script", function(a) {
            void 0 === a.cache && (a.cache = !1), a.crossDomain && (a.type = "GET", a.global = !1)
        }), ea.ajaxTransport("script", function(a) {
            if (a.crossDomain) {
                var b, c = oa.head || ea("head")[0] || oa.documentElement;
                return {
                    send: function(d, e) {
                        b = oa.createElement("script"), b.async = !0, a.scriptCharset && (b.charset = a.scriptCharset), b.src = a.url, b.onload = b.onreadystatechange = function(a, c) {
                            (c || !b.readyState || /loaded|complete/.test(b.readyState)) && (b.onload = b.onreadystatechange = null, b.parentNode && b.parentNode.removeChild(b), b = null, c || e(200, "success"))
                        }, c.insertBefore(b, c.firstChild)
                    },
                    abort: function() {
                        b && b.onload(void 0, !0)
                    }
                }
            }
        });
        var ac = [],
            bc = /(=)\?(?=&|$)|\?\?/;
        ea.ajaxSetup({
            jsonp: "callback",
            jsonpCallback: function() {
                var a = ac.pop() || ea.expando + "_" + Eb++;
                return this[a] = !0, a
            }
        }), ea.ajaxPrefilter("json jsonp", function(b, c, d) {
            var e, f, g, h = b.jsonp !== !1 && (bc.test(b.url) ? "url" : "string" == typeof b.data && !(b.contentType || "").indexOf("application/x-www-form-urlencoded") && bc.test(b.data) && "data");
            return h || "jsonp" === b.dataTypes[0] ? (e = b.jsonpCallback = ea.isFunction(b.jsonpCallback) ? b.jsonpCallback() : b.jsonpCallback, h ? b[h] = b[h].replace(bc, "$1" + e) : b.jsonp !== !1 && (b.url += (Fb.test(b.url) ? "&" : "?") + b.jsonp + "=" + e), b.converters["script json"] = function() {
                return g || ea.error(e + " was not called"), g[0]
            }, b.dataTypes[0] = "json", f = a[e], a[e] = function() {
                g = arguments
            }, d.always(function() {
                a[e] = f, b[e] && (b.jsonpCallback = c.jsonpCallback, ac.push(e)), g && ea.isFunction(f) && f(g[0]), g = f = void 0
            }), "script") : void 0
        }), ea.parseHTML = function(a, b, c) {
            if (!a || "string" != typeof a) return null;
            "boolean" == typeof b && (c = b, b = !1), b = b || oa;
            var d = la.exec(a),
                e = !c && [];
            return d ? [b.createElement(d[1])] : (d = ea.buildFragment([a], b, e), e && e.length && ea(e).remove(), ea.merge([], d.childNodes))
        };
        var cc = ea.fn.load;
        ea.fn.load = function(a, b, c) {
            if ("string" != typeof a && cc) return cc.apply(this, arguments);
            var d, e, f, g = this,
                h = a.indexOf(" ");
            return h >= 0 && (d = ea.trim(a.slice(h, a.length)), a = a.slice(0, h)), ea.isFunction(b) ? (c = b, b = void 0) : b && "object" == typeof b && (f = "POST"), g.length > 0 && ea.ajax({
                url: a,
                type: f,
                dataType: "html",
                data: b
            }).done(function(a) {
                e = arguments, g.html(d ? ea("<div>").append(ea.parseHTML(a)).find(d) : a)
            }).complete(c && function(a, b) {
                g.each(c, e || [a.responseText, b, a])
            }), this
        }, ea.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(a, b) {
            ea.fn[b] = function(a) {
                return this.on(b, a)
            }
        }), ea.expr.filters.animated = function(a) {
            return ea.grep(ea.timers, function(b) {
                return a === b.elem
            }).length
        };
        var dc = a.document.documentElement;
        ea.offset = {
            setOffset: function(a, b, c) {
                var d, e, f, g, h, i, j, k = ea.css(a, "position"),
                    l = ea(a),
                    m = {};
                "static" === k && (a.style.position = "relative"), h = l.offset(), f = ea.css(a, "top"), i = ea.css(a, "left"), j = ("absolute" === k || "fixed" === k) && ea.inArray("auto", [f, i]) > -1, j ? (d = l.position(), g = d.top, e = d.left) : (g = parseFloat(f) || 0, e = parseFloat(i) || 0), ea.isFunction(b) && (b = b.call(a, c, h)), null != b.top && (m.top = b.top - h.top + g), null != b.left && (m.left = b.left - h.left + e), "using" in b ? b.using.call(a, m) : l.css(m)
            }
        }, ea.fn.extend({
            offset: function(a) {
                if (arguments.length) return void 0 === a ? this : this.each(function(b) {
                    ea.offset.setOffset(this, a, b)
                });
                var b, c, d = {
                        top: 0,
                        left: 0
                    },
                    e = this[0],
                    f = e && e.ownerDocument;
                return f ? (b = f.documentElement, ea.contains(b, e) ? (typeof e.getBoundingClientRect !== xa && (d = e.getBoundingClientRect()), c = V(f), {
                    top: d.top + (c.pageYOffset || b.scrollTop) - (b.clientTop || 0),
                    left: d.left + (c.pageXOffset || b.scrollLeft) - (b.clientLeft || 0)
                }) : d) : void 0
            },
            position: function() {
                if (this[0]) {
                    var a, b, c = {
                            top: 0,
                            left: 0
                        },
                        d = this[0];
                    return "fixed" === ea.css(d, "position") ? b = d.getBoundingClientRect() : (a = this.offsetParent(), b = this.offset(), ea.nodeName(a[0], "html") || (c = a.offset()), c.top += ea.css(a[0], "borderTopWidth", !0), c.left += ea.css(a[0], "borderLeftWidth", !0)), {
                        top: b.top - c.top - ea.css(d, "marginTop", !0),
                        left: b.left - c.left - ea.css(d, "marginLeft", !0)
                    }
                }
            },
            offsetParent: function() {
                return this.map(function() {
                    for (var a = this.offsetParent || dc; a && !ea.nodeName(a, "html") && "static" === ea.css(a, "position");) a = a.offsetParent;
                    return a || dc
                })
            }
        }), ea.each({
            scrollLeft: "pageXOffset",
            scrollTop: "pageYOffset"
        }, function(a, b) {
            var c = /Y/.test(b);
            ea.fn[a] = function(d) {
                return Da(this, function(a, d, e) {
                    var f = V(a);
                    return void 0 === e ? f ? b in f ? f[b] : f.document.documentElement[d] : a[d] : void(f ? f.scrollTo(c ? ea(f).scrollLeft() : e, c ? e : ea(f).scrollTop()) : a[d] = e)
                }, a, d, arguments.length, null)
            }
        }), ea.each(["top", "left"], function(a, b) {
            ea.cssHooks[b] = A(ca.pixelPosition, function(a, c) {
                return c ? (c = bb(a, b), db.test(c) ? ea(a).position()[b] + "px" : c) : void 0
            })
        }), ea.each({
            Height: "height",
            Width: "width"
        }, function(a, b) {
            ea.each({
                padding: "inner" + a,
                content: b,
                "": "outer" + a
            }, function(c, d) {
                ea.fn[d] = function(d, e) {
                    var f = arguments.length && (c || "boolean" != typeof d),
                        g = c || (d === !0 || e === !0 ? "margin" : "border");
                    return Da(this, function(b, c, d) {
                        var e;
                        return ea.isWindow(b) ? b.document.documentElement["client" + a] : 9 === b.nodeType ? (e = b.documentElement, Math.max(b.body["scroll" + a], e["scroll" + a], b.body["offset" + a], e["offset" + a], e["client" + a])) : void 0 === d ? ea.css(b, c, g) : ea.style(b, c, d, g)
                    }, b, f ? d : void 0, f, null)
                }
            })
        }), ea.fn.size = function() {
            return this.length
        }, ea.fn.andSelf = ea.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function() {
            return ea
        });
        var ec = a.jQuery,
            fc = a.$;
        return ea.noConflict = function(b) {
            return a.$ === ea && (a.$ = fc), b && a.jQuery === ea && (a.jQuery = ec), ea
        }, typeof b === xa && (a.jQuery = a.$ = ea), ea
    }), ! function(a) {
        var b = navigator.userAgent;
        a.HTMLPictureElement && /ecko/.test(b) && b.match(/rv\:(\d+)/) && RegExp.$1 < 41 && addEventListener("resize", function() {
            var b, c = document.createElement("source"),
                d = function(a) {
                    var b, d, e = a.parentNode;
                    "PICTURE" === e.nodeName.toUpperCase() ? (b = c.cloneNode(), e.insertBefore(b, e.firstElementChild), setTimeout(function() {
                        e.removeChild(b)
                    })) : (!a._pfLastSize || a.offsetWidth > a._pfLastSize) && (a._pfLastSize = a.offsetWidth, d = a.sizes, a.sizes += ",100vw", setTimeout(function() {
                        a.sizes = d
                    }))
                },
                e = function() {
                    var a, b = document.querySelectorAll("picture > img, img[srcset][sizes]");
                    for (a = 0; a < b.length; a++) d(b[a])
                },
                f = function() {
                    clearTimeout(b), b = setTimeout(e, 99)
                },
                g = a.matchMedia && matchMedia("(orientation: landscape)"),
                h = function() {
                    f(), g && g.addListener && g.addListener(f)
                };
            return c.srcset = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==", /^[c|i]|d$/.test(document.readyState || "") ? h() : document.addEventListener("DOMContentLoaded", h), f
        }())
    }(window),
    function(a, b, c) {
        "use strict";

        function d(a) {
            return " " === a || "	" === a || "\n" === a || "\f" === a || "\r" === a
        }

        function e(b, c) {
            var d = new a.Image;
            return d.onerror = function() {
                z[b] = !1, aa()
            }, d.onload = function() {
                z[b] = 1 === d.width, aa()
            }, d.src = c, "pending"
        }

        function f() {
            L = !1, O = a.devicePixelRatio, M = {}, N = {}, s.DPR = O || 1, P.width = Math.max(a.innerWidth || 0, y.clientWidth), P.height = Math.max(a.innerHeight || 0, y.clientHeight), P.vw = P.width / 100, P.vh = P.height / 100, r = [P.height, P.width, O].join("-"), P.em = s.getEmValue(), P.rem = P.em
        }

        function g(a, b, c, d) {
            var e, f, g, h;
            return "saveData" === A.algorithm ? a > 2.7 ? h = c + 1 : (f = b - c, e = Math.pow(a - .6, 1.5), g = f * e, d && (g += .1 * e), h = a + g) : h = c > 1 ? Math.sqrt(a * b) : a, h > c
        }

        function h(a) {
            var b, c = s.getSet(a),
                d = !1;
            "pending" !== c && (d = r, c && (b = s.setRes(c), s.applySetCandidate(b, a))), a[s.ns].evaled = d
        }

        function i(a, b) {
            return a.res - b.res
        }

        function j(a, b, c) {
            var d;
            return !c && b && (c = a[s.ns].sets, c = c && c[c.length - 1]), d = k(b, c), d && (b = s.makeUrl(b), a[s.ns].curSrc = b, a[s.ns].curCan = d, d.res || _(d, d.set.sizes)), d
        }

        function k(a, b) {
            var c, d, e;
            if (a && b)
                for (e = s.parseSet(b), a = s.makeUrl(a), c = 0; c < e.length; c++)
                    if (a === s.makeUrl(e[c].url)) {
                        d = e[c];
                        break
                    }
            return d
        }

        function l(a, b) {
            var c, d, e, f, g = a.getElementsByTagName("source");
            for (c = 0, d = g.length; d > c; c++) e = g[c], e[s.ns] = !0, f = e.getAttribute("srcset"), f && b.push({
                srcset: f,
                media: e.getAttribute("media"),
                type: e.getAttribute("type"),
                sizes: e.getAttribute("sizes")
            })
        }

        function m(a, b) {
            function c(b) {
                var c, d = b.exec(a.substring(m));
                return d ? (c = d[0], m += c.length, c) : void 0
            }

            function e() {
                var a, c, d, e, f, i, j, k, l, m = !1,
                    o = {};
                for (e = 0; e < h.length; e++) f = h[e], i = f[f.length - 1], j = f.substring(0, f.length - 1), k = parseInt(j, 10), l = parseFloat(j), W.test(j) && "w" === i ? ((a || c) && (m = !0), 0 === k ? m = !0 : a = k) : X.test(j) && "x" === i ? ((a || c || d) && (m = !0), 0 > l ? m = !0 : c = l) : W.test(j) && "h" === i ? ((d || c) && (m = !0), 0 === k ? m = !0 : d = k) : m = !0;
                m || (o.url = g, a && (o.w = a), c && (o.d = c), d && (o.h = d), d || c || a || (o.d = 1), 1 === o.d && (b.has1x = !0), o.set = b, n.push(o))
            }

            function f() {
                for (c(S), i = "", j = "in descriptor";;) {
                    if (k = a.charAt(m), "in descriptor" === j)
                        if (d(k)) i && (h.push(i), i = "", j = "after descriptor");
                        else {
                            if ("," === k) return m += 1, i && h.push(i), void e();
                            if ("(" === k) i += k, j = "in parens";
                            else {
                                if ("" === k) return i && h.push(i), void e();
                                i += k
                            }
                        }
                    else if ("in parens" === j)
                        if (")" === k) i += k, j = "in descriptor";
                        else {
                            if ("" === k) return h.push(i), void e();
                            i += k
                        }
                    else if ("after descriptor" === j)
                        if (d(k));
                        else {
                            if ("" === k) return void e();
                            j = "in descriptor", m -= 1
                        }
                    m += 1
                }
            }
            for (var g, h, i, j, k, l = a.length, m = 0, n = [];;) {
                if (c(T), m >= l) return n;
                g = c(U), h = [], "," === g.slice(-1) ? (g = g.replace(V, ""), e()) : f()
            }
        }

        function n(a) {
            function b(a) {
                function b() {
                    f && (g.push(f), f = "")
                }

                function c() {
                    g[0] && (h.push(g), g = [])
                }
                for (var e, f = "", g = [], h = [], i = 0, j = 0, k = !1;;) {
                    if (e = a.charAt(j), "" === e) return b(), c(), h;
                    if (k) {
                        if ("*" === e && "/" === a[j + 1]) {
                            k = !1, j += 2, b();
                            continue
                        }
                        j += 1
                    } else {
                        if (d(e)) {
                            if (a.charAt(j - 1) && d(a.charAt(j - 1)) || !f) {
                                j += 1;
                                continue
                            }
                            if (0 === i) {
                                b(), j += 1;
                                continue
                            }
                            e = " "
                        } else if ("(" === e) i += 1;
                        else if (")" === e) i -= 1;
                        else {
                            if ("," === e) {
                                b(), c(), j += 1;
                                continue
                            }
                            if ("/" === e && "*" === a.charAt(j + 1)) {
                                k = !0, j += 2;
                                continue
                            }
                        }
                        f += e, j += 1
                    }
                }
            }

            function c(a) {
                return k.test(a) && parseFloat(a) >= 0 ? !0 : l.test(a) ? !0 : "0" === a || "-0" === a || "+0" === a ? !0 : !1
            }
            var e, f, g, h, i, j, k = /^(?:[+-]?[0-9]+|[0-9]*\.[0-9]+)(?:[eE][+-]?[0-9]+)?(?:ch|cm|em|ex|in|mm|pc|pt|px|rem|vh|vmin|vmax|vw)$/i,
                l = /^calc\((?:[0-9a-z \.\+\-\*\/\(\)]+)\)$/i;
            for (f = b(a), g = f.length, e = 0; g > e; e++)
                if (h = f[e], i = h[h.length - 1], c(i)) {
                    if (j = i, h.pop(), 0 === h.length) return j;
                    if (h = h.join(" "), s.matchesMedia(h)) return j
                }
            return "100vw"
        }
        b.createElement("picture");
        var o, p, q, r, s = {},
            t = function() {},
            u = b.createElement("img"),
            v = u.getAttribute,
            w = u.setAttribute,
            x = u.removeAttribute,
            y = b.documentElement,
            z = {},
            A = {
                algorithm: ""
            },
            B = "data-pfsrc",
            C = B + "set",
            D = navigator.userAgent,
            E = /rident/.test(D) || /ecko/.test(D) && D.match(/rv\:(\d+)/) && RegExp.$1 > 35,
            F = "currentSrc",
            G = /\s+\+?\d+(e\d+)?w/,
            H = /(\([^)]+\))?\s*(.+)/,
            I = a.picturefillCFG,
            J = "position:absolute;left:0;visibility:hidden;display:block;padding:0;border:none;font-size:1em;width:1em;overflow:hidden;clip:rect(0px, 0px, 0px, 0px)",
            K = "font-size:100%!important;",
            L = !0,
            M = {},
            N = {},
            O = a.devicePixelRatio,
            P = {
                px: 1,
                "in": 96
            },
            Q = b.createElement("a"),
            R = !1,
            S = /^[ \t\n\r\u000c]+/,
            T = /^[, \t\n\r\u000c]+/,
            U = /^[^ \t\n\r\u000c]+/,
            V = /[,]+$/,
            W = /^\d+$/,
            X = /^-?(?:[0-9]+|[0-9]*\.[0-9]+)(?:[eE][+-]?[0-9]+)?$/,
            Y = function(a, b, c, d) {
                a.addEventListener ? a.addEventListener(b, c, d || !1) : a.attachEvent && a.attachEvent("on" + b, c)
            },
            Z = function(a) {
                var b = {};
                return function(c) {
                    return c in b || (b[c] = a(c)), b[c]
                }
            },
            $ = function() {
                var a = /^([\d\.]+)(em|vw|px)$/,
                    b = function() {
                        for (var a = arguments, b = 0, c = a[0]; ++b in a;) c = c.replace(a[b], a[++b]);
                        return c
                    },
                    c = Z(function(a) {
                        return "return " + b((a || "").toLowerCase(), /\band\b/g, "&&", /,/g, "||", /min-([a-z-\s]+):/g, "e.$1>=", /max-([a-z-\s]+):/g, "e.$1<=", /calc([^)]+)/g, "($1)", /(\d+[\.]*[\d]*)([a-z]+)/g, "($1 * e.$2)", /^(?!(e.[a-z]|[0-9\.&=|><\+\-\*\(\)\/])).*/gi, "") + ";"
                    });
                return function(b, d) {
                    var e;
                    if (!(b in M))
                        if (M[b] = !1, d && (e = b.match(a))) M[b] = e[1] * P[e[2]];
                        else try {
                            M[b] = new Function("e", c(b))(P)
                        } catch (f) {}
                        return M[b]
                }
            }(),
            _ = function(a, b) {
                return a.w ? (a.cWidth = s.calcListLength(b || "100vw"), a.res = a.w / a.cWidth) : a.res = a.d, a
            },
            aa = function(a) {
                var c, d, e, f = a || {};
                if (f.elements && 1 === f.elements.nodeType && ("IMG" === f.elements.nodeName.toUpperCase() ? f.elements = [f.elements] : (f.context = f.elements, f.elements = null)), c = f.elements || s.qsa(f.context || b, f.reevaluate || f.reselect ? s.sel : s.selShort), e = c.length) {
                    for (s.setupRun(f), R = !0, d = 0; e > d; d++) s.fillImg(c[d], f);
                    s.teardownRun(f)
                }
            };
        o = a.console && console.warn ? function(a) {
            console.warn(a)
        } : t, F in u || (F = "src"), z["image/jpeg"] = !0, z["image/gif"] = !0, z["image/png"] = !0, z["image/svg+xml"] = b.implementation.hasFeature("http://wwwindow.w3.org/TR/SVG11/feature#Image", "1.1"), s.ns = ("pf" + (new Date).getTime()).substr(0, 9), s.supSrcset = "srcset" in u, s.supSizes = "sizes" in u, s.supPicture = !!a.HTMLPictureElement, s.supSrcset && s.supPicture && !s.supSizes && ! function(a) {
            u.srcset = "data:,a", a.src = "data:,a", s.supSrcset = u.complete === a.complete, s.supPicture = s.supSrcset && s.supPicture
        }(b.createElement("img")), s.selShort = "picture>img,img[srcset]", s.sel = s.selShort, s.cfg = A, s.supSrcset && (s.sel += ",img[" + C + "]"), s.DPR = O || 1, s.u = P, s.types = z, q = s.supSrcset && !s.supSizes, s.setSize = t, s.makeUrl = Z(function(a) {
            return Q.href = a, Q.href
        }), s.qsa = function(a, b) {
            return a.querySelectorAll(b)
        }, s.matchesMedia = function() {
            return a.matchMedia && (matchMedia("(min-width: 0.1em)") || {}).matches ? s.matchesMedia = function(a) {
                return !a || matchMedia(a).matches
            } : s.matchesMedia = s.mMQ, s.matchesMedia.apply(this, arguments)
        }, s.mMQ = function(a) {
            return a ? $(a) : !0
        }, s.calcLength = function(a) {
            var b = $(a, !0) || !1;
            return 0 > b && (b = !1), b
        }, s.supportsType = function(a) {
            return a ? z[a] : !0
        }, s.parseSize = Z(function(a) {
            var b = (a || "").match(H);
            return {
                media: b && b[1],
                length: b && b[2]
            }
        }), s.parseSet = function(a) {
            return a.cands || (a.cands = m(a.srcset, a)), a.cands
        }, s.getEmValue = function() {
            var a;
            if (!p && (a = b.body)) {
                var c = b.createElement("div"),
                    d = y.style.cssText,
                    e = a.style.cssText;
                c.style.cssText = J, y.style.cssText = K, a.style.cssText = K, a.appendChild(c), p = c.offsetWidth, a.removeChild(c), p = parseFloat(p, 10), y.style.cssText = d, a.style.cssText = e
            }
            return p || 16
        }, s.calcListLength = function(a) {
            if (!(a in N) || A.uT) {
                var b = s.calcLength(n(a));
                N[a] = b ? b : P.width
            }
            return N[a]
        }, s.setRes = function(a) {
            var b;
            if (a) {
                b = s.parseSet(a);
                for (var c = 0, d = b.length; d > c; c++) _(b[c], a.sizes)
            }
            return b
        }, s.setRes.res = _, s.applySetCandidate = function(a, b) {
            if (a.length) {
                var c, d, e, f, h, k, l, m, n, o = b[s.ns],
                    p = s.DPR;
                if (k = o.curSrc || b[F], l = o.curCan || j(b, k, a[0].set), l && l.set === a[0].set && (n = E && !b.complete && l.res - .1 > p, n || (l.cached = !0, l.res >= p && (h = l))), !h)
                    for (a.sort(i), f = a.length, h = a[f - 1], d = 0; f > d; d++)
                        if (c = a[d], c.res >= p) {
                            e = d - 1, h = a[e] && (n || k !== s.makeUrl(c.url)) && g(a[e].res, c.res, p, a[e].cached) ? a[e] : c;
                            break
                        }
                h && (m = s.makeUrl(h.url), o.curSrc = m, o.curCan = h, m !== k && s.setSrc(b, h), s.setSize(b))
            }
        }, s.setSrc = function(a, b) {
            var c;
            a.src = b.url, "image/svg+xml" === b.set.type && (c = a.style.width, a.style.width = a.offsetWidth + 1 + "px", a.offsetWidth + 1 && (a.style.width = c))
        }, s.getSet = function(a) {
            var b, c, d, e = !1,
                f = a[s.ns].sets;
            for (b = 0; b < f.length && !e; b++)
                if (c = f[b], c.srcset && s.matchesMedia(c.media) && (d = s.supportsType(c.type))) {
                    "pending" === d && (c = d), e = c;
                    break
                }
            return e
        }, s.parseSets = function(a, b, d) {
            var e, f, g, h, i = b && "PICTURE" === b.nodeName.toUpperCase(),
                j = a[s.ns];
            (j.src === c || d.src) && (j.src = v.call(a, "src"), j.src ? w.call(a, B, j.src) : x.call(a, B)), (j.srcset === c || d.srcset || !s.supSrcset || a.srcset) && (e = v.call(a, "srcset"), j.srcset = e, h = !0), j.sets = [], i && (j.pic = !0, l(b, j.sets)), j.srcset ? (f = {
                srcset: j.srcset,
                sizes: v.call(a, "sizes")
            }, j.sets.push(f), g = (q || j.src) && G.test(j.srcset || ""), g || !j.src || k(j.src, f) || f.has1x || (f.srcset += ", " + j.src, f.cands.push({
                url: j.src,
                d: 1,
                set: f
            }))) : j.src && j.sets.push({
                srcset: j.src,
                sizes: null
            }), j.curCan = null, j.curSrc = c, j.supported = !(i || f && !s.supSrcset || g), h && s.supSrcset && !j.supported && (e ? (w.call(a, C, e), a.srcset = "") : x.call(a, C)), j.supported && !j.srcset && (!j.src && a.src || a.src !== s.makeUrl(j.src)) && (null === j.src ? a.removeAttribute("src") : a.src = j.src), j.parsed = !0
        }, s.fillImg = function(a, b) {
            var c, d = b.reselect || b.reevaluate;
            a[s.ns] || (a[s.ns] = {}), c = a[s.ns], (d || c.evaled !== r) && ((!c.parsed || b.reevaluate) && s.parseSets(a, a.parentNode, b), c.supported ? c.evaled = r : h(a))
        }, s.setupRun = function() {
            (!R || L || O !== a.devicePixelRatio) && f()
        }, s.supPicture ? (aa = t, s.fillImg = t) : ! function() {
            var c, d = a.attachEvent ? /d$|^c/ : /d$|^c|^i/,
                e = function() {
                    var a = b.readyState || "";
                    f = setTimeout(e, "loading" === a ? 200 : 999), b.body && (s.fillImgs(), c = c || d.test(a), c && clearTimeout(f))
                },
                f = setTimeout(e, b.body ? 9 : 99),
                g = function(a, b) {
                    var c, d, e = function() {
                        var f = new Date - d;
                        b > f ? c = setTimeout(e, b - f) : (c = null, a())
                    };
                    return function() {
                        d = new Date, c || (c = setTimeout(e, b))
                    }
                },
                h = y.clientHeight,
                i = function() {
                    L = Math.max(a.innerWidth || 0, y.clientWidth) !== P.width || y.clientHeight !== h, h = y.clientHeight, L && s.fillImgs()
                };
            Y(a, "resize", g(i, 99)), Y(b, "readystatechange", e)
        }(), s.picturefill = aa, s.fillImgs = aa, s.teardownRun = t, aa._ = s, a.picturefillCFG = {
            pf: s,
            push: function(a) {
                var b = a.shift();
                "function" == typeof s[b] ? s[b].apply(s, a) : (A[b] = a[0], R && s.fillImgs({
                    reselect: !0
                }))
            }
        };
        for (; I && I.length;) a.picturefillCFG.push(I.shift());
        a.picturefill = aa, "object" == typeof module && "object" == typeof module.exports ? module.exports = aa : "function" == typeof define && define.amd && define("picturefill", function() {
            return aa
        }), s.supPicture || (z["image/webp"] = e("image/webp", "data:image/webp;base64,UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAABBxAR/Q9ERP8DAABWUDggGAAAADABAJ0BKgEAAQADADQlpAADcAD++/1QAA=="))
    }(window, document), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery"], a) : a(jQuery)
    }(function(a) {
        "use strict";

        function b(a) {
            m.Plugins[a].initialized || (m.Plugins[a].methods._setup.call(document), m.Plugins[a].initialized = !0)
        }

        function c(a, b, c, d) {
            var e, f = {
                raw: {}
            };
            d = d || {};
            for (e in d) d.hasOwnProperty(e) && ("classes" === a ? (f.raw[d[e]] = b + "-" + d[e], f[d[e]] = "." + b + "-" + d[e]) : (f.raw[e] = d[e], f[e] = d[e] + "." + b));
            for (e in c) c.hasOwnProperty(e) && ("classes" === a ? (f.raw[e] = c[e].replace(/{ns}/g, b), f[e] = c[e].replace(/{ns}/g, "." + b)) : (f.raw[e] = c[e].replace(/.{ns}/g, ""), f[e] = c[e].replace(/{ns}/g, b)));
            return f
        }

        function d() {
            var a, b = {
                    WebkitTransition: "webkitTransitionEnd",
                    MozTransition: "transitionend",
                    OTransition: "otransitionend",
                    transition: "transitionend"
                },
                c = ["transition", "-webkit-transition"],
                d = {
                    transform: "transform",
                    MozTransform: "-moz-transform",
                    OTransform: "-o-transform",
                    msTransform: "-ms-transform",
                    webkitTransform: "-webkit-transform"
                },
                e = "transitionend",
                f = "",
                g = "",
                h = document.createElement("div");
            for (a in b)
                if (b.hasOwnProperty(a) && a in h.style) {
                    e = b[a], m.support.transition = !0;
                    break
                }
            p.transitionEnd = e + ".{ns}";
            for (a in c)
                if (c.hasOwnProperty(a) && c[a] in h.style) {
                    f = c[a];
                    break
                }
            m.transition = f;
            for (a in d)
                if (d.hasOwnProperty(a) && d[a] in h.style) {
                    m.support.transform = !0, g = d[a];
                    break
                }
            m.transform = g
        }

        function e() {
            m.windowWidth = m.$window.width(), m.windowHeight = m.$window.height(), q = l.startTimer(q, r, f)
        }

        function f() {
            for (var a in m.ResizeHandlers) m.ResizeHandlers.hasOwnProperty(a) && m.ResizeHandlers[a].callback.call(window, m.windowWidth, m.windowHeight)
        }

        function g() {
            if (m.support.raf) {
                m.window.requestAnimationFrame(g);
                for (var a in m.RAFHandlers) m.RAFHandlers.hasOwnProperty(a) && m.RAFHandlers[a].callback.call(window)
            }
        }

        function h(a, b) {
            return parseInt(a.priority) - parseInt(b.priority)
        }
        var i = "undefined" != typeof window ? window : this,
            j = i.document,
            k = function() {
                this.Version = "1.2.0", this.Plugins = {}, this.DontConflict = !1, this.Conflicts = {
                    fn: {}
                }, this.ResizeHandlers = [], this.RAFHandlers = [], this.window = i, this.$window = a(i), this.document = j, this.$document = a(j), this.$body = null, this.windowWidth = 0, this.windowHeight = 0, this.fallbackWidth = 1024, this.fallbackHeight = 768, this.userAgent = window.navigator.userAgent || window.navigator.vendor || window.opera, this.isFirefox = /Firefox/i.test(this.userAgent), this.isChrome = /Chrome/i.test(this.userAgent), this.isSafari = /Safari/i.test(this.userAgent) && !this.isChrome, this.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(this.userAgent), this.isIEMobile = /IEMobile/i.test(this.userAgent), this.isFirefoxMobile = this.isFirefox && this.isMobile, this.transform = null, this.transition = null, this.support = {
                    file: !!(window.File && window.FileList && window.FileReader),
                    history: !!(window.history && window.history.pushState && window.history.replaceState),
                    matchMedia: !(!window.matchMedia && !window.msMatchMedia),
                    pointer: !!window.PointerEvent,
                    raf: !(!window.requestAnimationFrame || !window.cancelAnimationFrame),
                    touch: !!("ontouchstart" in window || window.DocumentTouch && document instanceof window.DocumentTouch),
                    transition: !1,
                    transform: !1
                }
            },
            l = {
                killEvent: function(a, b) {
                    try {
                        a.preventDefault(), a.stopPropagation(), b && a.stopImmediatePropagation()
                    } catch (c) {}
                },
                startTimer: function(a, b, c, d) {
                    return l.clearTimer(a), d ? setInterval(c, b) : setTimeout(c, b)
                },
                clearTimer: function(a, b) {
                    a && (b ? clearInterval(a) : clearTimeout(a), a = null)
                },
                sortAsc: function(a, b) {
                    return parseInt(a, 10) - parseInt(b, 10)
                },
                sortDesc: function(a, b) {
                    return parseInt(b, 10) - parseInt(a, 10)
                },
                decodeEntities: function(a) {
                    var b = m.document.createElement("textarea");
                    return b.innerHTML = a, b.value
                },
                parseQueryString: function(a) {
                    for (var b = {}, c = a.slice(a.indexOf("?") + 1).split("&"), d = 0; d < c.length; d++) {
                        var e = c[d].split("=");
                        b[e[0]] = e[1]
                    }
                    return b
                }
            },
            m = new k,
            n = a.Deferred(),
            o = {
                base: "{ns}",
                element: "{ns}-element"
            },
            p = {
                namespace: ".{ns}",
                beforeUnload: "beforeunload.{ns}",
                blur: "blur.{ns}",
                change: "change.{ns}",
                click: "click.{ns}",
                dblClick: "dblclick.{ns}",
                drag: "drag.{ns}",
                dragEnd: "dragend.{ns}",
                dragEnter: "dragenter.{ns}",
                dragLeave: "dragleave.{ns}",
                dragOver: "dragover.{ns}",
                dragStart: "dragstart.{ns}",
                drop: "drop.{ns}",
                error: "error.{ns}",
                focus: "focus.{ns}",
                focusIn: "focusin.{ns}",
                focusOut: "focusout.{ns}",
                input: "input.{ns}",
                keyDown: "keydown.{ns}",
                keyPress: "keypress.{ns}",
                keyUp: "keyup.{ns}",
                load: "load.{ns}",
                mouseDown: "mousedown.{ns}",
                mouseEnter: "mouseenter.{ns}",
                mouseLeave: "mouseleave.{ns}",
                mouseMove: "mousemove.{ns}",
                mouseOut: "mouseout.{ns}",
                mouseOver: "mouseover.{ns}",
                mouseUp: "mouseup.{ns}",
                panStart: "panstart.{ns}",
                pan: "pan.{ns}",
                panEnd: "panend.{ns}",
                resize: "resize.{ns}",
                scaleStart: "scalestart.{ns}",
                scaleEnd: "scaleend.{ns}",
                scale: "scale.{ns}",
                scroll: "scroll.{ns}",
                select: "select.{ns}",
                swipe: "swipe.{ns}",
                touchCancel: "touchcancel.{ns}",
                touchEnd: "touchend.{ns}",
                touchLeave: "touchleave.{ns}",
                touchMove: "touchmove.{ns}",
                touchStart: "touchstart.{ns}"
            };
        k.prototype.NoConflict = function() {
            m.DontConflict = !0;
            for (var b in m.Plugins) m.Plugins.hasOwnProperty(b) && (a[b] = m.Conflicts[b], a.fn[b] = m.Conflicts.fn[b])
        }, k.prototype.Plugin = function(d, e) {
            return m.Plugins[d] = function(b, d) {
                function e(c) {
                    var e, f, h, i = "object" === a.type(c),
                        j = this,
                        k = a();
                    for (c = a.extend(!0, {}, d.defaults || {}, i ? c : {}), f = 0, h = j.length; h > f; f++)
                        if (e = j.eq(f), !g(e)) {
                            var l = "__" + d.guid++,
                                m = d.classes.raw.base + l,
                                n = e.data(b + "-options"),
                                o = a.extend(!0, {
                                    $el: e,
                                    guid: l,
                                    rawGuid: m,
                                    dotGuid: "." + m
                                }, c, "object" === a.type(n) ? n : {});
                            e.addClass(d.classes.raw.element).data(r, o), d.methods._construct.apply(e, [o].concat(Array.prototype.slice.call(arguments, i ? 1 : 0))), k = k.add(e)
                        }
                    for (f = 0, h = k.length; h > f; f++) e = k.eq(f), d.methods._postConstruct.apply(e, [g(e)]);
                    return j
                }

                function f(a) {
                    d.functions.iterate.apply(this, [d.methods._destruct].concat(Array.prototype.slice.call(arguments, 1))), this.removeClass(d.classes.raw.element).removeData(r)
                }

                function g(a) {
                    return a.data(r)
                }

                function i(b) {
                    if (this instanceof a) {
                        var c = d.methods[b];
                        return "object" !== a.type(b) && b ? c && 0 !== b.indexOf("_") ? d.functions.iterate.apply(this, [c].concat(Array.prototype.slice.call(arguments, 1))) : this : e.apply(this, arguments)
                    }
                }

                function j(b) {
                    var c = d.utilities[b] || d.utilities._initialize || !1;
                    return c ? c.apply(window, Array.prototype.slice.call(arguments, "object" === a.type(b) ? 0 : 1)) : void 0
                }

                function k(b) {
                    d.defaults = a.extend(!0, d.defaults, b || {})
                }

                function n(b) {
                    for (var c = this, d = 0, e = c.length; e > d; d++) {
                        var f = c.eq(d),
                            h = g(f) || {};
                        "undefined" !== a.type(h.$el) && b.apply(f, [h].concat(Array.prototype.slice.call(arguments, 1)))
                    }
                    return c
                }
                var q = "fs-" + b,
                    r = "fs" + b.replace(/(^|\s)([a-z])/g, function(a, b, c) {
                        return b + c.toUpperCase()
                    });
                return d.initialized = !1, d.priority = d.priority || 10, d.classes = c("classes", q, o, d.classes), d.events = c("events", b, p, d.events), d.functions = a.extend({
                    getData: g,
                    iterate: n
                }, l, d.functions), d.methods = a.extend(!0, {
                    _setup: a.noop,
                    _construct: a.noop,
                    _postConstruct: a.noop,
                    _destruct: a.noop,
                    _resize: !1,
                    destroy: f
                }, d.methods), d.utilities = a.extend(!0, {
                    _initialize: !1,
                    _delegate: !1,
                    defaults: k
                }, d.utilities), d.widget && (m.Conflicts.fn[b] = a.fn[b], a.fn[r] = i, m.DontConflict || (a.fn[b] = a.fn[r])), m.Conflicts[b] = a[b], a[r] = d.utilities._delegate || j, m.DontConflict || (a[b] = a[r]), d.namespace = b, d.namespaceClean = r, d.guid = 0, d.methods._resize && (m.ResizeHandlers.push({
                    namespace: b,
                    priority: d.priority,
                    callback: d.methods._resize
                }), m.ResizeHandlers.sort(h)), d.methods._raf && (m.RAFHandlers.push({
                    namespace: b,
                    priority: d.priority,
                    callback: d.methods._raf
                }), m.RAFHandlers.sort(h)), d
            }(d, e), n.then(function() {
                b(d)
            }), m.Plugins[d]
        };
        var q = null,
            r = 20;
        return m.$window.on("resize.fs", e), e(), g(), a(function() {
            m.$body = a("body"), n.resolve(), m.support.nativeMatchMedia = m.support.matchMedia && !a("html").hasClass("no-matchmedia")
        }), p.clickTouchStart = p.click + " " + p.touchStart, d(), window.Formstone = m, m
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./mediaquery"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c() {
            u = b.$body
        }

        function d() {
            r.scrollDepth && k()
        }

        function e() {
            if (arguments.length && "object" !== a.type(arguments[0]))
                if ("destroy" === arguments[0]) g.apply(this);
                else {
                    var b = Array.prototype.slice.call(arguments, 1);
                    switch (arguments[0]) {
                        case "pageview":
                            n.apply(this, b);
                            break;
                        case "event":
                            m.apply(this, b)
                    }
                }
            else f.apply(this, arguments);
            return null
        }

        function f(b) {
            !x && u.length && (x = !0, r = a.extend(r, b || {}), r.autoEvents && u.find("a").not("[" + z + "]").each(h), r.scrollDepth && (k(), t.on(w.scroll, i).one(w.load, d)), u.on(w.click, "*[" + z + "]", l))
        }

        function g() {
            x && u.length && (t.off(w.namespace), u.off(w.namespace), x = !1)
        }

        function h() {
            var b, c = a(this),
                d = "undefined" !== a.type(c[0].href) ? c[0].href : "",
                e = document.domain.split(".").reverse(),
                f = null !== d.match(e[1] + "." + e[0]);
            if (d.match(/^mailto\:/i)) b = "Email, Click, " + d.replace(/^mailto\:/i, "");
            else if (d.match(/^tel\:/i)) b = "Telephone, Click, " + d.replace(/^tel\:/i, "");
            else if (d.match(r.fileTypes)) {
                var g = /[.]/.exec(d) ? /[^.]+$/.exec(d) : void 0;
                b = "File, Download:" + g[0] + ", " + d.replace(/ /g, "-")
            } else f || (b = "ExternalLink, Click, " + d);
            b && c.attr(z, b)
        }

        function i(a) {
            v.startTimer(B, 250, j)
        }

        function j() {
            for (var a, c = t.scrollTop() + b.windowHeight, d = 1 / r.scrollStops, e = d, f = 1; f <= r.scrollStops; f++) a = Math.round(100 * e).toString(), !A[C][a].passed && c > A[C][a].edge && (A[C][a].passed = !0, m({
                eventCategory: "ScrollDepth",
                eventAction: C,
                eventLabel: a,
                nonInteraction: !0
            })), e += d
        }

        function k() {
            var b, c = a.mediaquery("state"),
                d = u.outerHeight(),
                e = {},
                f = 1 / r.scrollStops,
                g = f,
                h = 0;
            c.minWidth && (C = "MinWidth:" + c.minWidth + "px");
            for (var i = 1; i <= r.scrollStops; i++) h = parseInt(d * g), b = Math.round(100 * g).toString(), e[b] = {
                edge: "100" === b ? h - 10 : h,
                passsed: A[C] && A[C][b] ? A[C][b].passed : !1
            }, g += f;
            A[C] = e
        }

        function l(b) {
            var c = a(this),
                d = c.attr("href"),
                e = c.data(y).split(",");
            r.eventCallback && b.preventDefault();
            for (var f in e) e.hasOwnProperty(f) && (e[f] = a.trim(e[f]));
            m({
                eventCategory: e[0],
                eventAction: e[1],
                eventLabel: e[2] || d,
                eventValue: e[3],
                nonInteraction: e[4]
            }, c)
        }

        function m(b, c) {
            var d = (s.location, a.extend({
                hitType: "event"
            }, b));
            if ("undefined" !== a.type(c) && !c.attr("data-analytics-stop")) {
                var e = "undefined" !== a.type(c[0].href) ? c[0].href : "",
                    f = !e.match(/^mailto\:/i) && !e.match(/^tel\:/i) && e.indexOf(":") < 0 ? s.location.protocol + "//" + s.location.hostname + "/" + e : e;
                if ("" !== f) {
                    var g = c.attr("target");
                    if (g) s.open(f, g);
                    else if (r.eventCallback) {
                        var h = "hitCallback";
                        d[h] = function() {
                            D && (v.clearTimer(D), p(f))
                        }, D = v.startTimer(D, r.eventTimeout, d[h])
                    }
                }
            }
            o(d)
        }

        function n(b) {
            var c = a.extend({
                hitType: "pageview"
            }, b);
            o(c)
        }

        function o(b) {
            if ("function" === a.type(s.ga) && "function" === a.type(s.ga.getAll))
                for (var c = s.ga.getAll(), d = 0, e = c.length; e > d; d++) s.ga(c[d].get("name") + ".send", b)
        }

        function p(a) {
            document.location = a
        }
        var q = b.Plugin("analytics", {
                methods: {
                    _setup: c,
                    _resize: d
                },
                utilities: {
                    _delegate: e
                }
            }),
            r = {
                autoEvents: !1,
                fileTypes: /\.(zip|exe|dmg|pdf|doc.*|xls.*|ppt.*|mp3|txt|rar|wma|mov|avi|flv|wav)$/i,
                eventCallback: !1,
                eventTimeout: 1e3,
                scrollDepth: !1,
                scrollStops: 5
            },
            s = b.window,
            t = b.$window,
            u = null,
            v = q.functions,
            w = q.events,
            x = !1,
            y = "analytics-event",
            z = "data-" + y,
            A = {},
            B = null,
            C = "Site",
            D = null
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./analytics"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(c) {
            !q && b.support.history && (o = b.$body, q = a.extend(s, c), q.render === a.noop && (q.render = i), q.transitionOut === a.noop && (q.transitionOut = function() {
                return a.Deferred().resolve()
            }), history.state ? (A = history.state.id, z = history.state.url) : (z = window.location.href, m(A, z)), t.on(w.popState, f), d())
        }

        function d() {
            o && !o.hasClass(x.base) && o.on(w.click, q.selector, e).addClass(x.base)
        }

        function e(a) {
            var b = a.currentTarget;
            a.which > 1 || a.metaKey || a.ctrlKey || a.shiftKey || a.altKey || window.location.protocol !== b.protocol || window.location.host !== b.host || "_blank" === b.target || (!b.hash || b.href.replace(b.hash, "") !== window.location.href.replace(location.hash, "") && b.href !== window.location.href + "#") && (b.href.match(q.ignoreTypes) || (v.killEvent(a), a.stopImmediatePropagation(), b.href !== z && g(b.href, !0)))
        }

        function f(a) {
            p && p.abort();
            var b = a.originalEvent.state;
            b && (A = b.id, b.url !== z && g(b.url, !1))
        }

        function g(b, c) {
            p && p.abort(), t.trigger(w.requested, [c]), q.transitionOutDeferred = q.transitionOut.apply(u, [!1]);
            var d = n(b),
                e = d.params,
                f = d.hash,
                g = d.clean,
                i = "User error",
                j = null,
                k = a.Deferred();
            e[q.requestKey] = !0, p = a.ajax({
                url: g,
                data: e,
                dataType: "json",
                cache: q.cache,
                xhr: function() {
                    var a = new u.XMLHttpRequest;
                    return a.addEventListener("progress", function(a) {
                        if (a.lengthComputable) {
                            var b = a.loaded / a.total;
                            t.trigger(w.progress, [b])
                        }
                    }, !1), a
                },
                success: function(c, e, g) {
                    j = "string" === a.type(c) ? a.parseJSON(c) : c, c.location && (b = c.location, d = n(b), f = d.hash), k.resolve()
                },
                error: function(a, b, c) {
                    i = c, k.reject()
                }
            }), a.when(k, q.transitionOutDeferred).done(function() {
                h(d, j, c)
            }).fail(function() {
                t.trigger(w.failed, [i])
            })
        }

        function h(b, c, d) {
            t.trigger(w.loaded, [c]), void 0 !== a.fsAnalytics && a.fsAnalytics("pageview"), q.render.call(this, c, b.hash), z = b.url, d && (A++, l(A, z)), t.trigger(w.rendered, [c]);
            var e = !1;
            if ("" !== b.hash) {
                var f = a(b.hash);
                f.length && (e = f.offset().top)
            }
            e !== !1 && t.scrollTop(e)
        }

        function i(b, c) {
            if ("undefined" !== a.type(b)) {
                var d;
                for (var e in b) b.hasOwnProperty(e) && (d = a(e), d.length && d.html(b[e]))
            }
        }

        function j(a) {
            q && b.support.history ? a && g(a, !0) : window.location.href = a
        }

        function k(a) {
            var b = history.state;
            z = a, m(b.id, a)
        }

        function l(a, b) {
            history.pushState({
                id: a,
                url: b
            }, y + a, b)
        }

        function m(a, b) {
            history.replaceState({
                id: a,
                url: b
            }, y + a, b)
        }

        function n(a) {
            var b = a.indexOf("?"),
                c = a.indexOf("#"),
                d = {},
                e = "",
                f = a;
            return c > -1 && (e = a.slice(c), f = a.slice(0, c)), b > -1 && (d = v.parseQueryString(a.slice(b + 1, c > -1 ? c : a.length)), f = a.slice(0, b)), {
                hash: e,
                params: d,
                url: a,
                clean: f
            }
        }
        var o, p, q, r = b.Plugin("asap", {
                utilities: {
                    _initialize: c,
                    load: j,
                    replace: k
                },
                events: {
                    failed: "failed",
                    loaded: "loaded",
                    popState: "popstate",
                    progress: "progress",
                    requested: "requested",
                    rendered: "rendered"
                }
            }),
            s = {
                cache: !0,
                ignoreTypes: /\.(jpg|sjpg|jpeg|png|gif|zip|exe|dmg|pdf|doc.*|xls.*|ppt.*|mp3|txt|rar|wma|mov|avi|wmv|flv|wav)$/i,
                render: a.noop,
                requestKey: "fs-asap",
                selector: "a",
                transitionOut: a.noop
            },
            t = b.$window,
            u = t[0],
            v = r.functions,
            w = r.events,
            x = r.classes.raw,
            y = "asap-",
            z = "",
            A = 1
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./transition"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c() {
            e(), F.on("scroll", e)
        }

        function d() {
            D.iterate.call(H, u), D.iterate.call(I, w), D.iterate.call(I, x)
        }

        function e() {
            G = F.scrollTop() + b.windowHeight, 0 > G && (G = 0), D.iterate.call(I, x)
        }

        function f() {
            H = a(A.base), I = a(A.lazy), D.iterate.call(I, w)
        }

        function g(b) {
		console.log('B.container :'+B.container);
            b.youTubeGuid = 0, b.$container = a('<div class="' + B.container + '"></div>').appendTo(this), b.thisClasses = [B.base, b.customClass], b.visible = !0, b.lazy && (b.visible = !1, b.thisClasses.push(B.lazy)), this.addClass(b.thisClasses.join(" ")), f(), b.lazy ? (w(b), x(b)) : i(b)
			console.log(' b.youTubeGuid :'+ b.youTubeGuid);
        }

        function h(a) {
            a.$container.remove(), this.removeClass(a.thisClasses.join(" ")).off(C.namespace), f()
        }

        function i(a) {
            if (a.visible) {
                var b = a.source;
                a.source = null, j(a, b, !0)
            }
        }

        function j(b, c, d) {
            if (c !== b.source && b.visible) {
                if (b.source = c, b.responsive = !1, b.isYouTube = !1, "object" === a.type(c) && "string" === a.type(c.video)) {
                    var e = c.video.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i);
                    e && e.length >= 1 && (b.isYouTube = !0, b.videoId = e[1])
                }
                var f = !b.isYouTube && "object" === a.type(c) && (c.hasOwnProperty("mp4") || c.hasOwnProperty("ogg") || c.hasOwnProperty("webm"));
                if (b.video = b.isYouTube || f, b.playing = !1, b.isYouTube) b.playerReady = !1, b.posterLoaded = !1, n(b, c, d);
                else if ("object" === a.type(c) && c.hasOwnProperty("poster")) m(b, c, d);
                else {
                    var g = c;
                    if ("object" === a.type(c)) {
                        var h, i = [],
                            j = [];
                        for (h in c) c.hasOwnProperty(h) && j.push(h);
                        j.sort(D.sortAsc);
                        for (h in j) j.hasOwnProperty(h) && i.push({
                            width: parseInt(j[h]),
                            url: c[j[h]],
                            mq: E.matchMedia("(min-width: " + parseInt(j[h]) + "px)")
                        });
                        b.responsive = !0, b.sources = i, g = k(b)
                    }
                    l(b, g, !1, d)
                }
            } else b.$el.trigger(C.loaded)
        }

        function k(a) {
            var c = a.source;
            if (a.responsive) {
                c = a.sources[0].url;
                for (var d in a.sources) a.sources.hasOwnProperty(d) && (b.support.nativeMatchMedia ? a.sources[d].mq.matches && (c = a.sources[d].url) : a.sources[d].width < b.fallbackWidth && (c = a.sources[d].url))
            }
            return c
        }

        function l(b, c, d, e) {
            var f = [B.media, B.image, e !== !0 ? B.animated : ""].join(" "),
                g = a('<div class="' + f + '" aria-hidden="true"><img alt=""></div>'),
                h = g.find("img"),
                i = c;
            h.one(C.load, function() {
                J && g.addClass(B["native"]).css({
                    backgroundImage: "url('" + i + "')"
                }), g.fsTransition({
                    property: "opacity"
                }, function() {
                    d || o(b)
                }).css({
                    opacity: 1
                }), v(b), d && !e || b.$el.trigger(C.loaded)
            }).attr("src", i), b.responsive && g.addClass(B.responsive), b.$container.append(g), (h[0].complete || 4 === h[0].readyState) && h.trigger(C.load), b.currentSource = i
        }

        function m(c, d, e) {
            if (c.source && c.source.poster && (l(c, c.source.poster, !0, !0), e = !1), !b.isMobile) {
                var f = [B.media, B.video, e !== !0 ? B.animated : ""].join(" "),
                    g = '<div class="' + f + '" aria-hidden="true">';
                g += "<video", c.loop && (g += " loop"), c.mute && (g += " muted"), g += ">", c.source.webm && (g += '<source src="' + c.source.webm + '" type="video/webm" />'), c.source.mp4 && (g += '<source src="' + c.source.mp4 + '" type="video/mp4" />'), c.source.ogg && (g += '<source src="' + c.source.ogg + '" type="video/ogg" />'), g += "</video>", g += "</div>";
                var h = a(g),
                    i = h.find("video");
                i.one(C.loadedMetaData, function(a) {
                    h.fsTransition({
                        property: "opacity"
                    }, function() {
                        o(c)
                    }).css({
                        opacity: 1
                    }), v(c), c.$el.trigger(C.loaded), c.autoPlay && r(c)
                }), c.$container.append(h)
            }
        }

        function n(c, d, e) {
            if (!c.videoId) {
                var f = d.match(/^.*(?:youtu.be\/|v\/|e\/|u\/\w+\/|embed\/|v=)([^#\&\?]*).*/);
                c.videoId = f[1]
            }
            if (c.posterLoaded || (c.source.poster || (c.source.poster = "http://img.youtube.com/vi/" + c.videoId + "/0.jpg"), c.posterLoaded = !0, l(c, c.source.poster, !0, e), e = !1), !b.isMobile)
                if (a("script[src*='youtube.com/iframe_api']").length || a("head").append('<script src="//www.youtube.com/iframe_api"></script>'), K) {
                    var g = c.guid + "_" + c.youTubeGuid++,
                        h = [B.media, B.embed, e !== !0 ? B.animated : ""].join(" "),
                        i = '<div class="' + h + '" aria-hidden="true">';
                    i += '<div id="' + g + '"></div>', i += "</div>";
                    var j = a(i),
                        k = a.extend(!0, {}, {
                            controls: 0,
                            rel: 0,
                            showinfo: 0,
                            wmode: "transparent",
                            enablejsapi: 1,
                            version: 3,
                            playerapiid: g,
                            loop: c.loop ? 1 : 0,
                            autoplay: 1,
                            origin: E.location.protocol + "//" + E.location.host
                        }, c.youtubeOptions);
                    k.autoplay = 1, c.$container.append(j), c.player && (c.oldPlayer = c.player, c.player = null), c.player = new E.YT.Player(g, {
                        videoId: c.videoId,
                        playerVars: k,
                        events: {
                            onReady: function(a) {
                                c.playerReady = !0, c.mute && c.player.mute(), c.autoPlay || c.player.pauseVideo()
                            },
                            onStateChange: function(a) {
                                c.playing || a.data !== E.YT.PlayerState.PLAYING ? c.loop && c.playing && a.data === E.YT.PlayerState.ENDED && c.player.playVideo() : (c.playing = !0, j.fsTransition({
                                    property: "opacity"
                                }, function() {
                                    o(c)
                                }).css({
                                    opacity: 1
                                }), v(c), c.$el.trigger(C.loaded)), c.$el.find(A.embed).addClass(B.ready)
                            },
                            onPlaybackQualityChange: function(a) {},
                            onPlaybackRateChange: function(a) {},
                            onError: function(a) {},
                            onApiChange: function(a) {}
                        }
                    }), v(c)
                } else L.push({
                    data: c,
                    source: d
                })
        }

        function o(a) {
            var b = a.$container.find(A.media);
            b.length >= 1 && (b.not(":last").remove(), a.oldPlayer = null)
        }

        function p(a) {
            var b = a.$container.find(A.media);
            b.length >= 1 && b.fsTransition({
                property: "opacity"
            }, function() {
                b.remove(), delete a.source
            }).css({
                opacity: 0
            })
        }

        function q(a) {
            if (a.video && a.playing) {
                if (a.isYouTube) a.playerReady ? a.player.pauseVideo() : a.autoPlay = !1;
                else {
                    var b = a.$container.find("video");
                    b.length && b[0].pause()
                }
                a.playing = !1
            }
        }

        function r(a) {
            if (a.video && !a.playing)
                if (a.isYouTube) a.playerReady ? a.player.playVideo() : a.autoPlay = !0;
                else {
                    var b = a.$container.find("video");
                    b.length && b[0].play(), a.playing = !0
                }
        }

        function s(a) {
            if (a.video)
                if (a.isYouTube && a.playerReady) a.player.mute();
                else {
                    var b = a.$container.find("video");
                    b.length && (b[0].muted = !0)
                }
            a.mute = !0
        }

        function t(a) {
            if (a.video) {
                if (a.isYouTube && a.playerReady) a.player.unMute();
                else {
                    var b = a.$container.find("video");
                    b.length && (b[0].muted = !1)
                }
                a.playing = !0
            }
            a.mute = !1
        }

        function u(a) {
            if (a.visible)
                if (a.responsive) {
                    var b = k(a);
                    b !== a.currentSource ? l(a, b, !1, !0) : v(a)
                } else v(a)
        }

        function v(a) {
            for (var b = a.$container.find(A.media), c = 0, d = b.length; d > c; c++) {
                var e = b.eq(c),
                    f = a.isYouTube ? "iframe" : e.find("video").length ? "video" : "img",
                    g = e.find(f);
                if (g.length && ("img" !== f || !J)) {
                    var h = a.$el.outerWidth(),
                        i = a.$el.outerHeight(),
                        j = y(a, g);
                    a.width = j.width, a.height = j.height, a.left = 0, a.top = 0;
                    var k = a.isYouTube ? a.embedRatio : a.width / a.height;
                    a.height = i, a.width = a.height * k, a.width < h && (a.width = h, a.height = a.width / k), a.left = -(a.width - h) / 2, a.top = -(a.height - i) / 2, e.css({
                        height: a.height,
                        width: a.width,
                        left: a.left,
                        top: a.top
                    })
                }
            }
        }

        function w(a) {
            a.scrollTop = a.$el.offset().top
        }

        function x(a) {
            !a.visible && a.scrollTop < G + a.lazyEdge && (a.visible = !0, i(a))
        }

        function y(b, c) {
            if (b.isYouTube) return {
                height: 500,
                width: 500 / b.embedRatio
            };
            if (c.is("img")) {
                var d = c[0];
                if ("undefined" !== a.type(d.naturalHeight)) return {
                    height: d.naturalHeight,
                    width: d.naturalWidth
                };
                var e = new Image;
                return e.src = d.src, {
                    height: e.height,
                    width: e.width
                }
            }
            return {
                height: c[0].videoHeight,
                width: c[0].videoWidth
            }
        }
        var z = b.Plugin("background", {
                widget: !0,
                defaults: {
                    autoPlay: !0,
                    customClass: "",
                    embedRatio: 1.777777,
                    lazy: !1,
                    lazyEdge: 100,
                    loop: !0,
                    mute: !0,
                    source: null,
                    youtubeOptions: {}
                },
                classes: ["container", "media", "animated", "responsive", "native", "fixed", "ready", "lazy"],
                events: {
                    loaded: "loaded",
                    ready: "ready",
                    loadedMetaData: "loadedmetadata"
                },
                methods: {
                    _setup: c,
                    _construct: g,
                    _destruct: h,
                    _resize: d,
                    play: r,
                    pause: q,
                    mute: s,
                    unmute: t,
                    resize: v,
                    load: j,
                    unload: p
                }
            }),
            A = z.classes,
            B = A.raw,
            C = z.events,
            D = z.functions,
            E = b.window,
            F = b.$window,
            G = 0,
            H = [],
            I = [],
            J = "backgroundSize" in b.document.documentElement.style,
            K = !1,
            L = [];
        E.onYouTubeIframeAPIReady = function() {
            K = !0;
            for (var a in L) L.hasOwnProperty(a) && n(L[a].data, L[a].source);
            L = []
        }
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./mediaquery", "./touch"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(a) {
            R.iterate.call(S, i)
        }

        function d() {
            S = a(O.base)
        }

        function e(c) {
            var e;
            c.didPan = !1, c.carouselClasses = [P.base, c.theme, c.customClass, c.rtl ? P.rtl : P.ltr], c.maxWidth = c.maxWidth === 1 / 0 ? "100000px" : c.maxWidth, c.mq = "(min-width:" + c.minWidth + ") and (max-width:" + c.maxWidth + ")", c.customControls = "object" === a.type(c.controls) && c.controls.previous && c.controls.next, c.customPagination = "string" === a.type(c.pagination), c.id = this.attr("id"), c.id ? c.ariaId = c.id : (c.ariaId = c.rawGuid, this.attr("id", c.ariaId)), b.support.transform || (c.useMargin = !0);
            var f = "",
                i = "",
                k = [P.control, P.control_previous].join(" "),
                l = [P.control, P.control_next].join(" ");
            c.controls && !c.customControls && (f += '<div class="' + P.controls + '" aria-label="carousel controls" aria-controls="' + c.ariaId + '">', f += '<button type="button" class="' + k + '" aria-label="' + c.labels.previous + '">' + c.labels.previous + "</button>", f += '<button type="button" class="' + l + '" aria-label="' + c.labels.next + '">' + c.labels.next + "</button>", f += "</div>"), c.pagination && !c.customPagination && (i += '<div class="' + P.pagination + '" aria-label="carousel pagination" aria-controls="' + c.ariaId + '" role="navigation">', i += "</div>"), c.autoHeight && c.carouselClasses.push(P.auto_height), c.contained && c.carouselClasses.push(P.contained), c.single && c.carouselClasses.push(P.single), this.addClass(c.carouselClasses.join(" ")).wrapInner('<div class="' + P.wrapper + '" aria-live="polite"><div class="' + P.container + '"><div class="' + P.canister + '"></div></div></div>').append(f).wrapInner('<div class="' + P.viewport + '"></div>').append(i), c.$viewport = this.find(O.viewport).eq(0), c.$container = this.find(O.container).eq(0), c.$canister = this.find(O.canister).eq(0), c.$pagination = this.find(O.pagination).eq(0), c.$controlPrevious = c.$controlNext = a(""), c.customControls ? (c.$controls = a(c.controls.container).addClass([P.controls, P.controls_custom].join(" ")), c.$controlPrevious = a(c.controls.previous).addClass(k), c.$controlNext = a(c.controls.next).addClass(l)) : (c.$controls = this.find(O.controls).eq(0), c.$controlPrevious = c.$controls.find(O.control_previous), c.$controlNext = c.$controls.find(O.control_next)), c.$controlItems = c.$controlPrevious.add(c.$controlNext), c.customPagination && (c.$pagination = a(c.pagination).addClass([P.pagination])), c.$paginationItems = c.$pagination.find(O.page), c.index = 0, c.enabled = !1, c.leftPosition = 0, c.autoTimer = null, c.resizeTimer = null;
            var m = this.data(M + "-linked");
            c.linked = m ? "[data-" + M + '-linked="' + m + '"]' : !1, c.linked && (c.paged = !0);
            var n = this.data(M + "-controller-for") || "";
            if (c.$subordinate = a(n), c.$subordinate.length && (c.controller = !0), "object" === a.type(c.show)) {
                var o = c.show,
                    p = [],
                    q = [];
                for (e in o) o.hasOwnProperty(e) && q.push(e);
                q.sort(R.sortAsc);
                for (e in q) q.hasOwnProperty(e) && p.push({
                    width: parseInt(q[e]),
                    count: o[q[e]],
                    mq: window.matchMedia("(min-width: " + parseInt(q[e]) + "px)")
                });
                c.show = p
            }
            j(c), a.fsMediaquery("bind", c.rawGuid, c.mq, {
                enter: function() {
                    h.call(c.$el, c)
                },
                leave: function() {
                    g.call(c.$el, c)
                }
            }), d(), c.carouselClasses.push(P.enabled), c.carouselClasses.push(P.animated)
        }

        function f(b) {
            R.clearTimer(b.autoTimer), R.clearTimer(b.resizeTimer), g.call(this, b), a.fsMediaquery("unbind", b.rawGuid), b.id !== b.ariaId && this.removeAttr("id"), b.$controlItems.removeClass([O.control, P.control_previous, O.control_next, O.visible].join(" ")).off(Q.namespace), b.$images.off(Q.namespace), b.$canister.fsTouch("destroy"), b.$items.removeClass([P.item, P.visible, O.item_previous, O.item_next].join(" ")).unwrap().unwrap().unwrap().unwrap(), b.controls && !b.customControls && b.$controls.remove(), b.customControls && b.$controls.removeClass([P.controls, P.controls_custom, P.visible].join(" ")), b.pagination && !b.customPagination && b.$pagination.remove(), b.customPagination && b.$pagination.html("").removeClass([P.pagination, P.visible].join(" ")), this.removeClass(b.carouselClasses.join(" ")), d()
        }

        function g(a) {
            a.enabled && (R.clearTimer(a.autoTimer), a.enabled = !1, a.$subordinate.off(Q.update), this.removeClass([P.enabled, P.animated].join(" ")).off(Q.namespace), a.$canister.fsTouch("destroy").off(Q.namespace).attr("style", "").css(U, "none"), a.$items.css({
                width: "",
                height: ""
            }).removeClass([P.visible, O.item_previous, O.item_next].join(" ")), a.$images.off(Q.namespace), a.$controlItems.off(Q.namespace), a.$pagination.html("").off(Q.namespace), u(a), a.useMargin ? a.$canister.css({
                marginLeft: ""
            }) : a.$canister.css(T, ""), a.index = 0)
        }

        function h(a) {
            a.enabled || (a.enabled = !0, this.addClass(P.enabled), a.$controlItems.on(Q.click, a, r), a.$pagination.on(Q.click, O.page, a, s), a.$items.on(Q.click, a, H), a.$subordinate.on(Q.update, a, I), I({
                data: a
            }, 0), a.$canister.fsTouch({
                axis: "x",
                pan: !0,
                swipe: !0
            }).on(Q.panStart, a, y).on(Q.pan, a, z).on(Q.panEnd, a, A).on(Q.swipe, a, E).css(U, ""), j(a), a.$images.on(Q.load, a, p), a.autoAdvance && (a.autoTimer = R.startTimer(a.autoTimer, a.autoTime, function() {
                q(a)
            }, !0)), i.call(this, a))
        }

        function i(a) {
            if (a.enabled) {
                var b, c, d, e, f, g, h, i, j, k;
                if (a.count = a.$items.length, a.count < 1) return u(a), void a.$canister.css({
                    height: ""
                });
                for (this.removeClass(P.animated), a.containerWidth = a.$container.outerWidth(!1), a.visible = x(a), a.perPage = a.paged ? 1 : a.visible, a.itemMarginLeft = parseInt(a.$items.eq(0).css("marginLeft")), a.itemMarginRight = parseInt(a.$items.eq(0).css("marginRight")), a.itemMargin = a.itemMarginLeft + a.itemMarginRight, isNaN(a.itemMargin) && (a.itemMargin = 0), a.itemWidth = (a.containerWidth - a.itemMargin * (a.visible - 1)) / a.visible, a.itemHeight = 0, a.pageWidth = a.paged ? a.itemWidth : a.containerWidth, a.pageCount = Math.ceil(a.count / a.perPage), a.canisterWidth = a.single ? a.containerWidth : (a.pageWidth + a.itemMargin) * a.pageCount, a.$canister.css({
                        width: a.matchWidth ? a.canisterWidth : 1e6,
                        height: ""
                    }), a.$items.css({
                        width: a.matchWidth ? a.itemWidth : "",
                        height: ""
                    }).removeClass([P.visible, P.item_previous, P.item_next].join(" ")), a.pages = [], c = 0, d = 0; c < a.count; c += a.perPage) {
                    for (g = a.$items.slice(c, c + a.perPage), i = 0, j = 0, g.length < a.perPage && (g = 0 === c ? a.$items : a.$items.slice(a.$items.length - a.perPage)), h = a.rtl ? g.eq(g.length - 1) : g.eq(0), k = h.position().left, e = 0; e < g.length; e++) f = g.eq(e).outerWidth(!0), b = g.eq(e).outerHeight(), i += f, b > j && (j = b);
                    a.pages.push({
                        left: a.rtl ? k - (a.canisterWidth - i) : k,
                        height: j,
                        width: i,
                        $items: g
                    }), j > a.itemHeight && (a.itemHeight = j), d++
                }
                a.paged && (a.pageCount -= a.count % a.visible), a.pageCount <= 0 && (a.pageCount = 1), a.maxMove = -a.pages[a.pageCount - 1].left, a.autoHeight ? a.$canister.css({
                    height: a.pages[0].height
                }) : a.matchHeight && a.$items.css({
                    height: a.itemHeight
                });
                var l = "";
                for (c = 0; c < a.pageCount; c++) l += '<button type="button" class="' + P.page + '">' + (c + 1) + "</button>";
                a.$pagination.html(l), a.pageCount <= 1 ? u(a) : v(a), a.$paginationItems = a.$pagination.find(O.page), t(a, a.index, !1), setTimeout(function() {
                    a.$el.addClass(P.animated)
                }, 5)
            }
        }

        function j(a) {
            a.$items = a.$canister.children().not(":hidden").addClass(P.item), a.$images = a.$canister.find("img"), a.totalImages = a.$images.length
        }

        function k(a) {
            a.enabled && l.call(this, a, !1)
        }

        function l(a, b) {
            a.$images.off(Q.namespace), b !== !1 && a.$canister.html(b), a.index = 0, j(a), i.call(this, a)
        }

        function m(a, b, c, d, e) {
            a.enabled && (R.clearTimer(a.autoTimer), "undefined" == typeof e && (e = !0), t(a, b - 1, e, c, d))
        }

        function n(a) {
            var b = a.index - 1;
            a.infinite && 0 > b && (b = a.pageCount - 1), t(a, b)
        }

        function o(a) {
            var b = a.index + 1;
            a.infinite && b >= a.pageCount && (b = 0), t(a, b)
        }

        function p(a) {
            var b = a.data;
            b.resizeTimer = R.startTimer(b.resizeTimer, 20, function() {
                i.call(b.$el, b)
            })
        }

        function q(a) {
            var b = a.index + 1;
            b >= a.pageCount && (b = 0), t(a, b)
        }

        function r(b) {
            R.killEvent(b);
            var c = b.data,
                d = c.index + (a(b.currentTarget).hasClass(P.control_next) ? 1 : -1);
            R.clearTimer(c.autoTimer), t(c, d)
        }

        function s(b) {
            R.killEvent(b);
            var c = b.data,
                d = c.$paginationItems.index(a(b.currentTarget));
            R.clearTimer(c.autoTimer), t(c, d)
        }

        function t(b, c, d, e, f) {
            if (0 > c && (c = b.infinite ? b.pageCount - 1 : 0), c >= b.pageCount && (c = b.infinite ? 0 : b.pageCount - 1), !(b.count < 1)) {
                b.pages[c] && (b.leftPosition = -b.pages[c].left), b.leftPosition = J(b, b.leftPosition), b.useMargin ? b.$canister.css({
                    marginLeft: b.leftPosition
                }) : d === !1 ? (b.$canister.css(U, "none").css(T, "translateX(" + b.leftPosition + "px)"), setTimeout(function() {
                    b.$canister.css(U, "")
                }, 5)) : b.$canister.css(T, "translateX(" + b.leftPosition + "px)"), b.$items.removeClass([P.visible, P.item_previous, P.item_next].join(" "));
                for (var g = 0, h = b.pages.length; h > g; g++) g === c ? b.pages[g].$items.addClass(P.visible).attr("aria-hidden", "false") : b.pages[g].$items.not(b.pages[c].$items).addClass(c > g ? P.item_previous : P.item_next).attr("aria-hidden", "true");
                b.autoHeight && b.$canister.css({
                    height: b.pages[c].height
                }), d !== !1 && e !== !0 && c !== b.index && (b.infinite || c > -1 && c < b.pageCount) && b.$el.trigger(Q.update, [c]), b.index = c, b.linked && f !== !0 && a(b.linked).not(b.$el)[N]("jump", b.index + 1, !0, !0), w(b)
            }
        }

        function u(a) {
            a.$controls.removeClass(P.visible), a.$controlItems.removeClass(P.visible), a.$pagination.removeClass(P.visible)
        }

        function v(a) {
            a.$controls.addClass(P.visible), a.$controlItems.addClass(P.visible), a.$pagination.addClass(P.visible)
        }

        function w(a) {
            a.$paginationItems.removeClass(P.active).eq(a.index).addClass(P.active), a.infinite ? a.$controlItems.addClass(P.visible) : a.pageCount < 1 ? a.$controlItems.removeClass(P.visible) : (a.$controlItems.addClass(P.visible), a.index <= 0 ? a.$controlPrevious.removeClass(P.visible) : (a.index >= a.pageCount - 1 || !a.single && a.leftPosition === a.maxMove) && a.$controlNext.removeClass(P.visible))
        }

        function x(c) {
            var d = 1;
            if (c.single) return d;
            if ("array" === a.type(c.show))
                for (var e in c.show) c.show.hasOwnProperty(e) && (b.support.nativeMatchMedia ? c.show[e].mq.matches && (d = c.show[e].count) : c.show[e].width < b.fallbackWidth && (d = c.show[e].count));
            else d = c.show;
            return c.fill && c.count < d ? c.count : d
        }

        function y(b, c) {
            var d = b.data;
            if (R.clearTimer(d.autoTimer), !d.single) {
                if (d.useMargin) d.leftPosition = parseInt(d.$canister.css("marginLeft"));
                else {
                    var e = d.$canister.css(T).split(",");
                    d.leftPosition = parseInt(e[4])
                }
                if (d.$canister.css(U, "none"), z(b), d.linked && c !== !0) {
                    var f = b.deltaX / d.pageWidth;
                    d.rtl && (f *= -1), a(d.linked).not(d.$el)[N]("panStart", f)
                }
            }
            d.isTouching = !0
        }

        function z(b, c) {
            var d = b.data;
            if (!d.single && (d.touchLeft = J(d, d.leftPosition + b.deltaX), d.useMargin ? d.$canister.css({
                    marginLeft: d.touchLeft
                }) : d.$canister.css(T, "translateX(" + d.touchLeft + "px)"), d.linked && c !== !0)) {
                var e = b.deltaX / d.pageWidth;
                d.rtl && (e *= -1), a(d.linked).not(d.$el)[N]("pan", e)
            }
        }

        function A(b, c) {
            var d = b.data,
                e = Math.abs(b.deltaX),
                f = K(d, b),
                g = !1;
            if (d.didPan = !1, !d.single) {
                var h, i, j = Math.abs(d.touchLeft),
                    k = !1,
                    l = d.rtl ? "right" : "left";
                if (b.directionX === l)
                    for (h = 0, i = d.pages.length; i > h; h++) k = d.pages[h], j > Math.abs(k.left) + 20 && (g = h + 1);
                else
                    for (h = d.pages.length - 1, i = 0; h >= i; h--) k = d.pages[h], j < Math.abs(k.left) && (g = h - 1)
            }
            g === !1 && (g = 50 > e ? d.index : d.index + f), g !== d.index && (d.didPan = !0), d.linked && c !== !0 && a(d.linked).not(d.$el)[N]("panEnd", g), G(d, g)
        }

        function B(a, b) {
            if (R.clearTimer(a.autoTimer), !a.single) {
                if (a.rtl && (b *= -1), a.useMargin) a.leftPosition = parseInt(a.$canister.css("marginLeft"));
                else {
                    var c = a.$canister.css(T).split(",");
                    a.leftPosition = parseInt(c[4])
                }
                a.$canister.css(U, "none");
                var d = {
                    data: a,
                    deltaX: a.pageWidth * b
                };
                z(d, !0)
            }
            a.isTouching = !0
        }

        function C(a, b) {
            if (!a.single) {
                a.rtl && (b *= -1);
                var c = a.pageWidth * b;
                a.touchLeft = J(a, a.leftPosition + c), a.useMargin ? a.$canister.css({
                    marginLeft: a.touchLeft
                }) : a.$canister.css(T, "translateX(" + a.touchLeft + "px)")
            }
        }

        function D(a, b) {
            G(a, b, !0)
        }

        function E(b, c) {
            var d = b.data,
                e = K(d, b),
                f = d.index + e;
            d.linked && c !== !0 && a(d.linked).not(d.$el)[N]("swipe", b.directionX), G(d, f)
        }

        function F(a, b) {
            var c = {
                data: a,
                directionX: b
            };
            E(c, !0)
        }

        function G(a, b) {
            a.$canister.css(U, ""), t(a, b), a.isTouching = !1
        }

        function H(b) {
            var c = b.data,
                d = a(b.currentTarget);
            if (!c.didPan && (d.trigger(Q.itemClick), c.controller)) {
                var e = c.$items.index(d);
                I(b, e), c.$subordinate[N]("jump", e + 1, !0)
            }
        }

        function I(a, b) {
            var c = a.data;
            if (c.controller) {
                var d = c.$items.eq(b);
                c.$items.removeClass(P.active), d.addClass(P.active);
                for (var e = 0; e < c.pageCount; e++)
                    if (c.pages[e].$items.is(d)) {
                        t(c, e, !0, !0);
                        break
                    }
            }
        }

        function J(a, b) {
            return isNaN(b) ? b = 0 : a.rtl ? (b > a.maxMove && (b = a.maxMove), 0 > b && (b = 0)) : (b < a.maxMove && (b = a.maxMove), b > 0 && (b = 0)), b
        }

        function K(a, b) {
            return a.rtl ? "right" === b.directionX ? 1 : -1 : "left" === b.directionX ? 1 : -1
        }
        var L = b.Plugin("carousel", {
                widget: !0,
                defaults: {
                    autoAdvance: !1,
                    autoHeight: !1,
                    autoTime: 8e3,
                    contained: !0,
                    controls: !0,
                    customClass: "",
                    fill: !1,
                    infinite: !1,
                    labels: {
                        next: "Next",
                        previous: "Previous"
                    },
                    matchHeight: !1,
                    matchWidth: !0,
                    maxWidth: 1 / 0,
                    minWidth: "0px",
                    paged: !1,
                    pagination: !0,
                    rtl: !1,
                    show: 1,
                    single: !1,
                    theme: "fs-light",
                    useMargin: !1
                },
                classes: ["ltr", "rtl", "viewport", "wrapper", "container", "canister", "item", "item_previous", "item_next", "controls", "controls_custom", "control", "control_previous", "control_next", "pagination", "page", "animated", "enabled", "visible", "active", "auto_height", "contained", "single"],
                events: {
                    itemClick: "itemClick",
                    update: "update"
                },
                methods: {
                    _construct: e,
                    _destruct: f,
                    _resize: c,
                    disable: g,
                    enable: h,
                    jump: m,
                    previous: n,
                    next: o,
                    reset: k,
                    resize: i,
                    update: l,
                    panStart: B,
                    pan: C,
                    panEnd: D,
                    swipe: F
                }
            }),
            M = L.namespace,
            N = L.namespaceClean,
            O = L.classes,
            P = O.raw,
            Q = L.events,
            R = L.functions,
            S = [],
            T = b.transform,
            U = b.transition
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(b) {
            var c = this.closest("label"),
                d = c.length ? c.eq(0) : a("label[for=" + this.attr("id") + "]"),
                e = [p.base, b.theme, b.customClass].join(" "),
                f = "";
            b.radio = "radio" === this.attr("type"), b.group = this.attr("name"), f += '<div class="' + p.marker + '" aria-hidden="true">', f += '<div class="' + p.flag + '"></div>', b.toggle && (e += " " + p.toggle, f += '<span class="' + [p.state, p.state_on].join(" ") + '">' + b.labels.on + "</span>", f += '<span class="' + [p.state, p.state_off].join(" ") + '">' + b.labels.off + "</span>"), b.radio && (e += " " + p.radio), f += "</div>", b.$placeholder = a('<span class="' + p.element_placeholder + '"></span>'), this.before(b.$placeholder), d.length ? d.addClass(p.label).wrap('<div class="' + e + '"></div>').before(f) : this.before('<div class=" ' + e + '">' + f + "</div>"), b.$checkbox = d.length ? d.parents(o.base) : this.prev(o.base), b.$marker = b.$checkbox.find(o.marker), b.$states = b.$checkbox.find(o.state), b.$label = d, this.is(":checked") && b.$checkbox.addClass(p.checked), this.is(":disabled") && b.$checkbox.addClass(p.disabled), this.appendTo(b.$marker), this.on(q.focus, b, l).on(q.blur, b, m).on(q.change, b, i).on(q.click, b, h).on(q.deselect, b, k), b.$checkbox.on(q.click, b, h)
        }

        function d(a) {
            a.$checkbox.off(q.namespace), a.$marker.remove(), a.$states.remove(), a.$label.unwrap().removeClass(p.label), a.$placeholder.before(this), a.$placeholder.remove(), this.off(q.namespace)
        }

        function e(a) {
            this.prop("disabled", !1), a.$checkbox.removeClass(p.disabled)
        }

        function f(a) {
            this.prop("disabled", !0), a.$checkbox.addClass(p.disabled)
        }

        function g(a) {
            var b = a.$el.is(":disabled"),
                c = a.$el.is(":checked");
            b || (c ? j({
                data: a
            }) : k({
                data: a
            }))
        }

        function h(b) {
            b.stopPropagation();
            var c = b.data;
            a(b.target).is(c.$el) || (b.preventDefault(), c.$el.trigger("click"))
        }

        function i(a) {
            var b = a.data,
                c = b.$el.is(":disabled"),
                d = b.$el.is(":checked");
            c || (b.radio ? d && j(a) : d ? j(a) : k(a))
        }

        function j(b) {
            b.data.radio && a('input[name="' + b.data.group + '"]').not(b.data.$el).trigger("deselect"), b.data.$el.trigger(q.focus), b.data.$checkbox.addClass(p.checked)
        }

        function k(a) {
            a.data.$el.trigger(q.focus), a.data.$checkbox.removeClass(p.checked)
        }

        function l(a) {
            a.data.$checkbox.addClass(p.focus)
        }

        function m(a) {
            a.data.$checkbox.removeClass(p.focus)
        }
        var n = b.Plugin("checkbox", {
                widget: !0,
                defaults: {
                    customClass: "",
                    toggle: !1,
                    labels: {
                        on: "ON",
                        off: "OFF"
                    },
                    theme: "fs-light"
                },
                classes: ["element_placeholder", "label", "marker", "flag", "radio", "focus", "checked", "disabled", "toggle", "state", "state_on", "state_off"],
                methods: {
                    _construct: c,
                    _destruct: d,
                    enable: e,
                    disable: f,
                    update: g
                },
                events: {
                    deselect: "deselect"
                }
            }),
            o = n.classes,
            p = o.raw,
            q = n.events;
        n.functions
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(b, c, h) {
            if ("object" === a.type(b)) g = a.extend(g, b);
            else if (h = a.extend({}, g, h || {}), "undefined" !== a.type(b)) {
                if ("undefined" === a.type(c)) return e(b);
                null === c ? f(b, h) : d(b, c, h)
            }
            return null
        }

        function d(b, c, d) {
            var e = !1,
                f = new Date;
            d.expires && "number" === a.type(d.expires) && (f.setTime(f.getTime() + d.expires), e = f.toGMTString());
            var g = d.domain ? "; domain=" + d.domain : "",
                i = e ? "; expires=" + e : "",
                j = e ? "; max-age=" + d.expires / 1e3 : "",
                k = d.path ? "; path=" + d.path : "",
                l = d.secure ? "; secure" : "";
            h.cookie = b + "=" + c + i + j + g + k + l
        }

        function e(a) {
            for (var b = a + "=", c = h.cookie.split(";"), d = 0; d < c.length; d++) {
                for (var e = c[d];
                    " " === e.charAt(0);) e = e.substring(1, e.length);
                if (0 === e.indexOf(b)) return e.substring(b.length, e.length)
            }
            return null
        }

        function f(b, c) {
            d(b, "", a.extend({}, c, {
                expires: -6048e5
            })), console.log(h.cookie)
        }
        var g = (b.Plugin("cookie", {
                utilities: {
                    _delegate: c
                }
            }), {
                domain: null,
                expires: 6048e5,
                path: null,
                secure: null
            }),
            h = b.document
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./scrollbar", "./touch"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c() {
            H = b.$body
        }

        function d(c) {
            c.multiple = this.prop("multiple"), c.disabled = this.is(":disabled") || this.is("[readonly]"), c.lastIndex = !1, c.multiple ? c.links = !1 : c.external && (c.links = !0);
            var d = this.find("[selected]").not(":disabled"),
                e = this.find(":selected").not(":disabled"),
                f = e.text(),
                g = this.find("option").index(e);
            c.multiple || "" === c.label || d.length ? c.label = "" : (e = this.prepend('<option value="" class="' + B.item_placeholder + '" selected>' + c.label + "</option>"), f = c.label, g = 0);
            var h = this.find("option, optgroup"),
                k = h.filter("option"),
                l = a("[for=" + this.attr("id") + "]");
            c.tabIndex = this[0].tabIndex, this[0].tabIndex = -1, l.length && (l[0].tabIndex = -1);
            var m = [B.base, c.theme, c.customClass];
            c.mobile || b.isMobile ? m.push(B.mobile) : c.cover && m.push(B.cover), c.multiple && m.push(B.multiple), c.disabled && m.push(B.disabled), c.id = this.attr("id"), c.id ? c.ariaId = c.id : c.ariaId = c.rawGuid, c.ariaId += "-dropdown", c.selectedAriaId = c.ariaId + "-selected";
            var n = "",
                t = "";
            n += '<div class="' + m.join(" ") + '"id="' + c.ariaId + '" tabindex="' + c.tabIndex + '" role="listbox"', n += c.multiple ? ' aria-label="multi select"' : ' aria-haspopup="true" aria-live="polite" aria-labeledby="' + c.selectedAriaId + '"', n += "></div>", c.multiple || (t += '<button type="button" class="' + B.selected + '" id="' + c.selectedAriaId + '" tabindex="-1">', t += a("<span></span>").text(y(f, c.trim)).html(), t += "</button>"), t += '<div class="' + B.options + '">', t += "</div>", this.wrap(n).after(t), c.$dropdown = this.parent(A.base), c.$label = l, c.$allOptions = h, c.$options = k, c.$selected = c.$dropdown.find(A.selected), c.$wrapper = c.$dropdown.find(A.options), c.$placeholder = c.$dropdown.find(A.placeholder), c.index = -1, c.closed = !0, c.focused = !1, i(c), c.multiple || u(g, c), void 0 !== a.fn.fsScrollbar && c.$wrapper.fsScrollbar({
                theme: c.theme
            }).find(".fs-scrollbar-content").attr("tabindex", null), c.$dropdown.on(C.click, c, j), c.$selected.on(C.click, c, j), c.$dropdown.on(C.click, A.item, c, p).on(C.close, c, o), this.on(C.change, c, q), b.isMobile || (this.on(C.focusIn, c, function(a) {
                a.data.$dropdown.trigger(C.raw.focus)
            }), c.$dropdown.on(C.focusIn, c, r).on(C.focusOut, c, s))
        }

        function e(b) {
            b.$dropdown.hasClass(B.open) && b.$selected.trigger(C.click), void 0 !== a.fn.fsScrollbar && b.$wrapper.fsScrollbar("destroy"), b.$el[0].tabIndex = b.tabIndex, b.$label.length && (b.$label[0].tabIndex = b.tabIndex), b.$dropdown.off(C.namespace), b.$options.off(C.namespace), b.$placeholder.remove(), b.$selected.remove(), b.$wrapper.remove(), b.$el.off(C.namespace).show().unwrap()
        }

        function f(a, b) {
            if ("undefined" != typeof b) {
                var c = a.$items.index(a.$items.filter("[data-value=" + b + "]"));
                a.$items.eq(c).addClass(B.item_disabled), a.$options.eq(c).prop("disabled", !0)
            } else a.$dropdown.hasClass(B.open) && a.$selected.trigger(C.click), a.$dropdown.addClass(B.disabled), a.$el.prop("disabled", !0), a.disabled = !0
        }

        function g(a, b) {
            if ("undefined" != typeof b) {
                var c = a.$items.index(a.$items.filter("[data-value=" + b + "]"));
                a.$items.eq(c).removeClass(B.item_disabled), a.$options.eq(c).prop("disabled", !1)
            } else a.$dropdown.removeClass(B.disabled), a.$el.prop("disabled", !1), a.disabled = !1
        }

        function h(b) {
            void 0 !== a.fn.fsScrollbar && b.$wrapper.fsScrollbar("destroy");
            var c = b.index;
            b.$allOptions = b.$el.find("option, optgroup"), b.$options = b.$allOptions.filter("option"), b.index = -1, c = b.$options.index(b.$options.filter(":selected")), i(b), b.multiple || u(c, b), void 0 !== a.fn.fsScrollbar && b.$wrapper.fsScrollbar()
        }

        function i(b) {
            for (var c = "", d = 0, e = 0, f = b.$allOptions.length; f > e; e++) {
                var g = b.$allOptions.eq(e),
                    h = [];
                if ("OPTGROUP" === g[0].tagName) h.push(B.group), g.is(":disabled") && h.push(B.disabled), c += '<span class="' + h.join(" ") + '">' + g.attr("label") + "</span>";
                else {
                    var i = g.val(),
                        j = g.data("label"),
                        k = b.links ? "a" : 'button type="button"';
                    g.attr("value") || g.attr("value", i), h.push(B.item), g.hasClass(B.item_placeholder) && (h.push(B.item_placeholder), k = "span"), g.is(":selected") && h.push(B.item_selected), g.is(":disabled") && h.push(B.item_disabled), c += "<" + k + ' class="' + h.join(" ") + '"', b.links ? "span" === k ? c += ' aria-hidden="true"' : (c += ' href="' + i + '"', b.external && (c += ' target="_blank"')) : c += ' data-value="' + i + '"', c += ' role="option"', g.is(":selected") && (c += ' "aria-selected"="true"'), c += ">", c += j ? j : D.decodeEntities(y(g.text(), b.trim)), c += "</" + k + ">", d++
                }
            }
            b.$items = b.$wrapper.html(a.parseHTML(c)).find(A.item)
        }

        function j(a) {
            D.killEvent(a);
            var c = a.data;
            if (!c.disabled)
                if (c.mobile || !b.isMobile || b.isFirefoxMobile || b.isIEMobile) c.closed ? l(c) : m(c);
                else {
                    var d = c.$el[0];
                    if (G.createEvent) {
                        var e = G.createEvent("MouseEvents");
                        e.initMouseEvent("mousedown", !1, !0, E, 0, 0, 0, 0, 0, !1, !1, !1, !1, 0, null), d.dispatchEvent(e)
                    } else d.fireEvent && d.fireEvent("onmousedown")
                }
            k(c)
        }

        function k(b) {
            a(A.base).not(b.$dropdown).trigger(C.close, [b])
        }

        function l(a) {
            if (a.closed) {
                var b = F.height(),
                    c = a.$wrapper.outerHeight(!0),
                    d = a.$dropdown[0].getBoundingClientRect();
                d.bottom + c > b - a.bottomEdge && a.$dropdown.addClass(B.bottom), H.on(C.click + a.dotGuid, ":not(" + A.options + ")", a, n), a.$dropdown.trigger(C.focusIn), a.$dropdown.addClass(B.open), v(a), a.closed = !1
            }
        }

        function m(a) {
            a && !a.closed && (H.off(C.click + a.dotGuid), a.$dropdown.removeClass([B.open, B.bottom].join(" ")), a.closed = !0)
        }

        function n(b) {
            D.killEvent(b);
            var c = b.data;
            c && 0 === a(b.currentTarget).parents(A.base).length && (m(c), c.$dropdown.trigger(C.focusOut))
        }

        function o(a) {
            var b = a.data;
            b && (m(b), b.$dropdown.trigger(C.focusOut))
        }

        function p(b) {
            var c = a(this),
                d = b.data;
            if (D.killEvent(b), !d.disabled) {
                var e = d.$items.index(c);
                d.focusIndex = e, d.$wrapper.is(":visible") && (u(e, d, b.shiftKey, b.metaKey || b.ctrlKey), w(d)), d.multiple || m(d), d.$dropdown.trigger(C.focus)
            }
        }

        function q(b, c) {
            var d = (a(this), b.data);
            if (!c && !d.multiple) {
                var e = d.$options.index(d.$options.filter(":selected"));
                d.focusIndex = e, u(e, d), w(d, !0)
            }
        }

        function r(b) {
            D.killEvent(b);
            var c = (a(b.currentTarget), b.data);
            c.disabled || c.multiple || c.focused || (k(c), c.focused = !0, c.focusIndex = c.index, c.input = "", c.$dropdown.addClass(B.focus).on(C.keyDown + c.dotGuid, c, t))
        }

        function s(b) {
            D.killEvent(b);
            var c = (a(b.currentTarget), b.data);
            c.focused && c.closed && (c.focused = !1, c.$dropdown.removeClass(B.focus).off(C.keyDown + c.dotGuid), c.multiple || (m(c), c.index !== c.focusIndex && (w(c), c.focusIndex = c.index)))
        }

        function t(c) {
            var d = c.data;
            if (d.keyTimer = D.startTimer(d.keyTimer, 1e3, function() {
                    d.input = ""
                }), 13 === c.keyCode) d.closed || (m(d), u(d.index, d)), w(d);
            else if (!(9 === c.keyCode || c.metaKey || c.altKey || c.ctrlKey || c.shiftKey)) {
                D.killEvent(c);
                var e = d.$items.length - 1,
                    f = d.index < 0 ? 0 : d.index;
                if (a.inArray(c.keyCode, b.isFirefox ? [38, 40, 37, 39] : [38, 40]) > -1) f += 38 === c.keyCode || b.isFirefox && 37 === c.keyCode ? -1 : 1, 0 > f && (f = 0), f > e && (f = e);
                else {
                    var g, h, i = String.fromCharCode(c.keyCode).toUpperCase();
                    for (d.input += i, h = d.index + 1; e >= h; h++)
                        if (g = d.$options.eq(h).text().substr(0, d.input.length).toUpperCase(), g === d.input) {
                            f = h;
                            break
                        }
                    if (0 > f || f === d.index)
                        for (h = 0; e >= h; h++)
                            if (g = d.$options.eq(h).text().substr(0, d.input.length).toUpperCase(), g === d.input) {
                                f = h;
                                break
                            }
                }
                f >= 0 && (u(f, d), v(d))
            }
        }

        function u(a, c, d, e) {
            var f = c.$items.eq(a),
                g = c.$options.eq(a),
                h = f.hasClass(B.item_selected),
                i = f.hasClass(B.item_disabled);
            if (!i)
                if (c.multiple)
                    if (b.isMobile) i || (h ? (g.prop("selected", null).attr("aria-selected", null), f.removeClass(B.item_selected)) : (g.prop("selected", !0).attr("aria-selected", !0), f.addClass(B.item_selected)));
                    else if (d && c.lastIndex !== !1) {
                var j = c.lastIndex > a ? a : c.lastIndex,
                    k = (c.lastIndex > a ? c.lastIndex : a) + 1;
                c.$options.prop("selected", null).attr("aria-selected", null), c.$items.filter(A.item_selected).removeClass(B.item_selected), c.$options.slice(j, k).not("[disabled]").prop("selected", !0), c.$items.slice(j, k).not(A.item_disabled).addClass(B.item_selected)
            } else e ? (h ? (g.prop("selected", null).attr("aria-selected", null), f.removeClass(B.item_selected)) : (g.prop("selected", !0).attr("aria-selected", !0), f.addClass(B.item_selected)), c.lastIndex = a) : (c.$options.prop("selected", null).attr("aria-selected", null), c.$items.filter(A.item_selected).removeClass(B.item_selected), g.prop("selected", !0).attr("aria-selected", !0), f.addClass(B.item_selected), c.lastIndex = a);
            else if (a > -1 && a < c.$items.length) {
                if (a !== c.index) {
                    var l = g.data("label") || f.html();
                    c.$selected.html(l).removeClass(A.item_placeholder), c.$items.filter(A.item_selected).removeClass(B.item_selected), c.$el[0].selectedIndex = a, f.addClass(B.item_selected), c.index = a
                }
            } else "" !== c.label && c.$selected.html(c.label)
        }

        function v(b) {
            var c = b.$items.eq(b.index),
                d = b.index >= 0 && !c.hasClass(B.item_placeholder) ? c.position() : {
                    left: 0,
                    top: 0
                },
                e = (b.$wrapper.outerHeight() - c.outerHeight()) / 2;
            void 0 !== a.fn.fsScrollbar ? b.$wrapper.fsScrollbar("resize").fsScrollbar("scroll", b.$wrapper.find(".fs-scrollbar-content").scrollTop() + d.top) : b.$wrapper.scrollTop(b.$wrapper.scrollTop() + d.top - e)
        }

        function w(a, b) {
            a.links ? x(a) : b || a.$el.trigger(C.raw.change, [!0])
        }

        function x(a) {
            var b = a.$el.val();
            a.external ? E.open(b) : E.location.href = b
        }

        function y(a, b) {
            return 0 === b ? a : a.length > b ? a.substring(0, b) + "..." : a
        }
        var z = b.Plugin("dropdown", {
                widget: !0,
                defaults: {
                    bottomEdge: 0,
                    cover: !1,
                    customClass: "",
                    label: "",
                    external: !1,
                    links: !1,
                    mobile: !1,
                    theme: "fs-light",
                    trim: 0
                },
                methods: {
                    _setup: c,
                    _construct: d,
                    _destruct: e,
                    disable: f,
                    enable: g,
                    update: h,
                    open: l,
                    close: m
                },
                classes: ["cover", "bottom", "multiple", "mobile", "open", "disabled", "focus", "selected", "options", "group", "item", "item_disabled", "item_selected", "item_placeholder"],
                events: {
                    close: "close"
                }
            }),
            A = z.classes,
            B = A.raw,
            C = z.events,
            D = z.functions,
            E = b.window,
            F = b.$window,
            G = b.document,
            H = null
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./mediaquery"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(a) {
            n.iterate.call(o, g)
        }

        function d() {
            o = a(l.element)
        }

        function e(b) {
            b.maxWidth = b.maxWidth === 1 / 0 ? "100000px" : b.maxWidth, b.mq = "(min-width:" + b.minWidth + ") and (max-width:" + b.maxWidth + ")", b.type = "height" === b.property ? "outerHeight" : "outerWidth", b.target ? a.isArray(b.target) || (b.target = [b.target]) : b.target = ["> *"], d(), a.fsMediaquery("bind", b.rawGuid, b.mq, {
                enter: function() {
                    i.call(b.$el, b)
                },
                leave: function() {
                    h.call(b.$el, b)
                }
            })
        }

        function f(b) {
            j(b), a.fsMediaquery("unbind", b.rawGuid), d()
        }

        function g(a) {
            if (a.data && (a = a.data), a.enabled)
                for (var b, c, d, e = 0; e < a.target.length; e++) {
                    b = 0, c = 0, d = a.$el.find(a.target[e]), d.css(a.property, "");
                    for (var f = 0; f < d.length; f++) c = d.eq(f)[a.type](), c > b && (b = c);
                    d.css(a.property, b)
                }
        }

        function h(a) {
            a.enabled && (a.enabled = !1, j(a))
        }

        function i(a) {
            if (!a.enabled) {
                a.enabled = !0;
                var b = a.$el.find("img");
                b.length && b.on(m.load, a, g), g(a)
            }
        }

        function j(a) {
            for (var b = 0; b < a.target.length; b++) a.$el.find(a.target[b]).css(a.property, "");
            a.$el.find("img").off(m.namespace)
        }
        var k = b.Plugin("equalize", {
                widget: !0,
                priority: 5,
                defaults: {
                    maxWidth: 1 / 0,
                    minWidth: "0px",
                    property: "height",
                    target: null
                },
                methods: {
                    _construct: e,
                    _destruct: f,
                    _resize: c,
                    resize: g
                }
            }),
            l = k.classes,
            m = (l.raw, k.events),
            n = k.functions,
            o = []
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./touch", "./transition"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c() {
            da = b.$body, ea = a("html, body"), fa = b.window.location.hash.replace("#", "")
        }

        function d() {
            ha && i()
        }

        function e(a) {
            this.on(_.click, a, h);
            var b = this.data(X + "-gallery");
            !ga && fa && b === fa && (ga = !0, this.trigger(_.click))
        }

        function f(a) {
            j(), this.off(_.namespace)
        }

        function g(b, c) {
            b instanceof a && h.apply(ba, [{
                data: a.extend(!0, {}, {
                    $object: b
                }, Y, c || {})
            }])
        }

        function h(c) {
            if (!ha) {
                var d = c.data;
                ha = a.extend({}, {
                    visible: !1,
                    gallery: {
                        active: !1
                    },
                    isMobile: b.isMobile || d.mobile,
                    isTouch: b.support.touch,
                    isAnimating: !0,
                    oldContentHeight: 0,
                    oldContentWidth: 0,
                    metaHeight: 0,
                    thumbnailHeight: 0,
                    captionOpen: !1,
                    thumbnailsOpen: !1
                }, d);
                var e = d.$el,
                    f = d.$object,
                    g = e && e[0].href ? e[0].href || "" : "",
                    h = e && e[0].hash ? e[0].hash || "" : "",
                    i = (g.toLowerCase().split(".").pop().split(/\#|\?/), e ? e.data(X + "-type") : ""),
                    k = "image" === i || g.match(d.fileTypes) || "data:image" === g.substr(0, 10),
                    l = U(g),
                    n = "url" === i || !k && !l && "http" === g.substr(0, 4) && !h,
                    p = "element" === i || !k && !l && !n && "#" === h.substr(0, 1),
                    q = "undefined" != typeof f;
                if (p && (g = h), !(k || l || n || p || q)) return void(ha = null);
                if (aa.killEvent(c), ha.touch = d.touch && ha.isMobile && ha.isTouch, ha.margin *= 2, k ? ha.type = "image" : l ? ha.type = "video" : ha.type = "element", k || l) {
                    var s = e.data(X + "-gallery");
                    s && (ha.gallery.active = !0, ha.gallery.id = s, ha.gallery.$items = a("a[data-lightbox-gallery= " + ha.gallery.id + "], a[rel= " + ha.gallery.id + "]"), ha.gallery.index = ha.gallery.$items.index(ha.$el), ha.gallery.total = ha.gallery.$items.length - 1)
                }
                ha.thumbnails && (k || l) && ha.gallery.active || (ha.thumbnails = !1);
                var u = "";
                ha.isMobile || (u += '<div class="' + [$.overlay, ha.theme, ha.customClass].join(" ") + '"></div>');
                var v = [$.base, $.loading, $.animating, ha.theme, ha.customClass];
                if (ha.fixed && v.push($.fixed), ha.isMobile && v.push($.mobile), ha.isTouch && v.push($.touch), n && v.push($.iframed), (p || q) && v.push($.inline), ha.thumbnails && v.push($.thumbnailed), u += '<div class="' + v.join(" ") + '" role="dialog" aria-label="lightbox" tabindex="-1">', u += '<button type="button" class="' + $.close + '">' + ha.labels.close + "</button>", u += '<span class="' + $.loading_icon + '"></span>', u += '<div class="' + $.container + '">', ha.gallery.active && ha.thumbnails) {
                    u += '<div class="' + [$.thumbnails] + '">', u += '<div class="' + [$.thumbnail_container] + '">';
                    for (var w, x, y = 0, z = ha.gallery.$items.length; z > y; y++) w = ha.gallery.$items.eq(y), x = w.data("lightbox-thumbnail"), x || (x = w.find("img").attr("src")), u += '<button class="' + [$.thumbnail_item] + '">', u += '<img src="' + x + '" alt="">', u += "</button>";
                    u += "</div></div>"
                }
                u += '<div class="' + $.content + '"></div>', (k || l) && (u += '<div class="' + $.tools + '">', u += '<div class="' + $.controls + '">', ha.gallery.active && (u += '<button type="button" class="' + [$.control, $.control_previous].join(" ") + '">' + ha.labels.previous + "</button>", u += '<button type="button" class="' + [$.control, $.control_next].join(" ") + '">' + ha.labels.next + "</button>"), ha.isMobile && ha.isTouch && (u += '<button type="button" class="' + [$.toggle, $.caption_toggle].join(" ") + '">' + ha.labels.captionClosed + "</button>", ha.gallery.active && ha.thumbnails && (u += '<button type="button" class="' + [$.toggle, $.thumbnail_toggle].join(" ") + '">' + ha.labels.thumbnailsClosed + "</button>")),
                    u += "</div>", u += '<div class="' + $.meta + '">', u += '<div class="' + $.meta_content + '">', ha.gallery.active && (u += '<p class="' + $.position + '"', ha.gallery.total < 1 && (u += ' style="display: none;"'), u += ">", u += '<span class="' + $.position_current + '">' + (ha.gallery.index + 1) + "</span> ", u += ha.labels.count, u += ' <span class="' + $.position_total + '">' + (ha.gallery.total + 1) + "</span>", u += "</p>"), u += '<div class="' + $.caption + '">', u += ha.formatter.call(e, d), u += "</div></div></div>", u += "</div>"), u += "</div></div>", da.append(u), ha.$overlay = a(Z.overlay), ha.$lightbox = a(Z.base), ha.$close = a(Z.close), ha.$container = a(Z.container), ha.$content = a(Z.content), ha.$tools = a(Z.tools), ha.$meta = a(Z.meta), ha.$metaContent = a(Z.meta_content), ha.$position = a(Z.position), ha.$caption = a(Z.caption), ha.$controlBox = a(Z.controls), ha.$controls = a(Z.control), ha.$thumbnails = a(Z.thumbnails), ha.$thumbnailContainer = a(Z.thumbnail_container), ha.$thumbnailItems = a(Z.thumbnail_item), ha.isMobile ? (ha.paddingVertical = ha.$close.outerHeight(), ha.paddingHorizontal = 0, ha.mobilePaddingVertical = parseInt(ha.$content.css("paddingTop"), 10) + parseInt(ha.$content.css("paddingBottom"), 10), ha.mobilePaddingHorizontal = parseInt(ha.$content.css("paddingLeft"), 10) + parseInt(ha.$content.css("paddingRight"), 10)) : (ha.paddingVertical = parseInt(ha.$lightbox.css("paddingTop"), 10) + parseInt(ha.$lightbox.css("paddingBottom"), 10), ha.paddingHorizontal = parseInt(ha.$lightbox.css("paddingLeft"), 10) + parseInt(ha.$lightbox.css("paddingRight"), 10), ha.mobilePaddingVertical = 0, ha.mobilePaddingHorizontal = 0), ha.contentHeight = ha.$lightbox.outerHeight() - ha.paddingVertical, ha.contentWidth = ha.$lightbox.outerWidth() - ha.paddingHorizontal, ha.controlHeight = ha.$controls.outerHeight(), m(), ha.gallery.active && (ha.$lightbox.addClass($.has_controls), L()), ca.on(_.keyDown, M), da.on(_.click, [Z.overlay, Z.close].join(", "), j).on([_.focus, _.focusIn].join(" "), V), ha.gallery.active && ha.$lightbox.on(_.click, Z.control, G), ha.thumbnails && ha.$lightbox.on(_.click, Z.thumbnail_item, H), ha.isMobile && ha.isTouch && ha.$lightbox.on(_.click, Z.caption_toggle, o).on(_.click, Z.thumbnail_toggle, r), ha.$lightbox.fsTransition({
                    property: "opacity"
                }, function() {
                    k ? t(g) : l ? D(g) : n ? P(g) : p ? N(g) : q && Q(ha.$object)
                }).addClass($.open), ha.$overlay.addClass($.open)
            }
        }

        function i(a) {
            "object" != typeof a && (ha.targetHeight = arguments[0], ha.targetWidth = arguments[1]), "element" === ha.type ? R(ha.$content.find("> :first-child")) : "image" === ha.type ? z() : "video" === ha.type && E(), l()
        }

        function j(a) {
            aa.killEvent(a), ha && (ha.$lightbox.fsTransition("destroy"), ha.$content.fsTransition("destroy"), u(), ha.$lightbox.addClass($.animating).fsTransition({
                property: "opacity"
            }, function(a) {
                "undefined" != typeof ha.$inlineTarget && ha.$inlineTarget.length && O(), ha.$lightbox.off(_.namespace), ha.$container.off(_.namespace), ca.off(_.keyDown), da.off(_.namespace), da.off(_.namespace), ha.$overlay.remove(), ha.$lightbox.remove(), ha.$el.focus(), ha = null, ca.trigger(_.close)
            }), ha.$lightbox.removeClass($.open), ha.$overlay.removeClass($.open), ha.isMobile && ea.removeClass($.lock))
        }

        function k() {
            var a = n();
            ha.isMobile ? 0 : ha.duration, ha.isMobile || ha.$controls.css({
                marginTop: (ha.contentHeight - ha.controlHeight - ha.metaHeight + ha.thumbnailHeight) / 2
            }), "" === ha.$caption.html() ? (ha.$caption.hide(), ha.$lightbox.removeClass($.has_caption), ha.gallery.active || ha.$tools.hide()) : (ha.$caption.show(), ha.$lightbox.addClass($.has_caption)), ha.$lightbox.fsTransition({
                property: ha.contentHeight !== ha.oldContentHeight ? "height" : "width"
            }, function() {
                ha.$content.fsTransition({
                    property: "opacity"
                }, function() {
                    ha.$lightbox.removeClass($.animating), ha.isAnimating = !1
                }), ha.$lightbox.removeClass($.loading).addClass($.ready), ha.visible = !0, ca.trigger(_.open), ha.gallery.active && (F(), I(), J()), ha.$lightbox.focus()
            }), ha.isMobile || ha.$lightbox.css({
                height: ha.contentHeight + ha.paddingVertical,
                width: ha.contentWidth + ha.paddingHorizontal,
                top: ha.fixed ? 0 : a.top
            });
            var b = ha.oldContentHeight !== ha.contentHeight || ha.oldContentWidth !== ha.contentWidth;
            !ha.isMobile && b || ha.$lightbox.fsTransition("resolve"), ha.oldContentHeight = ha.contentHeight, ha.oldContentWidth = ha.contentWidth, ha.isMobile && ea.addClass($.lock)
        }

        function l() {
            if (ha.visible && !ha.isMobile) {
                var a = n();
                ha.$controls.css({
                    marginTop: (ha.contentHeight - ha.controlHeight - ha.metaHeight + ha.thumbnailHeight) / 2
                }), ha.$lightbox.css({
                    height: ha.contentHeight + ha.paddingVertical,
                    width: ha.contentWidth + ha.paddingHorizontal,
                    top: ha.fixed ? 0 : a.top
                }), ha.oldContentHeight = ha.contentHeight, ha.oldContentWidth = ha.contentWidth
            }
        }

        function m() {
            var a = n();
            ha.$lightbox.css({
                top: ha.fixed ? 0 : a.top
            })
        }

        function n() {
            if (ha.isMobile) return {
                left: 0,
                top: 0
            };
            var a = {
                left: (b.windowWidth - ha.contentWidth - ha.paddingHorizontal) / 2,
                top: ha.top <= 0 ? (b.windowHeight - ha.contentHeight - ha.paddingVertical) / 2 : ha.top
            };
            return ha.fixed !== !0 && (a.top += ca.scrollTop()), a
        }

        function o(a) {
            if (aa.killEvent(a), ha.captionOpen) p();
            else {
                s();
                var b = parseInt(ha.$metaContent.outerHeight(!0));
                b += parseInt(ha.$meta.css("padding-top")), b += parseInt(ha.$meta.css("padding-bottom")), ha.$meta.css({
                    height: b
                }), ha.$lightbox.addClass($.caption_open).find(Z.caption_toggle).text(ha.labels.captionOpen), ha.captionOpen = !0
            }
        }

        function p() {
            ha.$lightbox.removeClass($.caption_open).find(Z.caption_toggle).text(ha.labels.captionClosed), ha.captionOpen = !1
        }

        function q() {
            var a = this.attr("title"),
                b = void 0 !== a && a ? a.replace(/^\s+|\s+$/g, "") : !1;
            return b ? '<p class="caption">' + b + "</p>" : ""
        }

        function r(a) {
            aa.killEvent(a), ha.thumbnailsOpen ? s() : (p(), ha.$lightbox.addClass($.thumbnails_open).find(Z.thumbnail_toggle).text(ha.labels.thumbnailsOpen), ha.thumbnailsOpen = !0)
        }

        function s() {
            ha.$lightbox.removeClass($.thumbnails_open).find(Z.thumbnail_toggle).text(ha.labels.thumbnailsClosed), ha.thumbnailsOpen = !1
        }

        function t(b) {
            ha.hasScaled = !1, ha.$imageContainer = a('<div class="' + $.image_container + '"><img></div>'), ha.$image = ha.$imageContainer.find("img"), ha.$image.one(_.load, function() {
                var a = T(ha.$image);
                ha.naturalHeight = a.naturalHeight, ha.naturalWidth = a.naturalWidth, ha.retina && (ha.naturalHeight /= 2, ha.naturalWidth /= 2), ha.$content.prepend(ha.$imageContainer), z(), k(), ha.touch && (v(), x({
                    scale: 1,
                    deltaX: 0,
                    deltaY: 0
                }), y(), ha.$content.fsTouch({
                    pan: !0,
                    scale: !0
                }).on(_.scaleStart, w).on(_.scaleEnd, y).on(_.scale, x))
            }).error(S).attr("src", b).addClass($.image), (ha.$image[0].complete || 4 === ha.$image[0].readyState) && ha.$image.trigger(_.load)
        }

        function u() {
            ha.$image && ha.$image.length && ha.$content.fsTouch("destroy")
        }

        function v() {
            ha.scalePosition = ha.$imageContainer.position(), ha.scaleY = ha.scalePosition.top, ha.scaleX = ha.scalePosition.left, ha.scaleHeight = ha.$image.outerHeight(), ha.scaleWidth = ha.$image.outerWidth()
        }

        function w(a) {
            v(), ha.$lightbox.addClass($.scaling)
        }

        function x(a) {
            ha.targetContainerY = ha.scaleY + a.deltaY, ha.targetContainerX = ha.scaleX + a.deltaX, ha.targetImageHeight = ha.scaleHeight * a.scale, ha.targetImageWidth = ha.scaleWidth * a.scale, ha.targetImageHeight < ha.scaleMinHeight && (ha.targetImageHeight = ha.scaleMinHeight), ha.targetImageHeight > ha.scaleMaxHeight && (ha.targetImageHeight = ha.scaleMaxHeight), ha.targetImageWidth < ha.scaleMinWidth && (ha.targetImageWidth = ha.scaleMinWidth), ha.targetImageWidth > ha.scaleMaxWidth && (ha.targetImageWidth = ha.scaleMaxWidth), ha.hasScaled = !0, ha.isScaling = !0, ha.$imageContainer.css({
                top: ha.targetContainerY,
                left: ha.targetContainerX
            }), ha.$image.css({
                height: ha.targetImageHeight,
                width: ha.targetImageWidth,
                top: -(ha.targetImageHeight / 2),
                left: -(ha.targetImageWidth / 2)
            })
        }

        function y(a) {
            v(), ha.isScaling = !1;
            var b = ha.$container.outerHeight() - ha.metaHeight,
                c = ha.$container.outerWidth();
            ha.scaleMinY = b - ha.scaleHeight / 2, ha.scaleMinX = c - ha.scaleWidth / 2, ha.scaleMaxY = ha.scaleHeight / 2, ha.scaleMaxX = ha.scaleWidth / 2, ha.scaleHeight < b ? ha.scalePosition.top = b / 2 : (ha.scalePosition.top < ha.scaleMinY && (ha.scalePosition.top = ha.scaleMinY), ha.scalePosition.top > ha.scaleMaxY && (ha.scalePosition.top = ha.scaleMaxY)), ha.scaleWidth < c ? ha.scalePosition.left = c / 2 : (ha.scalePosition.left < ha.scaleMinX && (ha.scalePosition.left = ha.scaleMinX), ha.scalePosition.left > ha.scaleMaxX && (ha.scalePosition.left = ha.scaleMaxX)), ha.$lightbox.removeClass($.scaling), ha.$imageContainer.css({
                left: ha.scalePosition.left,
                top: ha.scalePosition.top
            })
        }

        function z() {
            if (ha.$image) {
                var a = 0;
                for (ha.windowHeight = ha.viewportHeight = b.windowHeight - ha.mobilePaddingVertical - ha.paddingVertical, ha.windowWidth = ha.viewportWidth = b.windowWidth - ha.mobilePaddingHorizontal - ha.paddingHorizontal, ha.contentHeight = 1 / 0, ha.contentWidth = 1 / 0, ha.imageMarginTop = 0, ha.imageMarginLeft = 0; ha.contentHeight > ha.viewportHeight && 2 > a;) ha.imageHeight = 0 === a ? ha.naturalHeight : ha.$image.outerHeight(), ha.imageWidth = 0 === a ? ha.naturalWidth : ha.$image.outerWidth(), ha.metaHeight = 0 === a ? 0 : ha.metaHeight, ha.spacerHeight = 0 === a ? 0 : ha.spacerHeight, ha.thumbnailHeight = 0 === a ? 0 : ha.thumbnailHeight, 0 === a && (ha.ratioHorizontal = ha.imageHeight / ha.imageWidth, ha.ratioVertical = ha.imageWidth / ha.imageHeight, ha.isWide = ha.imageWidth > ha.imageHeight), ha.imageHeight < ha.minHeight && (ha.minHeight = ha.imageHeight), ha.imageWidth < ha.minWidth && (ha.minWidth = ha.imageWidth), ha.isMobile ? (ha.isTouch ? (ha.$controlBox.css({
                    width: b.windowWidth
                }), ha.spacerHeight = ha.$controls.outerHeight(!0)) : (ha.$tools.css({
                    width: b.windowWidth
                }), ha.spacerHeight = ha.$tools.outerHeight(!0)), ha.spacerHeight += ha.$thumbnails.outerHeight(!0) + 10, ha.contentHeight = ha.viewportHeight, ha.contentWidth = ha.viewportWidth, A(), ha.imageMarginTop = (ha.contentHeight - ha.targetImageHeight - ha.spacerHeight) / 2, ha.imageMarginLeft = (ha.contentWidth - ha.targetImageWidth) / 2) : (0 === a && (ha.viewportHeight -= ha.margin + ha.paddingVertical, ha.viewportWidth -= ha.margin + ha.paddingHorizontal), ha.viewportHeight -= ha.metaHeight, ha.thumbnails && (ha.viewportHeight -= ha.thumbnailHeight), A(), ha.contentHeight = ha.targetImageHeight, ha.contentWidth = ha.targetImageWidth), ha.isMobile || ha.isTouch || ha.$meta.css({
                    width: ha.contentWidth
                }), ha.hasScaled || (ha.$image.css({
                    height: ha.targetImageHeight,
                    width: ha.targetImageWidth
                }), ha.touch ? ha.$image.css({
                    top: -(ha.targetImageHeight / 2),
                    left: -(ha.targetImageWidth / 2)
                }) : ha.$image.css({
                    marginTop: ha.imageMarginTop,
                    marginLeft: ha.imageMarginLeft
                })), ha.isMobile || (ha.metaHeight = ha.$meta.outerHeight(!0), ha.contentHeight += ha.metaHeight), ha.thumbnails && (ha.thumbnailHeight = ha.$thumbnails.outerHeight(!0), ha.contentHeight += ha.thumbnailHeight), a++;
                ha.touch && (ha.scaleMinHeight = ha.targetImageHeight, ha.scaleMinWidth = ha.targetImageWidth, ha.scaleMaxHeight = ha.naturalHeight, ha.scaleMaxWidth = ha.naturalWidth)
            }
        }

        function A() {
            var a = ha.isMobile ? ha.contentHeight - ha.spacerHeight : ha.viewportHeight,
                b = ha.isMobile ? ha.contentWidth : ha.viewportWidth;
            ha.isWide ? (ha.targetImageWidth = b, ha.targetImageHeight = ha.targetImageWidth * ha.ratioHorizontal, ha.targetImageHeight > a && (ha.targetImageHeight = a, ha.targetImageWidth = ha.targetImageHeight * ha.ratioVertical)) : (ha.targetImageHeight = a, ha.targetImageWidth = ha.targetImageHeight * ha.ratioVertical, ha.targetImageWidth > b && (ha.targetImageWidth = b, ha.targetImageHeight = ha.targetImageWidth * ha.ratioHorizontal)), (ha.targetImageWidth > ha.imageWidth || ha.targetImageHeight > ha.imageHeight) && (ha.targetImageHeight = ha.imageHeight, ha.targetImageWidth = ha.imageWidth), (ha.targetImageWidth < ha.minWidth || ha.targetImageHeight < ha.minHeight) && (ha.targetImageWidth < ha.minWidth ? (ha.targetImageWidth = ha.minWidth, ha.targetImageHeight = ha.targetImageWidth * ha.ratioHorizontal) : (ha.targetImageHeight = ha.minHeight, ha.targetImageWidth = ha.targetImageHeight * ha.ratioVertical))
        }

        function B(a) {
            return "//www.youtube.com/embed/" + a[1]
        }

        function C(a) {
            return "//player.vimeo.com/video/" + a[3]
        }

        function D(b) {
            var c = U(b),
                d = b.split("?");
            c ? (d.length >= 2 && (c += "?" + d.slice(1)[0].trim()), ha.$videoWrapper = a('<div class="' + $.video_wrapper + '"></div>'), ha.$video = a('<iframe class="' + $.video + '" frameborder="0" seamless="seamless" allowfullscreen></iframe>'), ha.$video.attr("src", c).addClass($.video).prependTo(ha.$videoWrapper), ha.$content.prepend(ha.$videoWrapper), E(), k()) : S()
        }

        function E() {
            ha.windowHeight = ha.viewportHeight = b.windowHeight - ha.mobilePaddingVertical - ha.paddingVertical, ha.windowWidth = ha.viewportWidth = b.windowWidth - ha.mobilePaddingHorizontal - ha.paddingHorizontal, ha.videoMarginTop = 0, ha.videoMarginLeft = 0, ha.isMobile ? (ha.isTouch ? (ha.$controlBox.css({
                width: b.windowWidth
            }), ha.spacerHeight = ha.$controls.outerHeight(!0)) : (ha.$tools.css({
                width: b.windowWidth
            }), ha.spacerHeight = ha.$tools.outerHeight(!0)), ha.spacerHeight = ha.$thumbnails.outerHeight(!0) + 10, ha.viewportHeight -= ha.spacerHeight, ha.targetVideoWidth = ha.viewportWidth, ha.targetVideoHeight = ha.targetVideoWidth * ha.videoRatio, ha.targetVideoHeight > ha.viewportHeight && (ha.targetVideoHeight = ha.viewportHeight, ha.targetVideoWidth = ha.targetVideoHeight / ha.videoRatio), ha.videoMarginTop = (ha.viewportHeight - ha.targetVideoHeight) / 2, ha.videoMarginLeft = (ha.viewportWidth - ha.targetVideoWidth) / 2) : (ha.viewportHeight = ha.windowHeight - ha.margin, ha.viewportWidth = ha.windowWidth - ha.margin, ha.targetVideoWidth = ha.videoWidth > ha.viewportWidth ? ha.viewportWidth : ha.videoWidth, ha.targetVideoWidth < ha.minWidth && (ha.targetVideoWidth = ha.minWidth), ha.targetVideoHeight = ha.targetVideoWidth * ha.videoRatio, ha.contentHeight = ha.targetVideoHeight, ha.contentWidth = ha.targetVideoWidth), ha.isMobile || ha.isTouch || ha.$meta.css({
                width: ha.contentWidth
            }), ha.$videoWrapper.css({
                height: ha.targetVideoHeight,
                width: ha.targetVideoWidth,
                marginTop: ha.videoMarginTop,
                marginLeft: ha.videoMarginLeft
            }), ha.isMobile || (ha.metaHeight = ha.$meta.outerHeight(!0), ha.contentHeight += ha.metaHeight), ha.thumbnails && (ha.thumbnailHeight = ha.$thumbnails.outerHeight(!0), ha.contentHeight += ha.thumbnailHeight)
        }

        function F(b) {
            var c = "";
            ha.gallery.index > 0 && (c = ha.gallery.$items.eq(ha.gallery.index - 1).attr("href"), U(c) || a('<img src="' + c + '">')), ha.gallery.index < ha.gallery.total && (c = ha.gallery.$items.eq(ha.gallery.index + 1).attr("href"), U(c) || a('<img src="' + c + '">'))
        }

        function G(b) {
            aa.killEvent(b);
            var c = a(b.currentTarget);
            ha.isAnimating || c.hasClass($.control_disabled) || (ha.isAnimating = !0, u(), p(), ha.gallery.index += c.hasClass($.control_next) ? 1 : -1, ha.gallery.index > ha.gallery.total && (ha.gallery.index = ha.infinite ? 0 : ha.gallery.total), ha.gallery.index < 0 && (ha.gallery.index = ha.infinite ? ha.gallery.total : 0), I(), ha.$lightbox.addClass($.animating), ha.$content.fsTransition({
                property: "opacity"
            }, K), ha.$lightbox.addClass($.loading))
        }

        function H(b) {
            aa.killEvent(b);
            var c = a(b.currentTarget);
            ha.isAnimating || c.hasClass($.active) || (ha.isAnimating = !0, u(), p(), ha.gallery.index = ha.$thumbnailItems.index(c), I(), ha.$lightbox.addClass($.animating), ha.$content.fsTransition({
                property: "opacity"
            }, K), ha.$lightbox.addClass($.loading))
        }

        function I() {
            if (ha.thumbnails) {
                var a = ha.$thumbnailItems.eq(ha.gallery.index);
                ha.$thumbnailItems.removeClass($.active), a.addClass($.active)
            }
        }

        function J() {
            if (ha.thumbnails) {
                var a = ha.$thumbnailItems.eq(ha.gallery.index),
                    b = a.position().left + a.outerWidth(!1) / 2 - ha.$thumbnailContainer.outerWidth(!0) / 2;
                ha.$thumbnailContainer.stop().animate({
                    scrollLeft: b
                }, 200, "linear")
            }
        }

        function K() {
            "undefined" != typeof ha.$imageContainer && ha.$imageContainer.remove(), "undefined" != typeof ha.$videoWrapper && ha.$videoWrapper.remove(), ha.$el = ha.gallery.$items.eq(ha.gallery.index), ha.$caption.html(ha.formatter.call(ha.$el, ha)), ha.$position.find(Z.position_current).html(ha.gallery.index + 1);
            var a = ha.$el.attr("href"),
                b = U(a);
            b ? (ha.type = "video", D(a)) : (ha.type = "image", t(a)), L()
        }

        function L() {
            ha.$controls.removeClass($.control_disabled), ha.infinite || (0 === ha.gallery.index && ha.$controls.filter(Z.control_previous).addClass($.control_disabled), ha.gallery.index === ha.gallery.total && ha.$controls.filter(Z.control_next).addClass($.control_disabled))
        }

        function M(a) {
            !ha.gallery.active || 37 !== a.keyCode && 39 !== a.keyCode ? 27 === a.keyCode && ha.$close.trigger(_.click) : (aa.killEvent(a), ha.$controls.filter(37 === a.keyCode ? Z.control_previous : Z.control_next).trigger(_.click))
        }

        function N(b) {
            ha.$inlineTarget = a(b), ha.$inlineContents = ha.$inlineTarget.children().detach(), Q(ha.$inlineContents)
        }

        function O() {
            ha.$inlineTarget.append(ha.$inlineContents.detach())
        }

        function P(b) {
            b += b.indexOf("?") > -1 ? "&" + ha.requestKey + "=true" : "?" + ha.requestKey + "=true";
            var c = a('<iframe class="' + $.iframe + '" src="' + b + '"></iframe>');
            Q(c)
        }

        function Q(a) {
            ha.$content.append(a), R(a), k()
        }

        function R(a) {
            ha.windowHeight = b.windowHeight - ha.mobilePaddingVertical - ha.paddingVertical, ha.windowWidth = b.windowWidth - ha.mobilePaddingHorizontal - ha.paddingHorizontal, ha.objectHeight = a.outerHeight(!0), ha.objectWidth = a.outerWidth(!0), ha.targetHeight = ha.targetHeight || (ha.$el ? ha.$el.data(X + "-height") : null), ha.targetWidth = ha.targetWidth || (ha.$el ? ha.$el.data(X + "-width") : null), ha.maxHeight = ha.windowHeight < 0 ? ha.minHeight : ha.windowHeight, ha.isIframe = a.is("iframe"), ha.objectMarginTop = 0, ha.objectMarginLeft = 0, ha.isMobile || (ha.windowHeight -= ha.margin, ha.windowWidth -= ha.margin), ha.contentHeight = ha.targetHeight ? ha.targetHeight : ha.isIframe || ha.isMobile ? ha.windowHeight : ha.objectHeight, ha.contentWidth = ha.targetWidth ? ha.targetWidth : ha.isIframe || ha.isMobile ? ha.windowWidth : ha.objectWidth, (ha.isIframe || ha.isObject) && ha.isMobile ? (ha.contentHeight = ha.windowHeight, ha.contentWidth = ha.windowWidth) : ha.isObject && (ha.contentHeight = ha.contentHeight > ha.windowHeight ? ha.windowHeight : ha.contentHeight, ha.contentWidth = ha.contentWidth > ha.windowWidth ? ha.windowWidth : ha.contentWidth), ha.isMobile || (ha.contentHeight > ha.maxHeight && (ha.contentHeight = ha.maxHeight), ha.contentWidth > ha.maxWidth && (ha.contentWidth = ha.maxWidth))
        }

        function S() {
            var b = a('<div class="' + $.error + '"><p>Error Loading Resource</p></div>');
            ha.type = "element", ha.$tools.remove(), ha.$image.off(_.namespace), Q(b)
        }

        function T(a) {
            var b = a[0],
                c = new Image;
            return "undefined" != typeof b.naturalHeight ? {
                naturalHeight: b.naturalHeight,
                naturalWidth: b.naturalWidth
            } : "img" === b.tagName.toLowerCase() ? (c.src = b.src, {
                naturalHeight: c.height,
                naturalWidth: c.width
            }) : !1
        }

        function U(a) {
            var b, c = ha.videoFormatter;
            for (var d in c)
                if (c.hasOwnProperty(d) && (b = a.match(c[d].pattern), null !== b)) return c[d].format.call(ha, b);
            return !1
        }

        function V(b) {
            var c = b.target;
            a.contains(ha.$lightbox[0], c) || c === ha.$lightbox[0] || c === ha.$overlay[0] || (aa.killEvent(b), ha.$lightbox.focus())
        }
        var W = b.Plugin("lightbox", {
                widget: !0,
                defaults: {
                    customClass: "",
                    fileTypes: /\.(jpg|sjpg|jpeg|png|gif)$/i,
                    fixed: !1,
                    formatter: q,
                    infinite: !1,
                    labels: {
                        close: "Close",
                        count: "of",
                        next: "Next",
                        previous: "Previous",
                        captionClosed: "View Caption",
                        captionOpen: "Close Caption",
                        thumbnailsClosed: "View Thumbnails",
                        thumbnailsOpen: "Close Thumbnails"
                    },
                    margin: 50,
                    maxHeight: 1e4,
                    maxWidth: 1e4,
                    minHeight: 100,
                    minWidth: 100,
                    mobile: !1,
                    retina: !1,
                    requestKey: "fs-lightbox",
                    theme: "fs-light",
                    thumbnails: !1,
                    top: 0,
                    touch: !0,
                    videoFormatter: {
                        youtube: {
                            pattern: /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/,
                            format: B
                        },
                        vimeo: {
                            pattern: /(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/,
                            format: C
                        }
                    },
                    videoRatio: .5625,
                    videoWidth: 800
                },
                classes: ["loading", "animating", "scaling", "fixed", "mobile", "touch", "inline", "iframed", "open", "ready", "overlay", "close", "loading_icon", "container", "content", "image", "image_container", "video", "video_wrapper", "tools", "meta", "meta_content", "controls", "control", "control_previous", "control_next", "control_disabled", "position", "position_current", "position_total", "toggle", "caption_toggle", "caption", "caption_open", "thumbnailed", "thumbnails_open", "thumbnail_toggle", "thumbnails", "thumbnail_container", "thumbnail_item", "active", "has_controls", "has_caption", "iframe", "error", "active", "lock"],
                events: {
                    open: "open",
                    close: "close"
                },
                methods: {
                    _setup: c,
                    _construct: e,
                    _destruct: f,
                    _resize: d,
                    resize: i
                },
                utilities: {
                    _initialize: g,
                    close: j
                }
            }),
            X = W.namespace,
            Y = W.defaults,
            Z = W.classes,
            $ = Z.raw,
            _ = W.events,
            aa = W.functions,
            ba = b.window,
            ca = b.$window,
            da = null,
            ea = null,
            fa = !1,
            ga = !1,
            ha = null
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(b) {
            b = b || {};
            for (var c in t) t.hasOwnProperty(c) && (l[c] = b[c] ? a.merge(b[c], l[c]) : l[c]);
            l = a.extend(l, b), l.minWidth.sort(p.sortDesc), l.maxWidth.sort(p.sortAsc), l.minHeight.sort(p.sortDesc), l.maxHeight.sort(p.sortAsc);
            for (var d in t)
                if (t.hasOwnProperty(d)) {
                    s[d] = {};
                    for (var e in l[d])
                        if (l[d].hasOwnProperty(e)) {
                            var f = window.matchMedia("(" + t[d] + ": " + (l[d][e] === 1 / 0 ? 1e5 : l[d][e]) + l.unit + ")");
                            f.addListener(g), s[d][l[d][e]] = f
                        }
                }
            g()
        }

        function d(a, b, c) {
            var d = o.matchMedia(b),
                e = i(d.media);
            r[e] || (r[e] = {
                mq: d,
                active: !0,
                enter: {},
                leave: {}
            }, r[e].mq.addListener(h));
            for (var f in c) c.hasOwnProperty(f) && r[e].hasOwnProperty(f) && (r[e][f][a] = c[f]);
            var g = r[e],
                j = d.matches;
            j && g[m.enter].hasOwnProperty(a) ? (g[m.enter][a].apply(d), g.active = !0) : !j && g[m.leave].hasOwnProperty(a) && (g[m.leave][a].apply(d), g.active = !1)
        }

        function e(a, b) {
            if (a)
                if (b) {
                    var c = i(b);
                    r[c] && (r[c].enter[a] && delete r[c].enter[a], r[c].leave[a] && delete r[c].leave[a])
                } else
                    for (var d in r) r.hasOwnProperty(d) && (r[d].enter[a] && delete r[d].enter[a], r[d].leave[a] && delete r[d].leave[a])
        }

        function f() {
            q = {
                unit: l.unit
            };
            for (var a in t)
                if (t.hasOwnProperty(a))
                    for (var c in s[a])
                        if (s[a].hasOwnProperty(c)) {
                            var d = "Infinity" === c ? 1 / 0 : parseInt(c, 10),
                                e = t[a].indexOf("width") > -1 ? b.fallbackWidth : b.fallbackHeight,
                                f = a.indexOf("max") > -1;
                            b.support.nativeMatchMedia ? s[a][c].matches && (f ? (!q[a] || d < q[a]) && (q[a] = d) : (!q[a] || d > q[a]) && (q[a] = d)) : f ? !q[a] && d > e && (q[a] = d) : (!q[a] && 0 !== q[a] || d > q[a] && e > d) && (q[a] = d)
                        }
        }

        function g() {
            f(), n.trigger(m.mqChange, [q])
        }

        function h(a) {
            var b = i(a.media),
                c = r[b],
                d = a.matches,
                e = d ? m.enter : m.leave;
            if (c && (c.active || !c.active && d)) {
                for (var f in c[e]) c[e].hasOwnProperty(f) && c[e][f].apply(c.mq);
                c.active = !0
            }
        }

        function i(a) {
            return a.replace(/[^a-z0-9\s]/gi, "").replace(/[_\s]/g, "").replace(/^\s+|\s+$/g, "")
        }

        function j() {
            return q
        }
        var k = b.Plugin("mediaquery", {
                utilities: {
                    _initialize: c,
                    state: j,
                    bind: d,
                    unbind: e
                },
                events: {
                    mqChange: "mqchange"
                }
            }),
            l = {
                minWidth: [0],
                maxWidth: [1 / 0],
                minHeight: [0],
                maxHeight: [1 / 0],
                unit: "px"
            },
            m = a.extend(k.events, {
                enter: "enter",
                leave: "leave"
            }),
            n = b.$window,
            o = n[0],
            p = k.functions,
            q = null,
            r = [],
            s = {},
            t = {
                minWidth: "min-width",
                maxWidth: "max-width",
                minHeight: "min-height",
                maxHeight: "max-height"
            }
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./mediaquery"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(b) {
            b.mq = "(max-width:" + (b.maxWidth === 1 / 0 ? "100000px" : b.maxWidth) + ")";
            var c = "";
            c += '<button type="button" class="' + [m.control, m.control_previous].join(" ") + '">' + b.labels.previous + "</button>", c += '<button type="button" class="' + [m.control, m.control_next].join(" ") + '">' + b.labels.next + "</button>", c += '<div class="' + m.position + '" aria-hidden="true">', c += '<span class="' + m.current + '">0</span>', c += " " + b.labels.count + " ", c += '<span class="' + m.total + '">0</span>', c += "</div>", c += '<select class="' + m.select + '" tabindex="-1" aria-hidden="true"></select>', b.thisClasses = [m.base, b.theme, b.customClass], this.addClass(b.thisClasses.join(" ")).wrapInner('<div class="' + m.pages + '" aria-label="pagination"></div>').prepend(c), b.$controls = this.find(l.control), b.$pages = this.find(l.pages), b.$items = b.$pages.children().addClass(m.page), b.$position = this.find(l.position), b.$select = this.find(l.select), b.index = -1, b.total = b.$items.length - 1;
            var d = b.$items.index(b.$items.filter("[data-" + k.namespace + "-active]"));
            d || (d = b.$items.index(b.$items.filter(l.active))), b.$items.eq(0).addClass(m.first).after('<span class="' + m.ellipsis + '">&hellip;</span>').end().eq(b.total).addClass(m.last).before('<span class="' + m.ellipsis + '">&hellip;</span>'), b.$ellipsis = b.$pages.find(l.ellipsis), j(b), this.on(n.click, l.page, b, g).on(n.click, l.control, b, e).on(n.click, l.position, b, h).on(n.change, l.select, b, f), a.fsMediaquery("bind", b.rawGuid, b.mq, {
                enter: function() {
                    b.$el.addClass(m.mobile)
                },
                leave: function() {
                    b.$el.removeClass(m.mobile)
                }
            }), i(b, d)
        }

        function d(b) {
            a.fsMediaquery("unbind", b.rawGuid), b.$controls.remove(), b.$ellipsis.remove(), b.$select.remove(), b.$position.remove(), b.$items.removeClass([m.page, m.active, m.visible, m.first, m.last].join(" ")).unwrap(), this.removeClass(b.thisClasses.join(" ")).off(n.namespace)
        }

        function e(b) {
            o.killEvent(b);
            var c = b.data,
                d = c.index + (a(b.currentTarget).hasClass(m.control_previous) ? -1 : 1);
            d >= 0 && c.$items.eq(d).trigger(n.raw.click)
        }

        function f(b) {
            o.killEvent(b);
            var c = b.data,
                d = a(b.currentTarget),
                e = parseInt(d.val(), 10);
            c.$items.eq(e).trigger(n.raw.click)
        }

        function g(b) {
            var c = b.data,
                d = c.$items.index(a(b.currentTarget));
            c.ajax && o.killEvent(b), i(c, d)
        }

        function h(a) {
            o.killEvent(a);
            var c = a.data;
            if (b.isMobile && !b.isFirefoxMobile) {
                var d = c.$select[0];
                if (window.document.createEvent) {
                    var e = window.document.createEvent("MouseEvents");
                    e.initMouseEvent("mousedown", !1, !0, window, 0, 0, 0, 0, 0, !1, !1, !1, !1, 0, null), d.dispatchEvent(e)
                } else d.fireEvent && d.fireEvent("onmousedown")
            }
        }

        function i(a, b) {
            if (0 > b && (b = 0), b > a.total && (b = a.total), b !== a.index) {
                a.index = b;
                var c = a.index - a.visible,
                    d = a.index + (a.visible + 1);
                0 > c && (c = 0), d > a.total && (d = a.total), a.$items.removeClass(m.visible).removeClass(m.hidden).filter(l.active).removeClass(m.active).end().eq(a.index).addClass(m.active).end().slice(c, d).addClass(m.visible), a.$items.not(l.visible).addClass(m.hidden), a.$position.find(l.current).text(a.index + 1).end().find(l.total).text(a.total + 1), a.$select.val(a.index), a.$controls.removeClass(m.visible), b > 0 && a.$controls.filter(l.control_previous).addClass(m.visible), b < a.total && a.$controls.filter(l.control_next).addClass(m.visible), a.$ellipsis.removeClass(m.visible), b > a.visible + 1 && a.$ellipsis.eq(0).addClass(m.visible), b < a.total - a.visible - 1 && a.$ellipsis.eq(1).addClass(m.visible), a.$el.trigger(n.update, [a.index])
            }
        }

        function j(a) {
            for (var b = "", c = 0; c <= a.total; c++) b += '<option value="' + c + '"', c === a.index && (b += 'selected="selected"'), b += ">Page " + (c + 1) + "</option>";
            a.$select.html(b)
        }
        var k = b.Plugin("pagination", {
                widget: !0,
                defaults: {
                    ajax: !1,
                    customClass: "",
                    labels: {
                        count: "of",
                        next: "Next",
                        previous: "Previous"
                    },
                    maxWidth: "740px",
                    theme: "fs-light",
                    visible: 2
                },
                classes: ["pages", "page", "active", "first", "last", "ellipsis", "visible", "hidden", "control", "control_previous", "control_next", "position", "select", "mobile", "current", "total"],
                events: {
                    update: "update"
                },
                methods: {
                    _construct: c,
                    _destruct: d
                }
            }),
            l = k.classes,
            m = l.raw,
            n = k.events,
            o = k.functions
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./mediaquery", "./swap"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c() {
            A = a("html, body")
        }

        function d(b) {
            b.handleGuid = x.handle + b.guid, b.isToggle = "toggle" === b.type, b.open = !1, b.isToggle && (b.gravity = "");
            var c = x.base,
                d = [c, b.type].join("-"),
                e = b.gravity ? [d, b.gravity].join("-") : "",
                f = [b.rawGuid, b.theme, b.customClass].join(" ");
            b.handle = this.data(v + "-handle"), b.content = this.data(v + "-content"), b.handleClasses = [x.handle, x.handle.replace(c, d), e ? x.handle.replace(c, e) : "", b.handleGuid, f].join(" "), b.thisClasses = [x.nav.replace(c, d), e ? x.nav.replace(c, e) : "", f], b.contentClasses = [x.content.replace(c, d), f].join(" "), b.contentClassesOpen = [e ? x.content.replace(c, e) : "", x.open].join(" "), b.$nav = this.addClass(b.thisClasses.join(" ")).attr("role", "navigation"), b.$handle = a(b.handle).addClass(b.handleClasses), b.$content = a(b.content).addClass(b.contentClasses), b.$animate = a().add(b.$nav).add(b.$content), s(b), b.navTabIndex = b.$nav.attr("tabindex"), b.$nav.attr("tabindex", -1), b.id = this.attr("id"), b.id ? b.ariaId = b.id : (b.ariaId = b.rawGuid, this.attr("id", b.ariaId)), b.$handle.attr("data-swap-target", b.dotGuid).attr("data-swap-linked", b.handleGuid).attr("data-swap-group", x.base).attr("tabindex", 0).on("activate.swap" + b.dotGuid, b, m).on("deactivate.swap" + b.dotGuid, b, n).on("enable.swap" + b.dotGuid, b, o).on("disable.swap" + b.dotGuid, b, p).on(y.focus + b.dotGuid, b, j).on(y.blur + b.dotGuid, b, k).fsSwap({
                maxWidth: b.maxWidth,
                classes: {
                    target: b.dotGuid,
                    enabled: w.enabled,
                    active: w.open,
                    raw: {
                        target: b.rawGuid,
                        enabled: x.enabled,
                        active: x.open
                    }
                }
            }), b.$handle.is("a, button") || b.$handle.on(y.keyPress + b.dotGuid, b, l)
        }

        function e(a) {
            a.$content.removeClass([a.contentClasses, a.contentClassesOpen].join(" ")).off(y.namespace), a.$handle.removeAttr("aria-controls").removeAttr("aria-expanded").removeAttr("data-swap-target").removeData("swap-target").removeAttr("data-swap-linked").removeAttr("data-swap-group").removeData("swap-linked").removeData("tabindex").removeClass(a.handleClasses).off(a.dotGuid).html(a.originalLabel).fsSwap("destroy"), a.$nav.attr("tabindex", a.navTabIndex), t(a), r(a), this.removeAttr("aria-hidden").removeClass(a.thisClasses.join(" ")).off(y.namespace), this.attr("id") === a.rawGuid && this.removeAttr("id")
        }

        function f(a) {
            a.$handle.fsSwap("activate")
        }

        function g(a) {
            a.$handle.fsSwap("deactivate")
        }

        function h(a) {
            a.$handle.fsSwap("enable")
        }

        function i(a) {
            a.$handle.fsSwap("disable")
        }

        function j(a) {
            a.data.$handle.addClass(x.focus)
        }

        function k(a) {
            a.data.$handle.removeClass(x.focus)
        }

        function l(a) {
            var b = a.data;
            13 !== a.keyCode && 32 !== a.keyCode || (z.killEvent(a), b.$handle.trigger(y.raw.click))
        }

        function m(a) {
            if (!a.originalEvent) {
                var b = a.data;
                b.open || (b.$el.trigger(y.open).attr("aria-hidden", !1), b.$content.addClass(b.contentClassesOpen).one(y.click, function() {
                    g(b)
                }), b.$handle.attr("aria-expanded", !0), b.label && b.$handle.html(b.labels.open), q(b), b.open = !0, b.$nav.focus())
            }
        }

        function n(a) {
            if (!a.originalEvent) {
                var b = a.data;
                b.open && (b.$el.trigger(y.close).attr("aria-hidden", !0), b.$content.removeClass(b.contentClassesOpen).off(y.namespace), b.$handle.attr("aria-expanded", !1), b.label && b.$handle.html(b.labels.closed), r(b), b.open = !1, b.$el.focus())
            }
        }

        function o(a) {
            var b = a.data;
            b.$el.attr("aria-hidden", !0), b.$handle.attr("aria-controls", b.ariaId).attr("aria-expanded", !1), b.$content.addClass(x.enabled), setTimeout(function() {
                b.$animate.addClass(x.animated)
            }, 0), b.label && b.$handle.html(b.labels.closed)
        }

        function p(a) {
            var b = a.data;
            b.$el.removeAttr("aria-hidden"), b.$handle.removeAttr("aria-controls").removeAttr("aria-expanded"), b.$content.removeClass(x.enabled, x.animated), b.$animate.removeClass(x.animated), t(b), r(b)
        }

        function q(a) {
            a.isToggle || A.addClass(x.lock)
        }

        function r(a) {
            a.isToggle || A.removeClass(x.lock)
        }

        function s(a) {
            if (a.label)
                if (a.$handle.length > 1) {
                    a.originalLabel = [];
                    for (var b = 0, c = a.$handle.length; c > b; b++) a.originalLabel[b] = a.$handle.eq(b).html()
                } else a.originalLabel = a.$handle.html()
        }

        function t(a) {
            if (a.label)
                if (a.$handle.length > 1)
                    for (var b = 0, c = a.$handle.length; c > b; b++) a.$handle.eq(b).html(a.originalLabel[b]);
                else a.$handle.html(a.originalLabel)
        }
        var u = b.Plugin("navigation", {
                widget: !0,
                defaults: {
                    customClass: "",
                    gravity: "left",
                    label: !0,
                    labels: {
                        closed: "Menu",
                        open: "Close"
                    },
                    maxWidth: "980px",
                    theme: "fs-light",
                    type: "toggle"
                },
                classes: ["handle", "nav", "content", "animated", "enabled", "focus", "open", "toggle", "push", "reveal", "overlay", "left", "right", "lock"],
                events: {
                    open: "open",
                    close: "close"
                },
                methods: {
                    _setup: c,
                    _construct: d,
                    _destruct: e,
                    open: f,
                    close: g,
                    enable: h,
                    disable: i
                }
            }),
            v = u.namespace,
            w = u.classes,
            x = w.raw,
            y = u.events,
            z = u.functions,
            A = null
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c() {
            v = b.$body
        }

        function d(a) {
            var b = parseFloat(this.attr("min")),
                c = parseFloat(this.attr("max"));
            a.min = b || 0 === b ? b : !1, a.max = c || 0 === c ? c : !1, a.step = parseFloat(this.attr("step")) || 1, a.timer = null, a.digits = o(a.step), a.disabled = this.is(":disabled") || this.is("[readonly]");
            var d = "";
            d += '<button type="button" class="' + [s.arrow, s.up].join(" ") + '" aria-hidden="true" tabindex="-1">' + a.labels.up + "</button>", d += '<button type="button" class="' + [s.arrow, s.down].join(" ") + '" aria-hidden="true" tabindex="-1">' + a.labels.down + "</button>", this.wrap('<div class="' + [s.base, a.theme, a.customClass, a.disabled ? s.disabled : ""].join(" ") + '"></div>').after(d), a.$container = this.parent(r.base), a.$arrows = a.$container.find(r.arrow), this.on(t.focus, a, i).on(t.blur, a, j).on(t.keyPress, a, k), a.$container.on([t.touchStart, t.mouseDown].join(" "), r.arrow, a, l), n(a, 0)
        }

        function e(a) {
            a.$arrows.remove(), this.unwrap().off(t.namespace)
        }

        function f(a) {
            a.disabled && (this.prop("disabled", !1), a.$container.removeClass(s.disabled), a.disabled = !1)
        }

        function g(a) {
            a.disabled || (this.prop("disabled", !0), a.$container.addClass(s.disabled), a.disabled = !0)
        }

        function h(a) {
            var b = parseFloat(a.$el.attr("min")),
                c = parseFloat(a.$el.attr("max"));
            a.min = b || 0 === b ? b : !1, a.max = c || 0 === c ? c : !1, a.step = parseFloat(a.$el.attr("step")) || 1, a.timer = null, a.digits = o(a.step), a.disabled = a.$el.is(":disabled") || a.$el.is("[readonly]"), n(a, 0)
        }

        function i(a) {
            a.data.$container.addClass(s.focus)
        }

        function j(a) {
            n(a.data, 0), a.data.$container.removeClass(s.focus)
        }

        function k(a) {
            var b = a.data;
            38 !== a.keyCode && 40 !== a.keyCode || (a.preventDefault(),
                n(b, 38 === a.keyCode ? b.step : -b.step))
        }

        function l(b) {
            u.killEvent(b), m(b);
            var c = b.data;
            if (!c.disabled && b.which <= 1) {
                var d = a(b.target).hasClass(s.up) ? c.step : -c.step;
                c.timer = u.startTimer(c.timer, 300, function() {
                    c.timer = u.startTimer(c.timer, 125, function() {
                        n(c, d, !1)
                    }, !0)
                }), n(c, d), v.on([t.touchEnd, t.mouseUp].join(" "), c, m)
            }
        }

        function m(a) {
            u.killEvent(a);
            var b = a.data;
            u.clearTimer(b.timer, !0), v.off(t.namespace)
        }

        function n(b, c) {
            var d = parseFloat(b.$el.val()),
                e = c;
            "undefined" === a.type(d) || isNaN(d) ? e = b.min !== !1 ? b.min : 0 : b.min !== !1 && d < b.min ? e = b.min : e += d;
            var f = (e - b.min) % b.step;
            0 !== f && (e -= f), b.min !== !1 && e < b.min && (e = b.min), b.max !== !1 && e > b.max && (e = b.max), e !== d && (e = p(e, b.digits), b.$el.val(e).trigger(t.raw.change, [!0]))
        }

        function o(a) {
            var b = String(a);
            return b.indexOf(".") > -1 ? b.length - b.indexOf(".") - 1 : 0
        }

        function p(a, b) {
            var c = Math.pow(10, b);
            return Math.round(a * c) / c
        }
        var q = b.Plugin("number", {
                widget: !0,
                defaults: {
                    customClass: "",
                    labels: {
                        up: "Up",
                        down: "Down"
                    },
                    theme: "fs-light"
                },
                classes: ["arrow", "up", "down", "disabled", "focus"],
                methods: {
                    _setup: c,
                    _construct: d,
                    _destruct: e,
                    enable: f,
                    disable: g,
                    update: h
                }
            }),
            r = q.classes,
            s = r.raw,
            t = q.events,
            u = q.functions,
            v = null
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./touch"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(a) {
            w.iterate.call(x, j)
        }

        function d() {
            x = a(t.element)
        }

        function e(a) {
            a.formatter || (a.formatter = r), a.min = parseFloat(this.attr("min")) || 0, a.max = parseFloat(this.attr("max")) || 100, a.step = parseFloat(this.attr("step")) || 1, a.digits = a.step.toString().length - a.step.toString().indexOf("."), a.value = parseFloat(this.val()) || a.min + (a.max - a.min) / 2;
            var b = "";
            a.vertical = "vertical" === this.attr("orient") || a.vertical, a.disabled = this.is(":disabled") || this.is("[readonly]"), b += '<div class="' + u.track + '" aria-hidden="true">', a.fill && (b += '<span class="' + u.fill + '"></span>'), b += '<div class="' + u.handle + '" role="slider">', b += '<span class="' + u.marker + '"></span>', b += "</div>", b += "</div>";
            var c = [u.base, a.theme, a.customClass, a.vertical ? u.vertical : "", a.labels ? u.labels : "", a.disabled ? u.disabled : ""];
            if (this.addClass(u.element).wrap('<div class="' + c.join(" ") + '"></div>').after(b), a.$container = this.parents(t.base), a.$track = a.$container.find(t.track), a.$fill = a.$container.find(t.fill), a.$handle = a.$container.find(t.handle), a.$output = a.$container.find(t.output), a.labels) {
                var e = '<span class="' + [u.label, u.label_max].join(" ") + '">' + a.formatter.call(this, a.labels.max ? a.labels.max : a.max) + "</span>",
                    f = '<span class="' + [u.label, u.label_min].join(" ") + '">' + a.formatter.call(this, a.labels.max ? a.labels.min : a.min) + "</span>";
                a.$container.prepend(a.vertical ? e : f).append(a.vertical ? f : e)
            }
            a.$labels = a.$container.find(t.label), this.on(v.focus, a, n).on(v.blur, a, o).on(v.change, a, q), a.$container.fsTouch({
                pan: !0,
                axis: a.vertical ? "y" : "x"
            }).on(v.panStart, a, k).on(v.pan, a, l).on(v.panEnd, a, m), d(), j.call(this, a)
        }

        function f(a) {
            a.$container.off(v.namespace).fsTouch("destroy"), a.$track.remove(), a.$labels.remove(), this.unwrap().removeClass(u.element).off(v.namespace), d()
        }

        function g(a) {
            a.disabled && (this.prop("disabled", !1), a.$container.removeClass(u.disabled), a.disabled = !1)
        }

        function h(a) {
            a.disabled || (this.prop("disabled", !0), a.$container.addClass(u.disabled), a.disabled = !0)
        }

        function i(a) {
            a.min = parseFloat(a.$el.attr("min")) || 0, a.max = parseFloat(a.$el.attr("max")) || 100, a.step = parseFloat(a.$el.attr("step")) || 1, a.digits = a.step.toString().length - a.step.toString().indexOf("."), a.value = parseFloat(this.val()) || a.min + (a.max - a.min) / 2, a.labels && (a.$labels.filter(t.label_max).html(a.formatter.call(this, a.labels.max ? a.labels.max : a.max)), a.$labels.filter(t.label_min).html(a.formatter.call(this, a.labels.max ? a.labels.min : a.min))), j.call(this, a)
        }

        function j(a) {
            a.stepCount = (a.max - a.min) / a.step, a.offset = a.$track.offset(), a.vertical ? (a.trackHeight = a.$track.outerHeight(), a.handleHeight = a.$handle.outerHeight(), a.increment = a.trackHeight / a.stepCount) : (a.trackWidth = a.$track.outerWidth(), a.handleWidth = a.$handle.outerWidth(), a.increment = a.trackWidth / a.stepCount);
            var b = (a.$el.val() - a.min) / (a.max - a.min);
            p(a, b, !0)
        }

        function k(a) {
            w.killEvent(a);
            var b = a.data;
            b.disabled || (l(a), b.$container.addClass(u.focus))
        }

        function l(a) {
            w.killEvent();
            var b = a.data,
                c = 0;
            b.disabled || (c = b.vertical ? 1 - (a.pageY - b.offset.top) / b.trackHeight : (a.pageX - b.offset.left) / b.trackWidth, p(b, c))
        }

        function m(a) {
            w.killEvent(a);
            var b = a.data;
            b.disabled || b.$container.removeClass(u.focus)
        }

        function n(a) {
            a.data.$container.addClass(u.focus)
        }

        function o(a) {
            a.data.$container.removeClass(u.focus)
        }

        function p(a, b, c) {
            a.increment > 1 && (b = a.vertical ? Math.round(b * a.stepCount) * a.increment / a.trackHeight : Math.round(b * a.stepCount) * a.increment / a.trackWidth), 0 > b && (b = 0), b > 1 && (b = 1);
            var d = (a.min - a.max) * b;
            d = -parseFloat(d.toFixed(a.digits)), a.$fill.css(a.vertical ? "height" : "width", 100 * b + "%"), a.$handle.css(a.vertical ? "bottom" : "left", 100 * b + "%"), d += a.min, d !== a.value && d !== !1 && c !== !0 && (a.$el.val(d).trigger(v.raw.change, [!0]), a.value = d)
        }

        function q(a, b) {
            var c = a.data;
            if (!b && !c.disabled) {
                var d = (c.$el.val() - c.min) / (c.max - c.min);
                p(c, d)
            }
        }

        function r(a) {
            var b = a.toString().split(".");
            return b[0] = b[0].replace(/\B(?=(\d{3})+(?!\d))/g, ","), b.join(".")
        }
        var s = b.Plugin("range", {
                widget: !0,
                defaults: {
                    customClass: "",
                    fill: !1,
                    formatter: !1,
                    labels: {
                        max: !1,
                        min: !1
                    },
                    theme: "fs-light",
                    vertical: !1
                },
                classes: ["track", "handle", "fill", "marker", "labels", "label", "label_min", "label_max", "vertical", "focus", "disabled"],
                methods: {
                    _construct: e,
                    _destruct: f,
                    _resize: c,
                    enable: g,
                    disable: h,
                    resize: j,
                    update: i
                }
            }),
            t = s.classes,
            u = t.raw,
            v = s.events,
            w = s.functions,
            x = []
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./touch"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c() {
            q = b.$body
        }

        function d(a) {
            v.iterate.call(w, i)
        }

        function e() {
            w = a(s.base)
        }

        function f(a) {
            var b = "";
            b += '<div class="' + t.bar + '">', b += '<div class="' + t.track + '">', b += '<button type="button" class="' + t.handle + '" aria-hidden="true" tabindex="-1"></button>', b += "</div></div>", a.paddingRight = parseInt(this.css("padding-right"), 10), a.paddingBottom = parseInt(this.css("padding-bottom"), 10), a.thisClasses = [t.base, a.theme, a.customClass, a.horizontal ? t.horizontal : ""], this.addClass(a.thisClasses.join(" ")).wrapInner('<div class="' + t.content + '" tabindex="0"></div>').prepend(b), a.$content = this.find(s.content), a.$bar = this.find(s.bar), a.$track = this.find(s.track), a.$handle = this.find(s.handle), a.trackMargin = parseInt(a.trackMargin, 10), a.$content.on(u.scroll, a, j), a.mouseWheel && a.$content.on("DOMMouseScroll" + u.namespace + " mousewheel" + u.namespace, a, k), a.$track.fsTouch({
                axis: a.horizontal ? "x" : "y",
                pan: !0
            }).on(u.panStart, a, m).on(u.pan, a, n).on(u.panEnd, a, o), i(a), e()
        }

        function g(a) {
            a.$track.fsTouch("destroy"), a.$bar.remove(), a.$content.off(u.namespace).contents().unwrap(), this.removeClass(a.thisClasses.join(" ")).off(u.namespace), this.attr("id") === a.rawGuid && this.removeAttr("id")
        }

        function h(b, c, d) {
            var e = d || b.duration,
                f = {};
            if ("number" !== a.type(c)) {
                var g = a(c);
                if (g.length > 0) {
                    var h = g.position();
                    c = b.horizontal ? h.left + b.$content.scrollLeft() : h.top + b.$content.scrollTop()
                } else c = "top" === c ? 0 : "bottom" === c ? b.horizontal ? b.$content[0].scrollWidth : b.$content[0].scrollHeight : b.$content.scrollTop()
            }
            f[b.horizontal ? "scrollLeft" : "scrollTop"] = c, b.$content.stop().animate(f, e)
        }

        function i(a) {
            a.$el.addClass(t.isSetup);
            var b = {},
                c = {},
                d = {},
                e = 0,
                f = !0;
            if (a.horizontal) {
                a.barHeight = a.$content[0].offsetHeight - a.$content[0].clientHeight, a.frameWidth = a.$content.outerWidth(), a.trackWidth = a.frameWidth - 2 * a.trackMargin, a.scrollWidth = a.$content[0].scrollWidth, a.ratio = a.trackWidth / a.scrollWidth, a.trackRatio = a.trackWidth / a.scrollWidth, a.handleWidth = a.handleSize > 0 ? a.handleSize : a.trackWidth * a.trackRatio, a.scrollRatio = (a.scrollWidth - a.frameWidth) / (a.trackWidth - a.handleWidth), a.handleBounds = {
                    left: 0,
                    right: a.trackWidth - a.handleWidth
                }, a.$content.css({
                    paddingBottom: a.barHeight + a.paddingBottom
                });
                var g = a.$content.scrollLeft();
                e = g * a.ratio, f = a.scrollWidth <= a.frameWidth, b = {
                    width: a.frameWidth
                }, c = {
                    width: a.trackWidth,
                    marginLeft: a.trackMargin,
                    marginRight: a.trackMargin
                }, d = {
                    width: a.handleWidth
                }
            } else {
                a.barWidth = a.$content[0].offsetWidth - a.$content[0].clientWidth, a.frameHeight = a.$content.outerHeight(), a.trackHeight = a.frameHeight - 2 * a.trackMargin, a.scrollHeight = a.$content[0].scrollHeight, a.ratio = a.trackHeight / a.scrollHeight, a.trackRatio = a.trackHeight / a.scrollHeight, a.handleHeight = a.handleSize > 0 ? a.handleSize : a.trackHeight * a.trackRatio, a.scrollRatio = (a.scrollHeight - a.frameHeight) / (a.trackHeight - a.handleHeight), a.handleBounds = {
                    top: 0,
                    bottom: a.trackHeight - a.handleHeight
                };
                var h = a.$content.scrollTop();
                e = h * a.ratio, f = a.scrollHeight <= a.frameHeight, b = {
                    height: a.frameHeight
                }, c = {
                    height: a.trackHeight,
                    marginBottom: a.trackMargin,
                    marginTop: a.trackMargin
                }, d = {
                    height: a.handleHeight
                }
            }
            f ? a.$el.removeClass(t.active) : a.$el.addClass(t.active), a.$bar.css(b), a.$track.css(c), a.$handle.css(d), a.panning = !1, p(a, e), j({
                data: a
            }), a.$el.removeClass(t.setup)
        }

        function j(a) {
            v.killEvent(a);
            var b = a.data,
                c = {};
            if (!b.panning) {
                if (b.horizontal) {
                    var d = b.$content.scrollLeft();
                    0 > d && (d = 0), b.handleLeft = d / b.scrollRatio, b.handleLeft > b.handleBounds.right && (b.handleLeft = b.handleBounds.right), c = {
                        left: b.handleLeft
                    }
                } else {
                    var e = b.$content.scrollTop();
                    0 > e && (e = 0), b.handleTop = e / b.scrollRatio, b.handleTop > b.handleBounds.bottom && (b.handleTop = b.handleBounds.bottom), c = {
                        top: b.handleTop
                    }
                }
                b.$handle.css(c)
            }
        }

        function k(a) {
            var b, c, d = a.data;
            if (d.horizontal) {
                var e = d.$content[0].scrollLeft,
                    f = d.$content[0].scrollWidth,
                    g = d.$content.outerWidth();
                if (b = "DOMMouseScroll" === a.type ? -40 * a.originalEvent.detail : a.originalEvent.wheelDelta, c = b > 0 ? "right" : "left", "left" === c && -b > f - g - e) return d.$content.scrollLeft(f), l(a);
                if ("right" === c && b > e) return d.$content.scrollLeft(0), l(a)
            } else {
                var h = d.$content[0].scrollTop,
                    i = d.$content[0].scrollHeight,
                    j = d.$content.outerHeight();
                if (b = "DOMMouseScroll" === a.type ? -40 * a.originalEvent.detail : a.originalEvent.wheelDelta, c = b > 0 ? "up" : "down", "down" === c && -b > i - j - h) return d.$content.scrollTop(i), l(a);
                if ("up" === c && b > h) return d.$content.scrollTop(0), l(a)
            }
        }

        function l(a) {
            return v.killEvent(a), a.returnValue = !1, !1
        }

        function m(a) {
            var b, c = a.data,
                d = c.$track.offset();
            c.panning = !0, b = c.horizontal ? c.handleLeft = a.pageX - d.left - c.handleWidth / 2 : c.handleTop = a.pageY - d.top - c.handleHeight / 2, p(c, b)
        }

        function n(a) {
            var b, c = a.data;
            b = c.horizontal ? c.handleLeft + a.deltaX : c.handleTop + a.deltaY, p(c, b)
        }

        function o(a) {
            var b = a.data;
            b.panning = !1, b.horizontal ? b.handleLeft += a.deltaX : b.handleTop += a.deltaY
        }

        function p(a, b) {
            var c = {};
            a.horizontal ? (b < a.handleBounds.left && (b = a.handleBounds.left), b > a.handleBounds.right && (b = a.handleBounds.right), c = {
                left: b
            }, a.$content.scrollLeft(Math.round(b * a.scrollRatio))) : (b < a.handleBounds.top && (b = a.handleBounds.top), b > a.handleBounds.bottom && (b = a.handleBounds.bottom), c = {
                top: b
            }, a.$content.scrollTop(Math.round(b * a.scrollRatio))), a.$handle.css(c)
        }
        var q, r = b.Plugin("scrollbar", {
                widget: !0,
                defaults: {
                    customClass: "",
                    duration: 0,
                    handleSize: 0,
                    horizontal: !1,
                    mouseWheel: !0,
                    theme: "fs-light",
                    trackMargin: 0
                },
                classes: ["content", "bar", "track", "handle", "horizontal", "setup", "active"],
                methods: {
                    _setup: c,
                    _construct: f,
                    _destruct: g,
                    _resize: d,
                    scroll: h,
                    resize: i
                }
            }),
            s = r.classes,
            t = s.raw,
            u = r.events,
            v = r.functions,
            w = (b.$window, [])
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./mediaquery"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(b) {
            b.enabled = !1, b.active = !1, b.classes = a.extend(!0, {}, m, b.classes), b.target = this.data(l + "-target"), b.$target = a(b.target).addClass(b.classes.raw.target), b.mq = "(max-width:" + (b.maxWidth === 1 / 0 ? "100000px" : b.maxWidth) + ")";
            var c = this.data(l + "-linked");
            b.linked = c ? "[data-" + l + '-linked="' + c + '"]' : !1;
            var d = this.data(l + "-group");
            b.group = d ? "[data-" + l + '-group="' + d + '"]' : !1, b.$swaps = a().add(this).add(b.$target), this.on(n.click + b.dotGuid, b, j)
        }

        function d(b) {
            b.collapse || !b.group || a(b.group).filter("[data-" + l + "-active]").length || a(b.group).eq(0).attr("data-" + l + "-active", "true"), b.onEnable = this.data(l + "-active") || !1, a.fsMediaquery("bind", b.rawGuid, b.mq, {
                enter: function() {
                    h.call(b.$el, b, !0)
                },
                leave: function() {
                    i.call(b.$el, b, !0)
                }
            })
        }

        function e(b) {
            a.fsMediaquery("unbind", b.rawGuid), b.$swaps.removeClass([b.classes.raw.enabled, b.classes.raw.active].join(" ")).off(n.namespace)
        }

        function f(b, c) {
            if (b.enabled && !b.active) {
                b.group && !c && a(b.group).not(b.$el).not(b.linked)[k.namespaceClean]("deactivate", !0);
                var d = b.group ? a(b.group).index(b.$el) : null;
                b.$swaps.addClass(b.classes.raw.active), c || b.linked && a(b.linked).not(b.$el)[k.namespaceClean]("activate", !0), this.trigger(n.activate, [d]), b.active = !0
            }
        }

        function g(b, c) {
            b.enabled && b.active && (b.$swaps.removeClass(b.classes.raw.active), c || b.linked && a(b.linked).not(b.$el)[k.namespaceClean]("deactivate", !0), this.trigger(n.deactivate), b.active = !1)
        }

        function h(b, c) {
            b.enabled || (b.enabled = !0, b.$swaps.addClass(b.classes.raw.enabled), c || a(b.linked).not(b.$el)[k.namespaceClean]("enable"), this.trigger(n.enable), b.onEnable ? (b.active = !1, f.call(this, b)) : (b.active = !0, g.call(this, b)))
        }

        function i(b, c) {
            b.enabled && (b.enabled = !1, b.$swaps.removeClass([b.classes.raw.enabled, b.classes.raw.active].join(" ")), c || a(b.linked).not(b.$el)[k.namespaceClean]("disable"), this.trigger(n.disable))
        }

        function j(a) {
            o.killEvent(a);
            var b = a.data;
            b.active && b.collapse ? g.call(b.$el, b) : f.call(b.$el, b)
        }
        var k = b.Plugin("swap", {
                widget: !0,
                defaults: {
                    collapse: !0,
                    maxWidth: 1 / 0
                },
                classes: ["target", "enabled", "active"],
                events: {
                    activate: "activate",
                    deactivate: "deactivate",
                    enable: "enable",
                    disable: "disable"
                },
                methods: {
                    _construct: c,
                    _postConstruct: d,
                    _destruct: e,
                    activate: f,
                    deactivate: g,
                    enable: h,
                    disable: i
                }
            }),
            l = k.namespace,
            m = k.classes,
            n = k.events,
            o = k.functions
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core", "./mediaquery", "./swap"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(c) {
            c.mq = "(max-width:" + (c.mobileMaxWidth === 1 / 0 ? "100000px" : c.mobileMaxWidth) + ")", c.content = this.attr("href"), c.group = this.data(q + "-group"), c.elementClasses = [s.tab, c.rawGuid, c.theme, c.customClass], c.mobileTabClasses = [s.tab, s.tab_mobile, c.rawGuid, c.theme, c.customClass], c.contentClasses = [s.content, c.rawGuid, c.theme, c.customClass], c.$mobileTab = a('<button type="button" class="' + c.mobileTabClasses.join(" ") + '" aria-hidden="true">' + this.text() + "</button>"), c.$content = a(c.content).addClass(c.contentClasses.join(" ")), c.$content.before(c.$mobileTab).attr("role", "tabpanel"), this.attr("role", "tab"), c.id = this.attr("id"), c.id ? c.ariaId = c.id : (c.ariaId = c.rawGuid, this.attr("id", c.ariaId)), c.contentId = c.$content.attr("id"), c.contentGuid = c.rawGuid + "_content", c.contentId ? c.ariacontentId = c.contentId : (c.ariaContentId = c.contentGuid, c.$content.attr("id", c.ariaContentId));
            var d = b.window.location.hash,
                e = !1,
                f = !1;
            d.length && (e = this.filter("[href*='" + d + "']").length > 0, f = c.group && a("[data-" + q + '-group="' + c.group + '"]').filter("[href*='" + d + "']").length > 0), e ? this.attr("data-swap-active", "true") : f ? this.removeAttr("data-swap-active").removeData("data-swap-active") : "true" === this.attr("data-tabs-active") && this.attr("data-swap-active", "true"), this.attr("data-swap-target", c.content).attr("data-swap-group", c.group).addClass(c.elementClasses.join(" ")).on("activate.swap" + c.dotGuid, c, i).on("deactivate.swap" + c.dotGuid, c, j).on("enable.swap" + c.dotGuid, c, k).on("disable.swap" + c.dotGuid, c, l)
        }

        function d(b) {
            this.fsSwap({
                maxWidth: b.maxWidth,
                classes: {
                    target: b.dotGuid,
                    enabled: r.enabled,
                    active: r.active,
                    raw: {
                        target: b.rawGuid,
                        enabled: s.enabled,
                        active: s.active
                    }
                },
                collapse: !1
            }), b.$mobileTab.on("click" + b.dotGuid, b, m), a.fsMediaquery("bind", b.rawGuid, b.mq, {
                enter: function() {
                    n.call(b.$el, b)
                },
                leave: function() {
                    o.call(b.$el, b)
                }
            })
        }

        function e(b) {
            a.fsMediaquery("unbind", b.rawGuid), b.$mobileTab.off(t.namespace).remove(), b.elementClasses.push(s.mobile), b.contentClasses.push(s.mobile), b.$content.removeAttr("aria-labelledby").removeAttr("aria-hidden").removeAttr("role").removeClass(b.contentClasses.join(" ")), b.$content.attr("id") === b.contentGuid && b.$content.removeAttr("id"), this.removeAttr("aria-controls").removeAttr("aria-selected").removeAttr("data-swap-active").removeData("data-swap-active").removeAttr("data-swap-target").removeData("data-swap-target").removeAttr("data-swap-group").removeData("data-swap-group").removeAttr("role").removeClass(b.elementClasses.join(" ")).off(t.namespace).fsSwap("destroy"), this.attr("id") === b.rawGuid && this.removeAttr("id")
        }

        function f(a) {
            this.fsSwap("activate")
        }

        function g(a) {
            this.fsSwap("enable")
        }

        function h(a) {
            this.fsSwap("disable")
        }

        function i(a) {
            if (!a.originalEvent) {
                var b = a.data,
                    c = 0;
                b.$el.attr("aria-selected", !0).trigger(t.update, [c]), b.$mobileTab.addClass(s.active), b.$content.attr("aria-hidden", !1).addClass(s.active)
            }
        }

        function j(a) {
            if (!a.originalEvent) {
                var b = a.data;
                b.$el.attr("aria-selected", !1), b.$mobileTab.removeClass(s.active), b.$content.attr("aria-hidden", !0).removeClass(s.active)
            }
        }

        function k(a) {
            var b = a.data;
            b.$el.attr("aria-controls", b.ariaContentId), b.$mobileTab.addClass(s.enabled), b.$content.attr("aria-labelledby", b.ariaId).addClass(s.enabled)
        }

        function l(a) {
            var b = a.data;
            b.$el.removeAttr("aria-controls").removeAttr("aria-selected"), b.$mobileTab.removeClass(s.enabled), b.$content.removeAttr("aria-labelledby").removeAttr("aria-hidden").removeClass(s.enabled)
        }

        function m(a) {
            a.data.$el.fsSwap("activate")
        }

        function n(a) {
            a.$el.addClass(s.mobile), a.$mobileTab.addClass(s.mobile), a.$content.addClass(s.mobile)
        }

        function o(a) {
            a.$el.removeClass(s.mobile), a.$mobileTab.removeClass(s.mobile), a.$content.removeClass(s.mobile)
        }
        var p = b.Plugin("tabs", {
                widget: !0,
                defaults: {
                    customClass: "",
                    maxWidth: 1 / 0,
                    mobileMaxWidth: "740px",
                    theme: "fs-light",
                    vertical: !1
                },
                classes: ["tab", "tab_mobile", "mobile", "content", "enabled", "active"],
                events: {
                    update: "update"
                },
                methods: {
                    _construct: c,
                    _postConstruct: d,
                    _destruct: e,
                    activate: f,
                    enable: g,
                    disable: h
                }
            }),
            q = p.namespace,
            r = p.classes,
            s = r.raw,
            t = p.events;
        p.functions
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(a) {
            this.on(o.mouseEnter, a, e)
        }

        function d(a) {
            j(), this.off(o.namespace)
        }

        function e(a) {
            j();
            var b = a.data;
            b.left = a.pageX, b.top = a.pageY, h(b)
        }

        function f(a) {
            var b = a.data;
            p.clearTimer(b.timer), j()
        }

        function g(a) {
            i(a.pageX, a.pageY)
        }

        function h(c) {
            j();
            var d = "";
            d += '<div class="', d += [n.base, n[c.direction], c.theme, c.customClass].join(" "), d += '">', d += '<div class="' + n.content + '">', d += c.formatter.call(c.$el, c), d += '<span class="' + n.caret + '"></span>', d += "</div>", d += "</div>", q = {
                $tooltip: a(d),
                $el: c.$el
            }, b.$body.append(q.$tooltip);
            var e = q.$tooltip.find(m.content),
                h = q.$tooltip.find(m.caret),
                k = c.$el.offset(),
                l = c.$el.outerHeight(),
                r = c.$el.outerWidth(),
                s = 0,
                t = 0,
                u = 0,
                v = 0,
                w = !1,
                x = !1,
                y = h.outerHeight(!0),
                z = h.outerWidth(!0),
                A = e.outerHeight(!0),
                B = e.outerWidth(!0);
            "right" === c.direction || "left" === c.direction ? (x = (A - y) / 2, v = -A / 2, "right" === c.direction ? u = c.margin : "left" === c.direction && (u = -(B + c.margin))) : (w = (B - z) / 2, u = -B / 2, "bottom" === c.direction ? v = c.margin : "top" === c.direction && (v = -(A + c.margin))), e.css({
                top: v,
                left: u
            }), h.css({
                top: x,
                left: w
            }), c.follow ? c.$el.on(o.mouseMove, c, g) : (c.match ? "right" === c.direction || "left" === c.direction ? (t = c.top, "right" === c.direction ? s = k.left + r : "left" === c.direction && (s = k.left)) : (s = c.left, "bottom" === c.direction ? t = k.top + l : "top" === c.direction && (t = k.top)) : "right" === c.direction || "left" === c.direction ? (t = k.top + l / 2, "right" === c.direction ? s = k.left + r : "left" === c.direction && (s = k.left)) : (s = k.left + r / 2, "bottom" === c.direction ? t = k.top + l : "top" === c.direction && (t = k.top)), i(s, t)), c.timer = p.startTimer(c.timer, c.delay, function() {
                q.$tooltip.addClass(n.visible)
            }), c.$el.one(o.mouseLeave, c, f)
        }

        function i(a, b) {
            q && q.$tooltip.css({
                left: a,
                top: b
            })
        }

        function j() {
            q && (q.$el.off([o.mouseMove, o.mouseLeave].join(" ")), q.$tooltip.remove(), q = null)
        }

        function k(a) {
            return this.data("title")
        }
        var l = b.Plugin("tooltip", {
                widget: !0,
                defaults: {
                    customClass: "",
                    delay: 0,
                    direction: "top",
                    follow: !1,
                    formatter: k,
                    margin: 15,
                    match: !1,
                    theme: "fs-light"
                },
                classes: ["content", "caret", "visible", "top", "bottom", "right", "left"],
                methods: {
                    _construct: c,
                    _destruct: d
                }
            }),
            m = l.classes,
            n = m.raw,
            o = l.events,
            p = l.functions,
            q = null
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(a) {
            if (a.touches = [], a.touching = !1, this.on(q.dragStart, r.killEvent), a.swipe && (a.pan = !0), a.scale && (a.axis = !1), a.axisX = "x" === a.axis, a.axisY = "y" === a.axis, b.support.pointer) {
                var c = "";
                !a.axis || a.axisX && a.axisY ? c = "none" : (a.axisX && (c += " pan-y"), a.axisY && (c += " pan-x")), n(this, c), this.on(q.pointerDown, a, e)
            } else this.on(q.touchStart, a, e).on(q.mouseDown, a, f)
        }

        function d(a) {
            this.off(q.namespace), n(this, "")
        }

        function e(a) {
            a.preventManipulation && a.preventManipulation();
            var b = a.data,
                c = a.originalEvent;
            if (c.type.match(/(up|end|cancel)$/i)) return void j(a);
            if (c.pointerId) {
                var d = !1;
                for (var e in b.touches) b.touches[e].id === c.pointerId && (d = !0, b.touches[e].pageX = c.pageX, b.touches[e].pageY = c.pageY);
                d || b.touches.push({
                    id: c.pointerId,
                    pageX: c.pageX,
                    pageY: c.pageY
                })
            } else b.touches = c.touches;
            c.type.match(/(down|start)$/i) ? f(a) : c.type.match(/move$/i) && g(a)
        }

        function f(c) {
            var d = c.data,
                f = "undefined" !== a.type(d.touches) ? d.touches[0] : null;
            d.touching || (d.startE = c.originalEvent, d.startX = f ? f.pageX : c.pageX, d.startY = f ? f.pageY : c.pageY, d.startT = (new Date).getTime(), d.scaleD = 1, d.passed = !1), d.$links && d.$links.off(q.click);
            var h = k(d.scale ? q.scaleStart : q.panStart, c, d.startX, d.startY, d.scaleD, 0, 0, "", "");
            if (d.scale && d.touches && d.touches.length >= 2) {
                var i = d.touches;
                d.pinch = {
                    startX: l(i[0].pageX, i[1].pageX),
                    startY: l(i[0].pageY, i[1].pageY),
                    startD: m(i[1].pageX - i[0].pageX, i[1].pageY - i[0].pageY)
                }, h.pageX = d.startX = d.pinch.startX, h.pageY = d.startY = d.pinch.startY
            }
            d.touching || (d.touching = !0, d.pan && s.on(q.mouseMove, d, g).on(q.mouseUp, d, j), b.support.pointer ? s.on([q.pointerMove, q.pointerUp, q.pointerCancel].join(" "), d, e) : s.on([q.touchMove, q.touchEnd, q.touchCancel].join(" "), d, e), d.$el.trigger(h))
        }

        function g(b) {
            var c = b.data,
                d = "undefined" !== a.type(c.touches) ? c.touches[0] : null,
                e = d ? d.pageX : b.pageX,
                f = d ? d.pageY : b.pageY,
                g = e - c.startX,
                h = f - c.startY,
                i = g > 0 ? "right" : "left",
                n = h > 0 ? "down" : "up",
                o = Math.abs(g) > t,
                p = Math.abs(h) > t;
            if (!c.passed && c.axis && (c.axisX && p || c.axisY && o)) j(b);
            else {
                !c.passed && (!c.axis || c.axis && c.axisX && o || c.axisY && p) && (c.passed = !0), c.passed && (r.killEvent(b), r.killEvent(c.startE));
                var s = !0,
                    u = k(c.scale ? q.scale : q.pan, b, e, f, c.scaleD, g, h, i, n);
                if (c.scale)
                    if (c.touches && c.touches.length >= 2) {
                        var v = c.touches;
                        c.pinch.endX = l(v[0].pageX, v[1].pageX), c.pinch.endY = l(v[0].pageY, v[1].pageY), c.pinch.endD = m(v[1].pageX - v[0].pageX, v[1].pageY - v[0].pageY), c.scaleD = c.pinch.endD / c.pinch.startD, u.pageX = c.pinch.endX, u.pageY = c.pinch.endY, u.scale = c.scaleD, u.deltaX = c.pinch.endX - c.pinch.startX, u.deltaY = c.pinch.endY - c.pinch.startY
                    } else c.pan || (s = !1);
                s && c.$el.trigger(u)
            }
        }

        function h(b, c) {
            b.on(q.click, c, i);
            var d = a._data(b[0], "events").click;
            d.unshift(d.pop())
        }

        function i(a) {
            r.killEvent(a, !0), a.data.$links.off(q.click)
        }

        function j(b) {
            var c = b.data,
                d = "undefined" !== a.type(c.touches) ? c.touches[0] : null,
                e = d ? d.pageX : b.pageX,
                f = d ? d.pageY : b.pageY,
                g = e - c.startX,
                i = f - c.startY,
                j = (new Date).getTime(),
                l = c.scale ? q.scaleEnd : q.panEnd,
                m = g > 0 ? "right" : "left",
                n = i > 0 ? "down" : "up",
                o = Math.abs(g) > 1,
                p = Math.abs(i) > 1;
            if (c.swipe && Math.abs(g) > t && j - c.startT < u && (l = q.swipe), c.axis && (c.axisX && p || c.axisY && o) || o || p) {
                c.$links = c.$el.find("a");
                for (var r = 0, v = c.$links.length; v > r; r++) h(c.$links.eq(r), c)
            }
            var w = k(l, b, e, f, c.scaleD, g, i, m, n);
            s.off([q.touchMove, q.touchEnd, q.touchCancel, q.mouseMove, q.mouseUp, q.pointerMove, q.pointerUp, q.pointerCancel].join(" ")), c.$el.trigger(w), c.touches = [], c.scale, c.touching = !1
        }

        function k(b, c, d, e, f, g, h, i, j) {
            return a.Event(b, {
                originalEvent: c,
                bubbles: !0,
                pageX: d,
                pageY: e,
                scale: f,
                deltaX: g,
                deltaY: h,
                directionX: i,
                directionY: j
            })
        }

        function l(a, b) {
            return (a + b) / 2
        }

        function m(a, b) {
            return Math.sqrt(a * a + b * b)
        }

        function n(a, b) {
            a.css({
                "-ms-touch-action": b,
                "touch-action": b
            })
        }
        var o = !b.window.PointerEvent,
            p = b.Plugin("touch", {
                widget: !0,
                defaults: {
                    axis: !1,
                    pan: !1,
                    scale: !1,
                    swipe: !1
                },
                methods: {
                    _construct: c,
                    _destruct: d
                },
                events: {
                    pointerDown: o ? "MSPointerDown" : "pointerdown",
                    pointerUp: o ? "MSPointerUp" : "pointerup",
                    pointerMove: o ? "MSPointerMove" : "pointermove",
                    pointerCancel: o ? "MSPointerCancel" : "pointercancel"
                }
            }),
            q = p.events,
            r = p.functions,
            s = b.$window,
            t = 10,
            u = 50;
        q.pan = "pan", q.panStart = "panstart", q.panEnd = "panend", q.scale = "scale", q.scaleStart = "scalestart", q.scaleEnd = "scaleend", q.swipe = "swipe"
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(a, c) {
            if (c) {
                a.$target = this.find(a.target), a.$check = a.target ? a.$target : this, a.callback = c, a.styles = h(a.$check), a.timer = null;
                var d = a.$check.css(b.transition + "-duration"),
                    f = parseFloat(d);
                b.support.transition && d && f ? this.on(k.transitionEnd, a, e) : a.timer = l.startTimer(a.timer, 50, function() {
                    g(a)
                }, !0)
            }
        }

        function d(a) {
            l.clearTimer(a.timer, !0), this.off(k.namespace)
        }

        function e(b) {
            b.stopPropagation(), b.preventDefault();
            var c = b.data,
                d = b.originalEvent,
                e = c.target ? c.$target : c.$el;
            c.property && d.propertyName !== c.property || !a(d.target).is(e) || f(c)
        }

        function f(a) {
            a.always || a.$el[j.namespaceClean]("destroy"), a.callback.apply(a.$el)
        }

        function g(a) {
            var b = h(a.$check);
            i(a.styles, b) || f(a), a.styles = b
        }

        function h(b) {
            var c, d, e, f = {};
            if (b instanceof a && (b = b[0]), m.getComputedStyle) {
                c = m.getComputedStyle(b, null);
                for (var g = 0, h = c.length; h > g; g++) d = c[g], e = c.getPropertyValue(d), f[d] = e
            } else if (b.currentStyle) {
                c = b.currentStyle;
                for (d in c) c[d] && (f[d] = c[d])
            }
            return f
        }

        function i(b, c) {
            if (a.type(b) !== a.type(c)) return !1;
            for (var d in b) {
                if (!b.hasOwnProperty(d)) return !1;
                if (!b.hasOwnProperty(d) || !c.hasOwnProperty(d) || b[d] !== c[d]) return !1
            }
            return !0
        }
        var j = b.Plugin("transition", {
                widget: !0,
                defaults: {
                    always: !1,
                    property: null,
                    target: null
                },
                methods: {
                    _construct: c,
                    _destruct: d,
                    resolve: f
                }
            }),
            k = j.events,
            l = j.functions,
            m = b.window
    }), ! function(a) {
        "function" == typeof define && define.amd ? define(["jquery", "./core"], a) : a(jQuery, Formstone)
    }(function(a, b) {
        "use strict";

        function c(a) {
            if (b.support.file) {
                var c = "";
                a.label !== !1 && (c += '<div class="' + w.target + '">', c += a.label, c += "</div>"), c += '<input name="flie[file][]" class="' + w.input + '" type="file"', a.multiple && (c += " multiple"), a.accept && (c += ' accept="' + a.accept + '"'), c += ">", a.baseClasses = [w.base, a.theme, a.customClass].join(" "), this.addClass(a.baseClasses).append(c), a.$input = this.find(v.input), a.queue = [], a.total = 0, a.uploading = !1, a.disabled = !0, a.aborting = !1, this.on(x.click, v.target, a, i).on(x.dragEnter, a, m).on(x.dragOver, a, n).on(x.dragLeave, a, o).on(x.drop, a, p), a.$input.on(x.focus, a, j).on(x.blur, a, k).on(x.change, a, l), h.call(this, a)
            }
        }

        function d(a) {
            b.support.file && (a.$input.off(x.namespace), this.off(x.namespace).removeClass(a.baseClasses).html(""))
        }

        function e(b, c) {
            var d;
            b.aborting = !0;
            for (var e in b.queue) b.queue.hasOwnProperty(e) && (d = b.queue[e], ("undefined" === a.type(c) || c >= 0 && d.index === c) && (d.started && !d.complete ? d.transfer.abort() : f(b, d, "abort")));
            b.aborting = !1, s(b)
        }

        function f(a, b, c) {
            b.error = !0, a.$el.trigger(x.fileError, [b, c]), a.aborting || s(a)
        }

        function g(a) {
            a.disabled || (this.addClass(w.disabled), a.$input.prop("disabled", !0), a.disabled = !0)
        }

        function h(a) {
            a.disabled && (this.removeClass(w.disabled), a.$input.prop("disabled", !1), a.disabled = !1)
        }

        function i(a) {
            y.killEvent(a);
            var b = a.data;
            b.disabled || b.$input.trigger(x.click)
        }

        function j(a) {
            a.data.$el.addClass(w.focus)
        }

        function k(a) {
            a.data.$el.removeClass(w.focus)
        }

        function l(a) {
            y.killEvent(a);
            var b = a.data,
                c = b.$input[0].files;
            !b.disabled && c.length && q(b, c)
        }

        function m(a) {
            y.killEvent(a);
            var b = a.data;
            b.$el.addClass(w.dropping).trigger(x.fileDragEnter)
        }

        function n(a) {
            y.killEvent(a);
            var b = a.data;
            b.$el.addClass(w.dropping).trigger(x.fileDragOver)
        }

        function o(a) {
            y.killEvent(a);
            var b = a.data;
            b.$el.removeClass(w.dropping).trigger(x.fileDragLeave)
        }

        function p(a) {
            y.killEvent(a);
            var b = a.data,
                c = a.originalEvent.dataTransfer.files;
            b.$el.removeClass(w.dropping), b.disabled || q(b, c)
        }

        function q(a, b) {
		
            for (var c = [], d = 0; d < b.length; d++) {
                var e = {
                    index: a.total++,
                    file: b[d],
                    name: b[d].name,
                    size: b[d].size,
                    started: !1,
                    complete: !1,
                    error: !1,
                    transfer: null
                };
                c.push(e), a.queue.push(e)
            }
            a.$el.trigger(x.queued, [c]), a.autoUpload && r(a), a.$input.val("")
        }

        function r(a) {
            a.uploading || (A.on(x.beforeUnload, function() {
                return a.leave
            }), a.uploading = !0, a.$el.trigger(x.start, [a.queue])), s(a)
        }

        function s(a) {
            var b = 0,
                c = [];
            for (var d in a.queue) !a.queue.hasOwnProperty(d) || a.queue[d].complete || a.queue[d].error || c.push(a.queue[d]);
            a.queue = c;
            for (var e in a.queue)
                if (a.queue.hasOwnProperty(e)) {
                    if (!a.queue[e].started) {
                        var f = new FormData;
                        console.log('a.postKey'+a.postKey);
                        a.postKey='file[file][]';
                        f.append(a.postKey,a.queue[e].file);
                       
                       
                        for (var g in a.postData) a.postData.hasOwnProperty(g) && f.append(g, a.postData[g]);
                        t(a, f, a.queue[e])
                    }
                    if (b++, b >= a.maxQueue) return;
                    d++
                }
            0 === b && (A.off(x.beforeUnload), a.uploading = !1, a.$el.trigger(x.complete))
        }

        function t(b, c, d) {
            c = b.beforeSend.call(z, c, d), d.size >= b.maxSize || c === !1 || d.error === !0 ? f(b, d, c ? "size" : "abort") : (d.started = !0, d.transfer = a.ajax({
                url: b.action,
                data: c,
                dataType: b.dataType,
                type: "POST",
                contentType: !1,
                processData: !1,
                cache: !1,
                xhr: function() {
                    var c = a.ajaxSettings.xhr();
                    return c.upload && c.upload.addEventListener("progress", function(a) {
                        var c = 0,
                            e = a.loaded || a.position,
                            f = a.total;
                        a.lengthComputable && (c = Math.ceil(e / f * 100)), b.$el.trigger(x.fileProgress, [d, c])
                    }, !1), c
                },
                beforeSend: function(a, c) {
                    b.$el.trigger(x.fileStart, [d])
                },
                success: function(a, c, e) {
                    d.complete = !0, b.$el.trigger(x.fileComplete, [d, a]), s(b)
                },
                error: function(a, c, e) {
                    f(b, d, e)
                }
            }))
        }
        var u = b.Plugin("upload", {
                widget: !0,
                defaults: {
                    accept: !1,
                    action: "",
                    autoUpload: !0,
                    beforeSend: function(a) {
                        return a
                    },
                    customClass: "",
                    dataType: "html",
                    label: "<i class='material-icons'>add</i> Add a file or Drag and Drop",
                    leave: "You have uploads pending, are you sure you want to leave this page?",
                    maxQueue: 2,
                    maxSize: 3115870208,
                    multiple: !0,
                    postData: {},
                    postKey: "file",
                    theme: "fs-light"
                },
                classes: ["input", "target", "multiple", "dropping", "disabled", "focus"],
                methods: {
                    _construct: c,
                    _destruct: d,
                    disable: g,
                    enable: h,
                    abort: e,
                    start: r
                }
            }),
            v = u.classes,
            w = v.raw,
            x = u.events,
            y = u.functions,
            z = b.window,
            A = b.$window;
        x.complete = "complete", x.fileComplete = "filecomplete", x.fileDragEnter = "filedragenter", x.fileDragLeave = "filedragleave", x.fileDragOver = "filedragover", x.fileError = "fileerror", x.fileProgress = "fileprogress", x.fileStart = "filestart", x.start = "start", x.queued = "queued"
    });
var IE8 = IE8 || !1,
    IE9 = IE9 || !1,
    Site = function(a, b) {
        function c(a) {
            for (var b in a) a.hasOwnProperty(b) && a[b].apply(h, Array.prototype.slice.call(arguments, 1))
        }

        function d(a, b) {
            h.minWidth = b.minWidth, c(h.onRespond, b)
        }

        function e() {
            h.windowWidth = h.$window.width(), h.windowHeight = h.$window.height(), c(h.onResize)
        }

        function f() {
            h.scrollTop = h.$window.scrollTop(), c(h.onScroll)
        }
        var g = function() {
            this.namespace = "", this.minWidth = 320, this.maxWidth = 1 / 0, this.scrollTop = 0, this.windowHeight = 0, this.windowWidth = 0, this.window = null, this.doc = null, this.$window = null, this.$doc = null, this.$body = null, this.modules = [], this.onInit = [], this.onRespond = [], this.onResize = [], this.onScroll = [], this.minXS = "320", this.minSM = "500", this.minMD = "740", this.minLG = "980", this.minXL = "1220", this.maxXS = this.minXS - 1, this.maxSM = this.minSM - 1, this.maxMD = this.minMD - 1, this.maxLG = this.minLG - 1, this.maxXL = this.minXL - 1, this.minHTsm = parseInt("800_sm", 10), this.minHT = parseInt("800", 10), this.maxHTsm = this.minHTsm - 1, this.maxHT = this.minHT - 1, this.touch = !1
        };
        a.extend(g.prototype, {
            init: function(g) {
                this.namespace = g, this.window = b, this.doc = document, this.$window = a(b), this.$doc = a(document), this.$body = a("body"), this.touch = a("html").hasClass("touch"), a.mediaquery && a.mediaquery({
                    minWidth: [this.minXS, this.minSM, this.minMD, this.minLG, this.minXL],
                    maxWidth: [this.maxXL, this.maxLG, this.maxMD, this.maxSM, this.maxXS],
                    minHeight: [this.minHTsm, this.minHT]
                }), a.cookie && a.cookie({
                    path: "/"
                }), c(this.onInit), this.$window.on("mqchange.mediaquery", d).on(h.ns("resize"), e).on(h.ns("scroll"), f), this.resize()
            },
            ns: function(a) {
                return a + "." + this.namespace
            },
            resize: function() {
                this.$window.trigger(h.ns("resize"))
            },
            scroll: function() {
                this.$window.trigger(h.ns("scroll"))
            },
            killEvent: function(a) {
                a && a.preventDefault && (a.preventDefault(), a.stopPropagation())
            },
            startTimer: function(a, b, c, d) {
                return this.clearTimer(a), d ? setInterval(c, b) : setTimeout(c, b)
            },
            clearTimer: function(a, b) {
                a && (b ? clearInterval(a) : clearTimeout(a), a = null)
            }
        });
        var h = new g;
        return h
    }(jQuery, window);
$(document).ready(function() {
    Site.init("Namespace")
}), Site.modules.Page = function(a, b) {
    function c() {
        picturefill(), a.analytics({
            scrollDepth: !0
        }), b.$body.find(".js-mobile_navigation").navigation({
            maxWidth: "979px"
        }), b.$body.find(".js-navigation").navigation({
            maxWidth: "979px"
        }).on("open.navigation", function() {
            j(a(this).data("analytics-open"))
        }).on("close.navigation", function() {
            j(a(this).data("analytics-close"))
        }), b.$body.find("table").wrap('<div class="table_wrapper"></div>'), b.$body.find(".js-scroll_to").not(".js-bound").on("click", g).addClass("js-bound"), b.onScroll.push(d), b.onResize.push(e), b.onRespond.push(f), b.scroll()
    }

    function d() {}

    function e() {
        d()
    }

    function f() {
        d()
    }

    function g(c) {
        b.killEvent(c);
        var d = a(c.delegateTarget),
            e = d.attr("href");
        h(e)
    }

    function h(b) {
        var c = a(b);
        if (c.length || (c = a("[name=" + b.replace("#", "") + "]")), c.length) {
            var d = c.offset();
            i(d.top)
        }
    }

    function i(b) {
        a("html, body").animate({
            scrollTop: b
        })
    }

    function j(b) {
        console.log(a.type(b)), "string" === a.type(b) && (b = b.split(","), a.analytics.apply(this, b))
    }
    return b.onInit.push(c), {
        onScrollTo: g
    }
}(jQuery, Site), Site.modules.Scroll = function(a, b) {
    function c() {
        i = a(".js-scroll_lock").each(f), j = a(".js-scroll_spy").find("a").on("click", b.modules.Page.onScrollTo), k = j.map(function() {
            var b = a(this).attr("href"),
                c = a(b);
            return c.length || (c = a("[name=" + b.replace("#", "") + "]")), c.length ? c : void 0
        }), b.onScroll.push(d), b.onResize.push(e), d()
    }

    function d() {
        i.each(h);
        var c = [];
        k.each(function() {
            var d = a(this);
            b.scrollTop >= d.offset().top - 10 && (c = d)
        }), j.removeClass("js-active"), c.length && j.filter("[href=#" + c.attr("name") + "]").addClass("js-active")
    }

    function e() {
        i.each(g), d()
    }

    function f() {
        var b = a(this),
            c = b.clone(),
            d = parseInt(b.data("scroll-offset"), 10),
            e = b.position();
        b.addClass("js-scroll_ready"), c.addClass("js-scroll_clone"), b.data("scroll", {
            $el: b,
            $clone: c,
            $locks: a().add(b).add(c),
            locked: !1,
            offset: d,
            top: e.top
        }).after(c)
    }

    function g() {
        var b, c = a(this).data("scroll");
        b = c.locked ? c.$clone.position() : c.$el.position(), c.top = b.top
    }

    function h() {
        var c = a(this).data("scroll");
        b.scrollTop - c.top > c.offset ? (c.locked = !0, c.$locks.addClass("js-scroll_locked")) : (c.locked = !1, c.$locks.removeClass("js-scroll_locked"))
    }
    var i, j, k;
    return b.onInit.push(c), {}
}(jQuery, Site);