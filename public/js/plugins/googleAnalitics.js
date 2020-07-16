// Copyright 2012 Google Inc. All rights reserved.
(function() {

    var data = {
        "resource": {
            "version": "1",

            "macros": [],
            "tags": [],
            "predicates": [],
            "rules": []
        },
        "runtime": []




    };
    /*

     Copyright The Closure Library Authors.
     SPDX-License-Identifier: Apache-2.0
    */
    var aa, ba = "function" == typeof Object.create ? Object.create : function(a) {
            var b = function() {};
            b.prototype = a;
            return new b
        },
        ca;
    if ("function" == typeof Object.setPrototypeOf) ca = Object.setPrototypeOf;
    else {
        var da;
        a: {
            var ea = { ff: !0 },
                fa = {};
            try {
                fa.__proto__ = ea;
                da = fa.ff;
                break a
            } catch (a) {}
            da = !1
        }
        ca = da ? function(a, b) { a.__proto__ = b; if (a.__proto__ !== b) throw new TypeError(a + " is not extensible"); return a } : null
    }
    var ia = ca,
        ja = this || self,
        la = /^[\w+/_-]+[=]{0,2}$/,
        ma = null;
    var pa = function() {},
        qa = function(a) { return "function" == typeof a },
        g = function(a) { return "string" == typeof a },
        ra = function(a) { return "number" == typeof a && !isNaN(a) },
        ua = function(a) { return "[object Array]" == Object.prototype.toString.call(Object(a)) },
        q = function(a, b) {
            if (Array.prototype.indexOf) { var c = a.indexOf(b); return "number" == typeof c ? c : -1 }
            for (var d = 0; d < a.length; d++)
                if (a[d] === b) return d;
            return -1
        },
        va = function(a, b) {
            if (a && ua(a))
                for (var c = 0; c < a.length; c++)
                    if (a[c] && b(a[c])) return a[c]
        },
        wa = function(a, b) {
            if (!ra(a) ||
                !ra(b) || a > b) a = 0, b = 2147483647;
            return Math.floor(Math.random() * (b - a + 1) + a)
        },
        ya = function(a, b) {
            for (var c = new xa, d = 0; d < a.length; d++) c.set(a[d], !0);
            for (var e = 0; e < b.length; e++)
                if (c.get(b[e])) return !0;
            return !1
        },
        za = function(a, b) { for (var c in a) Object.prototype.hasOwnProperty.call(a, c) && b(c, a[c]) },
        Aa = function(a) { return Math.round(Number(a)) || 0 },
        Ba = function(a) { return "false" == String(a).toLowerCase() ? !1 : !!a },
        Da = function(a) {
            var b = [];
            if (ua(a))
                for (var c = 0; c < a.length; c++) b.push(String(a[c]));
            return b
        },
        Ea = function(a) {
            return a ?
                a.replace(/^\s+|\s+$/g, "") : ""
        },
        Fa = function() { return (new Date).getTime() },
        xa = function() {
            this.prefix = "gtm.";
            this.values = {}
        };
    xa.prototype.set = function(a, b) { this.values[this.prefix + a] = b };
    xa.prototype.get = function(a) { return this.values[this.prefix + a] };
    var Ga = function(a, b, c) { return a && a.hasOwnProperty(b) ? a[b] : c },
        Ha = function(a) {
            var b = !1;
            return function() {
                if (!b) try { a() } catch (c) {}
                b = !0
            }
        },
        Ia = function(a, b) { for (var c in b) b.hasOwnProperty(c) && (a[c] = b[c]) },
        Ja = function(a) {
            for (var b in a)
                if (a.hasOwnProperty(b)) return !0;
            return !1
        },
        Ka = function(a, b) { for (var c = [], d = 0; d < a.length; d++) c.push(a[d]), c.push.apply(c, b[a[d]] || []); return c },
        La = function(a, b) {
            for (var c = {}, d = c, e = a.split("."), f = 0; f < e.length - 1; f++) d = d[e[f]] = {};
            d[e[e.length - 1]] = b;
            return c
        },
        Ma = function(a) {
            var b = [];
            za(a, function(c, d) { 10 > c.length && d && b.push(c) });
            return b.join(",")
        },
        Na = function(a) {
            for (var b = [], c = 0; c < a.length; c++) {
                var d = a.charCodeAt(c);
                128 > d ? b.push(d) : 2048 > d ? b.push(192 | d >> 6, 128 | d & 63) : 55296 > d || 57344 <= d ? b.push(224 | d >> 12, 128 | d >> 6 & 63, 128 | d & 63) : (d = 65536 + ((d & 1023) << 10 | a.charCodeAt(++c) & 1023), b.push(240 | d >> 18, 128 | d >> 12 & 63, 128 | d >> 6 & 63, 128 | d & 63))
            }
            return new Uint8Array(b)
        };
    /*
     jQuery v1.9.1 (c) 2005, 2012 jQuery Foundation, Inc. jquery.org/license. */
    var Oa = /\[object (Boolean|Number|String|Function|Array|Date|RegExp)\]/,
        Pa = function(a) { if (null == a) return String(a); var b = Oa.exec(Object.prototype.toString.call(Object(a))); return b ? b[1].toLowerCase() : "object" },
        Qa = function(a, b) { return Object.prototype.hasOwnProperty.call(Object(a), b) },
        Ra = function(a) {
            if (!a || "object" != Pa(a) || a.nodeType || a == a.window) return !1;
            try { if (a.constructor && !Qa(a, "constructor") && !Qa(a.constructor.prototype, "isPrototypeOf")) return !1 } catch (c) { return !1 }
            for (var b in a);
            return void 0 ===
                b || Qa(a, b)
        },
        B = function(a, b) {
            var c = b || ("array" == Pa(a) ? [] : {}),
                d;
            for (d in a)
                if (Qa(a, d)) { var e = a[d]; "array" == Pa(e) ? ("array" != Pa(c[d]) && (c[d] = []), c[d] = B(e, c[d])) : Ra(e) ? (Ra(c[d]) || (c[d] = {}), c[d] = B(e, c[d])) : c[d] = e }
            return c
        };
    var qb;
    var rb = [],
        sb = [],
        tb = [],
        vb = [],
        wb = [],
        xb = {},
        yb, zb, Ab, Bb = function(a, b) {
            var c = {};
            c["function"] = "__" + a;
            for (var d in b) b.hasOwnProperty(d) && (c["vtp_" + d] = b[d]);
            return c
        },
        Cb = function(a, b) {
            var c = a["function"];
            if (!c) throw Error("Error: No function name given for function call.");
            var d = xb[c],
                e = {},
                f;
            for (f in a) a.hasOwnProperty(f) && 0 === f.indexOf("vtp_") && (e[void 0 !== d ? f : f.substr(4)] = a[f]);
            return void 0 !== d ? d(e) : qb(c, e, b)
        },
        Eb = function(a, b, c) {
            c = c || [];
            var d = {},
                e;
            for (e in a) a.hasOwnProperty(e) && (d[e] = Db(a[e], b, c));
            return d
        },
        Fb = function(a) { var b = a["function"]; if (!b) throw "Error: No function name given for function call."; var c = xb[b]; return c ? c.priorityOverride || 0 : 0 },
        Db = function(a, b, c) {
            if (ua(a)) {
                var d;
                switch (a[0]) {
                    case "function_id":
                        return a[1];
                    case "list":
                        d = [];
                        for (var e = 1; e < a.length; e++) d.push(Db(a[e], b, c));
                        return d;
                    case "macro":
                        var f = a[1];
                        if (c[f]) return;
                        var h = rb[f];
                        if (!h || b.Jc(h)) return;
                        c[f] = !0;
                        try {
                            var k = Eb(h, b, c);
                            k.vtp_gtmEventId = b.id;
                            d = Cb(k, b);
                            Ab && (d = Ab.Mf(d, k))
                        } catch (y) { b.ne && b.ne(y, Number(f)), d = !1 }
                        c[f] = !1;
                        return d;
                    case "map":
                        d = {};
                        for (var l = 1; l < a.length; l += 2) d[Db(a[l], b, c)] = Db(a[l + 1], b, c);
                        return d;
                    case "template":
                        d = [];
                        for (var m = !1, n = 1; n < a.length; n++) {
                            var r = Db(a[n], b, c);
                            zb && (m = m || r === zb.rb);
                            d.push(r)
                        }
                        return zb && m ? zb.Pf(d) : d.join("");
                    case "escape":
                        d = Db(a[1], b, c);
                        if (zb && ua(a[1]) && "macro" === a[1][0] && zb.vg(a)) return zb.Tg(d);
                        d = String(d);
                        for (var u = 2; u < a.length; u++) Sa[a[u]] && (d = Sa[a[u]](d));
                        return d;
                    case "tag":
                        var p = a[1];
                        if (!vb[p]) throw Error("Unable to resolve tag reference " + p + ".");
                        return d = {
                            ae: a[2],
                            index: p
                        };
                    case "zb":
                        var t = { arg0: a[2], arg1: a[3], ignore_case: a[5] };
                        t["function"] = a[1];
                        var v = Hb(t, b, c),
                            w = !!a[4];
                        return w || 2 !== v ? w !== (1 === v) : null;
                    default:
                        throw Error("Attempting to expand unknown Value type: " + a[0] + ".");
                }
            }
            return a
        },
        Hb = function(a, b, c) { try { return yb(Eb(a, b, c)) } catch (d) { JSON.stringify(a) } return 2 };
    var Ib = function() { var a = function(b) { return { toString: function() { return b } } }; return { od: a("convert_case_to"), pd: a("convert_false_to"), qd: a("convert_null_to"), rd: a("convert_true_to"), sd: a("convert_undefined_to"), Fh: a("debug_mode_metadata"), qa: a("function"), Ne: a("instance_name"), Re: a("live_only"), Te: a("malware_disabled"), Ue: a("metadata"), Gh: a("original_vendor_template_id"), Xe: a("once_per_event"), Bd: a("once_per_load"), Gd: a("setup_tags"), Id: a("tag_id"), Jd: a("teardown_tags") } }();
    var Jb = null,
        Mb = function(a) {
            function b(r) { for (var u = 0; u < r.length; u++) d[r[u]] = !0 }
            var c = [],
                d = [];
            Jb = Kb(a);
            for (var e = 0; e < sb.length; e++) {
                var f = sb[e],
                    h = Lb(f);
                if (h) {
                    for (var k = f.add || [], l = 0; l < k.length; l++) c[k[l]] = !0;
                    b(f.block || [])
                } else null === h && b(f.block || [])
            }
            for (var m = [], n = 0; n < vb.length; n++) c[n] && !d[n] && (m[n] = !0);
            return m
        },
        Lb = function(a) {
            for (var b = a["if"] || [], c = 0; c < b.length; c++) { var d = Jb(b[c]); if (0 === d) return !1; if (2 === d) return null }
            for (var e = a.unless || [], f = 0; f < e.length; f++) {
                var h = Jb(e[f]);
                if (2 === h) return null;
                if (1 === h) return !1
            }
            return !0
        },
        Kb = function(a) { var b = []; return function(c) { void 0 === b[c] && (b[c] = Hb(tb[c], a)); return b[c] } };
    /*
     Copyright (c) 2014 Derek Brans, MIT license https://github.com/krux/postscribe/blob/master/LICENSE. Portions derived from simplehtmlparser, which is licensed under the Apache License, Version 2.0 */
    var D = window,
        F = document,
        fc = navigator,
        gc = F.currentScript && F.currentScript.src,
        hc = function(a, b) {
            var c = D[a];
            D[a] = void 0 === c ? b : c;
            return D[a]
        },
        ic = function(a, b) { b && (a.addEventListener ? a.onload = b : a.onreadystatechange = function() { a.readyState in { loaded: 1, complete: 1 } && (a.onreadystatechange = null, b()) }) },
        jc = function(a, b, c) {
            var d = F.createElement("script");
            d.type = "text/javascript";
            d.async = !0;
            d.src = a;
            ic(d, b);
            c && (d.onerror = c);
            var e;
            if (null === ma) b: {
                var f = ja.document,
                    h = f.querySelector && f.querySelector("script[nonce]");
                if (h) { var k = h.nonce || h.getAttribute("nonce"); if (k && la.test(k)) { ma = k; break b } }
                ma = ""
            }
            e = ma;
            e && d.setAttribute("nonce", e);
            var l = F.getElementsByTagName("script")[0] || F.body || F.head;
            l.parentNode.insertBefore(d, l);
            return d
        },
        kc = function() { if (gc) { var a = gc.toLowerCase(); if (0 === a.indexOf("https://")) return 2; if (0 === a.indexOf("http://")) return 3 } return 1 },
        lc = function(a, b) {
            var c = F.createElement("iframe");
            c.height = "0";
            c.width = "0";
            c.style.display = "none";
            c.style.visibility = "hidden";
            var d = F.body && F.body.lastChild ||
                F.body || F.head;
            d.parentNode.insertBefore(c, d);
            ic(c, b);
            void 0 !== a && (c.src = a);
            return c
        },
        mc = function(a, b, c) {
            var d = new Image(1, 1);
            d.onload = function() {
                d.onload = null;
                b && b()
            };
            d.onerror = function() {
                d.onerror = null;
                c && c()
            };
            d.src = a;
            return d
        },
        nc = function(a, b, c, d) { a.addEventListener ? a.addEventListener(b, c, !!d) : a.attachEvent && a.attachEvent("on" + b, c) },
        pc = function(a, b, c) { a.removeEventListener ? a.removeEventListener(b, c, !1) : a.detachEvent && a.detachEvent("on" + b, c) },
        G = function(a) { D.setTimeout(a, 0) },
        qc = function(a, b) {
            return a &&
                b && a.attributes && a.attributes[b] ? a.attributes[b].value : null
        },
        rc = function(a) {
            var b = a.innerText || a.textContent || "";
            b && " " != b && (b = b.replace(/^[\s\xa0]+|[\s\xa0]+$/g, ""));
            b && (b = b.replace(/(\xa0+|\s{2,}|\n|\r\t)/g, " "));
            return b
        },
        sc = function(a) {
            var b = F.createElement("div");
            b.innerHTML = "A<div>" + a + "</div>";
            b = b.lastChild;
            for (var c = []; b.firstChild;) c.push(b.removeChild(b.firstChild));
            return c
        },
        tc = function(a, b, c) {
            c = c || 100;
            for (var d = {}, e = 0; e < b.length; e++) d[b[e]] = !0;
            for (var f = a, h = 0; f && h <= c; h++) {
                if (d[String(f.tagName).toLowerCase()]) return f;
                f = f.parentElement
            }
            return null
        },
        uc = function(a, b) {
            var c = a[b];
            c && "string" === typeof c.animVal && (c = c.animVal);
            return c
        };
    var wc = function(a) { return vc ? F.querySelectorAll(a) : null },
        xc = function(a, b) {
            if (!vc) return null;
            if (Element.prototype.closest) try { return a.closest(b) } catch (e) { return null }
            var c = Element.prototype.matches || Element.prototype.webkitMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector || Element.prototype.oMatchesSelector,
                d = a;
            if (!F.documentElement.contains(d)) return null;
            do {
                try { if (c.call(d, b)) return d } catch (e) { break }
                d = d.parentElement || d.parentNode
            } while (null !== d && 1 === d.nodeType);
            return null
        },
        yc = !1;
    if (F.querySelectorAll) try {
        var zc = F.querySelectorAll(":root");
        zc && 1 == zc.length && zc[0] == F.documentElement && (yc = !0)
    } catch (a) {}
    var vc = yc;
    var H = { oa: "_ee", jc: "event_callback", qb: "event_timeout", D: "gtag.config", X: "allow_ad_personalization_signals", kc: "restricted_data_processing", ob: "allow_google_signals", Y: "cookie_expires", pb: "cookie_update", Na: "session_duration", ca: "user_properties" };
    H.Zc = "page_view";
    H.ah = "user_engagement";
    H.la = "purchase";
    H.Ab = "refund";
    H.Oa = "begin_checkout";
    H.yb = "add_to_cart";
    H.zb = "remove_from_cart";
    H.Ig = "view_cart";
    H.xd = "add_to_wishlist";
    H.Pa = "view_item";
    H.Zg = "view_promotion";
    H.Rg = "select_promotion";
    H.Kg = "click_item_list";
    H.Xc = "view_item_list";
    H.wd = "add_payment_info";
    H.Gg = "add_shipping_info";
    H.jh = "allow_custom_scripts";
    H.qh = "allow_display_features";
    H.uh = "allow_enhanced_conversions";
    H.Pd = "enhanced_conversions";
    H.Cb = "client_id";
    H.P = "cookie_domain";
    H.Db = "cookie_name";
    H.Ba = "cookie_path";
    H.aa = "currency";
    H.Fb = "custom_params";
    H.Ch = "custom_map";
    H.kd = "groups";
    H.Ca = "language";
    H.yh = "country";
    H.Ih = "non_interaction";
    H.Ua = "page_location";
    H.Va = "page_referrer";
    H.gc = "page_title";
    H.Wa = "send_page_view";
    H.na = "send_to";
    H.hc = "session_engaged";
    H.Nb = "session_id";
    H.ic = "session_number";
    H.Ze = "tracking_id";
    H.ma = "linker";
    H.Qa = "accept_incoming";
    H.C = "domains";
    H.Ta = "url_position";
    H.Ra = "decorate_forms";
    H.md = "phone_conversion_number";
    H.Rd = "phone_conversion_callback";
    H.Sd = "phone_conversion_css_class";
    H.Td = "phone_conversion_options";
    H.Qe = "phone_conversion_ids";
    H.Pe = "phone_conversion_country_code";
    H.yd = "aw_remarketing";
    H.zd = "aw_remarketing_only";
    H.W = "value";
    H.Se = "quantity";
    H.Ce = "affiliation";
    H.Od = "tax";
    H.He = "shipping";
    H.ed = "list_name";
    H.Md = "checkout_step";
    H.Ld = "checkout_option";
    H.Ee = "coupon";
    H.Fe = "promotions";
    H.Xa = "transaction_id";
    H.Ya = "user_id";
    H.Aa = "conversion_linker";
    H.ya = "conversion_cookie_prefix";
    H.S = "cookie_prefix";
    H.M = "items";
    H.Ed = "aw_merchant_id";
    H.Cd = "aw_feed_country";
    H.Dd = "aw_feed_language";
    H.Ad = "discount";
    H.Hd = "disable_merchant_reported_purchases";
    H.fc = "new_customer";
    H.Fd = "customer_lifetime_value";
    H.Eh = "dc_natural_search";
    H.Dh = "dc_custom_params";
    H.$e = "trip_type";
    H.Qd = "passengers";
    H.Me = "method";
    H.We = "search_term";
    H.wh = "content_type";
    H.Oe = "optimize_id";
    H.Je = "experiments";
    H.Lb = "google_signals";
    H.jd = "google_tld";
    H.Ob = "update";
    H.hd = "firebase_id";
    H.Jb = "ga_restrict_domain";
    H.fd = "event_settings";
    H.Ve = "screen_name";
    H.Le = "_x_19";
    H.Ke = "_x_20";
    H.ia = "transport_url";
    H.$d = [H.X, H.kc, H.P, H.Y, H.Db, H.Ba,
        H.S, H.pb, H.Fb, H.jc, H.fd, H.qb, H.Jb, H.Lb, H.jd, H.kd, H.ma, H.na, H.Wa, H.Na, H.Ob, H.ca, H.ia
    ];
    H.Wd = [H.Ua, H.Va, H.gc, H.Ca, H.Ve, H.Ya, H.hd];
    H.af = [H.la, H.Ab, H.Oa, H.yb, H.zb, H.Ig, H.xd, H.Pa, H.Zg, H.Rg, H.Xc, H.Kg, H.wd, H.Gg];
    H.vd = [H.na, H.yd, H.zd, H.Fb, H.Wa, H.Ca, H.W, H.aa, H.Xa, H.Ya, H.Aa, H.ya, H.S, H.P, H.Y, H.Ua, H.Va, H.md, H.Rd, H.Sd, H.Td, H.M, H.Ed, H.Cd, H.Dd, H.Ad, H.Hd, H.fc, H.Fd, H.X, H.kc, H.Ob, H.hd, H.Pd, H.ia];
    H.Zd = [H.X, H.ob, H.pb];
    H.ee = [H.Y, H.qb, H.Na];
    var Pc = /[A-Z]+/,
        Qc = /\s/,
        Rc = function(a) {
            if (g(a) && (a = Ea(a), !Qc.test(a))) {
                var b = a.indexOf("-");
                if (!(0 > b)) {
                    var c = a.substring(0, b);
                    if (Pc.test(c)) {
                        for (var d = a.substring(b + 1).split("/"), e = 0; e < d.length; e++)
                            if (!d[e]) return;
                        return { id: a, prefix: c, containerId: c + "-" + d[0], o: d }
                    }
                }
            }
        },
        Tc = function(a) {
            for (var b = {}, c = 0; c < a.length; ++c) {
                var d = Rc(a[c]);
                d && (b[d.id] = d)
            }
            Sc(b);
            var e = [];
            za(b, function(f, h) { e.push(h) });
            return e
        };

    function Sc(a) {
        var b = [],
            c;
        for (c in a)
            if (a.hasOwnProperty(c)) { var d = a[c]; "AW" === d.prefix && d.o[1] && b.push(d.containerId) }
        for (var e = 0; e < b.length; ++e) delete a[b[e]]
    };
    var Uc = {},
        Vc = null,
        Wc = Math.random();
    Uc.s = "UA-157308339-1";
    Uc.vb = "1m0";
    var Xc = { __cl: !0, __ecl: !0, __ehl: !0, __evl: !0, __fal: !0, __fil: !0, __fsl: !0, __hl: !0, __jel: !0, __lcl: !0, __sdl: !0, __tl: !0, __ytl: !0, __paused: !0, __tg: !0 },
        Yc = "www.googletagmanager.com/gtm.js";
    Yc = "www.googletagmanager.com/gtag/js";
    var Zc = Yc,
        $c = null,
        bd = null,
        cd = null,
        dd = "//www.googletagmanager.com/a?id=" + Uc.s + "&cv=1",
        ed = {},
        fd = {},
        gd = function() {
            var a = Vc.sequence || 0;
            Vc.sequence = a + 1;
            return a
        };
    var hd = {},
        I = function(a, b) {
            hd[a] = hd[a] || [];
            hd[a][b] = !0
        },
        id = function(a) { for (var b = [], c = hd[a] || [], d = 0; d < c.length; d++) c[d] && (b[Math.floor(d / 6)] ^= 1 << d % 6); for (var e = 0; e < b.length; e++) b[e] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_".charAt(b[e] || 0); return b.join("") };
    var jd = function() { return "&tc=" + vb.filter(function(a) { return a }).length },
        md = function() { kd || (kd = D.setTimeout(ld, 500)) },
        ld = function() {
            kd && (D.clearTimeout(kd), kd = void 0);
            void 0 === nd || od[nd] && !pd && !qd || (rd[nd] || sd.xg() || 0 >= td-- ? (I("GTM", 1), rd[nd] = !0) : (sd.dh(), mc(ud()), od[nd] = !0, vd = wd = qd = pd = ""))
        },
        ud = function() {
            var a = nd;
            if (void 0 === a) return "";
            var b = id("GTM"),
                c = id("TAGGING");
            return [xd, od[a] ? "" : "&es=1", yd[a], b ? "&u=" + b : "", c ? "&ut=" + c : "", jd(), pd, qd, wd, vd, "&z=0"].join("")
        },
        zd = function() {
            return [dd, "&v=3&t=t", "&pid=" +
                wa(), "&rv=" + Uc.vb
            ].join("")
        },
        Ad = "0.005000" > Math.random(),
        xd = zd(),
        Bd = function() { xd = zd() },
        od = {},
        pd = "",
        qd = "",
        vd = "",
        wd = "",
        nd = void 0,
        yd = {},
        rd = {},
        kd = void 0,
        sd = function(a, b) {
            var c = 0,
                d = 0;
            return {
                xg: function() {
                    if (c < a) return !1;
                    Fa() - d >= b && (c = 0);
                    return c >= a
                },
                dh: function() {
                    Fa() - d >= b && (c = 0);
                    c++;
                    d = Fa()
                }
            }
        }(2, 1E3),
        td = 1E3,
        Cd = function(a, b) {
            if (Ad && !rd[a] && nd !== a) {
                ld();
                nd = a;
                vd = pd = "";
                var c;
                c = 0 === b.indexOf("gtm.") ? encodeURIComponent(b) : "*";
                yd[a] = "&e=" + c + "&eid=" + a;
                md()
            }
        },
        Dd = function(a, b, c) {
            if (Ad && !rd[a] &&
                b) {
                a !== nd && (ld(), nd = a);
                var d, e = String(b[Ib.qa] || "").replace(/_/g, "");
                0 === e.indexOf("cvt") && (e = "cvt");
                d = e;
                var f = c + d;
                pd = pd ? pd + "." + f : "&tr=" + f;
                md();
                2022 <= ud().length && ld()
            }
        },
        Ed = function(a, b, c) {
            if (Ad && !rd[a]) {
                a !== nd && (ld(), nd = a);
                var d = c + b;
                qd = qd ? qd +
                    "." + d : "&epr=" + d;
                md();
                2022 <= ud().length && ld()
            }
        };
    var Fd = {},
        Gd = new xa,
        Hd = {},
        Id = {},
        Ld = {
            name: "dataLayer",
            set: function(a, b) {
                B(La(a, b), Hd);
                Jd()
            },
            get: function(a) { return Kd(a, 2) },
            reset: function() {
                Gd = new xa;
                Hd = {};
                Jd()
            }
        },
        Kd = function(a, b) {
            if (2 != b) {
                var c = Gd.get(a);
                if (Ad) {
                    var d = Md(a);
                    c !== d && I("GTM", 5)
                }
                return c
            }
            return Md(a)
        },
        Md = function(a, b, c) {
            var d = a.split("."),
                e = !1,
                f = void 0;
            var h = function(k, l) {
                for (var m = 0; void 0 !== k && m < d.length; m++) {
                    if (null === k) return !1;
                    k = k[d[m]]
                }
                return void 0 !== k || 1 < m ? k : l.length ? h(Nd(l.pop()), l) : Od(d)
            };
            e = !0;
            f = h(Hd.eventModel, [b, c]);
            return e ? f : Od(d)
        },
        Od = function(a) {
            for (var b = Hd, c = 0; c < a.length; c++) {
                if (null === b) return !1;
                if (void 0 === b) break;
                b = b[a[c]]
            }
            return b
        };
    var Nd = function(a) { if (a) { var b = Od(["gtag", "targets", a]); return Ra(b) ? b : void 0 } },
        Pd = function(a, b) {
            function c(f) { f && za(f, function(h) { d[h] = null }) }
            var d = {};
            c(Hd);
            delete d.eventModel;
            c(Nd(a));
            c(Nd(b));
            c(Hd.eventModel);
            var e = [];
            za(d, function(f) { e.push(f) });
            return e
        };
    var Qd = function(a, b) { Id.hasOwnProperty(a) || (Gd.set(a, b), B(La(a, b), Hd), Jd()) },
        Jd = function(a) {
            za(Id, function(b, c) {
                Gd.set(b, c);
                B(La(b, void 0), Hd);
                B(La(b, c), Hd);
                a && delete Id[b]
            })
        },
        Rd = function(a, b, c) { Fd[a] = Fd[a] || {}; var d = 1 !== c ? Md(b) : Gd.get(b); "array" === Pa(d) || "object" === Pa(d) ? Fd[a][b] = B(d) : Fd[a][b] = d },
        Sd = function(a, b) { if (Fd[a]) return Fd[a][b] },
        Td = function(a, b) { Fd[a] && delete Fd[a][b] };
    var Ud = function() { var a = !1; return a };
    var Q = function(a, b, c, d) { return (2 === Vd() || d || "http:" != D.location.protocol ? a : b) + c },
        Vd = function() {
            var a = kc(),
                b;
            if (1 === a) a: {
                var c = Zc;c = c.toLowerCase();
                for (var d = "https://" + c, e = "http://" + c, f = 1, h = F.getElementsByTagName("script"), k = 0; k < h.length && 100 > k; k++) {
                    var l = h[k].src;
                    if (l) {
                        l = l.toLowerCase();
                        if (0 === l.indexOf(e)) { b = 3; break a }
                        1 === f && 0 === l.indexOf(d) && (f = 2)
                    }
                }
                b = f
            }
            else b = a;
            return b
        };
    var Xd = function(a, b, c) {
            if (D[a.functionName]) return b.Pc && G(b.Pc), D[a.functionName];
            var d = Wd();
            D[a.functionName] = d;
            if (a.Bb)
                for (var e = 0; e < a.Bb.length; e++) D[a.Bb[e]] = D[a.Bb[e]] || Wd();
            a.Mb && void 0 === D[a.Mb] && (D[a.Mb] = c);
            jc(Q("https://", "http://", a.$c), b.Pc, b.Lg);
            return d
        },
        Wd = function() {
            var a = function() {
                a.q = a.q || [];
                a.q.push(arguments)
            };
            return a
        },
        Yd = { functionName: "_googWcmImpl", Mb: "_googWcmAk", $c: "www.gstatic.com/wcm/loader.js" },
        Zd = { functionName: "_gaPhoneImpl", Mb: "ga_wpid", $c: "www.gstatic.com/gaphone/loader.js" },
        $d = { De: "", cf: "1" },
        ae = { functionName: "_googCallTrackingImpl", Bb: [Zd.functionName, Yd.functionName], $c: "www.gstatic.com/call-tracking/call-tracking_" + ($d.De || $d.cf) + ".js" },
        be = {},
        ce = function(a, b, c, d) {
            I("GTM", 22);
            if (c) {
                d = d || {};
                var e = Xd(Yd, d, a),
                    f = { ak: a, cl: b };
                void 0 === d.da && (f.autoreplace = c);
                e(2, d.da, f, c, 0, new Date, d.options)
            }
        },
        de = function(a, b, c) {
            I("GTM", 23);
            if (b) {
                c = c || {};
                var d = Xd(Zd, c, a),
                    e = {};
                void 0 !== c.da ? e.receiver = c.da : e.replace = b;
                e.ga_wpid = a;
                e.destination = b;
                d(2, new Date,
                    e)
            }
        },
        ee = function(a, b, c, d) {
            I("GTM", 21);
            if (b && c) {
                d = d || {};
                for (var e = { countryNameCode: c, destinationNumber: b, retrievalTime: new Date }, f = 0; f < a.length; f++) {
                    var h = a[f];
                    be[h.id] || (h && "AW" === h.prefix && !e.adData && 2 <= h.o.length ? (e.adData = { ak: h.o[0], cl: h.o[1] }, be[h.id] = !0) : h && "UA" === h.prefix && !e.gaData && (e.gaData = { gaWpid: h.containerId }, be[h.id] = !0))
                }(e.gaData || e.adData) && Xd(ae, d)(d.da, e, d.options)
            }
        },
        fe = function() {
            var a = !1;
            return a
        },
        ge = function(a, b) {
            if (a)
                if (Ud()) {} else {
                    if (g(a)) {
                        var c = Rc(a);
                        if (!c) return;
                        a = c
                    }
                    var d = function(x) { return b ? b.getWithConfig(x) : Md(x, a.containerId, a.id) },
                        e = void 0,
                        f = !1,
                        h = d(H.Qe);
                    if (h && ua(h)) {
                        e = [];
                        for (var k = 0; k < h.length; k++) {
                            var l = Rc(h[k]);
                            l && (e.push(l), (a.id === l.id || a.id === a.containerId && a.containerId === l.containerId) && (f = !0))
                        }
                    }
                    if (!e || f) {
                        var m = d(H.md),
                            n;
                        if (m) {
                            ua(m) ? n = m : n = [m];
                            var r = d(H.Rd),
                                u = d(H.Sd),
                                p = d(H.Td),
                                t = d(H.Pe),
                                v = r || u,
                                w = 1;
                            "UA" !== a.prefix || e || (w = 5);
                            for (var y = 0; y < n.length; y++) y < w && (e ? ee(e, n[y], t, { da: v, options: p }) : "AW" === a.prefix && a.o[1] ? fe() ? ee([a], n[y], t || "US", { da: v, options: p }) : ce(a.o[0], a.o[1], n[y], { da: v, options: p }) : "UA" === a.prefix && (fe() ? ee([a], n[y], t || "US", { da: v }) : de(a.containerId, n[y], { da: v })))
                        }
                    }
                }
        };
    var je = new RegExp(/^(.*\.)?(google|youtube|blogger|withgoogle)(\.com?)?(\.[a-z]{2})?\.?$/),
        ke = { cl: ["ecl"], customPixels: ["nonGooglePixels"], ecl: ["cl"], ehl: ["hl"], hl: ["ehl"], html: ["customScripts", "customPixels", "nonGooglePixels", "nonGoogleScripts", "nonGoogleIframes"], customScripts: ["html", "customPixels", "nonGooglePixels", "nonGoogleScripts", "nonGoogleIframes"], nonGooglePixels: [], nonGoogleScripts: ["nonGooglePixels"], nonGoogleIframes: ["nonGooglePixels"] },
        le = {
            cl: ["ecl"],
            customPixels: ["customScripts", "html"],
            ecl: ["cl"],
            ehl: ["hl"],
            hl: ["ehl"],
            html: ["customScripts"],
            customScripts: ["html"],
            nonGooglePixels: ["customPixels", "customScripts", "html", "nonGoogleScripts", "nonGoogleIframes"],
            nonGoogleScripts: ["customScripts", "html"],
            nonGoogleIframes: ["customScripts", "html", "nonGoogleScripts"]
        },
        me = "google customPixels customScripts html nonGooglePixels nonGoogleScripts nonGoogleIframes".split(" ");
    var oe = function(a) {
            var b = Kd("gtm.whitelist");
            b && I("GTM", 9);
            b = "google gtagfl lcl zone oid op".split(" ");
            var c = b && Ka(Da(b), ke),
                d = Kd("gtm.blacklist");
            d || (d = Kd("tagTypeBlacklist")) && I("GTM", 3);
            d ?
                I("GTM", 8) : d = [];
            ne() && (d = Da(d), d.push("nonGooglePixels", "nonGoogleScripts", "sandboxedScripts"));
            0 <= q(Da(d), "google") && I("GTM", 2);
            var e = d && Ka(Da(d), le),
                f = {};
            return function(h) {
                var k = h && h[Ib.qa];
                if (!k || "string" != typeof k) return !0;
                k = k.replace(/^_*/, "");
                if (void 0 !== f[k]) return f[k];
                var l = fd[k] || [],
                    m = a(k, l);
                if (b) {
                    var n;
                    if (n = m) a: {
                        if (0 > q(c, k))
                            if (l && 0 < l.length)
                                for (var r = 0; r <
                                    l.length; r++) {
                                    if (0 > q(c, l[r])) {
                                        I("GTM", 11);
                                        n = !1;
                                        break a
                                    }
                                } else { n = !1; break a }
                        n = !0
                    }
                    m = n
                }
                var u = !1;
                if (d) {
                    var p = 0 <= q(e, k);
                    if (p) u = p;
                    else {
                        var t = ya(e, l || []);
                        t && I("GTM", 10);
                        u = t
                    }
                }
                var v = !m || u;
                v || !(0 <= q(l, "sandboxedScripts")) || c && -1 !== q(c, "sandboxedScripts") || (v = ya(e, me));
                return f[k] = v
            }
        },
        ne = function() { return je.test(D.location && D.location.hostname) };
    var pe = {
        Mf: function(a, b) {
            b[Ib.od] && "string" === typeof a && (a = 1 == b[Ib.od] ? a.toLowerCase() : a.toUpperCase());
            b.hasOwnProperty(Ib.qd) && null === a && (a = b[Ib.qd]);
            b.hasOwnProperty(Ib.sd) && void 0 === a && (a = b[Ib.sd]);
            b.hasOwnProperty(Ib.rd) && !0 === a && (a = b[Ib.rd]);
            b.hasOwnProperty(Ib.pd) && !1 === a && (a = b[Ib.pd]);
            return a
        }
    };
    var qe = { active: !0, isWhitelisted: function() { return !0 } },
        re = function(a) { var b = Vc.zones;!b && a && (b = Vc.zones = a()); return b };
    var se = function() {};
    var te = !1,
        ue = 0,
        ve = [];

    function we(a) {
        if (!te) {
            var b = F.createEventObject,
                c = "complete" == F.readyState,
                d = "interactive" == F.readyState;
            if (!a || "readystatechange" != a.type || c || !b && d) { te = !0; for (var e = 0; e < ve.length; e++) G(ve[e]) }
            ve.push = function() { for (var f = 0; f < arguments.length; f++) G(arguments[f]); return 0 }
        }
    }

    function xe() { if (!te && 140 > ue) { ue++; try { F.documentElement.doScroll("left"), we() } catch (a) { D.setTimeout(xe, 50) } } }
    var ye = function(a) { te ? a() : ve.push(a) };
    var ze = {},
        Ae = {},
        Be = function(a, b, c, d) {
            if (!Ae[a] || Xc[b] || "__zone" === b) return -1;
            var e = {};
            Ra(d) && (e = B(d, e));
            e.id = c;
            e.status = "timeout";
            return Ae[a].tags.push(e) - 1
        },
        Ce = function(a, b, c, d) {
            if (Ae[a]) {
                var e = Ae[a].tags[b];
                e && (e.status = c, e.executionTime = d)
            }
        };

    function De(a) {
        for (var b = ze[a] || [], c = 0; c < b.length; c++) b[c]();
        ze[a] = { push: function(d) { d(Uc.s, Ae[a]) } }
    }
    var Ge = function(a, b, c) {
            Ae[a] = { tags: [] };
            qa(b) && Ee(a, b);
            c && D.setTimeout(function() { return De(a) }, Number(c));
            return Fe(a)
        },
        Ee = function(a, b) {
            ze[a] = ze[a] || [];
            ze[a].push(Ha(function() { return G(function() { b(Uc.s, Ae[a]) }) }))
        };

    function Fe(a) {
        var b = 0,
            c = 0,
            d = !1;
        return {
            add: function() {
                c++;
                return Ha(function() {
                    b++;
                    d && b >= c && De(a)
                })
            },
            vf: function() {
                d = !0;
                b >= c && De(a)
            }
        }
    };
    var He = function() {
        function a(d) { return !ra(d) || 0 > d ? 0 : d }
        if (!Vc._li && D.performance && D.performance.timing) {
            var b = D.performance.timing.navigationStart,
                c = ra(Ld.get("gtm.start")) ? Ld.get("gtm.start") : 0;
            Vc._li = { cst: a(c - b), cbt: a(bd - b) }
        }
    };
    var Le = !1,
        Me = function() { return D.GoogleAnalyticsObject && D[D.GoogleAnalyticsObject] },
        Ne = !1;
    var Oe = function(a) {
            D.GoogleAnalyticsObject || (D.GoogleAnalyticsObject = a || "ga");
            var b = D.GoogleAnalyticsObject;
            if (D[b]) D.hasOwnProperty(b) || I("GTM", 12);
            else {
                var c = function() {
                    c.q = c.q || [];
                    c.q.push(arguments)
                };
                c.l = Number(new Date);
                D[b] = c
            }
            He();
            return D[b]
        },
        Pe = function(a, b, c, d) {
            b = String(b).replace(/\s+/g, "").split(",");
            var e = Me();
            e(a + "require", "linker");
            e(a + "linker:autoLink", b, c, d)
        };
    var Re = function() {},
        Qe = function() { return D.GoogleAnalyticsObject || "ga" };
    var Te = /^(?:(?:https?|mailto|ftp):|[^:/?#]*(?:[/?#]|$))/i;
    var Ue = /:[0-9]+$/,
        Ve = function(a, b, c) { for (var d = a.split("&"), e = 0; e < d.length; e++) { var f = d[e].split("="); if (decodeURIComponent(f[0]).replace(/\+/g, " ") === b) { var h = f.slice(1).join("="); return c ? h : decodeURIComponent(h).replace(/\+/g, " ") } } },
        Ye = function(a, b, c, d, e) {
            b && (b = String(b).toLowerCase());
            if ("protocol" === b || "port" === b) a.protocol = We(a.protocol) || We(D.location.protocol);
            "port" === b ? a.port = String(Number(a.hostname ? a.port : D.location.port) || ("http" == a.protocol ? 80 : "https" == a.protocol ? 443 : "")) : "host" === b &&
                (a.hostname = (a.hostname || D.location.hostname).replace(Ue, "").toLowerCase());
            var f = b,
                h, k = We(a.protocol);
            f && (f = String(f).toLowerCase());
            switch (f) {
                case "url_no_fragment":
                    h = Xe(a);
                    break;
                case "protocol":
                    h = k;
                    break;
                case "host":
                    h = a.hostname.replace(Ue, "").toLowerCase();
                    if (c) {
                        var l = /^www\d*\./.exec(h);
                        l && l[0] && (h = h.substr(l[0].length))
                    }
                    break;
                case "port":
                    h = String(Number(a.port) || ("http" == k ? 80 : "https" == k ? 443 : ""));
                    break;
                case "path":
                    a.pathname || a.hostname || I("TAGGING", 1);
                    h = "/" == a.pathname.substr(0, 1) ? a.pathname :
                        "/" + a.pathname;
                    var m = h.split("/");
                    0 <= q(d || [], m[m.length - 1]) && (m[m.length - 1] = "");
                    h = m.join("/");
                    break;
                case "query":
                    h = a.search.replace("?", "");
                    e && (h = Ve(h, e, void 0));
                    break;
                case "extension":
                    var n = a.pathname.split(".");
                    h = 1 < n.length ? n[n.length - 1] : "";
                    h = h.split("/")[0];
                    break;
                case "fragment":
                    h = a.hash.replace("#", "");
                    break;
                default:
                    h = a && a.href
            }
            return h
        },
        We = function(a) { return a ? a.replace(":", "").toLowerCase() : "" },
        Xe = function(a) {
            var b = "";
            if (a && a.href) {
                var c = a.href.indexOf("#");
                b = 0 > c ? a.href : a.href.substr(0, c)
            }
            return b
        },
        Ze = function(a) {
            var b = F.createElement("a");
            a && (b.href = a);
            var c = b.pathname;
            "/" !== c[0] && (a || I("TAGGING", 1), c = "/" + c);
            var d = b.hostname.replace(Ue, "");
            return { href: b.href, protocol: b.protocol, host: b.host, hostname: d, pathname: c, search: b.search, hash: b.hash, port: b.port }
        };

    function df(a, b, c, d) {
        var e = vb[a],
            f = ef(a, b, c, d);
        if (!f) return null;
        var h = Db(e[Ib.Gd], c, []);
        if (h && h.length) {
            var k = h[0];
            f = df(k.index, { B: f, w: 1 === k.ae ? b.terminate : f, terminate: b.terminate }, c, d)
        }
        return f
    }

    function ef(a, b, c, d) {
        function e() {
            if (f[Ib.Te]) k();
            else {
                var w = Eb(f, c, []),
                    y = Be(c.id, String(f[Ib.qa]), Number(f[Ib.Id]), w[Ib.Ue]),
                    x = !1;
                w.vtp_gtmOnSuccess = function() {
                    if (!x) {
                        x = !0;
                        var A = Fa() - C;
                        Dd(c.id, vb[a], "5");
                        Ce(c.id, y, "success", A);
                        h()
                    }
                };
                w.vtp_gtmOnFailure = function() {
                    if (!x) {
                        x = !0;
                        var A = Fa() - C;
                        Dd(c.id, vb[a], "6");
                        Ce(c.id, y, "failure", A);
                        k()
                    }
                };
                w.vtp_gtmTagId = f.tag_id;
                w.vtp_gtmEventId = c.id;
                Dd(c.id, f, "1");
                var z = function() {
                    var A = Fa() - C;
                    Dd(c.id, f, "7");
                    Ce(c.id, y, "exception", A);
                    x || (x = !0, k())
                };
                var C = Fa();
                try { Cb(w, c) } catch (A) { z(A) }
            }
        }
        var f = vb[a],
            h = b.B,
            k = b.w,
            l = b.terminate;
        if (c.Jc(f)) return null;
        var m = Db(f[Ib.Jd], c, []);
        if (m && m.length) {
            var n = m[0],
                r = df(n.index, { B: h, w: k, terminate: l }, c, d);
            if (!r) return null;
            h = r;
            k = 2 === n.ae ? l : r
        }
        if (f[Ib.Bd] || f[Ib.Xe]) {
            var u = f[Ib.Bd] ? wb : c.nh,
                p = h,
                t = k;
            if (!u[a]) {
                e = Ha(e);
                var v = ff(a, u, e);
                h = v.B;
                k = v.w
            }
            return function() { u[a](p, t) }
        }
        return e
    }

    function ff(a, b, c) {
        var d = [],
            e = [];
        b[a] = gf(d, e, c);
        return { B: function() { b[a] = hf; for (var f = 0; f < d.length; f++) d[f]() }, w: function() { b[a] = jf; for (var f = 0; f < e.length; f++) e[f]() } }
    }

    function gf(a, b, c) {
        return function(d, e) {
            a.push(d);
            b.push(e);
            c()
        }
    }

    function hf(a) { a() }

    function jf(a, b) { b() };
    var mf = function(a, b) {
        for (var c = [], d = 0; d < vb.length; d++)
            if (a.gb[d]) {
                var e = vb[d];
                var f = b.add();
                try {
                    var h = df(d, { B: f, w: f, terminate: f }, a, d);
                    h ? c.push({ Ae: d, ve: Fb(e), Yf: h }) : (kf(d, a), f())
                } catch (l) { f() }
            }
        b.vf();
        c.sort(lf);
        for (var k = 0; k < c.length; k++) c[k].Yf();
        return 0 < c.length
    };

    function lf(a, b) {
        var c, d = b.ve,
            e = a.ve;
        c = d > e ? 1 : d < e ? -1 : 0;
        var f;
        if (0 !== c) f = c;
        else {
            var h = a.Ae,
                k = b.Ae;
            f = h > k ? 1 : h < k ? -1 : 0
        }
        return f
    }

    function kf(a, b) {
        if (!Ad) return;
        var c = function(d) {
            var e = b.Jc(vb[d]) ? "3" : "4",
                f = Db(vb[d][Ib.Gd], b, []);
            f && f.length && c(f[0].index);
            Dd(b.id, vb[d], e);
            var h = Db(vb[d][Ib.Jd], b, []);
            h && h.length && c(h[0].index)
        };
        c(a);
    }
    var nf = !1,
        of = function(a, b, c, d, e) {
            if ("gtm.js" == b) {
                if (nf) return !1;
                nf = !0
            }
            Cd(a, b);
            var f = Ge(a, d, e);
            Rd(a, "event", 1);
            Rd(a, "ecommerce", 1);
            Rd(a, "gtm");
            var h = { id: a, name: b, Jc: oe(c), gb: [], nh: [], ne: function() { I("GTM", 6) } };
            h.gb = Mb(h);
            var k = mf(h, f);
            if (!k) return k;
            for (var l = 0; l < h.gb.length; l++)
                if (h.gb[l]) { var m = vb[l]; if (m && !Xc[String(m[Ib.qa])]) return !0 }
            return !1
        };
    var pf = function(a, b) {
        var c = Bb(a, b);
        vb.push(c);
        return vb.length - 1
    };
    var qf = /^https?:\/\/www\.googletagmanager\.com/;

    function rf() { var a; return a }

    function tf(a, b) {}

    function sf(a) { 0 !== a.indexOf("http://") && 0 !== a.indexOf("https://") && (a = "https://" + a); "/" === a[a.length - 1] && (a = a.substring(0, a.length - 1)); return a }

    function uf() { var a = !1; return a };
    var vf = function() {
            this.eventModel = {};
            this.targetConfig = {};
            this.containerConfig = {};
            this.h = {};
            this.globalConfig = {};
            this.B = function() {};
            this.w = function() {}
        },
        wf = function(a) {
            var b = new vf;
            b.eventModel = a;
            return b
        },
        xf = function(a, b) { a.targetConfig = b; return a },
        yf = function(a, b) { a.containerConfig = b; return a },
        zf = function(a, b) { a.h = b; return a },
        Af = function(a, b) { a.globalConfig = b; return a },
        Bf = function(a, b) { a.B = b; return a },
        Cf = function(a, b) { a.w = b; return a };
    vf.prototype.getWithConfig = function(a) { if (void 0 !== this.eventModel[a]) return this.eventModel[a]; if (void 0 !== this.targetConfig[a]) return this.targetConfig[a]; if (void 0 !== this.containerConfig[a]) return this.containerConfig[a]; if (void 0 !== this.h[a]) return this.h[a]; if (void 0 !== this.globalConfig[a]) return this.globalConfig[a] };
    var Df = function(a) {
        function b(e) { za(e, function(f) { c[f] = null }) }
        var c = {};
        b(a.eventModel);
        b(a.targetConfig);
        b(a.containerConfig);
        b(a.globalConfig);
        var d = [];
        za(c, function(e) { d.push(e) });
        return d
    };
    var Ef = {},
        Ff = ["G"];
    Ef.Be = "";
    var Gf = Ef.Be.split(",");

    function Hf() { var a = Vc; return a.gcq = a.gcq || new If }
    var Jf = function(a, b, c) { Hf().register(a, b, c) },
        Kf = function(a, b, c, d) { Hf().push("event", [b, a], c, d) },
        Lf = function(a, b) { Hf().push("config", [a], b) },
        Mf = {},
        Nf = function() {
            this.status = 1;
            this.containerConfig = {};
            this.targetConfig = {};
            this.i = {};
            this.m = null;
            this.h = !1
        },
        Of = function(a, b, c, d, e) {
            this.type = a;
            this.m = b;
            this.N = c || "";
            this.h = d;
            this.i = e
        },
        If = function() {
            this.i = {};
            this.m = {};
            this.h = []
        },
        Pf = function(a, b) { var c = Rc(b); return a.i[c.containerId] = a.i[c.containerId] || new Nf },
        Qf = function(a, b, c, d) {
            if (d.N) {
                var e = Pf(a, d.N),
                    f = e.m;
                if (f) {
                    var h = B(c),
                        k = B(e.targetConfig[d.N]),
                        l = B(e.containerConfig),
                        m = B(e.i),
                        n = B(a.m),
                        r = Kd("gtm.uniqueEventId"),
                        u = Rc(d.N).prefix,
                        p = Cf(Bf(Af(zf(yf(xf(wf(h), k), l), m), n), function() { Ed(r, u, "2"); }), function() { Ed(r, u, "3"); });
                    try {
                        Ed(r, u, "1");
                        f(d.N, b, d.m, p)
                    } catch (t) {
                        Ed(r, u, "4");
                    }
                }
            }
        };
    If.prototype.register = function(a, b, c) {
        if (3 !== Pf(this, a).status) {
            Pf(this, a).m = b;
            Pf(this, a).status = 3;
            c && (Pf(this, a).i = c);
            var d = Rc(a),
                e = Mf[d.containerId];
            if (void 0 !== e) {
                var f = Vc[d.containerId].bootstrap,
                    h = d.prefix.toUpperCase();
                Vc[d.containerId]._spx && (h = h.toLowerCase());
                var k = Kd("gtm.uniqueEventId"),
                    l = h,
                    m = Fa() - f;
                if (Ad && !rd[k]) {
                    k !== nd && (ld(), nd = k);
                    var n = l + "." + Math.floor(f - e) + "." + Math.floor(m);
                    wd = wd ? wd + "," + n : "&cl=" + n
                }
                delete Mf[d.containerId]
            }
            this.flush()
        }
    };
    If.prototype.push = function(a, b, c, d) {
        var e = Math.floor(Fa() / 1E3);
        if (c) {
            var f = Rc(c),
                h;
            if (h = f) {
                var k;
                if (k = 1 === Pf(this, c).status) a: { var l = f.prefix;k = !0 }
                h = k
            }
            if (h && (Pf(this, c).status = 2, this.push("require", [], f.containerId), Mf[f.containerId] = Fa(), !Ud())) {
                var m = encodeURIComponent(f.containerId),
                    n = ("http:" != D.location.protocol ? "https:" : "http:") +
                    "//www.googletagmanager.com";
                jc(n + "/gtag/js?id=" + m + "&l=dataLayer&cx=c")
            }
        }
        this.h.push(new Of(a, e, c, b, d));
        d || this.flush()
    };
    If.prototype.flush = function(a) {
        for (var b = this; this.h.length;) {
            var c = this.h[0];
            if (c.i) c.i = !1, this.h.push(c);
            else switch (c.type) {
                case "require":
                    if (3 !== Pf(this, c.N).status && !a) return;
                    break;
                case "set":
                    za(c.h[0], function(l, m) { B(La(l, m), b.m) });
                    break;
                case "config":
                    var d = c.h[0],
                        e = !!d[H.Ob];
                    delete d[H.Ob];
                    var f = Pf(this, c.N),
                        h = Rc(c.N),
                        k = h.containerId === h.id;
                    e || (k ? f.containerConfig = {} : f.targetConfig[c.N] = {});
                    f.h && e || Qf(this, H.D, d, c);
                    f.h = !0;
                    delete d[H.oa];
                    k ? B(d, f.containerConfig) : B(d, f.targetConfig[c.N]);
                    break;
                case "event":
                    Qf(this, c.h[1], c.h[0], c)
            }
            this.h.shift()
        }
    };
    var Rf = function(a, b, c) {
            for (var d = [], e = String(b || document.cookie).split(";"), f = 0; f < e.length; f++) {
                var h = e[f].split("="),
                    k = h[0].replace(/^\s*|\s*$/g, "");
                if (k && k == a) {
                    var l = h.slice(1).join("=").replace(/^\s*|\s*$/g, "");
                    l && c && (l = decodeURIComponent(l));
                    d.push(l)
                }
            }
            return d
        },
        Vf = function(a, b, c, d) {
            var e = Sf(a, d);
            if (1 === e.length) return e[0].id;
            if (0 !== e.length) {
                e = Tf(e, function(f) { return f.Hb }, b);
                if (1 === e.length) return e[0].id;
                e = Tf(e, function(f) { return f.hb }, c);
                return e[0] ? e[0].id : void 0
            }
        };

    function Wf(a, b, c) {
        var d = document.cookie;
        document.cookie = a;
        var e = document.cookie;
        return d != e || void 0 != c && 0 <= Rf(b, e).indexOf(c)
    }
    var Zf = function(a, b, c, d, e, f) {
        d = d || "auto";
        var h = { path: c || "/" };
        e && (h.expires = e);
        "none" !== d && (h.domain = d);
        var k;
        a: {
            var l = b,
                m;
            if (void 0 == l) m = a + "=deleted; expires=" + (new Date(0)).toUTCString();
            else {
                f && (l = encodeURIComponent(l));
                var n = l;
                n && 1200 < n.length && (n = n.substring(0, 1200));
                l = n;
                m = a + "=" + l
            }
            var r = void 0,
                u = void 0,
                p;
            for (p in h)
                if (h.hasOwnProperty(p)) {
                    var t = h[p];
                    if (null != t) switch (p) {
                        case "secure":
                            t && (m += "; secure");
                            break;
                        case "domain":
                            r = t;
                            break;
                        default:
                            "path" == p && (u = t), "expires" == p && t instanceof Date && (t =
                                t.toUTCString()), m += "; " + p + "=" + t
                    }
                }
            if ("auto" === r) {
                for (var v = Xf(), w = 0; w < v.length; ++w) { var y = "none" != v[w] ? v[w] : void 0; if (!Yf(y, u) && Wf(m + (y ? "; domain=" + y : ""), a, l)) { k = !0; break a } }
                k = !1
            } else r && "none" != r && (m += "; domain=" + r),
            k = !Yf(r, u) && Wf(m, a, l)
        }
        return k
    };

    function Tf(a, b, c) {
        for (var d = [], e = [], f, h = 0; h < a.length; h++) {
            var k = a[h],
                l = b(k);
            l === c ? d.push(k) : void 0 === f || l < f ? (e = [k], f = l) : l === f && e.push(k)
        }
        return 0 < d.length ? d : e
    }

    function Sf(a, b) {
        for (var c = [], d = Rf(a), e = 0; e < d.length; e++) {
            var f = d[e].split("."),
                h = f.shift();
            if (!b || -1 !== b.indexOf(h)) {
                var k = f.shift();
                k && (k = k.split("-"), c.push({ id: f.join("."), Hb: 1 * k[0] || 1, hb: 1 * k[1] || 1 }))
            }
        }
        return c
    }
    var $f = /^(www\.)?google(\.com?)?(\.[a-z]{2})?$/,
        ag = /(^|\.)doubleclick\.net$/i,
        Yf = function(a, b) { return ag.test(document.location.hostname) || "/" === b && $f.test(a) },
        Xf = function() {
            var a = [],
                b = document.location.hostname.split(".");
            if (4 === b.length) { var c = b[b.length - 1]; if (parseInt(c, 10).toString() === c) return ["none"] }
            for (var d = b.length - 2; 0 <= d; d--) a.push(b.slice(d).join("."));
            var e = document.location.hostname;
            ag.test(e) || $f.test(e) || a.push("none");
            return a
        };
    var bg = "".split(/,/),
        cg = !1;
    var dg = null,
        eg = {},
        fg = {},
        gg;

    function hg(a, b) {
        var c = { event: a };
        b && (c.eventModel = B(b), b[H.jc] && (c.eventCallback = b[H.jc]), b[H.qb] && (c.eventTimeout = b[H.qb]));
        return c
    }
    var ig = function() {
            dg = dg || !Vc.gtagRegistered;
            Vc.gtagRegistered = !0;
            return dg
        },
        jg = function(a) {
            if (void 0 === fg[a.id]) {
                var b;
                switch (a.prefix) {
                    case "UA":
                        b = pf("gtagua", { trackingId: a.id });
                        break;
                    case "AW":
                        b = pf("gtagaw", { conversionId: a });
                        break;
                    case "DC":
                        b = pf("gtagfl", { targetId: a.id });
                        break;
                    case "GF":
                        b = pf("gtaggf", { conversionId: a });
                        break;
                    case "G":
                        b = pf("get", { trackingId: a.id, isAutoTag: !0 });
                        break;
                    case "HA":
                        b = pf("gtagha", { conversionId: a });
                        break;
                    case "GP":
                        b = pf("gtaggp", { conversionId: a.id });
                        break;
                    default:
                        return
                }
                if (!gg) {
                    var c =
                        Bb("v", { name: "send_to", dataLayerVersion: 2 });
                    rb.push(c);
                    gg = ["macro", rb.length - 1]
                }
                var d = { arg0: gg, arg1: a.id, ignore_case: !1 };
                d[Ib.qa] = "_lc";
                tb.push(d);
                var e = { "if": [tb.length - 1], add: [b] };
                e["if"] && (e.add || e.block) && sb.push(e);
                fg[a.id] = b
            }
        },
        kg = function(a) {
            za(eg, function(b, c) {
                var d = q(c, a);
                0 <= d && c.splice(d, 1)
            })
        },
        lg = Ha(function() {}),
        mg = function(a) {
            if (a.containerId !== Uc.s && "G" !== a.prefix) {
                var b;
                switch (a.prefix) {
                    case "UA":
                        b = 14;
                        break;
                    case "AW":
                        b = 15;
                        break;
                    case "DC":
                        b = 16;
                        break;
                    default:
                        b = 17
                }
                I("GTM", b)
            }
        };
    var ng = {
            config: function(a) {
                var b = a[2] || {};
                if (2 > a.length || !g(a[1]) || !Ra(b)) return;
                var c = Rc(a[1]);
                if (!c) return;
                kg(c.id);
                var d = c.id,
                    e = b[H.kd] || "default";
                e = e.toString().split(",");
                for (var f = 0; f < e.length; f++) eg[e[f]] = eg[e[f]] || [], eg[e[f]].push(d);
                delete b[H.kd];
                B(b);
                if (ig()) {
                    if (cg && -1 !== q(bg, c.prefix)) {
                        "G" === c.prefix && (b[H.oa] = !0);
                        Lf(b, c.id);
                        return
                    }
                    jg(c);
                    mg(c)
                } else lg();
                Qd("gtag.targets." + c.id, void 0);
                Qd("gtag.targets." + c.id, B(b));
                var h = {};
                h[H.na] = c.id;
                return hg(H.D, h);
            },
            event: function(a) {
                var b = a[1];
                if (g(b) && !(3 < a.length)) {
                    var c;
                    if (2 < a.length) {
                        if (!Ra(a[2]) && void 0 != a[2]) return;
                        c = a[2]
                    }
                    var d = hg(b, c);
                    var e;
                    var f = c && c[H.na];
                    void 0 === f && (f = Kd(H.na, 2), void 0 === f && (f = "default"));
                    if (g(f) || ua(f)) {
                        for (var h = f.toString().replace(/\s+/g, "").split(","), k = [], l = 0; l < h.length; l++) 0 <= h[l].indexOf("-") ? k.push(h[l]) : k = k.concat(eg[h[l]] || []);
                        e = Tc(k)
                    } else e = void 0;
                    var m = e;
                    if (!m) return;
                    var n = ig();
                    n || lg();
                    for (var r = [], u = 0; n && u < m.length; u++) {
                        var p = m[u];
                        mg(p);
                        if (cg && -1 !== q(bg, p.prefix)) {
                            var t = B(c);
                            "G" === p.prefix && (t[H.oa] = !0);
                            Kf(b, t, p.id)
                        } else jg(p);
                        r.push(p.id)
                    }
                    B(c, { event: b });
                    d.eventModel = d.eventModel || {};
                    0 < m.length ? d.eventModel[H.na] = r.join() : delete d.eventModel[H.na];
                    return d
                }
            },
            js: function(a) { if (2 == a.length && a[1].getTime) return { event: "gtm.js", "gtm.start": a[1].getTime() } },
            policy: function() {},
            set: function(a) {
                var b;
                2 == a.length && Ra(a[1]) ? b = B(a[1]) : 3 == a.length && g(a[1]) && (b = {}, Ra(a[2]) || ua(a[2]) ? b[a[1]] = B(a[2]) : b[a[1]] = a[2]);
                if (b) {
                    if (ig()) {
                        var c = B(b);
                        Hf().push("set", [c])
                    }
                    B(b);
                    b._clear = !0;
                    return b
                }
            }
        },
        og = { policy: !0 };
    var pg = function(a, b) {
            var c = a.hide;
            if (c && void 0 !== c[b] && c.end) {
                c[b] = !1;
                var d = !0,
                    e;
                for (e in c)
                    if (c.hasOwnProperty(e) && !0 === c[e]) { d = !1; break }
                d && (c.end(), c.end = null)
            }
        },
        rg = function(a) {
            var b = qg(),
                c = b && b.hide;
            c && c.end && (c[a] = !0)
        };
    var sg = !1,
        tg = [];

    function ug() { if (!sg) { sg = !0; for (var a = 0; a < tg.length; a++) G(tg[a]) } }
    var vg = function(a) { sg ? G(a) : tg.push(a) };
    var Kg = function(a) {
        if (Jg(a)) return a;
        this.h = a
    };
    Kg.prototype.eg = function() { return this.h };
    var Jg = function(a) { return !a || "object" !== Pa(a) || Ra(a) ? !1 : "getUntrustedUpdateValue" in a };
    Kg.prototype.getUntrustedUpdateValue = Kg.prototype.eg;
    var Lg = [],
        Mg = !1,
        Ng = function(a) { return D["dataLayer"].push(a) },
        Og = function(a) {
            var b = Vc["dataLayer"],
                c = b ? b.subscribers : 1,
                d = 0;
            return function() {++d === c && a() }
        };

    function Pg(a) {
        var b = a._clear;
        za(a, function(f, h) { "_clear" !== f && (b && Qd(f, void 0), Qd(f, h)) });
        $c || ($c = a["gtm.start"]);
        var c = a.event;
        if (!c) return !1;
        var d = a["gtm.uniqueEventId"];
        d || (d = gd(), a["gtm.uniqueEventId"] = d, Qd("gtm.uniqueEventId", d));
        cd = c;
        var e =
            Qg(a);
        cd = null;
        switch (c) {
            case "gtm.init":
                I("GTM", 19), e && I("GTM", 20)
        }
        return e
    }

    function Qg(a) {
        var b = a.event,
            c = a["gtm.uniqueEventId"],
            d, e = Vc.zones;
        d = e ? e.checkState(Uc.s, c) : qe;
        return d.active ? of(c, b, d.isWhitelisted, a.eventCallback, a.eventTimeout) ? !0 : !1 : !1
    }

    function Rg() {
        for (var a = !1; !Mg && 0 < Lg.length;) {
            Mg = !0;
            delete Hd.eventModel;
            Jd();
            var b = Lg.shift();
            if (null != b) {
                var c = Jg(b);
                if (c) {
                    var d = b;
                    b = Jg(d) ? d.getUntrustedUpdateValue() : void 0;
                    for (var e = ["gtm.whitelist", "gtm.blacklist", "tagTypeBlacklist"], f = 0; f < e.length; f++) {
                        var h = e[f],
                            k = Kd(h, 1);
                        if (ua(k) || Ra(k)) k = B(k);
                        Id[h] = k
                    }
                }
                try {
                    if (qa(b)) try { b.call(Ld) } catch (v) {} else if (ua(b)) {
                        var l = b;
                        if (g(l[0])) {
                            var m =
                                l[0].split("."),
                                n = m.pop(),
                                r = l.slice(1),
                                u = Kd(m.join("."), 2);
                            if (void 0 !== u && null !== u) try { u[n].apply(u, r) } catch (v) {}
                        }
                    } else {
                        var p = b;
                        if (p && ("[object Arguments]" == Object.prototype.toString.call(p) || Object.prototype.hasOwnProperty.call(p, "callee"))) {
                            a: {
                                if (b.length && g(b[0])) { var t = ng[b[0]]; if (t && (!c || !og[b[0]])) { b = t(b); break a } }
                                b = void 0
                            }
                            if (!b) { Mg = !1; continue }
                        }
                        a = Pg(b) || a
                    }
                } finally { c && Jd(!0) }
            }
            Mg = !1
        }
        return !a
    }

    function Sg() { var a = Rg(); try { pg(D["dataLayer"], Uc.s) } catch (b) {} return a }
    var Ug = function() {
            var a = hc("dataLayer", []),
                b = hc("google_tag_manager", {});
            b = b["dataLayer"] = b["dataLayer"] || {};
            ye(function() { b.gtmDom || (b.gtmDom = !0, a.push({ event: "gtm.dom" })) });
            vg(function() { b.gtmLoad || (b.gtmLoad = !0, a.push({ event: "gtm.load" })) });
            b.subscribers = (b.subscribers || 0) + 1;
            var c = a.push;
            a.push = function() {
                var d;
                if (0 < Vc.SANDBOXED_JS_SEMAPHORE) { d = []; for (var e = 0; e < arguments.length; e++) d[e] = new Kg(arguments[e]) } else d = [].slice.call(arguments, 0);
                var f = c.apply(a, d);
                Lg.push.apply(Lg, d);
                if (300 <
                    this.length)
                    for (I("GTM", 4); 300 < this.length;) this.shift();
                var h = "boolean" !== typeof f || f;
                return Rg() && h
            };
            Lg.push.apply(Lg, a.slice(0));
            Tg() && G(Sg)
        },
        Tg = function() { var a = !0; return a };
    var Vg = {};
    Vg.rb = new String("undefined");
    var Wg = function(a) { this.h = function(b) { for (var c = [], d = 0; d < a.length; d++) c.push(a[d] === Vg.rb ? b : a[d]); return c.join("") } };
    Wg.prototype.toString = function() { return this.h("undefined") };
    Wg.prototype.valueOf = Wg.prototype.toString;
    Vg.df = Wg;
    Vg.vc = {};
    Vg.Pf = function(a) { return new Wg(a) };
    var Xg = {};
    Vg.eh = function(a, b) {
        var c = gd();
        Xg[c] = [a, b];
        return c
    };
    Vg.Xd = function(a) {
        var b = a ? 0 : 1;
        return function(c) {
            var d = Xg[c];
            if (d && "function" === typeof d[b]) d[b]();
            Xg[c] = void 0
        }
    };
    Vg.vg = function(a) {
        for (var b = !1, c = !1, d = 2; d < a.length; d++) b =
            b || 8 === a[d], c = c || 16 === a[d];
        return b && c
    };
    Vg.Tg = function(a) {
        if (a === Vg.rb) return a;
        var b = gd();
        Vg.vc[b] = a;
        return 'google_tag_manager["' + Uc.s + '"].macro(' + b + ")"
    };
    Vg.Fg = function(a, b, c) { a instanceof Vg.df && (a = a.h(Vg.eh(b, c)), b = pa); return { Hc: a, B: b } };
    var Yg = function(a, b, c) {
            function d(f, h) { var k = f[h]; return k }
            var e = { event: b, "gtm.element": a, "gtm.elementClasses": d(a, "className"), "gtm.elementId": a["for"] || qc(a, "id") || "", "gtm.elementTarget": a.formTarget || d(a, "target") || "" };
            c && (e["gtm.triggers"] = c.join(","));
            e["gtm.elementUrl"] = (a.attributes && a.attributes.formaction ? a.formAction : "") || a.action || d(a, "href") || a.src || a.code || a.codebase ||
                "";
            return e
        },
        Zg = function(a) {
            Vc.hasOwnProperty("autoEventsSettings") || (Vc.autoEventsSettings = {});
            var b = Vc.autoEventsSettings;
            b.hasOwnProperty(a) || (b[a] = {});
            return b[a]
        },
        $g = function(a, b, c) { Zg(a)[b] = c },
        ah = function(a, b, c, d) {
            var e = Zg(a),
                f = Ga(e, b, d);
            e[b] = c(f)
        },
        bh = function(a, b, c) { var d = Zg(a); return Ga(d, b, c) };
    var ch = function() {
            for (var a = fc.userAgent + (F.cookie || "") + (F.referrer || ""), b = a.length, c = D.history.length; 0 < c;) a += c-- ^ b++;
            var d = 1,
                e, f, h;
            if (a)
                for (d = 0, f = a.length - 1; 0 <= f; f--) h = a.charCodeAt(f), d = (d << 6 & 268435455) + h + (h << 14), e = d & 266338304, d = 0 != e ? d ^ e >> 21 : d;
            return [Math.round(2147483647 * Math.random()) ^ d & 2147483647, Math.round(Fa() / 1E3)].join(".")
        },
        fh = function(a, b, c, d) { var e = dh(b); return Vf(a, e, eh(c), d) },
        gh = function(a, b, c, d) {
            var e = "" + dh(c),
                f = eh(d);
            1 < f && (e += "-" + f);
            return [b, e, a].join(".")
        },
        dh = function(a) {
            if (!a) return 1;
            a = 0 === a.indexOf(".") ? a.substr(1) : a;
            return a.split(".").length
        },
        eh = function(a) { if (!a || "/" === a) return 1; "/" !== a[0] && (a = "/" + a); "/" !== a[a.length - 1] && (a += "/"); return a.split("/").length - 1 };
    var hh = ["1"],
        ih = {},
        mh = function(a, b, c, d) {
            var e = jh(a);
            ih[e] || kh(e, b, c) || (lh(e, ch(), b, c, d), kh(e, b, c))
        };

    function lh(a, b, c, d, e) {
        var f = gh(b, "1", d, c);
        Zf(a, f, c, d, 0 == e ? void 0 : new Date(Fa() + 1E3 * (void 0 == e ? 7776E3 : e)))
    }

    function kh(a, b, c) {
        var d = fh(a, b, c, hh);
        d && (ih[a] = d);
        return d
    }

    function jh(a) { return (a || "_gcl") + "_au" };
    var nh = function() {
        for (var a = [], b = F.cookie.split(";"), c = /^\s*_gac_(UA-\d+-\d+)=\s*(.+?)\s*$/, d = 0; d < b.length; d++) {
            var e = b[d].match(c);
            e && a.push({ bd: e[1], value: e[2] })
        }
        var f = {};
        if (!a || !a.length) return f;
        for (var h = 0; h < a.length; h++) { var k = a[h].value.split("."); "1" == k[0] && 3 == k.length && k[1] && (f[a[h].bd] || (f[a[h].bd] = []), f[a[h].bd].push({ timestamp: k[1], ag: k[2] })) }
        return f
    };

    function oh() { for (var a = ph, b = {}, c = 0; c < a.length; ++c) b[a[c]] = c; return b }

    function qh() {
        var a = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        a += a.toLowerCase() + "0123456789-_";
        return a + "."
    }
    var ph, rh;

    function sh(a) {
        ph = ph || qh();
        rh = rh || oh();
        for (var b = [], c = 0; c < a.length; c += 3) {
            var d = c + 1 < a.length,
                e = c + 2 < a.length,
                f = a.charCodeAt(c),
                h = d ? a.charCodeAt(c + 1) : 0,
                k = e ? a.charCodeAt(c + 2) : 0,
                l = f >> 2,
                m = (f & 3) << 4 | h >> 4,
                n = (h & 15) << 2 | k >> 6,
                r = k & 63;
            e || (r = 64, d || (n = 64));
            b.push(ph[l], ph[m], ph[n], ph[r])
        }
        return b.join("")
    }

    function th(a) {
        function b(l) {
            for (; d < a.length;) {
                var m = a.charAt(d++),
                    n = rh[m];
                if (null != n) return n;
                if (!/^[\s\xa0]*$/.test(m)) throw Error("Unknown base64 encoding at char: " + m);
            }
            return l
        }
        ph = ph || qh();
        rh = rh || oh();
        for (var c = "", d = 0;;) {
            var e = b(-1),
                f = b(0),
                h = b(64),
                k = b(64);
            if (64 === k && -1 === e) return c;
            c += String.fromCharCode(e << 2 | f >> 4);
            64 != h && (c += String.fromCharCode(f << 4 & 240 | h >> 2), 64 != k && (c += String.fromCharCode(h << 6 & 192 | k)))
        }
    };
    var uh;

    function vh(a, b) {
        if (!a || b === F.location.hostname) return !1;
        for (var c = 0; c < a.length; c++)
            if (a[c] instanceof RegExp) { if (a[c].test(b)) return !0 } else if (0 <= b.indexOf(a[c])) return !0;
        return !1
    }
    var zh = function() {
            var a = wh,
                b = xh,
                c = yh(),
                d = function(h) { a(h.target || h.srcElement || {}) },
                e = function(h) { b(h.target || h.srcElement || {}) };
            if (!c.init) {
                nc(F, "mousedown", d);
                nc(F, "keyup", d);
                nc(F, "submit", e);
                var f = HTMLFormElement.prototype.submit;
                HTMLFormElement.prototype.submit = function() {
                    b(this);
                    f.call(this)
                };
                c.init = !0
            }
        },
        yh = function() {
            var a = hc("google_tag_data", {}),
                b = a.gl;
            b && b.decorators || (b = { decorators: [] }, a.gl = b);
            return b
        };
    var Ah = /(.*?)\*(.*?)\*(.*)/,
        Bh = /^https?:\/\/([^\/]*?)\.?cdn\.ampproject\.org\/?(.*)/,
        Ch = /^(?:www\.|m\.|amp\.)+/,
        Dh = /([^?#]+)(\?[^#]*)?(#.*)?/,
        Eh = /(.*?)(^|&)_gl=([^&]*)&?(.*)/,
        Gh = function(a) {
            var b = [],
                c;
            for (c in a)
                if (a.hasOwnProperty(c)) {
                    var d = a[c];
                    void 0 !== d && d === d && null !== d && "[object Object]" !== d.toString() && (b.push(c), b.push(sh(String(d))))
                }
            var e = b.join("*");
            return ["1", Fh(e), e].join("*")
        },
        Fh = function(a, b) {
            var c = [window.navigator.userAgent, (new Date).getTimezoneOffset(), window.navigator.userLanguage ||
                    window.navigator.language, Math.floor((new Date).getTime() / 60 / 1E3) - (void 0 === b ? 0 : b), a
                ].join("*"),
                d;
            if (!(d = uh)) {
                for (var e = Array(256), f = 0; 256 > f; f++) {
                    for (var h = f, k = 0; 8 > k; k++) h = h & 1 ? h >>> 1 ^ 3988292384 : h >>> 1;
                    e[f] = h
                }
                d = e
            }
            uh = d;
            for (var l = 4294967295, m = 0; m < c.length; m++) l = l >>> 8 ^ uh[(l ^ c.charCodeAt(m)) & 255];
            return ((l ^ -1) >>> 0).toString(36)
        },
        Ih = function() {
            return function(a) {
                var b = Ze(D.location.href),
                    c = b.search.replace("?", ""),
                    d = Ve(c, "_gl", !0) || "";
                a.query = Hh(d) || {};
                var e = Ye(b, "fragment").match(Eh);
                a.fragment = Hh(e && e[3] ||
                    "") || {}
            }
        },
        Jh = function() {
            var a = Ih(),
                b = yh();
            b.data || (b.data = { query: {}, fragment: {} }, a(b.data));
            var c = {},
                d = b.data;
            d && (Ia(c, d.query), Ia(c, d.fragment));
            return c
        },
        Hh = function(a) {
            var b;
            b = void 0 === b ? 3 : b;
            try {
                if (a) {
                    var c;
                    a: {
                        for (var d = a, e = 0; 3 > e; ++e) {
                            var f = Ah.exec(d);
                            if (f) { c = f; break a }
                            d = decodeURIComponent(d)
                        }
                        c = void 0
                    }
                    var h = c;
                    if (h && "1" === h[1]) {
                        var k = h[3],
                            l;
                        a: {
                            for (var m = h[2], n = 0; n < b; ++n)
                                if (m === Fh(k, n)) { l = !0; break a }
                            l = !1
                        }
                        if (l) { for (var r = {}, u = k ? k.split("*") : [], p = 0; p < u.length; p += 2) r[u[p]] = th(u[p + 1]); return r }
                    }
                }
            } catch (t) {}
        };

    function Kh(a, b, c) {
        function d(m) {
            var n = m,
                r = Eh.exec(n),
                u = n;
            if (r) {
                var p = r[2],
                    t = r[4];
                u = r[1];
                t && (u = u + p + t)
            }
            m = u;
            var v = m.charAt(m.length - 1);
            m && "&" !== v && (m += "&");
            return m + l
        }
        c = void 0 === c ? !1 : c;
        var e = Dh.exec(b);
        if (!e) return "";
        var f = e[1],
            h = e[2] || "",
            k = e[3] || "",
            l = "_gl=" + a;
        c ? k = "#" + d(k.substring(1)) : h = "?" + d(h.substring(1));
        return "" + f + h + k
    }

    function Lh(a, b, c) {
        for (var d = {}, e = {}, f = yh().decorators, h = 0; h < f.length; ++h) {
            var k = f[h];
            (!c || k.forms) && vh(k.domains, b) && (k.fragment ? Ia(e, k.callback()) : Ia(d, k.callback()))
        }
        if (Ja(d)) {
            var l = Gh(d);
            if (c) {
                if (a && a.action) {
                    var m = (a.method || "").toLowerCase();
                    if ("get" === m) {
                        for (var n = a.childNodes || [], r = !1, u = 0; u < n.length; u++) {
                            var p = n[u];
                            if ("_gl" === p.name) {
                                p.setAttribute("value", l);
                                r = !0;
                                break
                            }
                        }
                        if (!r) {
                            var t = F.createElement("input");
                            t.setAttribute("type", "hidden");
                            t.setAttribute("name", "_gl");
                            t.setAttribute("value",
                                l);
                            a.appendChild(t)
                        }
                    } else if ("post" === m) {
                        var v = Kh(l, a.action);
                        Te.test(v) && (a.action = v)
                    }
                }
            } else Mh(l, a, !1)
        }
        if (!c && Ja(e)) {
            var w = Gh(e);
            Mh(w, a, !0)
        }
    }

    function Mh(a, b, c) {
        if (b.href) {
            var d = Kh(a, b.href, void 0 === c ? !1 : c);
            Te.test(d) && (b.href = d)
        }
    }
    var wh = function(a) {
            try {
                var b;
                a: {
                    for (var c = a, d = 100; c && 0 < d;) {
                        if (c.href && c.nodeName.match(/^a(?:rea)?$/i)) { b = c; break a }
                        c = c.parentNode;
                        d--
                    }
                    b = null
                }
                var e = b;
                if (e) { var f = e.protocol; "http:" !== f && "https:" !== f || Lh(e, e.hostname, !1) }
            } catch (h) {}
        },
        xh = function(a) {
            try {
                if (a.action) {
                    var b = Ye(Ze(a.action), "host");
                    Lh(a, b, !0)
                }
            } catch (c) {}
        },
        Nh = function(a, b, c, d) {
            zh();
            var e = { callback: a, domains: b, fragment: "fragment" === c, forms: !!d };
            yh().decorators.push(e)
        },
        Oh = function() {
            var a = F.location.hostname,
                b = Bh.exec(F.referrer);
            if (!b) return !1;
            var c = b[2],
                d = b[1],
                e = "";
            if (c) {
                var f = c.split("/"),
                    h = f[1];
                e = "s" === h ? decodeURIComponent(f[2]) : decodeURIComponent(h)
            } else if (d) {
                if (0 === d.indexOf("xn--")) return !1;
                e = d.replace(/-/g, ".").replace(/\.\./g, "-")
            }
            var k = a.replace(Ch, ""),
                l = e.replace(Ch, ""),
                m;
            if (!(m = k === l)) {
                var n = "." + l;
                m = k.substring(k.length - n.length, k.length) === n
            }
            return m
        },
        Ph = function(a, b) { return !1 === a ? !1 : a || b || Oh() };
    var Qh = {};
    var Rh = /^\w+$/,
        Sh = /^[\w-]+$/,
        Th = /^~?[\w-]+$/,
        Uh = { aw: "_aw", dc: "_dc", gf: "_gf", ha: "_ha", gp: "_gp" };

    function Vh(a) { return a && "string" == typeof a && a.match(Rh) ? a : "_gcl" }
    var Xh = function() {
        var a = Ze(D.location.href),
            b = Ye(a, "query", !1, void 0, "gclid"),
            c = Ye(a, "query", !1, void 0, "gclsrc"),
            d = Ye(a, "query", !1, void 0, "dclid");
        if (!b || !c) {
            var e = a.hash.replace("#", "");
            b = b || Ve(e, "gclid", void 0);
            c = c || Ve(e, "gclsrc", void 0)
        }
        return Wh(b, c, d)
    };

    function Wh(a, b, c) {
        var d = {},
            e = function(f, h) {
                d[h] || (d[h] = []);
                d[h].push(f)
            };
        if (void 0 !== a && a.match(Sh)) switch (b) {
            case void 0:
                e(a, "aw");
                break;
            case "aw.ds":
                e(a, "aw");
                e(a, "dc");
                break;
            case "ds":
                e(a, "dc");
                break;
            case "3p.ds":
                (void 0 == Qh.gtm_3pds ? 0 : Qh.gtm_3pds) && e(a, "dc");
                break;
            case "gf":
                e(a, "gf");
                break;
            case "ha":
                e(a, "ha");
                break;
            case "gp":
                e(a, "gp")
        }
        c && e(c, "dc");
        return d
    }
    var Zh = function(a) {
        var b = Xh();
        Yh(b, a)
    };

    function Yh(a, b, c) {
        function d(r, u) {
            var p = $h(r, e);
            p && Zf(p, u, h, f, l, !0)
        }
        b = b || {};
        var e = Vh(b.prefix),
            f = b.domain || "auto",
            h = b.path || "/",
            k = void 0 == b.Ia ? 7776E3 : b.Ia;
        c = c || Fa();
        var l = 0 == k ? void 0 : new Date(c + 1E3 * k),
            m = Math.round(c / 1E3),
            n = function(r) { return ["GCL", m, r].join(".") };
        a.aw && (!0 === b.$h ? d("aw", n("~" + a.aw[0])) : d("aw", n(a.aw[0])));
        a.dc && d("dc", n(a.dc[0]));
        a.gf && d("gf", n(a.gf[0]));
        a.ha && d("ha", n(a.ha[0]));
        a.gp && d("gp", n(a.gp[0]))
    }
    var bi = function(a, b, c, d, e) {
            for (var f = Jh(), h = Vh(b), k = 0; k < a.length; ++k) {
                var l = a[k];
                if (void 0 !== Uh[l]) {
                    var m = $h(l, h),
                        n = f[m];
                    if (n) {
                        var r = Math.min(ai(n), Fa()),
                            u;
                        b: {
                            for (var p = r, t = Rf(m, F.cookie), v = 0; v < t.length; ++v)
                                if (ai(t[v]) > p) { u = !0; break b }
                            u = !1
                        }
                        u || Zf(m, n, c, d, 0 == e ? void 0 : new Date(r + 1E3 * (null == e ? 7776E3 : e)), !0)
                    }
                }
            }
            var w = { prefix: b, path: c, domain: d };
            Yh(Wh(f.gclid, f.gclsrc), w)
        },
        $h = function(a, b) { var c = Uh[a]; if (void 0 !== c) return b + c },
        ai = function(a) {
            var b = a.split(".");
            return 3 !== b.length || "GCL" !== b[0] ? 0 : 1E3 * (Number(b[1]) ||
                0)
        };

    function ci(a) { var b = a.split("."); if (3 == b.length && "GCL" == b[0] && b[1]) return b[2] }
    var di = function(a, b, c, d, e) {
            if (ua(b)) {
                var f = Vh(e);
                Nh(function() {
                    for (var h = {}, k = 0; k < a.length; ++k) {
                        var l = $h(a[k], f);
                        if (l) {
                            var m = Rf(l, F.cookie);
                            m.length && (h[l] = m.sort()[m.length - 1])
                        }
                    }
                    return h
                }, b, c, d)
            }
        },
        ei = function(a) { return a.filter(function(b) { return Th.test(b) }) },
        fi = function(a, b) {
            for (var c = Vh(b && b.prefix), d = {}, e = 0; e < a.length; e++) Uh[a[e]] && (d[a[e]] = Uh[a[e]]);
            za(d, function(f, h) {
                var k = Rf(c + h, F.cookie);
                if (k.length) {
                    var l = k[0],
                        m = ai(l),
                        n = {};
                    n[f] = [ci(l)];
                    Yh(n, b, m)
                }
            })
        };
    var gi = /^\d+\.fls\.doubleclick\.net$/;

    function hi(a) {
        var b = Ze(D.location.href),
            c = Ye(b, "host", !1);
        if (c && c.match(gi)) { var d = Ye(b, "path").split(a + "="); if (1 < d.length) return d[1].split(";")[0].split("?")[0] }
    }

    function ii(a, b) {
        if ("aw" == a || "dc" == a) { var c = hi("gcl" + a); if (c) return c.split(".") }
        var d = Vh(b);
        if ("_gcl" == d) {
            var e;
            e = Xh()[a] || [];
            if (0 < e.length) return e
        }
        var f = $h(a, d),
            h;
        if (f) {
            var k = [];
            if (F.cookie) {
                var l = Rf(f, F.cookie);
                if (l && 0 != l.length) {
                    for (var m = 0; m < l.length; m++) {
                        var n = ci(l[m]);
                        n && -1 === q(k, n) && k.push(n)
                    }
                    h = ei(k)
                } else h = k
            } else h = k
        } else h = [];
        return h
    }
    var ji = function() {
            var a = hi("gac");
            if (a) return decodeURIComponent(a);
            var b = nh(),
                c = [];
            za(b, function(d, e) {
                for (var f = [], h = 0; h < e.length; h++) f.push(e[h].ag);
                f = ei(f);
                f.length && c.push(d + ":" + f.join(","))
            });
            return c.join(";")
        },
        ki = function(a, b, c, d, e) {
            mh(b, c, d, e);
            var f = ih[jh(b)],
                h = Xh().dc || [],
                k = !1;
            if (f && 0 < h.length) {
                var l = Vc.joined_au = Vc.joined_au || {},
                    m = b || "_gcl";
                if (!l[m])
                    for (var n = 0; n < h.length; n++) {
                        var r = "https://adservice.google.com/ddm/regclk",
                            u = r = r + "?gclid=" + h[n] + "&auiddc=" + f;
                        fc.sendBeacon && fc.sendBeacon(u) || mc(u);
                        k = l[m] = !0
                    }
            }
            null == a && (a = k);
            if (a && f) {
                var p = jh(b),
                    t = ih[p];
                t && lh(p, t, c, d, e)
            }
        };
    var li;
    if (3 === Uc.vb.length) li = "g";
    else {
        var mi = "G";
        mi = "g";
        li = mi
    }
    var ni = { "": "n", UA: "u", AW: "a", DC: "d", G: "e", GF: "f", HA: "h", GTM: li, OPT: "o" },
        oi = function(a) {
            var b = Uc.s.split("-"),
                c = b[0].toUpperCase(),
                d = ni[c] || "i",
                e = a && "GTM" === c ? b[1] : "OPT" === c ? b[1] : "",
                f;
            if (3 === Uc.vb.length) {
                var h = void 0;
                h = h || (Ud() ? "s" : "o");
                f = "2" + (h || "w")
            } else f =
                "";
            return f + d + Uc.vb + e
        };
    var pi = function(a) { return !(void 0 === a || null === a || 0 === (a + "").length) },
        qi = function(a, b) {
            var c;
            if (2 === b.V) return a("ord", wa(1E11, 1E13)), !0;
            if (3 === b.V) return a("ord", "1"), a("num", wa(1E11, 1E13)), !0;
            if (4 === b.V) return pi(b.sessionId) && a("ord", b.sessionId), !0;
            if (5 === b.V) c = "1";
            else if (6 === b.V) c = b.Wc;
            else return !1;
            pi(c) && a("qty", c);
            pi(b.Eb) && a("cost", b.Eb);
            pi(b.transactionId) && a("ord", b.transactionId);
            return !0
        },
        ri = encodeURIComponent,
        si = function(a, b) {
            function c(n, r, u) {
                f.hasOwnProperty(n) || (r += "", e += ";" + n + "=" +
                    (u ? r : ri(r)))
            }
            var d = a.Cc,
                e = a.protocol;
            e += a.Xb ? "//" + d + ".fls.doubleclick.net/activityi" : "//ad.doubleclick.net/activity";
            e += ";src=" + ri(d) + (";type=" + ri(a.Fc)) + (";cat=" + ri(a.$a));
            var f = a.Rf || {};
            za(f, function(n, r) { e += ";" + ri(n) + "=" + ri(r + "") });
            if (qi(c, a)) {
                pi(a.cc) && c("u", a.cc);
                pi(a.bc) && c("tran", a.bc);
                c("gtm", oi());
                !1 === a.sf && c("npa", "1");
                if (a.Bc) {
                    var h = ii("dc", a.Da);
                    h && h.length && c("gcldc", h.join("."));
                    var k = ii("aw", a.Da);
                    k && k.length && c("gclaw", k.join("."));
                    var l = ji();
                    l && c("gac", l);
                    mh(a.Da, void 0, a.Nf, a.Of);
                    var m = ih[jh(a.Da)];
                    m && c("auiddc", m)
                }
                pi(a.Sc) && c("prd", a.Sc, !0);
                za(a.dd, function(n, r) { c(n, r) });
                e += b || "";
                pi(a.Sb) && c("~oref", a.Sb);
                a.Xb ? lc(e + "?", a.B) : mc(e + "?", a.B, a.w)
            } else G(a.w)
        };
    var ti = ["input", "select", "textarea"],
        ui = ["button", "hidden", "image", "reset", "submit"],
        vi = function(a) { var b = a.tagName.toLowerCase(); return !va(ti, function(c) { return c === b }) || "input" === b && va(ui, function(c) { return c === a.type.toLowerCase() }) ? !1 : !0 },
        wi = function(a) { return a.form ? a.form.tagName ? a.form : F.getElementById(a.form) : tc(a, ["form"], 100) },
        xi = function(a, b, c) {
            if (!a.elements) return 0;
            for (var d = b.getAttribute(c), e = 0, f = 1; e < a.elements.length; e++) {
                var h = a.elements[e];
                if (vi(h)) {
                    if (h.getAttribute(c) === d) return f;
                    f++
                }
            }
            return 0
        };
    var zi = function(a) {
            var b;
            if (a.hasOwnProperty("conversion_data")) b = "conversion_data";
            else if (a.hasOwnProperty("price")) b = "price";
            else return;
            var c = b,
                d = "/pagead/conversion/" + yi(a.conversion_id) + "/?",
                e = yi(JSON.stringify(a[c])),
                f = "https://www.googletraveladservices.com/travel/flights/clk" + d + c + "=" + e;
            if (a.conversionLinkerEnabled) {
                var h = ii("gf", a.cookiePrefix);
                if (h && h.length)
                    for (var k = 0; k < h.length; k++) f += "&gclgf=" + yi(h[k])
            }
            mc(f, a.onSuccess, a.onFailure)
        },
        yi = function(a) {
            return null === a || void 0 === a || 0 === String(a).length ?
                "" : encodeURIComponent(String(a))
        };
    var Ai = !!D.MutationObserver,
        Bi = void 0,
        Ci = function(a) {
            if (!Bi) {
                var b = function() {
                    var c = F.body;
                    if (c)
                        if (Ai)(new MutationObserver(function() { for (var e = 0; e < Bi.length; e++) G(Bi[e]) })).observe(c, { childList: !0, subtree: !0 });
                        else {
                            var d = !1;
                            nc(c, "DOMNodeInserted", function() { d || (d = !0, G(function() { d = !1; for (var e = 0; e < Bi.length; e++) G(Bi[e]) })) })
                        }
                };
                Bi = [];
                F.body ? b() : G(b)
            }
            Bi.push(a)
        };
    var Yi = D.clearTimeout,
        Zi = D.setTimeout,
        R = function(a, b, c) { if (Ud()) { b && G(b) } else return jc(a, b, c) },
        $i = function() { return D.location.href },
        aj = function(a) { return Ye(Ze(a), "fragment") },
        bj = function(a) { return Xe(Ze(a)) },
        S = function(a, b) { return Kd(a, b || 2) },
        cj = function(a, b, c) {
            var d;
            b ? (a.eventCallback = b, c && (a.eventTimeout = c), d = Ng(a)) : d = Ng(a);
            return d
        },
        dj = function(a, b) { D[a] = b },
        X = function(a, b, c) {
            b && (void 0 === D[a] || c && !D[a]) && (D[a] =
                b);
            return D[a]
        },
        ej = function(a, b, c) { return Rf(a, b, void 0 === c ? !0 : !!c) },
        fj = function(a, b) { if (Ud()) { b && G(b) } else lc(a, b) },
        gj = function(a) { return !!bh(a, "init", !1) },
        hj = function(a) { $g(a, "init", !0) },
        ij = function(a, b) {
            var c = (void 0 === b ? 0 : b) ? "www.googletagmanager.com/gtag/js" : Zc;
            c += "?id=" + encodeURIComponent(a) + "&l=dataLayer";
            R(Q("https://", "http://", c))
        },
        jj = function(a, b) { var c = a[b]; return c };
    var kj = Vg.Fg;
    var lj;
    var Ij = new xa;

    function Jj(a, b) {
        function c(h) {
            var k = Ze(h),
                l = Ye(k, "protocol"),
                m = Ye(k, "host", !0),
                n = Ye(k, "port"),
                r = Ye(k, "path").toLowerCase().replace(/\/$/, "");
            if (void 0 === l || "http" == l && "80" == n || "https" == l && "443" == n) l = "web", n = "default";
            return [l, m, n, r]
        }
        for (var d = c(String(a)), e = c(String(b)), f = 0; f < d.length; f++)
            if (d[f] !== e[f]) return !1;
        return !0
    }

    function Kj(a) { return Lj(a) ? 1 : 0 }

    function Lj(a) {
        var b = a.arg0,
            c = a.arg1;
        if (a.any_of && ua(c)) {
            for (var d = 0; d < c.length; d++)
                if (Kj({ "function": a["function"], arg0: b, arg1: c[d] })) return !0;
            return !1
        }
        switch (a["function"]) {
            case "_cn":
                return 0 <= String(b).indexOf(String(c));
            case "_css":
                var e;
                a: {
                    if (b) {
                        var f = ["matches", "webkitMatchesSelector", "mozMatchesSelector", "msMatchesSelector", "oMatchesSelector"];
                        try {
                            for (var h = 0; h < f.length; h++)
                                if (b[f[h]]) { e = b[f[h]](c); break a }
                        } catch (v) {}
                    }
                    e = !1
                }
                return e;
            case "_ew":
                var k, l;
                k = String(b);
                l = String(c);
                var m = k.length -
                    l.length;
                return 0 <= m && k.indexOf(l, m) == m;
            case "_eq":
                return String(b) == String(c);
            case "_ge":
                return Number(b) >= Number(c);
            case "_gt":
                return Number(b) > Number(c);
            case "_lc":
                var n;
                n = String(b).split(",");
                return 0 <= q(n, String(c));
            case "_le":
                return Number(b) <= Number(c);
            case "_lt":
                return Number(b) < Number(c);
            case "_re":
                var r;
                var u = a.ignore_case ? "i" : void 0;
                try {
                    var p = String(c) + u,
                        t = Ij.get(p);
                    t || (t = new RegExp(c, u), Ij.set(p, t));
                    r = t.test(b)
                } catch (v) { r = !1 }
                return r;
            case "_sw":
                return 0 == String(b).indexOf(String(c));
            case "_um":
                return Jj(b,
                    c)
        }
        return !1
    };
    var Mj = function(a, b) {
        var c = function() {};
        c.prototype = a.prototype;
        var d = new c;
        a.apply(d, Array.prototype.slice.call(arguments, 1));
        return d
    };
    var Nj = {},
        Oj = encodeURI,
        Y = encodeURIComponent,
        Pj = mc;
    var Qj = function(a, b) {
        if (!a) return !1;
        var c = Ye(Ze(a), "host");
        if (!c) return !1;
        for (var d = 0; b && d < b.length; d++) {
            var e = b[d] && b[d].toLowerCase();
            if (e) {
                var f = c.length - e.length;
                0 < f && "." != e.charAt(0) && (f--, e = "." + e);
                if (0 <= f && c.indexOf(e, f) == f) return !0
            }
        }
        return !1
    };
    var Rj = function(a, b, c) { for (var d = {}, e = !1, f = 0; a && f < a.length; f++) a[f] && a[f].hasOwnProperty(b) && a[f].hasOwnProperty(c) && (d[a[f][b]] = a[f][c], e = !0); return e ? d : null };
    Nj.wg = function() { var a = !1; return a };
    var dl = function() {
        var a = D.gaGlobal = D.gaGlobal || {};
        a.hid = a.hid || wa();
        return a.hid
    };
    var ol = window,
        pl = document,
        ql = function(a) {
            var b = ol._gaUserPrefs;
            if (b && b.ioo && b.ioo() || a && !0 === ol["ga-disable-" + a]) return !0;
            try { var c = ol.external; if (c && c._gaUserPrefs && "oo" == c._gaUserPrefs) return !0 } catch (f) {}
            for (var d = Rf("AMP_TOKEN", pl.cookie, !0), e = 0; e < d.length; e++)
                if ("$OPT_OUT" == d[e]) return !0;
            return pl.getElementById("__gaOptOutExtension") ? !0 : !1
        };
    var tl = function(a) {
        za(a, function(c) { "_" === c.charAt(0) && delete a[c] });
        var b = a[H.ca] || {};
        za(b, function(c) { "_" === c.charAt(0) && delete b[c] })
    };
    var xl = function(a, b, c) { Kf(b, c, a) },
        yl = function(a, b, c) { Kf(b, c, a, !0) },
        Al = function(a, b) {};

    function zl(a, b) {}
    var Bl = function(a) { var b = tf(a, "/2"); return b ? b : -1 === navigator.userAgent.toLowerCase().indexOf("firefox") ? Q("https://", "http://", "www.googleadservices.com/pagead/conversion_async.js") : "https://www.google.com/pagead/conversion_async.js" },
        Cl = !1,
        Dl = [],
        El = ["aw", "dc"],
        Fl = function(a) {
            var b = D.google_trackConversion,
                c = a.gtm_onFailure;
            "function" == typeof b ? b(a) || c() : c()
        },
        Gl = function() { for (; 0 < Dl.length;) Fl(Dl.shift()) },
        Hl = function(a) {
            if (!Cl) {
                Cl = !0;
                He();
                var b = function() {
                    Gl();
                    Dl = { push: Fl }
                };
                Ud() ? b() : jc(a, b, function() {
                    Gl();
                    Cl = !1
                })
            }
        },
        Il = function(a) {
            if (a) {
                for (var b = [], c = 0; c < a.length; ++c) {
                    var d = a[c];
                    d && b.push({ item_id: d.id, quantity: d.quantity, value: d.price, start_date: d.start_date, end_date: d.end_date })
                }
                return b
            }
        },
        Jl = function(a, b, c, d) {
            var e = Rc(a),
                f = b == H.D,
                h = e.o[0],
                k = e.o[1],
                l = void 0 !== k,
                m = function(W) { return d.getWithConfig(W) },
                n = !1 !== m(H.Aa),
                r = m(H.ya) || m(H.S),
                u = m(H.P),
                p = m(H.Y),
                t = Bl(m(H.ia));
            if (f) {
                var v = m(H.ma) || {};
                if (n) {
                    Ph(v[H.Qa], !!v[H.C]) && bi(El, r, void 0, u, p);
                    var w = { prefix: r, domain: u, Ia: p };
                    Zh(w);
                    fi(["aw", "dc"], w)
                }
                v[H.C] &&
                    di(El, v[H.C], v[H.Ta], !!v[H.Ra], r);
                var y = !1;
                y ? ge(e, d) : ge(e)
            }
            var x = !1 === m(H.yd) || !1 === m(H.Wa);
            if (!f || !l && !x)
                if (!0 === m(H.zd) && (l = !1), !1 !== m(H.X) || l) {
                    var z = {
                        google_conversion_id: h,
                        google_remarketing_only: !l,
                        onload_callback: d.B,
                        gtm_onFailure: d.w,
                        google_conversion_format: "3",
                        google_conversion_color: "ffffff",
                        google_conversion_domain: "",
                        google_conversion_label: k,
                        google_conversion_language: m(H.Ca),
                        google_conversion_value: m(H.W),
                        google_conversion_currency: m(H.aa),
                        google_conversion_order_id: m(H.Xa),
                        google_user_id: m(H.Ya),
                        google_conversion_page_url: m(H.Ua),
                        google_conversion_referrer_url: m(H.Va),
                        google_gtm: oi(),
                        google_transport_url: tf(m(H.ia), "/")
                    };
                    z.google_restricted_data_processing = m(H.kc);
                    Ud() && (z.opt_image_generator = function() { return new Image }, z.google_enable_display_cookie_match = !1);
                    !1 === m(H.X) && (z.google_allow_ad_personalization_signals = !1);
                    z.google_read_gcl_cookie_opt_out = !n;
                    n && r && (z.google_gcl_cookie_prefix = r);
                    var C = function() {
                        var W = m(H.Fb),
                            T = { event: b };
                        if (ua(W)) {
                            I("GTM", 26);
                            for (var na = 0; na < W.length; ++na) {
                                var ha = W[na],
                                    N = m(ha);
                                void 0 !== N && (T[ha] = N)
                            }
                            return T
                        }
                        var L = d.eventModel;
                        if (!L) return null;
                        B(L, T);
                        for (var P = 0; P < H.vd.length; ++P) delete T[H.vd[P]];
                        return T
                    }();
                    C && (z.google_custom_params = C);
                    !l && m(H.M) && (z.google_gtag_event_data = { items: m(H.M), value: m(H.W) });
                    if (l && b == H.la) {
                        z.google_conversion_merchant_id = m(H.Ed);
                        z.google_basket_feed_country =
                            m(H.Cd);
                        z.google_basket_feed_language = m(H.Dd);
                        z.google_basket_discount = m(H.Ad);
                        z.google_basket_transaction_type = b;
                        z.google_disable_merchant_reported_conversions = !0 === m(H.Hd);
                        Ud() && (z.google_disable_merchant_reported_conversions = !0);
                        var A = Il(m(H.M));
                        A && (z.google_conversion_items = A)
                    }
                    var E = function(W, T) { void 0 != T && "" !== T && (z.google_additional_conversion_params = z.google_additional_conversion_params || {}, z.google_additional_conversion_params[W] = T) };
                    l && ("boolean" === typeof m(H.fc) && E("vdnc", m(H.fc)), E("vdltv",
                        m(H.Fd)));
                    var J = !0;
                    J && Dl.push(z)
                }
            Hl(t)
        };
    var Kl = function(a, b, c, d, e, f) {
            var h = { config: a, gtm: oi() };
            c && (mh(d, void 0, e, f), h.auiddc = ih[jh(d)]);
            b && (h.loadInsecure = b);
            void 0 === D.__dc_ns_processor && (D.__dc_ns_processor = []);
            D.__dc_ns_processor.push(h);
            jc((b ? "http" : "https") + "://www.googletagmanager.com/dclk/ns/v1.js")
        },
        Ll = function(a, b, c) {
            var d = /^u([1-9]\d?|100)$/,
                e = a.getWithConfig(H.Ch) || {},
                f = Pd(b, c);
            var h = {},
                k = {};
            if (Ra(e))
                for (var l in e)
                    if (e.hasOwnProperty(l) &&
                        d.test(l)) {
                        var m = e[l];
                        g(m) && (h[l] = m)
                    }
            for (var n = 0; n < f.length; n++) {
                var r = f[n];
                d.test(r) && (h[r] = r)
            }
            for (var u in h) h.hasOwnProperty(u) && (k[u] = a.getWithConfig(h[u]));
            return k
        },
        Ml = function(a) {
            function b(l, m, n) { void 0 !== n && 0 !== (n + "").length && d.push(l + m + ":" + c(n + "")) }
            var c = encodeURIComponent,
                d = [],
                e = a(H.M) || [];
            if (ua(e))
                for (var f = 0; f < e.length; f++) {
                    var h = e[f],
                        k = f + 1;
                    b("i", k, h.id);
                    b("p", k, h.price);
                    b("q", k, h.quantity);
                    b("c", k, a(H.yh));
                    b("l", k, a(H.Ca))
                }
            return d.join("|")
        },
        Nl = function(a) {
            var b = /^DC-(\d+)(\/([\w-]+)\/([\w-]+)\+(\w+))?$/.exec(a);
            if (b) { var c = { standard: 2, unique: 3, per_session: 4, transactions: 5, items_sold: 6, "": 1 }[(b[5] || "").toLowerCase()]; if (c) return { containerId: "DC-" + b[1], N: b[3] ? a : "", kf: b[1], hf: b[3] || "", $a: b[4] || "", V: c } }
        },
        Pl = function(a, b, c, d) {
            var e = Nl(a);
            if (e) {
                var f = function(M) { return d.getWithConfig(M) },
                    h = !1 !== f(H.Aa),
                    k = f(H.ya) || f(H.S),
                    l = f(H.P),
                    m = f(H.Y),
                    n = f(H.Eh),
                    r = 3 === Vd();
                if (b === H.D) {
                    var u = f(H.ma) || {},
                        p = f(H.pb),
                        t = void 0 === p ? !0 : !!p;
                    if (h) {
                        if (Ph(u[H.Qa], !!u[H.C])) {
                            bi(Ol, k, void 0, l,
                                m);
                        }
                        var v = { prefix: k, domain: l, Ia: m };
                        Zh(v);
                        fi(Ol, v);
                        ki(t, k, void 0, l, m)
                    }
                    if (u[H.C]) { di(Ol, u[H.C], u[H.Ta], !!u[H.Ra], k); }
                    if (n && n.exclusion_parameters && n.engines)
                        if (Ud()) {} else Kl(n, r, h, k, l, m);
                    G(d.B)
                } else {
                    var w = {},
                        y = f(H.Dh);
                    if (Ra(y))
                        for (var x in y)
                            if (y.hasOwnProperty(x)) {
                                var z = y[x];
                                void 0 !== z && null !==
                                    z && (w[x] = z)
                            }
                    var C = "";
                    if (5 === e.V || 6 === e.V) C = Ml(f);
                    var A = Ll(d, e.containerId, e.N),
                        E = !0 === f(H.jh);
                    if (Ud() && E) { E = !1 }
                    var J = { $a: e.$a, Bc: h, Nf: l, Of: m, Da: k, Eb: f(H.W), V: e.V, Rf: w, Cc: e.kf, Fc: e.hf, w: d.w, B: d.B, Sb: Xe(Ze(D.location.href)), Sc: C, protocol: r ? "http:" : "https:", Wc: f(H.Se), Xb: E, sessionId: f(H.Nb), bc: void 0, transactionId: f(H.Xa), cc: void 0, dd: A, sf: !1 !== f(H.X) };
                    si(J)
                }
            } else G(d.w)
        },
        Ol = ["aw", "dc"];
    var Ql = /.*\.google\.com(:\d+)?\/booking\/flights.*/,
        Sl = function(a, b, c, d) {
            var e = function(w) { return d.getWithConfig(w) },
                f = Rc(a).o[0],
                h = !1 !== e(H.Aa),
                k = e(H.ya) || e(H.S),
                l = e(H.P),
                m = e(H.Y);
            if (b === H.D) {
                if (h) {
                    var n = { prefix: k, domain: l, Ia: m };
                    Zh(n);
                    fi(["aw", "dc"], n)
                }
                G(d.B)
            } else {
                var r = { conversion_id: f, onFailure: d.w, onSuccess: d.B, conversionLinkerEnabled: h, cookiePrefix: k },
                    u = Ql.test(D.location.href);
                if (b !== H.la) G(d.w);
                else {
                    var t = { partner_id: f, trip_type: e(H.$e), total_price: e(H.W), currency: e(H.aa), is_direct_booking: u, flight_segment: Rl(e(H.M)) },
                        v = e(H.Qd);
                    v && "object" === typeof v && (t.passengers_total = v.total, t.passengers_adult = v.adult, t.passengers_child = v.child, t.passengers_infant_in_seat = v.infant_in_seat, t.passengers_infant_in_lap = v.infant_in_lap);
                    r.conversion_data = t;
                    zi(r)
                }
            }
        },
        Rl = function(a) {
            if (a) {
                for (var b = [], c = 0, d = 0; d < a.length; ++d) { var e = a[d];!e || void 0 !== e.category && "" !== e.category && "FlightSegment" !== e.category || (b[c] = { cabin: e.travel_class, fare_product: e.fare_product, booking_code: e.booking_code, flight_number: e.flight_number, origin: e.origin, destination: e.destination, departure_date: e.start_date }, c++) }
                return b
            }
        };
    var Xl = function(a, b, c, d) {
            var e = Rc(a),
                f = function(t) { return d.getWithConfig(t) },
                h = !1 !== f(H.Aa),
                k = f(H.ya) || f(H.S),
                l = f(H.P),
                m = f(H.Y);
            if (b === H.D) {
                var n = f(H.ma) || {};
                if (h) {
                    Ph(n[H.Qa], !!n[H.C]) && bi(Tl, k, void 0, l, m);
                    var r = { prefix: k, domain: l, Ia: m };
                    Zh(r);
                    fi(["aw", "dc"], r)
                }
                if (n[H.C]) { di(Tl, n[H.C], n[H.Ta], !!n[H.Ra], k); }
                G(d.B)
            } else {
                var u, p;
                b === H.la ? u = Ul(f(H.Xa), f(H.W), f(H.aa), f(H.M)) : b === H.Pa && (p = Vl(e.o[0], f(H.W), f(H.Od), f(H.aa),
                    f(H.M)));
                void 0 !== u || void 0 !== p ? Wl(e.o[0], u, p, h, k, d.B, d.w) : G(d.w)
            }
        },
        Ul = function(a, b, c, d) {
            var e = {};
            if (g(a) || Yl(a)) e.ig = String(a);
            g(c) && (e.lg = c);
            if (g(b) || Yl(b)) e.ng = e.hg = String(b);
            if (!ua(d) || 0 === d.length) return e;
            var f = d[0];
            if (!Ra(f)) return e;
            if (g(f.id) || Yl(f.id)) e.mg = String(f.id);
            g(f.start_date) && (e.jg = f.start_date);
            g(f.end_date) && (e.kg = f.end_date);
            return e
        },
        Wl = function(a, b, c, d, e, f, h) {
            if (/^\d+$/.test(a)) {
                var k = Zl(b, c),
                    l = !1;
                void 0 === b && (l = !0);
                mc($l(a, k, l, d, e), f, h)
            } else G(h)
        },
        Vl = function(a, b, c, d, e) {
            function f(l,
                m) {
                void 0 === l && (l = 0);
                void 0 === m && (m = "USD");
                if (g(l)) return m + l;
                if (Yl(l)) return m + String(l)
            }
            var h = {};
            if (/^\d+$/.test(a)) h.Qg = a;
            else return h;
            g(d) && (h.currency = d);
            if (g(b) || Yl(b)) h.yf = f(b, h.currency);
            if (g(c) || Yl(c)) h.ph = f(c, h.currency);
            if (g(b) || Yl(b)) h.Vf = f(b, h.currency);
            g("LANDING_PAGE") && (h.Ng = "LANDING_PAGE");
            if (!ua(e) || 0 == e.length) return h;
            var k = e[0];
            if (!Ra(k)) return h;
            if (g(k.price) || Yl(k.price)) h.rh = f(k.price, h.currency);
            g(k.id) ? h.te = k.id : Yl(k.id) && (h.te = String(k.id));
            g(k.start_date) && (h.Jf = k.start_date);
            g(k.end_date) && (h.Kf = k.end_date);
            Yl(k.occupancy) && (h.jf = k.occupancy);
            g(k.room_id) && (h.hh = k.room_id);
            g(k.rate_rule_id) && (h.$g = k.rate_rule_id);
            return h
        },
        $l = function(a, b, c, d, e) {
            var f = encodeURIComponent(a),
                h = encodeURIComponent(b),
                k;
            k = c ? "https://www.googletraveladservices.com/travel/clk/pagead/conversion/" + f + "/?label=FH&guid=ON&script=0&ord=" + (String(wa(0, 4294967295)) + "&price=") + h : "https://www.googletraveladservices.com/travel/clk/pagead/conversion/" + f + "/?data=" + h;
            d && (k += ii("ha", e).map(function(l) {
                return "&gclha=" +
                    encodeURIComponent(l)
            }).join(""));
            return k
        },
        Zl = function(a, b) {
            function c(e, f) { void 0 !== f && d.push(e + "=" + f) }
            var d = [];
            void 0 !== a ? (c("hct_base_price", a.hg), c("hct_booking_xref", a.ig), c("hct_checkin_date", a.jg), c("hct_checkout_date", a.kg), c("hct_currency_code", a.lg), c("hct_partner_hotel_id", a.mg), c("hct_total_price", a.ng)) : void 0 !== b && (c("partner_id", b.Qg), c("partner_hotel_id", b.te), c("check_in_date", b.Jf), c("check_out_date", b.Kf), c("base_price_value_string", b.yf), c("tax_price_value_string", b.ph), c("total_price_value_string",
                b.rh), c("display_price_value_string", b.Vf), c("display_price_description_string", b.Oh), c("page_type", b.Ng), c("adults", b.jf), c("room_id", b.hh), c("rate_rule_id", b.$g));
            return d.join(";")
        },
        Yl = function(a) { return "number" === typeof a },
        Tl = ["ha"];
    var nm = function(a, b, c, d) {
            var e = "https://www.google-analytics.com/analytics.js",
                f = Oe();
            if (qa(f)) {
                var h = "gtag_" + a.split("-").join("_"),
                    k = function(x) {
                        var z = [].slice.call(arguments, 0);
                        z[0] = h + "." + z[0];
                        f.apply(window, z)
                    },
                    l = function() {
                        var x = function(E, J) { for (var M = 0; J && M < J.length; M++) k(E, J[M]) },
                            z = em(b, d);
                        if (z) {
                            var C = z.action;
                            if ("impressions" === C) x("ec:addImpression", z.pg);
                            else if ("promo_click" === C || "promo_view" === C) {
                                var A = z.Tc;
                                x("ec:addPromo", z.Tc);
                                A && 0 < A.length && "promo_click" === C && k("ec:setAction", C)
                            } else x("ec:addProduct",
                                z.Ja), k("ec:setAction", C, z.Za)
                        }
                    },
                    m = function() {
                        if (Ud()) {} else {
                            var x = d.getWithConfig(H.Oe);
                            x && (k("require", x, { dataLayer: "dataLayer" }), k("require", "render"))
                        }
                    },
                    n = fm(a, h, b, d);
                gm(h, n.Ea) && (f(function() { Me() && Me().remove(h) }), hm[h] = !1);
                f("create", a, n.Ea);
                (function() {
                    var x = d.getWithConfig("custom_map");
                    f(function() {
                        if (Ra(x)) {
                            var z = n.ja,
                                C = Me().getByName(h),
                                A;
                            for (A in x)
                                if (x.hasOwnProperty(A) && /^(dimension|metric)\d+$/.test(A) && void 0 != x[A]) {
                                    var E = C.get(im(x[A]));
                                    jm(z, A, E)
                                }
                        }
                    })
                })();
                (function(x) {
                    if (x) {
                        var z = {};
                        if (Ra(x))
                            for (var C in km) km.hasOwnProperty(C) && lm(km[C], C, x[C], z);
                        k("require", "linkid", z)
                    }
                })(n.linkAttribution);
                var u = n[H.ma];
                if (u && u[H.C]) {
                    var p = u[H.Ta];
                    Pe(h + ".", u[H.C], void 0 === p ? !!u.use_anchor : "fragment" === p, !!u[H.Ra])
                }
                var t = function(x, z, C) {
                    C && (z = "" + z);
                    n.ja[x] = z
                };
                if (b === H.Zc) m(), k("send", "pageview", n.ja);
                else if (b === H.D) {
                    m();
                    var v = !1;
                    v ? ge(a, d) : ge(a);
                    0 != n.sendPageView && k("send", "pageview", n.ja)
                } else "screen_view" === b ? k("send", "screenview", n.ja) : "timing_complete" === b ? (t("timingCategory",
                    n.eventCategory, !0), t("timingVar", n.name, !0), t("timingValue", Aa(n.value)), void 0 !== n.eventLabel && t("timingLabel", n.eventLabel, !0), k("send", "timing", n.ja)) : "exception" === b ? k("send", "exception", n.ja) : "optimize.callback" !== b && (0 <= q([H.Xc, "select_content", H.Pa, H.yb, H.zb, H.Oa, "set_checkout_option", H.la, H.Ab, "view_promotion", "checkout_progress"], b) && (k("require", "ec", "ec.js"), l()), t("eventCategory", n.eventCategory, !0), t("eventAction", n.eventAction || b, !0), void 0 !== n.eventLabel && t("eventLabel", n.eventLabel, !0), void 0 !== n.value && t("eventValue", Aa(n.value)), k("send", "event", n.ja));
                if (!mm) {
                    mm = !0;
                    He();
                    var w = d.w,
                        y = function() { Me().loaded || w() };
                    Ud() ? G(y) : jc(e, y, w)
                }
            } else G(d.w)
        },
        mm, hm = {},
        om = { client_id: 1, client_storage: "storage", cookie_name: 1, cookie_domain: 1, cookie_expires: 1, cookie_path: 1, cookie_update: 1, sample_rate: 1, site_speed_sample_rate: 1, use_amp_client_id: 1, store_gac: 1, conversion_linker: "storeGac" },
        pm = {
            anonymize_ip: 1,
            app_id: 1,
            app_installer_id: 1,
            app_name: 1,
            app_version: 1,
            campaign: {
                name: "campaignName",
                source: "campaignSource",
                medium: "campaignMedium",
                term: "campaignTerm",
                content: "campaignContent",
                id: "campaignId"
            },
            currency: "currencyCode",
            description: "exDescription",
            fatal: "exFatal",
            language: 1,
            non_interaction: 1,
            page_hostname: "hostname",
            page_referrer: "referrer",
            page_path: "page",
            page_location: "location",
            page_title: "title",
            screen_name: 1,
            transport_type: "transport",
            user_id: 1
        },
        qm = { content_id: 1, event_category: 1, event_action: 1, event_label: 1, link_attribution: 1, linker: 1, method: 1, name: 1, send_page_view: 1, value: 1 },
        km = {
            cookie_name: 1,
            cookie_expires: "duration",
            levels: 1
        },
        rm = { anonymize_ip: 1, fatal: 1, non_interaction: 1, use_amp_client_id: 1, send_page_view: 1, store_gac: 1, conversion_linker: 1 },
        lm = function(a, b, c, d) {
            if (void 0 !== c)
                if (rm[b] && (c = Ba(c)), "anonymize_ip" !== b || c || (c = void 0), 1 === a) d[im(b)] = c;
                else if (g(a)) d[a] = c;
            else
                for (var e in a) a.hasOwnProperty(e) && void 0 !== c[e] && (d[a[e]] = c[e])
        },
        im = function(a) { return a && g(a) ? a.replace(/(_[a-z])/g, function(b) { return b[1].toUpperCase() }) : a },
        sm = function(a) {
            var b = "general";
            0 <= q([H.wd, H.yb, H.xd, H.Oa, "checkout_progress", H.la, H.Ab,
                H.zb, "set_checkout_option"
            ], a) ? b = "ecommerce" : 0 <= q("generate_lead login search select_content share sign_up view_item view_item_list view_promotion view_search_results".split(" "), a) ? b = "engagement" : "exception" === a && (b = "error");
            return b
        },
        jm = function(a, b, c) { a.hasOwnProperty(b) || (a[b] = c) },
        tm = function(a) {
            if (ua(a)) {
                for (var b = [], c = 0; c < a.length; c++) {
                    var d = a[c];
                    if (void 0 != d) {
                        var e = d.id,
                            f = d.variant;
                        void 0 != e && void 0 != f && b.push(String(e) + "." + String(f))
                    }
                }
                return 0 < b.length ? b.join("!") : void 0
            }
        },
        fm = function(a, b,
            c, d) {
            var e = function(A) { return d.getWithConfig(A) },
                f = {},
                h = {},
                k = {},
                l = tm(e(H.Je));
            l && jm(h, "exp", l);
            var m = e("custom_map");
            if (Ra(m))
                for (var n in m)
                    if (m.hasOwnProperty(n) && /^(dimension|metric)\d+$/.test(n) && void 0 != m[n]) {
                        var r = e(String(m[n]));
                        void 0 !== r && jm(h, n, r)
                    }
            var u = Pd(a);
            for (var p = 0; p < u.length; ++p) {
                var t = u[p],
                    v = e(t);
                if (qm.hasOwnProperty(t)) lm(qm[t], t, v, f);
                else if (pm.hasOwnProperty(t)) lm(pm[t],
                    t, v, h);
                else if (om.hasOwnProperty(t)) lm(om[t], t, v, k);
                else if (/^(dimension|metric|content_group)\d+$/.test(t)) lm(1, t, v, h);
                else if ("developer_id" === t) {} else t === H.S && 0 > q(u, H.Db) && (k.cookieName = v + "_ga")
            }
            jm(k, "cookieDomain", "auto");
            jm(h, "forceSSL", !0);
            jm(f, "eventCategory", sm(c));
            0 <= q(["view_item", "view_item_list", "view_promotion", "view_search_results"], c) && jm(h, "nonInteraction", !0);
            "login" === c || "sign_up" === c || "share" === c ? jm(f, "eventLabel", e(H.Me)) : "search" === c || "view_search_results" === c ? jm(f, "eventLabel", e(H.We)) : "select_content" === c && jm(f, "eventLabel", e(H.wh));
            var y = f[H.ma] || {},
                x = y[H.Qa];
            x || 0 != x && y[H.C] ? k.allowLinker = !0 : !1 === x && jm(k, "useAmpClientId", !1);
            if (!1 === e(H.qh) || !1 === e(H.X) || !1 === e(H.ob)) h.allowAdFeatures = !1;
            !1 === e(H.X) && I("GTM", 27);
            k.name = b;
            h["&gtm"] = oi(!0);
            h.hitCallback = d.B;
            var z = e(H.Le) || Kd("gtag.remote_config." + a + ".url", 2),
                C = e(H.Ke) || Kd("gtag.remote_config." +
                    a + ".dualId", 2);
            z && null != gc && (k._x_19 = z);
            C && (k._x_20 = C);
            f.ja = h;
            f.Ea = k;
            return f
        },
        em = function(a, b) {
            function c(v) {
                var w = B(v);
                w.list = v.list_name;
                w.listPosition = v.list_position;
                w.position = v.list_position || v.creative_slot;
                w.creative = v.creative_name;
                return w
            }

            function d(v) { for (var w = [], y = 0; v && y < v.length; y++) v[y] && w.push(c(v[y])); return w.length ? w : void 0 }

            function e(v) { return { id: f(H.Xa), affiliation: f(H.Ce), revenue: f(H.W), tax: f(H.Od), shipping: f(H.He), coupon: f(H.Ee), list: f(H.ed) || v } }
            for (var f = function(v) { return b.getWithConfig(v) },
                    h = f(H.M), k, l = 0; h && l < h.length && !(k = h[l][H.ed]); l++);
            var m = f("custom_map");
            if (Ra(m))
                for (var n = 0; h && n < h.length; ++n) {
                    var r = h[n],
                        u;
                    for (u in m) m.hasOwnProperty(u) && /^(dimension|metric)\d+$/.test(u) && void 0 != m[u] && jm(r, u, r[m[u]])
                }
            var p = null,
                t = f(H.Fe);
            a === H.la || a === H.Ab ? p = { action: a, Za: e(), Ja: d(h) } : a === H.yb ? p = { action: "add", Ja: d(h) } : a === H.zb ? p = { action: "remove", Ja: d(h) } : a === H.Pa ? p = { action: "detail", Za: e(k), Ja: d(h) } : a === H.Xc ? p = { action: "impressions", pg: d(h) } : "view_promotion" === a ? p = { action: "promo_view", Tc: d(t) } :
                "select_content" === a && t && 0 < t.length ? p = { action: "promo_click", Tc: d(t) } : "select_content" === a ? p = { action: "click", Za: { list: f(H.ed) || k }, Ja: d(h) } : a === H.Oa || "checkout_progress" === a ? p = { action: "checkout", Ja: d(h), Za: { step: a === H.Oa ? 1 : f(H.Md), option: f(H.Ld) } } : "set_checkout_option" === a && (p = { action: "checkout_option", Za: { step: f(H.Md), option: f(H.Ld) } });
            p && (p.Mh = f(H.aa));
            return p
        },
        um = {},
        gm = function(a, b) {
            var c = um[a];
            um[a] = B(b);
            if (!c) return !1;
            for (var d in b)
                if (b.hasOwnProperty(d) && b[d] !== c[d]) return !0;
            for (var e in c)
                if (c.hasOwnProperty(e) &&
                    c[e] !== b[e]) return !0;
            return !1
        };
    var Z = { a: {} };



    Z.a.gtagha = ["google"],
        function() {
            var a = !1;
            var b = function(c) {
                var d = c.vtp_conversionId,
                    e = cd,
                    f = S("eventModel");
                if (a) {
                    Jf(d.id, Xl);
                    if (e === H.D) {
                        var h = S("gtag.targets." + d.id);
                        Lf(h, d.id)
                    } else Kf(e, f, d.id);
                    G(c.vtp_gtmOnSuccess)
                } else {
                    var k = Cf(Bf(wf(f), c.vtp_gtmOnSuccess), c.vtp_gtmOnFailure);
                    k.getWithConfig = function(l) { return Md(l, d.containerId, d.id) };
                    Xl(d.id, e, (new Date).getTime(),
                        k)
                }
            };
            Z.__gtagha = b;
            Z.__gtagha.b = "gtagha";
            Z.__gtagha.g = !0;
            Z.__gtagha.priorityOverride = 0;
        }();
    Z.a.e = ["google"],
        function() {
            (function(a) {
                Z.__e = a;
                Z.__e.b = "e";
                Z.__e.g = !0;
                Z.__e.priorityOverride = 0
            })(function(a) { return String(Sd(a.vtp_gtmEventId, "event")) })
        }();

    Z.a.v = ["google"],
        function() {
            (function(a) {
                Z.__v = a;
                Z.__v.b = "v";
                Z.__v.g = !0;
                Z.__v.priorityOverride = 0
            })(function(a) { var b = a.vtp_name; if (!b || !b.replace) return !1; var c = S(b.replace(/\\\./g, "."), a.vtp_dataLayerVersion || 1); return void 0 !== c ? c : a.vtp_defaultValue })
        }();








    Z.a.gtagaw = ["google"],
        function() {
            (function(a) {
                Z.__gtagaw = a;
                Z.__gtagaw.b = "gtagaw";
                Z.__gtagaw.g = !0;
                Z.__gtagaw.priorityOverride = 0
            })(function(a) {
                var b = a.vtp_conversionId,
                    c = cd;
                Jf(b.id, Jl);
                if (c === H.D) {
                    var d = S("gtag.targets." + b.id);
                    Lf(d, b.id)
                } else {
                    var e = S("eventModel");
                    Kf(c, e, b.id)
                }
                G(a.vtp_gtmOnSuccess)
            })
        }();

    Z.a.get = ["google"],
        function() {
            (function(a) {
                Z.__get = a;
                Z.__get.b = "get";
                Z.__get.g = !0;
                Z.__get.priorityOverride = 0
            })(function(a) {
                if (a.vtp_isAutoTag) {
                    var b = String(a.vtp_trackingId),
                        c = cd || "",
                        d = {};
                    if (c === H.D) {
                        var e = S("gtag.targets." + b);
                        B(e, d);
                        d[H.oa] = !0;
                        Lf(d, b)
                    } else {
                        var f = S("eventModel");
                        B(f, d);
                        d[H.oa] = !0;
                        Kf(c, d, b)
                    }
                } else {
                    var h = a.vtp_settings;
                    (a.vtp_deferrable ? yl : xl)(String(h.streamId), String(a.vtp_eventName), h.eventParameters || {})
                }
                a.vtp_gtmOnSuccess()
            })
        }();


    Z.a.gtagfl = [],
        function() {
            function a(d) { var e = /^DC-(\d+)(\/([\w-]+)\/([\w-]+)\+(\w+))?$/.exec(d); if (e) return { containerId: "DC-" + e[1], N: e[3] && d } }
            var b = !1;
            var c = function(d) {
                var e = d.vtp_targetId,
                    f = cd,
                    h = S("eventModel");
                if (b) {
                    Jf(e, Pl);
                    if (f === H.D) {
                        var k = S("gtag.targets." + e);
                        Lf(k, e)
                    } else Kf(f, h, e);
                    G(d.vtp_gtmOnSuccess)
                } else {
                    var l = a(e);
                    if (l) {
                        var m = Cf(Bf(wf(h), d.vtp_gtmOnSuccess),
                            d.vtp_gtmOnFailure);
                        m.getWithConfig = function(n) { return Md(n, l.containerId, l.N) };
                        Pl(e, f, (new Date).getTime(), m)
                    } else G(d.vtp_gtmOnFailure)
                }
            };
            Z.__gtagfl = c;
            Z.__gtagfl.b = "gtagfl";
            Z.__gtagfl.g = !0;
            Z.__gtagfl.priorityOverride = 0;
        }();


    Z.a.gtaggf = ["google"],
        function() {
            var a = !1;
            a = !0;
            var b = function(c) {
                var d = c.vtp_conversionId,
                    e = cd,
                    f = S("eventModel");
                if (a) {
                    Jf(d.id, Sl);
                    if (e === H.D) {
                        var h = S("gtag.targets." + d.id);
                        Lf(h, d.id)
                    } else Kf(e, f, d.id);
                    G(c.vtp_gtmOnSuccess)
                } else {
                    var k = Cf(Bf(wf(f), c.vtp_gtmOnSuccess), c.vtp_gtmOnFailure);
                    k.getWithConfig = function(l) { return Md(l, d.containerId, d.id) };
                    Sl(d.id, e,
                        (new Date).getTime(), k)
                }
            };
            Z.__gtaggf = b;
            Z.__gtaggf.b = "gtaggf";
            Z.__gtaggf.g = !0;
            Z.__gtaggf.priorityOverride = 0;
        }();




    Z.a.gtagua = ["google"],
        function() {
            var a = !1;
            var b = function(c) {
                var d = c.vtp_trackingId,
                    e = cd,
                    f = S("eventModel");
                if (a) {
                    Jf(d, nm);
                    if (e === H.D) {
                        var h = S("gtag.targets." + d);
                        Lf(h, d)
                    } else Kf(e, f, d);
                    G(c.vtp_gtmOnSuccess)
                } else {
                    var k = Cf(Bf(wf(f), c.vtp_gtmOnSuccess), c.vtp_gtmOnFailure);
                    k.getWithConfig = function(l) { return Md(l, d, void 0) };
                    nm(d, e, (new Date).getTime(), k)
                }
            };
            Z.__gtagua =
                b;
            Z.__gtagua.b = "gtagua";
            Z.__gtagua.g = !0;
            Z.__gtagua.priorityOverride = 0;
        }();


    var vm = {};
    vm.macro = function(a) { if (Vg.vc.hasOwnProperty(a)) return Vg.vc[a] }, vm.onHtmlSuccess = Vg.Xd(!0), vm.onHtmlFailure = Vg.Xd(!1);
    vm.dataLayer = Ld;
    vm.callback = function(a) {
        ed.hasOwnProperty(a) && qa(ed[a]) && ed[a]();
        delete ed[a]
    };

    function wm() {
        Vc[Uc.s] = vm;
        Ia(fd, Z.a);
        zb = zb || Vg;
        Ab = pe
    }

    function xm() {
        Qh.gtm_3pds = !0;
        Vc = D.google_tag_manager = D.google_tag_manager || {};
        if (Vc[Uc.s]) {
            var a = Vc.zones;
            a && a.unregisterChild(Uc.s)
        } else {
            for (var b = data.resource || {}, c = b.macros || [], d = 0; d < c.length; d++) rb.push(c[d]);
            for (var e = b.tags || [], f = 0; f < e.length; f++) vb.push(e[f]);
            for (var h = b.predicates || [], k = 0; k <
                h.length; k++) tb.push(h[k]);
            for (var l = b.rules || [], m = 0; m < l.length; m++) {
                for (var n = l[m], r = {}, u = 0; u < n.length; u++) r[n[u][0]] = Array.prototype.slice.call(n[u], 1);
                sb.push(r)
            }
            xb = Z;
            yb = Kj;
            wm();
            Ug();
            te = !1;
            ue = 0;
            if ("interactive" == F.readyState && !F.createEventObject || "complete" == F.readyState) we();
            else {
                nc(F, "DOMContentLoaded", we);
                nc(F, "readystatechange", we);
                if (F.createEventObject && F.documentElement.doScroll) {
                    var p = !0;
                    try { p = !D.frameElement } catch (y) {}
                    p && xe()
                }
                nc(D, "load", we)
            }
            sg = !1;
            "complete" === F.readyState ? ug() : nc(D,
                "load", ug);
            a: { if (!Ad) break a;D.setInterval(Bd, 864E5); }
            bd = (new Date).getTime();
            vm.bootstrap = bd;
        }
    }
    xm();

})()