<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="icon" href="/assets/images/favicon.svg" />
        <meta name="viewport" content="width=device-width,initial-scale=1" />
        <meta name="theme-color" content="#000000" />
        <meta name="description" content="Pharma Platform is online pharmacy management system that link all local pharmacies together under one system and enable online ordering for medicines." />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="/assets/css/all.min.css" />
        <link rel="apple-touch-icon" href="/logo192.png" />
        <link rel="manifest" href="/manifest.json" />
        <title>Pharma Platform</title>
        <link href="/static/css/2.f1888570.chunk.css" rel="stylesheet" />
        <link href="/static/css/main.4e762a9b.chunk.css" rel="stylesheet" />
    </head>
    <body style="background-image: url(/assets/images/bg.png);" class="bg-gray-100 text-black transition-colors duration-500">
        <noscript>You need to enable JavaScript to run this app.</noscript>
        <div id="root"></div>
        <script>
            !(function (e) {
                function r(r) {
                    for (var n, a, p = r[0], l = r[1], f = r[2], c = 0, s = []; c < p.length; c++) (a = p[c]), Object.prototype.hasOwnProperty.call(o, a) && o[a] && s.push(o[a][0]), (o[a] = 0);
                    for (n in l) Object.prototype.hasOwnProperty.call(l, n) && (e[n] = l[n]);
                    for (i && i(r); s.length; ) s.shift()();
                    return u.push.apply(u, f || []), t();
                }
                function t() {
                    for (var e, r = 0; r < u.length; r++) {
                        for (var t = u[r], n = !0, p = 1; p < t.length; p++) {
                            var l = t[p];
                            0 !== o[l] && (n = !1);
                        }
                        n && (u.splice(r--, 1), (e = a((a.s = t[0]))));
                    }
                    return e;
                }
                var n = {},
                    o = { 1: 0 },
                    u = [];
                function a(r) {
                    if (n[r]) return n[r].exports;
                    var t = (n[r] = { i: r, l: !1, exports: {} });
                    return e[r].call(t.exports, t, t.exports, a), (t.l = !0), t.exports;
                }
                (a.m = e),
                    (a.c = n),
                    (a.d = function (e, r, t) {
                        a.o(e, r) || Object.defineProperty(e, r, { enumerable: !0, get: t });
                    }),
                    (a.r = function (e) {
                        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, { value: "Module" }), Object.defineProperty(e, "__esModule", { value: !0 });
                    }),
                    (a.t = function (e, r) {
                        if ((1 & r && (e = a(e)), 8 & r)) return e;
                        if (4 & r && "object" == typeof e && e && e.__esModule) return e;
                        var t = Object.create(null);
                        if ((a.r(t), Object.defineProperty(t, "default", { enumerable: !0, value: e }), 2 & r && "string" != typeof e))
                            for (var n in e)
                                a.d(
                                    t,
                                    n,
                                    function (r) {
                                        return e[r];
                                    }.bind(null, n)
                                );
                        return t;
                    }),
                    (a.n = function (e) {
                        var r =
                            e && e.__esModule
                                ? function () {
                                      return e.default;
                                  }
                                : function () {
                                      return e;
                                  };
                        return a.d(r, "a", r), r;
                    }),
                    (a.o = function (e, r) {
                        return Object.prototype.hasOwnProperty.call(e, r);
                    }),
                    (a.p = "/");
                var p = (this["webpackJsonppharma-project"] = this["webpackJsonppharma-project"] || []),
                    l = p.push.bind(p);
                (p.push = r), (p = p.slice());
                for (var f = 0; f < p.length; f++) r(p[f]);
                var i = l;
                t();
            })([]);
        </script>
        <script src="/static/js/2.9b7ec32b.chunk.js"></script>
        <script src="/static/js/main.37435aee.chunk.js"></script>
    </body>
</html>
