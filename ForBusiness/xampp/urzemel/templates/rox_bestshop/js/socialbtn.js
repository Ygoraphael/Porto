if (typeof (stlib) == "undefined") {
    var stlib = {}
}
if (!stlib.functions) {
    stlib.functions = [];
    stlib.functionCount = 0
}
stlib.global = {};
stlib.global.hash = document.location.href.split("#");
stlib.global.hash.shift();
stlib.global.hash = stlib.global.hash.join("#");
stlib.dynamicOn = true;
stlib.debugOn = false;
stlib.debug = {
    count: 0,
    messages: [],
    debug: function (b, a) {
        if (a && (typeof console) != "undefined") {
            console.log(b)
        }
        stlib.debug.messages.push(b)
    },
    show: function (a) {
        for (message in stlib.debug.messages) {
            if ((typeof console) != "undefined") {
                if (a) {
                    /ERROR/.test(stlib.debug.messages[message]) ? console.log(stlib.debug.messages[message]) : null
                } else {
                    console.log(stlib.debug.messages[message])
                }
            }
        }
    },
    showError: function () {
        stlib.debug.show(true)
    }
};
var _$d = function (a) {
    stlib.debug.debug(a, stlib.debugOn)
};
var _$d0 = function () {
    _$d(" ")
};
var _$d_ = function () {
    _$d("___________________________________________")
};
var _$d1 = function (a) {
    _$d(_$dt() + "| " + a)
};
var _$d2 = function (a) {
    _$d(_$dt() + "|  * " + a)
};
var _$de = function (a) {
    _$d(_$dt() + "ERROR: " + a)
};
var _$dt = function () {
    var b = new Date();
    var e = b.getHours();
    var a = b.getMinutes();
    var d = b.getSeconds();
    return e + ":" + a + ":" + d + " > "
};
stlib.buttonInfo = {
    buttonList: [],
    addButton: function (a) {
        stlib.buttonInfo.buttonList.push(a)
    },
    getButton: function (a) {
        if (!isNaN(a)) {
            if (a >= stlib.buttonInfo.buttonList.length) {
                return false
            } else {
                return stlib.buttonInfo.buttonList[a]
            }
        } else {
            for (c = 0; c < stlib.buttonInfo.buttonList.length; c++) {
                if (stlib.buttonInfo.buttonList[c].service == a) {
                    debug(stlib.buttonInfo.buttonList[c])
                }
            }
        }
    },
    clickButton: function (a) {
        if (!isNaN(a)) {
            if (a >= stlib.buttonInfo.buttonList.length) {
                return false
            } else {
                if (stlib.buttonInfo.getButton(a).service == "sharethis" || stlib.buttonInfo.getButton(a).service == "email" || stlib.buttonInfo.getButton(a).service == "wordpress") {
                    stlib.buttonInfo.getButton(a).popup()
                } else {
                    stlib.buttonInfo.getButton(a).element.childNodes[0].onclick()
                }
            }
        } else {
            for (c = 0; c < stlib.buttonInfo.buttonList.length; c++) {
                if (stlib.buttonInfo.buttonList[c].service == a) {
                    if (stlib.buttonInfo.getButton(c).service == "sharethis" || stlib.buttonInfo.getButton(c).service == "email" || stlib.buttonInfo.getButton(c).service == "wordpress") {
                        stlib.buttonInfo.getButton(c).popup();
                        return true
                    } else {
                        stlib.buttonInfo.getButton(c).element.childNodes[0].onclick()
                    }
                }
            }
        }
    },
    resetButton: function () {
        stlib.buttonInfo.buttonList = []
    },
    listButton: function () {
        for (c = 0; c < stlib.buttonInfo.buttonList.length; c++) {
            debug(stlib.buttonInfo.buttonList[c])
        }
    }
};
stlib.buttonInfo.resetButton();
stlib.messageQueue = function () {
    var a = this;
    this.pumpInstance = null;
    this.queue = [];
    this.dependencies = ["data"];
    this.sending = true;
    this.setPumpInstance = function (b) {
        this.pumpInstance = b
    };
    this.send = function (f, d) {
        if ((typeof (f) == "string") && (typeof (d) == "string")) {
            _$d_();
            _$d1("Queueing message: " + d + ": " + f)
        }(typeof (f) == "string") && (typeof (d) == "string") ? this.queue.push([d, f]) : null;
        if (this.sending == false || stlib.browser.ieFallback) {
            if (this.pumpInstance != null) {
                if (this.dependencies.length > 0) {
                    for (messageSet in this.queue) {
                        if (this.queue[messageSet][0] == this.dependencies[0]) {
                            if (this.queue.length > 0) {
                                _$d1("Current Queue Length: " + this.queue.length);
                                var b = this.queue.shift();
                                this.pumpInstance.broadcastSendMessage(b[1]);
                                this.dependencies.shift();
                                this.sending = true
                            }
                        }
                    }
                } else {
                    if (this.queue.length > 0) {
                        _$d1("Current Queue Length: " + this.queue.length);
                        var b = this.queue.shift();
                        this.pumpInstance.broadcastSendMessage(b[1]);
                        this.sending = true
                    }
                }
            } else {
                _$d_();
                _$d1("Pump is null")
            }
        }
        if ((stlib.browser.ieFallback) && (this.queue.length > 0)) {
            var e = "process" + stlib.functionCount;
            stlib.functionCount++;
            stlib.functions[e] = a.process;
            setTimeout("stlib.functions['" + e + "']()", 500)
        }
    };
    this.process = function () {
        _$d1("Processing MessageQueue");
        a.sending = false;
        _$d(this.queue);
        a.send()
    }
};
stlib.sharer = {
    sharerUrl: (("https:" == document.location.protocol) ? "https://ws." : "http://wd.") + "sharethis.com/api/sharer.php",
    regAuto: new RegExp(/(.*?)_auto$/),
    constructParamString: function () {
        stlib.data.validate();
        stlib.hash.checkURL();
        var a = stlib.data.pageInfo;
        var d = "?";
        var b;
        for (b in a) {
            d += b + "=" + encodeURIComponent(a[b]) + "&";
            _$d1("constructParamStringPageInfo: " + b + ": " + a[b])
        }
        a = stlib.data.shareInfo;
        for (b in a) {
            d += b + "=" + encodeURIComponent(a[b]) + "&";
            _$d1("constructParamStringShareInfo: " + b + ": " + a[b])
        }
        return d.substring(0, d.length - 1)
    },
    sharePinterest: function () {
        if (typeof (stWidget) != "undefined" && typeof (stWidget.closeWidget) === "function") {
            stWidget.closeWidget()
        }
        if (typeof (stcloseWidget) === "function") {
            stcloseWidget()
        }
        if (typeof (stToolbar) != "undefined" && typeof (stToolbar.closeWidget) === "function") {
            stToolbar.closeWidget()
        }
        var a = document.createElement("script");
        a.setAttribute("type", "text/javascript");
        a.setAttribute("charset", "UTF-8");
        a.setAttribute("src", "//assets.pinterest.com/js/pinmarklet.js?r=" + Math.random() * 99999999);
        document.body.appendChild(a)
    },
    share: function (e, a) {
        var d = stlib.sharer.constructParamString();
        _$d_();
        _$d1("Initiating a Share with the following url:");
        _$d2(stlib.sharer.sharerUrl + d);
        if ((stlib.data.get("destination", "shareInfo") == "pinterest" && stlib.data.get("source", "shareInfo").match(/share4xmobile/) == null && stlib.data.get("source", "shareInfo").match(/share4xpage/) == null && stlib.data.get("source", "shareInfo").match(/5xpage/) == null && (stlib.data.get("image", "shareInfo") == false || stlib.data.get("image", "shareInfo") == null)) || stlib.data.get("destination", "shareInfo") == "copy" || stlib.data.get("destination", "shareInfo") == "plusone" || stlib.data.get("destination", "shareInfo").match(stlib.sharer.regAuto) || (typeof (stlib.nativeButtons) != "undefined" && stlib.nativeButtons.checkNativeButtonSupport(stlib.data.get("destination", "shareInfo")))) {
            var b = new Image(1, 1);
            b.src = stlib.sharer.sharerUrl + d;
            b.onload = function () {
                return
            }
        } else {
            if (typeof (a) != "undefined" && a == true) {
                window.open(stlib.sharer.sharerUrl + d, (new Date()).valueOf(), "scrollbars=1, status=1, height=480, width=640, resizable=1")
            } else {
                window.open(stlib.sharer.sharerUrl + d)
            }
        }
        e ? e() : null
    }
};
stlib.browser = {
    iemode: null,
    firefox: null,
    firefoxVersion: null,
    safari: null,
    chrome: null,
    windows: null,
    mac: null,
    ieFallback: (/MSIE [6789]/).test(navigator.userAgent),
    init: function () {
        if (window.navigator.appName == "Microsoft Internet Explorer") {
            if (document.documentMode) {
                stlib.browser.iemode = document.documentMode
            } else {
                stlib.browser.iemode = 5;
                if (document.compatMode) {
                    if (document.compatMode == "CSS1Compat") {
                        stlib.browser.iemode = 7
                    }
                }
            }
        }
        stlib.browser.firefox = (navigator.userAgent.indexOf("Firefox") != -1) ? true : false;
        stlib.browser.firefoxVersion = (navigator.userAgent.indexOf("Firefox/5.0") != -1 || navigator.userAgent.indexOf("Firefox/9.0") != -1) ? false : true;
        stlib.browser.safari = (navigator.userAgent.indexOf("Safari") != -1 && navigator.userAgent.indexOf("Chrome") == -1) ? true : false;
        stlib.browser.chrome = (navigator.userAgent.indexOf("Safari") != -1 && navigator.userAgent.indexOf("Chrome") != -1) ? true : false;
        stlib.browser.windows = (navigator.userAgent.indexOf("Windows") != -1) ? true : false;
        stlib.browser.mac = (navigator.userAgent.indexOf("Macintosh") != -1) ? true : false
    },
    getIEVersion: function () {
        return stlib.browser.iemode
    },
    isFirefox: function () {
        return stlib.browser.firefox
    },
    firefox8Version: function () {
        return stlib.browser.firefoxVersion
    },
    isSafari: function () {
        return stlib.browser.safari
    },
    isWindows: function () {
        return stlib.browser.windows
    },
    isMac: function () {
        return stlib.browser.mac
    }
};
stlib.browser.init();
stlib.browser.mobile = {
    mobile: false,
    uagent: null,
    android: null,
    iOs: null,
    silk: null,
    windows: null,
    kindle: null,
    init: function () {
        this.uagent = navigator.userAgent.toLowerCase();
        if (this.isAndroid()) {
            this.mobile = true
        } else {
            if (this.isIOs()) {
                this.mobile = true
            } else {
                if (this.isSilk()) {
                    this.mobile = true
                } else {
                    if (this.isWindowsPhone()) {
                        this.mobile = true
                    } else {
                        if (this.isKindle()) {
                            this.mobile = true
                        }
                    }
                }
            }
        }
    },
    isMobile: function isMobile() {
        return this.mobile
    },
    isAndroid: function () {
        if (this.android === null) {
            this.android = this.uagent.indexOf("android") > -1
        }
        return this.android
    },
    isKindle: function () {
        if (this.kindle === null) {
            this.kindle = this.uagent.indexOf("kindle") > -1
        }
        return this.kindle
    },
    isIOs: function isIOs() {
        if (this.iOs === null) {
            this.iOs = (this.uagent.indexOf("ipad") > -1) || (this.uagent.indexOf("ipod") > -1) || (this.uagent.indexOf("iphone") > -1)
        }
        return this.iOs
    },
    isSilk: function () {
        if (this.silk === null) {
            this.silk = this.uagent.indexOf("silk") > -1
        }
        return this.silk
    },
    isWindowsPhone: function () {
        if (this.windows === null) {
            this.windows = this.uagent.indexOf("windows phone") > -1
        }
        return this.windows
    },
    handleForMobileFriendly: function handleForMobileFriendly(d, q, g) {
        if (!this.isMobile()) {
            return false
        }
        if (typeof (stLight) === "undefined") {
            stLight = {};
            stLight.publisher = q.publisher;
            stLight.sessionID = q.sessionID;
            stLight.fpc = ""
        }
        var l = (typeof (d.title) !== "undefined") ? d.title : encodeURIComponent(document.title);
        var a = (typeof (d.url) !== "undefined") ? d.url : document.URL;
        if (q.service == "sharethis") {
            var l = (typeof (d.title) !== "undefined") ? d.title : encodeURIComponent(document.title);
            var a = (typeof (d.url) !== "undefined") ? d.url : document.URL;
            var b = document.createElement("form");
            b.setAttribute("method", "GET");
            b.setAttribute("action", "http://edge.sharethis.com/share4x/mobile.html");
            b.setAttribute("target", "_blank");
            var f = {
                url: a,
                title: l,
                destination: q.service,
                publisher: stLight.publisher,
                fpc: stLight.fpc,
                sessionID: stLight.sessionID
            };
            if (typeof (d.image) != "undefined" && d.image != null) {
                f.image = d.image
            }
            if (typeof (d.summary) != "undefined" && d.summary != null) {
                f.desc = d.summary
            }
            if (typeof (g) != "undefined" && typeof (g.exclusive_services) != "undefined" && g.exclusive_services != null) {
                f.exclusive_services = g.exclusive_services
            }
            if (typeof (q.exclusive_services) != "undefined" && q.exclusive_services != null) {
                f.exclusive_services = q.exclusive_services
            }
            if (typeof (g) != "undefined" && typeof (g.services) != "undefined" && g.services != null) {
                f.services = g.services
            }
            if (typeof (q.services) != "undefined" && q.services != null) {
                f.services = q.services
            }
            var m = q;
            if (typeof (g) != "undefined") {
                m = g
            }
            if (typeof (m.doNotHash) != "undefined" && m.doNotHash != null) {
                f.doNotHash = m.doNotHash
            }
            if (typeof (d.via) != "undefined" && d.via != null) {
                f.via = d.via
            }
            f.service = q.service;
            f.type = q.type;
            if (stlib.data) {
                var k = stlib.json.encode(stlib.data.pageInfo);
                var j = stlib.json.encode(stlib.data.shareInfo);
                if (stlib.browser.isFirefox() && !stlib.browser.firefox8Version()) {
                    k = encodeURIComponent(encodeURIComponent(k));
                    j = encodeURIComponent(encodeURIComponent(j))
                } else {
                    k = encodeURIComponent(k);
                    j = encodeURIComponent(j)
                }
                f.pageInfo = k;
                f.shareInfo = j
            }
            for (var n in f) {
                var e = document.createElement("input");
                e.setAttribute("type", "hidden");
                e.setAttribute("name", n);
                e.setAttribute("value", f[n]);
                b.appendChild(e)
            }
            document.body.appendChild(b);
            b.submit();
            return true
        }
        if (q.service == "email") {
            var h = a + "%0A%0a";
            h += "Sent using ShareThis";
            var p = "mailto:?";
            p += "Subject=" + l;
            p += "&body=" + h;
            window.location.href = p;
            return true
        }
        return false
    }
};
stlib.browser.mobile.init();
stlib.cookie = {
    setCookie: function (e, o, q) {
        var d = (navigator.userAgent.indexOf("Safari") != -1 && navigator.userAgent.indexOf("Chrome") == -1);
        var b = (navigator.userAgent.indexOf("MSIE") != -1);
        if (d || b) {
            var s = (q) ? q * 24 * 60 * 60 : 0;
            var l = document.createElement("div");
            l.setAttribute("id", e);
            l.setAttribute("type", "hidden");
            document.body.appendChild(l);
            var a = document.getElementById(e),
                f = document.createElement("form");
            try {
                var n = document.createElement('<iframe name="' + e + '" ></iframe>')
            } catch (m) {
                n = document.createElement("iframe")
            }
            n.name = e;
            n.src = "javascript:false";
            n.style.display = "none";
            a.appendChild(n);
            f.action = (("https:" == document.location.protocol) ? "https://sharethis.com/" : "http://sharethis.com/") + "account/setCookie.php";
            f.method = "POST";
            var k = document.createElement("input");
            k.setAttribute("type", "hidden");
            k.setAttribute("name", "name");
            k.setAttribute("value", e);
            f.appendChild(k);
            var r = document.createElement("input");
            r.setAttribute("type", "hidden");
            r.setAttribute("name", "value");
            r.setAttribute("value", o);
            f.appendChild(r);
            var p = document.createElement("input");
            p.setAttribute("type", "hidden");
            p.setAttribute("name", "time");
            p.setAttribute("value", s);
            f.appendChild(p);
            f.target = e;
            a.appendChild(f);
            f.submit()
        } else {
            if (q) {
                var j = new Date();
                j.setTime(j.getTime() + (q * 24 * 60 * 60 * 1000));
                var g = "; expires=" + j.toGMTString()
            } else {
                var g = ""
            }
            var h = e + "=" + escape(o) + g;
            h += "; domain=" + escape(".sharethis.com") + ";path=/";
            document.cookie = h
        }
    },
    getCookie: function (b) {
        var a = document.cookie.match("(^|;) ?" + b + "=([^;]*)(;|$)");
        if (a) {
            return (unescape(a[2]))
        } else {
            return false
        }
    },
    deleteCookie: function (e) {
        var d = (navigator.userAgent.indexOf("Safari") != -1 && navigator.userAgent.indexOf("Chrome") == -1);
        var b = (navigator.userAgent.indexOf("MSIE") != -1);
        if (d || b) {
            var h = document.createElement("div");
            h.setAttribute("id", e);
            h.setAttribute("type", "hidden");
            document.body.appendChild(h);
            var a = document.getElementById(e),
                f = document.createElement("form");
            try {
                var l = document.createElement('<iframe name="' + e + '" ></iframe>')
            } catch (j) {
                l = document.createElement("iframe")
            }
            l.name = e;
            l.src = "javascript:false";
            l.style.display = "none";
            a.appendChild(l);
            f.action = (("https:" == document.location.protocol) ? "https://sharethis.com/" : "http://sharethis.com/") + "account/deleteCookie.php";
            f.method = "POST";
            var g = document.createElement("input");
            g.setAttribute("type", "hidden");
            g.setAttribute("name", "name");
            g.setAttribute("value", e);
            f.appendChild(g);
            f.target = e;
            a.appendChild(f);
            f.submit()
        } else {
            var m = "/";
            var k = ".sharethis.com";
            document.cookie = e.replace(/^\s+|\s+$/g, "") + "=" + ((m) ? ";path=" + m : "") + ((k) ? ";domain=" + k : "") + ";expires=Thu, 01-Jan-1970 00:00:01 GMT"
        }
    },
    deleteAllSTCookie: function () {
        var e = document.cookie;
        e = e.split(";");
        for (var g = 0; g < e.length; g++) {
            var d = e[g];
            d = d.split("=");
            if (!/st_optout/.test(d[0])) {
                var f = d[0];
                var j = "/";
                var h = ".edge.sharethis.com";
                document.cookie = f + "=;path=" + j + ";domain=" + h + ";expires=Thu, 01-Jan-1970 00:00:01 GMT"
            }
        }
    },
    setFpcCookie: function (a, h) {
        var d = new Date;
        var k = d.getFullYear();
        var g = d.getMonth() + 9;
        var j = d.getDate();
        var e = a + "=" + escape(h);
        if (k) {
            var b = new Date(k, g, j);
            e += "; expires=" + b.toGMTString()
        }
        var f = stlib.cookie.getDomain();
        e += "; domain=" + escape(f) + ";path=/";
        document.cookie = e
    },
    getFpcCookie: function (b) {
        var a = document.cookie.match("(^|;) ?" + b + "=([^;]*)(;|$)");
        if (a) {
            return (unescape(a[2]))
        } else {
            return false
        }
    },
    getDomain: function () {
        var b = document.domain.split(/\./);
        var a = "";
        if (b.length > 1) {
            a = "." + b[b.length - 2] + "." + b[b.length - 1]
        }
        return a
    }
};
stlib.fpc = {
    cookieName: "__unam",
    cookieValue: "",
    createFpc: function () {
        if (!document.domain || document.domain.search(/\.gov/) > 0) {
            return false
        }
        var j = stlib.cookie.getFpcCookie(stlib.fpc.cookieName);
        if (j == false) {
            var d = Math.round(Math.random() * 2147483647);
            d = d.toString(16);
            var g = (new Date()).getTime();
            g = g.toString(16);
            var f = window.location.hostname.split(/\./)[1];
            if (!f) {
                return false
            }
            var h = "";
            h = stlib.fpc.determineHash(f) + "-" + g + "-" + d + "-1";
            j = h
        } else {
            var b = j;
            var a = b.split(/\-/);
            if (a.length == 4) {
                var e = Number(a[3]);
                e++;
                j = a[0] + "-" + a[1] + "-" + a[2] + "-" + e
            }
        }
        stlib.cookie.setFpcCookie(stlib.fpc.cookieName, j);
        stlib.fpc.cookieValue = j;
        return j
    },
    determineHash: function (b) {
        var f = 0;
        var e = 0;
        for (var d = b.length - 1; d >= 0; d--) {
            var a = parseInt(b.charCodeAt(d));
            f = ((f << 8) & 268435455) + a + (a << 12);
            if ((e = f & 161119850) != 0) {
                f = (f ^ (e >> 20))
            }
        }
        return f.toString(16)
    }
};
stlib.validate = {
    regexes: {
        notEncoded: /(%[^0-7])|(%[0-7][^0-9a-f])|["{}\[\]\<\>\\\^`\|]/gi,
        tooEncoded: /%25([0-7][0-9a-f])/gi,
        publisher: /^(([a-z]{2}(-|\.))|)[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i,
        url: /^(http|https):\/\/([a-z0-9!'\(\)\*\.\-\+:]*(\.)[a-z0-9!'\(\)\*\.\-\+:]*)((\/[a-z0-9!'\(\)\*\.\-\+:]*)*)/i,
        fpc: /^[0-9a-f]{7}-[0-9a-f]{11}-[0-9a-f]{7,8}-[0-9]*$/i,
        sessionID: /^[0-9]*\.[0-9a-f]*$/i,
        title: /.*/,
        description: /.*/,
        buttonType: /^(chicklet|vcount|hcount|large|custom|button|)$/,
        comment: /.*/,
        destination: /.*/,
        source: /.*/,
        image: /(^(http|https):\/\/([a-z0-9!'\(\)\*\.\-\+:]*(\.)[a-z0-9!'\(\)\*\.\-\+:]*)((\/[a-z0-9!'\(\)\*\.\-\+:]*)*))|^$/i,
        sourceURL: /^(http|https):\/\/([a-z0-9!'\(\)\*\.\-\+:]*(\.)[a-z0-9!'\(\)\*\.\-\+:]*)((\/[a-z0-9!'\(\)\*\.\-\+:]*)*)/i,
        sharURL: /(^(http|https):\/\/([a-z0-9!'\(\)\*\.\-\+:]*(\.)[a-z0-9!'\(\)\*\.\-\+:]*)((\/[a-z0-9!'\(\)\*\.\-\+:]*)*))|^$/i
    }
};
if (typeof (stlib.data) == "undefined") {
    stlib.data = {
        bInit: false,
        publisherKeySet: false,
        pageInfo: {},
        shareInfo: {},
        resetPageData: function () {
            stlib.data.pageInfo.fpc = "ERROR";
            stlib.data.pageInfo.sessionID = "ERROR";
            stlib.data.pageInfo.hostname = "ERROR";
            stlib.data.pageInfo.location = "ERROR"
        },
        resetShareData: function () {
            stlib.data.shareInfo = {};
            stlib.data.shareInfo.url = "ERROR";
            stlib.data.shareInfo.sharURL = "";
            stlib.data.shareInfo.buttonType = "ERROR";
            stlib.data.shareInfo.destination = "ERROR";
            stlib.data.shareInfo.source = "ERROR"
        },
        resetData: function () {
            stlib.data.resetPageData();
            stlib.data.resetShareData()
        },
        validate: function () {
            var a = stlib.validate.regexes;

            function b(f, h) {
                if (h != encodeURIComponent(h)) {
                    a.notEncoded.test(h) ? _$de(f + " not encoded") : null;
                    a.tooEncoded.test(h) ? _$de(f + " has too much encoding") : null
                }
                var g = a[f] ? a[f].test(decodeURIComponent(h)) : true;
                if (!g) {
                    _$de(f + " failed validation")
                }
            }
            var d = stlib.data.pageInfo;
            var e;
            for (e in d) {
                b(e, d[e])
            }
            d = stlib.data.shareInfo;
            for (e in d) {
                b(e, d[e])
            }
        },
        init: function () {
            if (!stlib.data.bInit) {
                stlib.data.bInit = true;
                stlib.data.resetData();
                stlib.data.set("url", document.location.href, "shareInfo");
                var g = "";
                stlib.hash.init();
                stlib.data.set("shareHash", stlib.hash.shareHash, "pageInfo");
                stlib.data.set("incomingHash", stlib.hash.incomingHash, "pageInfo");
                if (!stlib.hash.doNotHash) {
                    g = "#" + stlib.data.get("shareHash", "pageInfo")
                }
                var f = stlib.hash.updateParams();
                stlib.data.set("url", f + g, "shareInfo");
                if (stlib.data.publisherKeySet != true) {
                    stlib.data.set("publisher", "ur.00000000-0000-0000-0000-000000000000", "pageInfo")
                }
                stlib.fpc.createFpc();
                stlib.data.set("fpc", stlib.fpc.cookieValue, "pageInfo");
                var b = (new Date()).getTime().toString();
                var h = Number(Math.random().toPrecision(5).toString().substr(2)).toString();
                stlib.data.set("sessionID", b + "." + h, "pageInfo");
                stlib.data.set("hostname", document.location.hostname, "pageInfo");
                stlib.data.set("location", document.location.pathname, "pageInfo");
                var e = document.referrer;
                var j = e.replace("http://", "").replace("https://", "").split("/");
                var d = j.shift();
                var a = j.join("/");
                stlib.data.set("refDomain", d, "pageInfo");
                stlib.data.set("refQuery", a, "pageInfo")
            }
        },
        setPublisher: function (a) {
            stlib.data.set("publisher", a, "pageInfo");
            stlib.data.publisherKeySet = true
        },
        setSource: function (d, a) {
            var b = "";
            if (a) {
                if (a.toolbar) {
                    b = "toolbar" + d
                } else {
                    if (a.page && a.page != "home" && a.page != "") {
                        b = "chicklet" + d
                    } else {
                        b = "button" + d
                    }
                }
            } else {
                b = d
            }
            stlib.data.set("source", b, "shareInfo")
        },
        set: function (a, d, b) {
            _$d_();
            _$d1("Setting: " + a + ": " + d);
            if (typeof (d) == "number" || typeof (d) == "boolean") {
                stlib.data[b][a] = d
            } else {
                if (typeof (d) == "undefined" || d == null) {
                    _$d1("Value undefined or null")
                } else {
                    stlib.data[b][a] = encodeURIComponent(decodeURIComponent(unescape(d.replace(/<[^<>]*>/gi, " ")).replace(/%/gi, "%25")));
                    if (a == "url" || a == "location" || a == "image") {
                        try {
                            stlib.data[b][a] = encodeURIComponent(decodeURIComponent(decodeURI(d.replace(/<[^<>]*>/gi, " ")).replace(/%/gi, "%25")))
                        } catch (f) {
                            stlib.data[b][a] = encodeURIComponent(decodeURIComponent(unescape(d.replace(/<[^<>]*>/gi, " ")).replace(/%/gi, "%25")))
                        }
                    }
                }
            }
        },
        get: function (a, b) {
            if (stlib.data[b] && stlib.data[b][a]) {
                return decodeURIComponent(stlib.data[b][a])
            } else {
                return false
            }
        },
        unset: function (a, b) {
            if (stlib.data[b] && typeof (stlib.data[b][a]) != "undefined") {
                delete stlib.data[b][a]
            }
        }
    };
    stlib.data.resetData()
}
stlib.hash = {
    doNotHash: true,
    hashAddressBar: false,
    doNotCopy: true,
    prefix: "sthash",
    shareHash: "",
    incomingHash: "",
    validChars: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"],
    servicePreferences: {
        linkedin: "param",
        stumbleupon: "param",
        bebo: "param"
    },
    hashDestination: function (b) {
        if (b == "copy") {
            return "dpuf"
        }
        var d = b.substring(0, 2) + b.substring(b.length - 2, b.length);
        var a = function (e, f) {
            if (e.charCodeAt(f) == 122) {
                return "a"
            }
            return String.fromCharCode(e.charCodeAt(f) + 1)
        };
        return a(d, 0) + a(d, 1) + a(d, 2) + a(d, 3)
    },
    getHash: function () {
        var d = false;
        var b = "";
        var e = document.location.href;
        e = e.split("#").shift();
        var a = e.split("?");
        if (a.length > 1) {
            a = a[1].split("&");
            for (arg in a) {
                try {
                    if (a[arg].substring(0, 6) == "sthash") {
                        d = true;
                        b = a[arg]
                    }
                } catch (f) {}
            }
            if (d) {
                return b
            } else {
                return document.location.hash.substring(1)
            }
        } else {
            return document.location.hash.substring(1)
        }
    },
    stripHash: function (a) {
        var b = a;
        b = b.split("#");
        if (b.length > 1) {
            return b[1]
        } else {
            return ""
        }
    },
    clearHash: function () {
        if (stlib.hash.validateHash(document.location.hash)) {
            if (window.history && history.replaceState) {
                history.replaceState(null, "ShareThis", "#")
            } else {
                if ((/MSIE/).test(navigator.userAgent)) {
                    window.location.replace("#")
                } else {
                    document.location.hash = ""
                }
            }
        }
    },
    init: function () {
        var b = "";
        var a = stlib.hash.validChars.length;
        for (i = 0; i < 8; i++) {
            b += stlib.hash.validChars[Math.random() * a | 0]
        }
        if (stlib.hash.getHash() == "") {
            stlib.hash.shareHash = stlib.hash.prefix + "." + b
        } else {
            var d = stlib.hash.getHash().split(".");
            var e = d.shift();
            if (e == stlib.hash.prefix || e == stlib.hash.prefix) {
                stlib.hash.incomingHash = stlib.hash.getHash();
                stlib.hash.shareHash = stlib.hash.prefix + "." + d.shift() + "." + b
            } else {
                stlib.hash.shareHash = stlib.hash.prefix + "." + b
            }
        } if (!stlib.hash.doNotHash && stlib.hash.hashAddressBar) {
            if (document.location.hash == "" || stlib.hash.validateHash(document.location.hash)) {
                if (window.history && history.replaceState) {
                    history.replaceState(null, "ShareThis", "#" + stlib.hash.shareHash + ".dpbs")
                } else {
                    if ((/MSIE/).test(navigator.userAgent)) {
                        window.location.replace("#" + stlib.hash.shareHash + ".dpbs")
                    } else {
                        document.location.hash = stlib.hash.shareHash + ".dpbs"
                    }
                }
            }
        } else {
            stlib.hash.clearHash()
        } if (!stlib.hash.doNotHash && !stlib.hash.doNotCopy) {
            stlib.hash.copyPasteInit()
        }
        stlib.hash.copyPasteLog()
    },
    checkURL: function () {
        var a = stlib.data.get("destination", "shareInfo");
        var f = stlib.hash.updateParams(a);
        var d = "." + stlib.hash.hashDestination(a);
        stlib.hash.updateDestination(d);
        if (!stlib.hash.doNotHash && typeof (stlib.data.pageInfo.shareHash) != "undefined") {
            var b = stlib.data.get("url", "shareInfo");
            var g = stlib.hash.stripHash(b);
            if (stlib.hash.validateHash(g) || g == "") {
                if (typeof (stlib.hash.servicePreferences[a]) != "undefined") {
                    if (stlib.hash.servicePreferences[a] == "param") {
                        _$d1("Don't use hash, use params");
                        _$d2(f);
                        if (f.split("?").length > 1) {
                            var e = f.split("?")[1].split("&");
                            var h = false;
                            for (arg in e) {
                                if (e[arg].split(".")[0] == "sthash") {
                                    h = true
                                }
                            }
                            if (h) {
                                stlib.data.set("url", f, "shareInfo")
                            } else {
                                stlib.data.set("url", f + "&" + stlib.data.pageInfo.shareHash, "shareInfo")
                            }
                        } else {
                            stlib.data.set("url", f + "?" + stlib.data.pageInfo.shareHash, "shareInfo")
                        } if (a == "linkedin") {
                            if (stlib.data.get("sharURL", "shareInfo") != "") {
                                stlib.data.set("sharURL", stlib.data.get("url", "shareInfo"), "shareInfo")
                            }
                        }
                    } else {
                        _$d1("Using Hash");
                        stlib.data.set("url", f + "#" + stlib.data.pageInfo.shareHash, "shareInfo")
                    }
                } else {
                    _$d1("Not using custom destination hash type");
                    stlib.data.set("url", f + "#" + stlib.data.pageInfo.shareHash, "shareInfo")
                }
            }
        }
    },
    updateParams: function (a) {
        var g = stlib.data.get("url", "shareInfo").split("#").shift();
        var f = /(\?)sthash\.[a-zA-z0-9]{8}\.[a-zA-z0-9]{8}/;
        var e = /(&)sthash\.[a-zA-z0-9]{8}\.[a-zA-z0-9]{8}/;
        var d = /(\?)sthash\.[a-zA-z0-9]{8}/;
        var b = /(&)sthash\.[a-zA-z0-9]{8}/;
        if (f.test(g)) {
            g = g.replace(f, "?" + stlib.data.pageInfo.shareHash)
        } else {
            if (e.test(g)) {
                g = g.replace(e, "&" + stlib.data.pageInfo.shareHash)
            } else {
                if (d.test(g)) {
                    g = g.replace(d, "?" + stlib.data.pageInfo.shareHash)
                } else {
                    if (b.test(g)) {
                        g = g.replace(b, "&" + stlib.data.pageInfo.shareHash)
                    }
                }
            }
        }
        return g
    },
    updateDestination: function (b) {
        var a = /sthash\.[a-zA-z0-9]{8}\.[a-zA-z0-9]{8}\.[a-z]{4}/;
        var d = /sthash\.[a-zA-z0-9]{8}\.[a-z]{4}/;
        _$d_();
        _$d1("Updating Destination");
        if (a.test(stlib.data.pageInfo.shareHash)) {
            _$d2(stlib.data.pageInfo.shareHash.substring(0, 24));
            stlib.data.pageInfo.shareHash = stlib.data.pageInfo.shareHash.substring(0, 24) + b
        } else {
            if (d.test(stlib.data.pageInfo.shareHash)) {
                _$d2(stlib.data.pageInfo.shareHash.substring(0, 15));
                stlib.data.pageInfo.shareHash = stlib.data.pageInfo.shareHash.substring(0, 15) + b
            } else {
                stlib.data.pageInfo.shareHash += b
            }
        }
    },
    validateHash: function (a) {
        var b = /[\?#&]?sthash\.[a-zA-z0-9]{8}\.[a-zA-z0-9]{8}$/;
        var d = /[\?#&]?sthash\.[a-zA-z0-9]{8}\.[a-zA-z0-9]{8}\.[a-z]{4}$/;
        var e = /[\?#&]?sthash\.[a-zA-z0-9]{8}\.[a-z]{4}$/;
        var f = /[\?#&]?sthash\.[a-zA-z0-9]{8}$/;
        return f.test(a) || e.test(a) || d.test(a) || b.test(a)
    },
    appendHash: function (a) {
        var b = stlib.hash.stripHash(a);
        if (stlib.data.pageInfo.shareHash && (stlib.hash.validateHash(b) || b == "")) {
            a = a.replace("#" + b, "") + "#" + stlib.data.pageInfo.shareHash
        } else {}
        return a
    },
    copyPasteInit: function () {
        var a = document.getElementsByTagName("body")[0];
        var d = document.createElement("div");
        d.style.position = "absolute";
        d.style.top = "-1999px";
        d.style.left = "-1988px";
        a.appendChild(d);
        d.innerHTML = "ShareThis Copy and Paste";
        var b = document.location.href.split("#").shift();
        var e = "#" + stlib.hash.shareHash;
        if (document.addEventListener) {
            a.addEventListener("copy", function (j) {
                if (typeof (Tynt) != "undefined") {
                    return
                }
                var h = document.getSelection();
                var g = h.getRangeAt(0).cloneContents();
                d.innerHTML = "";
                d.appendChild(g);
                if ((h + "").trim().length == 0) {} else {
                    if (d.innerHTML == (h + "")) {
                        d.innerHTML = stlib.hash.selectionModify(h)
                    } else {
                        d.innerHTML += stlib.hash.selectionModify(h, true)
                    }
                }
                var f = document.createRange();
                f.selectNodeContents(d);
                var k = h.getRangeAt(0);
                h.removeAllRanges();
                h.addRange(f);
                setTimeout(function () {
                    h.removeAllRanges();
                    h.addRange(k)
                }, 0)
            }, false)
        } else {
            if (document.attachEvent) {}
        }
    },
    copyPasteLog: function () {
        var d = window.addEventListener ? "addEventListener" : "attachEvent";
        var b = d == "attachEvent" ? "oncopy" : "copy";
        var a = document.getElementsByTagName("body")[0];
        a[d](b, function (g) {
            var f = true;
            stlib.data.resetShareData();
            stlib.data.set("url", document.location.href, "shareInfo");
            stlib.data.setSource("copy");
            stlib.data.set("destination", "copy", "shareInfo");
            stlib.data.set("buttonType", "custom", "shareInfo");
            if (typeof (Tynt) != "undefined") {
                stlib.data.set("result", "tynt", "shareInfo");
                stlib.logger.log("debug");
                f = false
            }
            if (typeof (addthis_config) != "undefined") {
                stlib.data.set("result", "addThis", "shareInfo");
                if (typeof (addthis_config.data_track_textcopy) == "undefined" || addthis_config.data_track_textcopy) {
                    stlib.data.set("enabled", "true", "shareInfo");
                    f = false
                } else {
                    stlib.data.set("enabled", "false", "shareInfo")
                }
                stlib.logger.log("debug")
            }
            if (f) {
                stlib.data.set("result", "pass", "shareInfo");
                stlib.logger.log("debug")
            }
        }, false)
    },
    logCopy: function (a, b) {
        stlib.data.resetShareData();
        stlib.data.set("url", a, "shareInfo");
        stlib.data.setSource("copy");
        stlib.data.set("destination", "copy", "shareInfo");
        stlib.data.set("buttonType", "custom", "shareInfo");
        if (b) {
            stlib.data.set("description", b, "shareInfo")
        }
        stlib.sharer.share()
    },
    selectionModify: function (p, n) {
        p = "" + p;
        _$d_();
        _$d1("Copy Paste");
        var o = /^((http|https):\/\/([a-z0-9!'\(\)\*\.\-\+:]*(\.)[a-z0-9!'\(\)\*\.\-\+:]*)((\/[a-z0-9!'\(\)\*\.\-\+:]*)*))/i;
        var h = /^([a-z0-9!'\(\)\*\.\-\+:]*(\.)[a-z0-9!'\(\)\*\.\-\+:]*)((\/[a-z0-9!'\(\)\*\.\-\+:]*)*)/i;
        var f = /^\+?1?[\.\-\\)_\s]?[\\(]?[0-9]{3}[\.\-\\)_\s]?[0-9]{3}[\.\-_\s]?[0-9]{4}$|^[0-9]{3}[\.\-_\s]?[0-9]{4}$/;
        var k = /^[0-9]{3}[\.\-_\s]?[0-9]{8}$/;
        var m = /^[0-9]{2}[\.\-_\s]?[0-9]{4}[\.\-_\s]?[0-9]{4}$/;
        var d = /[\-_\.a-z0-9]+@[\-_\.a-z0-9]+\.[\-_\.a-z0-9]+/i;
        var g = /[\s@]/;
        var b = document.location.href.split("#").shift();
        var j = "#" + stlib.hash.shareHash;
        var a = "";
        var l = "";
        var e = "";
        if (typeof (n) == "undefined" && ((o.test(p) || h.test(p)) && !g.test(p.trim()))) {
            _$d2("is Url");
            if (p.match(/#/) == null || stlib.hash.validateHash(p)) {
                l = p.split("#")[0] + j + ".dpuf";
                e = l
            } else {
                l = p;
                e = l
            }
        } else {
            _$d2("is Not Url");
            if (document.location.hash == "" || (/^#$/).test(document.location.hash) || stlib.hash.validateHash(document.location.hash)) {
                l = b + j + ".dpuf"
            } else {
                l = document.location.href
            }
            e = p;
            if (p.length > 50) {
                a = " - See more at: " + l + "";
                if (!f.test(p) && !k.test(p) && !m.test(p) && !d.test(p)) {
                    e += a
                }
            }
        } if (p.length > 140) {
            p = p.substring(0, 137) + "..."
        }
        stlib.hash.logCopy(l, p);
        return ((n && n == true) ? a : e)
    }
};
stlib.pump = function (a, d, e) {
    var b = this;
    this.isIframeReady = false;
    this.isIframeSending = false;
    this.getHash = function (f) {
        var g = f.split("#");
        g.shift();
        return g.join("#")
    };
    this.broadcastInit = function (f) {
        this.destination = f;
        _$d_("---------------------");
        _$d1("Initiating broadcaster:");
        _$d(this.destination)
    };
    this.broadcastSendMessage = function (f) {
        _$d_("---------------------");
        _$d1("Initiating Send:");
        if (this.destination === window) {
            if (stlib.browser.ieFallback) {
                window.location.replace(window.location.href.split("#")[0] + "#" + f);
                _$d2("child can't communicate with parent");
                return
            }
            _$d2("Iframe to publisher: " + f);
            parent.postMessage("#" + f, document.referrer)
        } else {
            _$d2("Publisher to Iframe: " + f);
            if (stlib.browser.ieFallback) {
                if (this.destination.contentWindow) {
                    this.destination.contentWindow.location.replace(this.destination.src + "#" + f);
                    this.isIframeSending = true
                }
                return
            }
            this.destination.contentWindow.postMessage("#" + f, this.destination.src)
        }
    };
    this.receiverInit = function (h, l) {
        _$d_("---------------------");
        _$d1("Initiating Receiver:");
        _$d(h);
        if (stlib.browser.ieFallback) {
            this.callback = l;
            this.source = h;
            if (h === window) {
                window.location.replace(window.location.href.split("#")[0] + "#");
                this.currentIframe = window.location.hash;
                var g = "receiver" + stlib.functionCount;
                stlib.functions[g] = function (n) {
                    if ("" != window.location.hash && "#" != window.location.hash) {
                        var m = window.location.hash;
                        n(m);
                        window.location.replace(window.location.href.split("#")[0] + "#")
                    }
                };
                stlib.functionCount++;
                var k = "callback" + stlib.functionCount;
                stlib.functions[k] = l;
                stlib.functionCount++;
                setInterval("stlib.functions['" + g + "'](stlib.functions['" + k + "'])", 200)
            } else {}
            var j = window.addEventListener ? "addEventListener" : "attachEvent";
            var f = j == "attachEvent" ? "onmessage" : "message";
            window[j](f, function (m) {
                if (h == window) {} else {
                    if (m.origin.indexOf("sharethis.com") != -1) {
                        if (m.data.match(/#Pinterest Click/)) {
                            stlib.sharer.sharePinterest()
                        }
                    }
                }
            }, false);
            return
        }
        var j = window.addEventListener ? "addEventListener" : "attachEvent";
        var f = j == "attachEvent" ? "onmessage" : "message";
        window[j](f, function (m) {
            if (h == window) {
                _$d1("arrived in iframe from:");
                _$d(m.origin);
                if (m.data.match(/#fragmentPump/) || m.data.match(/#Buttons Ready/) || m.data.match(/#Widget Ready/) || m.data.indexOf("#light") == 0 || m.data.indexOf("#widget") == 0 || m.data.indexOf("#popup") == 0 || m.data.indexOf("#show") == 0 || m.data.indexOf("#init") == 0 || m.data.indexOf("#test") == 0 || m.data.indexOf("#data") == 0) {
                    l(m.data)
                }
            } else {
                if (m.origin.indexOf("sharethis.com") != -1) {
                    _$d1("arrived in parent from:");
                    _$d(m.origin);
                    if (m.data.match(/#fragmentPump/) || m.data.match(/#Buttons Ready/) || m.data.match(/#Widget Ready/) || m.data.indexOf("#light") == 0 || m.data.indexOf("#widget") == 0 || m.data.indexOf("#popup") == 0 || m.data.indexOf("#show") == 0 || m.data.indexOf("#init") == 0 || m.data.indexOf("#test") == 0 || m.data.indexOf("#data") == 0) {
                        l(m.data)
                    } else {
                        if (m.data.match(/#Pinterest Click/)) {
                            stlib.sharer.sharePinterest()
                        }
                    }
                } else {
                    _$d1("discarded event from:");
                    _$d(m.origin)
                }
            }
        }, false)
    };
    this.broadcastInit(a);
    this.receiverInit(d, e)
};
stlib.json = {
    c: {
        "\b": "b",
        "\t": "t",
        "\n": "n",
        "\f": "f",
        "\r": "r",
        '"': '"',
        "\\": "\\",
        "/": "/"
    },
    d: function (a) {
        return a < 10 ? "0".concat(a) : a
    },
    e: function (c, f, e) {
        e = eval;
        delete eval;
        if (typeof eval === "undefined") {
            eval = e
        }
        f = eval("" + c);
        eval = e;
        return f
    },
    i: function (d, b, a) {
        return 1 * d.substr(b, a)
    },
    p: ["", "000", "00", "0", ""],
    rc: null,
    rd: /^[0-9]{4}\-[0-9]{2}\-[0-9]{2}T[0-9]{2}:[0-9]{2}:[0-9]{2}$/,
    rs: /(\x5c|\x2F|\x22|[\x0c-\x0d]|[\x08-\x0a])/g,
    rt: /^([0-9]+|[0-9]+[,\.][0-9]{1,3})$/,
    ru: /([\x00-\x07]|\x0b|[\x0e-\x1f])/g,
    s: function (a, b) {
        return "\\".concat(stlib.json.c[b])
    },
    u: function (a, b) {
        var e = b.charCodeAt(0).toString(16);
        return "\\u".concat(stlib.json.p[e.length], e)
    },
    v: function (b, a) {
        return stlib.json.types[typeof result](result) !== Function && (a.hasOwnProperty ? a.hasOwnProperty(b) : a.constructor.prototype[b] !== a[b])
    },
    types: {
        "boolean": function () {
            return Boolean
        },
        "function": function () {
            return Function
        },
        number: function () {
            return Number
        },
        object: function (a) {
            return a instanceof a.constructor ? a.constructor : null
        },
        string: function () {
            return String
        },
        "undefined": function () {
            return null
        }
    },
    $$: function (a) {
        function b(f, d) {
            d = f[a];
            delete f[a];
            try {
                stlib.json.e(f)
            } catch (e) {
                f[a] = d;
                return 1
            }
        }
        return b(Array) && b(Object)
    },
    encode: function () {
        var d = arguments.length ? arguments[0] : this,
            a, h;
        if (d === null) {
            a = "null"
        } else {
            if (d !== undefined && (h = stlib.json.types[typeof d](d))) {
                switch (h) {
                    case Array:
                        a = [];
                        for (var g = 0, e = 0, b = d.length; e < b; e++) {
                            if (d[e] !== undefined && (h = stlib.json.encode(d[e]))) {
                                a[g++] = h
                            }
                        }
                        a = "[".concat(a.join(","), "]");
                        break;
                    case Boolean:
                        a = String(d);
                        break;
                    case Date:
                        a = '"'.concat(d.getFullYear(), "-", stlib.json.d(d.getMonth() + 1), "-", stlib.json.d(d.getDate()), "T", stlib.json.d(d.getHours()), ":", stlib.json.d(d.getMinutes()), ":", stlib.json.d(d.getSeconds()), '"');
                        break;
                    case Function:
                        break;
                    case Number:
                        a = isFinite(d) ? String(d) : "null";
                        break;
                    case String:
                        a = '"'.concat(d.replace(stlib.json.rs, stlib.json.s).replace(stlib.json.ru, stlib.json.u), '"');
                        break;
                    default:
                        var g = 0,
                            f;
                        a = [];
                        for (f in d) {
                            if (d[f] !== undefined && (h = stlib.json.encode(d[f]))) {
                                a[g++] = '"'.concat(f.replace(stlib.json.rs, stlib.json.s).replace(stlib.json.ru, stlib.json.u), '":', h)
                            }
                        }
                        a = "{".concat(a.join(","), "}");
                        break
                }
            }
        }
        return a
    },
    decode: function (a) {
        if (typeof (a) == "string") {
            var d = null;
            try {
                if (/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, "@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) {
                    d = window.JSON && window.JSON.parse ? window.JSON.parse(a) : (new Function("return " + a))();
                    return d
                } else {
                    return null
                }
            } catch (b) {}
        }
    }
};
try {
    stlib.json.rc = new RegExp('^("(\\\\.|[^"\\\\\\n\\r])*?"|[,:{}\\[\\]0-9.\\-+Eaeflnr-u \\n\\r\\t])+?$')
} catch (z) {
    stlib.json.rc = /^(true|false|null|\[.*\]|\{.*\}|".*"|\d+|\d+\.\d+)$/
}
stlib.logger = {
    loggerUrl: (("https:" == document.location.protocol) ? "https://" : "http://") + "l.sharethis.com/",
    constructParamString: function () {
        var a = stlib.data.pageInfo;
        var d = "";
        var b;
        for (b in a) {
            d += b + "=" + a[b] + "&"
        }
        a = stlib.data.shareInfo;
        for (b in a) {
            d += b + "=" + a[b] + "&"
        }
        return d.substring(0, d.length - 1)
    },
    log: function (e, g) {
        _$d_();
        _$d1("Log Event PageInfo:");
        _$d(stlib.data.pageInfo);
        _$d1("Log Event ShareInfo:");
        _$d(stlib.data.shareInfo);
        if (typeof (e) == "undefined") {
            _$de("event does not exist \nFor help, contact support@sharethis.com");
            return
        }
        if (stlib.data.pageInfo == null || stlib.data.shareInfo == null) {
            _$de("stlib.logger does not have enough info to log \nFor help, contact support@sharethis.com");
            return
        }
        if (!stlib.data.get("url", "shareInfo")) {
            _$de("shareThisInfo.url do not exist \nFor help, contact support@sharethis.com");
            return
        }
        if (!stlib.data.get("sessionID", "pageInfo")) {
            _$de("sharePageInfo.sessionID do not exist \nFor help, contact support@sharethis.com");
            return
        }
        if (!stlib.data.get("destination", "shareInfo")) {
            if (e != "pview") {
                _$de("shareThisInfo.destination do not exist \nFor help, contact support@sharethis.com");
                return
            }
        }
        if (!stlib.data.get("buttonType", "shareInfo")) {
            if (e != "pview") {
                _$de("shareThisInfo.type do not exist \nFor help, contact support@sharethis.com");
                return
            }
        }
        if (!stlib.data.get("source", "shareInfo")) {
            _$de("shareThisInfo.source do not exist \nFor help, contact support@sharethis.com");
            return
        }
        if (e == "pview") {
            stlib.data.unset("destination", "shareInfo");
            stlib.data.unset("buttonType", "shareInfo")
        } else {
            stlib.data.unset("refDomain", "pageInfo");
            stlib.data.unset("refQuery", "pageInfo")
        } if (typeof (stlib.data.get("counter", "shareInfo")) != "undefined") {
            var d = 0;
            if (stlib.data.get("counter", "shareInfo")) {
                d = stlib.data.get("counter", "shareInfo")
            }
            stlib.data.set("ts" + new Date().getTime() + "." + d, "", "shareInfo");
            stlib.data.unset("counter", "shareInfo")
        } else {
            stlib.data.set("ts" + new Date().getTime(), "", "shareInfo")
        }
        var a = (e == "pview") ? "pview" : ((e == "debug") ? "cns" : "log");
        var f = stlib.logger.loggerUrl + a + "?event=" + e + "&" + stlib.logger.constructParamString();
        _$d1("Final Log Url:");
        _$d2(f);
        var b = new Image(1, 1);
        b.src = f;
        b.onload = function () {
            return
        };
        g ? g() : null
    }
};
stlib.scriptLoader = {
    loadJavascript: function (b, d) {
        _$d_();
        _$d1("Loading JS: " + b);
        var a = stlib.scriptLoader;
        a.head = document.getElementsByTagName("head")[0];
        a.scriptSrc = b;
        a.script = document.createElement("script");
        a.script.setAttribute("type", "text/javascript");
        a.script.setAttribute("src", a.scriptSrc);
        a.script.async = true;
        a.script.onload = d;
        a.script.onreadystatechange = function () {
            if (this.readyState == "loaded") {
                d()
            }
        };
        a.s = document.getElementsByTagName("script")[0];
        a.s.parentNode.insertBefore(a.script, a.s)
    },
    loadCSS: function (b, e) {
        _$d_();
        _$d1("Loading CSS: " + b);
        var a = stlib.scriptLoader;
        var d;
        a.head = document.getElementsByTagName("head")[0];
        a.cssSrc = b;
        a.css = document.createElement("link");
        a.css.setAttribute("rel", "stylesheet");
        a.css.setAttribute("type", "text/css");
        a.css.setAttribute("href", b);
        a.css.setAttribute("id", b);
        setTimeout(function () {
            e();
            if (!document.getElementById(b)) {
                d = setInterval(function () {
                    if (document.getElementById(b)) {
                        clearInterval(d);
                        e()
                    }
                }, 100)
            }
        }, 100);
        a.head.appendChild(a.css)
    }
};
stlib.nativeButtons = {
    supportedNativeButtons: {
        linkedinfollow: {
            log: true,
            config: true,
            dependencyLoaded: false,
            dependencyLoading: false,
            requiredFields: [
                ["st_followId", "Profile Id", "Enter '207839' for profile id"]
            ]
        },
        twitterfollow: {
            log: false,
            config: true,
            requiredFields: [
                ["st_username", "Username", "Enter 'sharethis' for username"]
            ]
        },
        pinterestfollow: {
            log: true,
            config: true,
            requiredFields: [
                ["st_username", "Username", "Enter 'sharethis' for username"]
            ]
        },
        youtube: {
            log: true,
            config: true,
            requiredFields: [
                ["st_username", "Username", "Enter 'sharethis' for username"]
            ]
        },
        foursquaresave: {
            log: false,
            config: true,
            dependencyLoaded: false,
            dependencyLoading: false
        },
        foursquarefollow: {
            log: false,
            config: true,
            requiredFields: [
                ["st_username", "Username", "Enter 'sharethis' for username"],
                ["st_followId", "Follow id", "Enter '1234567' for follow id"]
            ]
        },
        googleplusfollow: {
            log: true,
            config: true,
            requiredFields: [
                ["st_followId", "Page Id", "Enter '110967630299632321627' for page id"]
            ]
        },
        googleplusadd: {
            log: true,
            config: true,
            requiredFields: [
                ["st_followId", "Profile Id", "Enter '113842823840690472625' for profile id"]
            ]
        }
    },
    loadService: function (a) {
        if (a == "foursquaresave" || a == "foursquarefollow") {
            if (stlib.nativeButtons.supportedNativeButtons.foursquaresave.dependencyLoaded == false) {
                if (stlib.nativeButtons.supportedNativeButtons.foursquaresave.dependencyLoading == false) {
                    stlib.nativeButtons.supportedNativeButtons.foursquaresave.dependencyLoading = true;
                    var d = "http://platform.foursquare.com/js/widgets.js";
                    var b = {
                        uid: "606"
                    };
                    if ("https:" == document.location.protocol) {
                        d = "http://platform-s.foursquare.com/js/widgets.js";
                        b.secure = true
                    }(function () {
                        window.___fourSq = b;
                        var e = document.createElement("script");
                        e.type = "text/javascript";
                        e.src = d;
                        e.async = true;
                        var f = document.getElementsByTagName("script")[0];
                        e.onload = function () {
                            fourSq.widget.Factory.go();
                            stlib.nativeButtons.supportedNativeButtons.foursquaresave.dependencyLoaded = true;
                            stlib.nativeButtons.supportedNativeButtons.foursquaresave.dependencyLoading = false
                        };
                        e.onreadystatechange = function () {
                            if (this.readyState == "complete" || this.readyState == "loaded") {
                                fourSq.widget.Factory.go();
                                stlib.nativeButtons.supportedNativeButtons.foursquaresave.dependencyLoaded = true;
                                stlib.nativeButtons.supportedNativeButtons.foursquaresave.dependencyLoading = false
                            }
                        };
                        f.parentNode.insertBefore(e, f)
                    })()
                }
            } else {
                fourSq.widget.Factory.go()
            }
        } else {
            if (a == "pinterestfollow") {} else {
                if (a == "twitterfollow") {} else {
                    if (a == "youtube") {} else {
                        if (a == "linkedinfollow") {
                            if (window.IN && typeof (window.IN.parse) === "function") {
                                window.IN.parse()
                            } else {
                                if (stlib.nativeButtons.supportedNativeButtons.linkedinfollow.dependencyLoading == false) {
                                    stlib.nativeButtons.supportedNativeButtons.linkedinfollow.dependencyLoading = true;
                                    var d = "//platform.linkedin.com/in.js";
                                    (function () {
                                        var e = document.createElement("script");
                                        e.type = "text/javascript";
                                        e.src = d;
                                        e.async = true;
                                        var f = document.getElementsByTagName("script")[0];
                                        e.onload = function () {
                                            stlib.nativeButtons.supportedNativeButtons.linkedinfollow.dependencyLoading = false
                                        };
                                        e.onreadystatechange = function () {
                                            if (this.readyState == "complete" || this.readyState == "loaded") {
                                                stlib.nativeButtons.supportedNativeButtons.linkedinfollow.dependencyLoading = false
                                            }
                                        };
                                        f.parentNode.insertBefore(e, f)
                                    })()
                                }
                            }
                        } else {}
                    }
                }
            }
        }
    },
    logService: function (a, b) {
        stlib.data.resetShareData();
        stlib.data.set("url", b, "shareInfo");
        stlib.data.set("destination", a, "shareInfo");
        stlib.data.setSource("chicklet");
        stlib.data.set("buttonType", "chicklet", "shareInfo");
        stlib.sharer.share()
    },
    makeButton: function (x, e, d) {
        if (x == "foursquaresave") {
            try {
                var l = document.createElement("<div></div>");
                var j = document.createElement("<a></a>")
            } catch (h) {
                l = document.createElement("div");
                j = document.createElement("a")
            }
            l.className = "stNativeButton stFourSquare";
            j.setAttribute("href", "https://foursquare.com/intent/venue.html");
            j.setAttribute("class", "fourSq-widget");
            j.setAttribute("data-on-open", "foursquareCallback");
            l.appendChild(j);
            return l
        } else {
            if (x == "foursquarefollow") {
                if (typeof (d.username) == "undefined" || d.username == "") {
                    return false
                }
                if (typeof (d.followId) == "undefined" || d.followId == "") {
                    return false
                }
                try {
                    var l = document.createElement("<div></div>");
                    var j = document.createElement("<a></a>")
                } catch (h) {
                    l = document.createElement("div");
                    j = document.createElement("a")
                }
                l.className = "stNativeButton stFourSquare";
                j.setAttribute("href", "https://foursquare.com/user/" + d.username);
                j.setAttribute("class", "fourSq-widget");
                j.setAttribute("data-type", "follow");
                j.setAttribute("data-fuid", d.followId);
                j.setAttribute("data-on-open", "foursquareCallback");
                l.appendChild(j);
                return l
            } else {
                if (x == "googleplusfollow" || x == "googleplusadd") {
                    if (typeof (d.followId) == "undefined" || d.followId == "") {
                        return false
                    }
                    try {
                        var r = document.createElement("<span></span>")
                    } catch (h) {
                        r = document.createElement("span")
                    }
                    r.className = "stNativeButton stGoogleNative";
                    var p = document.createElement("g:plus");
                    p.setAttribute("href", "https://plus.google.com/" + d.followId);
                    p.setAttribute("width", "300");
                    p.setAttribute("height", "69");
                    r.appendChild(p);
                    return r
                } else {
                    if (x == "pinterestfollow") {
                        if (typeof (d.username) == "undefined" || d.username == "") {
                            return false
                        }
                        try {
                            var b = document.createElement("<span></span>");
                            var q = document.createElement("<a></a>");
                            var o = document.createElement("<img></img>")
                        } catch (h) {
                            b = document.createElement("span");
                            q = document.createElement("a");
                            o = document.createElement("img")
                        }
                        b.className = "stNativeButton stPinterestfollow";
                        var g = d.username;
                        q.setAttribute("target", "_blank");
                        q.setAttribute("href", "//pinterest.com/" + g + "/");
                        o.setAttribute("src", "//passets-cdn.pinterest.com/images/follow-on-pinterest-button.png");
                        o.setAttribute("width", "156");
                        o.setAttribute("height", "26");
                        o.setAttribute("alt", "Follow " + g + " on Pinterest");
                        q.appendChild(o);
                        b.appendChild(q);
                        return b
                    } else {
                        if (x == "twitterfollow") {
                            if (typeof (d.username) == "undefined" || d.username == "") {
                                return false
                            }
                            try {
                                var k = document.createElement("<iframe></iframe>")
                            } catch (h) {
                                k = document.createElement("iframe")
                            }
                            var m = "&screen_name=" + d.username;
                            var s = "&show_count=false";
                            iedocmode = stlib.browser.getIEVersion();
                            var w = "";
                            if (e == "vcount") {
                                s = "&show_count=true"
                            } else {
                                if (e == "hcount") {
                                    s = "&show_count=true"
                                }
                            }
                            k.setAttribute("allowtransparency", "true");
                            k.setAttribute("frameborder", "0");
                            k.setAttribute("scrolling", "no");
                            k.className = "stTwitterFollowFrame";
                            k.setAttribute("src", "//platform.twitter.com/widgets/follow_button.html?lang=en&show_screen_name=false" + m + s);
                            var v = document.createElement("span");
                            v.className = "stNativeButton stTwitterFollowFrame stTwitterFollow";
                            v.appendChild(k);
                            return v
                        } else {
                            if (x == "youtube") {
                                if (typeof (d.username) == "undefined" || d.username == "") {
                                    return false
                                }
                                try {
                                    var n = document.createElement("<span></span>");
                                    var f = document.createElement("<a></a>");
                                    var a = document.createElement("<img></img>")
                                } catch (h) {
                                    n = document.createElement("span");
                                    f = document.createElement("a");
                                    a = document.createElement("img")
                                }
                                n.setAttribute("class", "stNativeButton stYoutube");
                                var g = d.username;
                                f.setAttribute("target", "_blank");
                                f.setAttribute("href", "//youtube.com/subscription_center?add_user=" + g);
                                a.setAttribute("src", "//s.ytimg.com/yt/img/creators_corner/Subscribe_to_my_videos/YT_Subscribe_130x36_red.png");
                                a.setAttribute("alt", "Follow " + g + " on youtube");
                                f.appendChild(a);
                                n.appendChild(f);
                                return n
                            } else {
                                if (x == "linkedinfollow") {
                                    if (typeof (d.followId) == "undefined" || d.followId == "") {
                                        return false
                                    }
                                    var t = document.createElement("span");
                                    t.setAttribute("class", "stNativeButton stLinkedinfollow");
                                    var u = document.createElement("script");
                                    u.type = "text/javascript";
                                    u.setAttribute("type", "IN/FollowCompany");
                                    u.setAttribute("data-id", d.followId);
                                    u.setAttribute("data-counter", "none");
                                    if (e == "vcount") {
                                        u.setAttribute("data-counter", "top")
                                    } else {
                                        if (e == "hcount") {
                                            u.setAttribute("data-counter", "right")
                                        }
                                    }
                                    t.appendChild(u);
                                    return t
                                } else {}
                            }
                        }
                    }
                }
            }
        }
    },
    checkNativeButtonSupport: function (a) {
        if (stlib.nativeButtons.supportedNativeButtons[a]) {
            return true
        }
        return false
    },
    checkNativeButtonLogging: function (a) {
        if (stlib.nativeButtons.supportedNativeButtons[a]) {
            return stlib.nativeButtons.supportedNativeButtons[a].log
        }
        return false
    },
    checkNativeButtonConfig: function (a) {
        if (stlib.nativeButtons.supportedNativeButtons[a]) {
            return stlib.nativeButtons.supportedNativeButtons[a].config
        }
        return false
    }
};
foursquareCallback = function (d) {
    if (d) {
        var a = "foursquaresave";
        var b = "https://foursquare.com/intent/venue.html";
        if (d.config.type) {
            a = "foursquarefollow";
            b = "https://foursquare.com/user/" + d.config.fuid
        }
        stlib.nativeButtons.logService(a, b)
    }
};
stlib.nativeCounts = {
    nativeCountServices: {
        linkedin: true,
        facebook: true,
        stumbleupon: true
    },
    nativeFunc: [],
    addNativeFunc: function (b, a) {
        stlib.nativeCounts.nativeFunc[b] = a
    },
    getNativeCounts: function (d, b, a) {
        switch (d) {
            case "facebook":
                stlib.scriptLoader.loadJavascript("http://api.facebook.com/method/fql.query?format=json&query=select url, like_count, total_count, comment_count, share_count, click_count from link_stat where url='" + encodeURIComponent(b) + "'&callback=" + a, function () {});
                break;
            case "linkedin":
                stlib.scriptLoader.loadJavascript("//www.linkedin.com/countserv/count/share?format=jsonp&callback=" + a + "&url=" + encodeURIComponent(b), function () {});
                break;
            case "stumbleupon":
                stlib.scriptLoader.loadJavascript("http://www.stumbleupon.com/services/1.1/badge.getinfo?url=" + encodeURIComponent(b) + "&format=jsonp&callback=" + a, function () {});
                break
        }
    },
    checkNativeCountServicesQueue: function (a) {
        if (stlib.nativeCounts.nativeCountServices[a]) {
            return true
        }
        return false
    }
};
__stgetPubGA = function () {
    if (typeof (_gaq) !== "undefined" && typeof (__stPubGA) == "undefined") {
        if (typeof (_gat) !== "undefined") {
            __stPubGA = _gat._getTrackerByName("~0")._getAccount()
        }
        if (typeof (__stPubGA) !== "undefined" && __stPubGA == "UA-XXXXX-X") {
            _gaq.push(function () {
                var a = _gat._getTrackerByName();
                __stPubGA = a._getAccount()
            })
        }
    }
    if (__stPubGA == "UA-XXXXX-X") {
        delete __stPubGA
    }
};
if (typeof (stLight) == "undefined" && typeof (SHARETHIS) == "undefined") {
    var stRecentServices = false;
    if (typeof (switchTo5x) == "undefined") {
        switchTo5x = false
    }
    var esiLoaded = false,
        stIsLoggedIn = false,
        servicesLoggedIn = {};
    var stFastShareObj = {};
    stFastShareObj.shorten = true;
    if ("https:" == document.location.protocol) {
        var useFastShare = false
    }
    if (typeof (useFastShare) == "undefined") {
        var useFastShare = true
    }
    stLight = new function () {
        this.publisher = null;
        this.sessionID_time = (new Date()).getTime().toString();
        this.sessionID_rand = Number(Math.random().toPrecision(5).toString().substr(2)).toString();
        this.sessionID = this.sessionID_time + "." + this.sessionID_rand;
        this.fpc = null;
        this.counter = 0;
        this.readyRun = false;
        this.meta = {
            hostname: document.location.host,
            location: document.location.pathname
        };
        this.loadedFromBar = false;
        this.clickCallBack = false
    };
    stLight.onReady = function () {
        if (stLight.readyRun == true) {
            return false
        }
        stlib.data.init();
        stLight.fpc = stlib.data.get("fpc", "pageInfo");
        if (stButtons.messageQueueInstance == null) {
            stButtons.messageQueueInstance = new stlib.messageQueue()
        }
        stLight.processSTQ();
        stLight.readyRun = true;
        if (stLight.publisher == null) {
            if (typeof (window.console) !== "undefined") {
                try {
                    console.debug("Please specify a ShareThis Publisher Key \nFor help, contact support@sharethis.com")
                } catch (a) {}
            }
        }
        var b = stLight.getSource();
        stLight.log("pview", b);
        stWidget.options.sessionID = stLight.sessionID;
        stWidget.options.fpc = stLight.fpc;
        stLight.loadServicesLoggedIn(function () {
            stButtons.onReady()
        })
    };
    stLight.getSource = function () {
        var a = "share4x";
        if (switchTo5x) {
            a = "share5x"
        }
        if (stLight.hasButtonOnPage()) {
            if (stLight.loadedFromBar) {
                if (switchTo5x) {
                    a = "bar_share5x"
                } else {
                    a = "bar_share4x"
                }
            }
        } else {
            if (stLight.loadedFromBar) {
                a = "bar"
            }
        }
        return a
    };
    stLight.getSource2 = function (a) {
        var d = "share4x";
        if (switchTo5x) {
            d = "share5x";
            try {
                if (stLight.clickCallBack != false) {
                    stLight.clickCallBack(a.service)
                }
            } catch (b) {}
        }
        if (a.type == "stbar" || a.type == "stsmbar") {
            d = "bar"
        }
        return d
    };
    stLight.log = function (d, e, a, b) {
        stlib.data.resetShareData();
        stlib.data.set("url", document.location.href, "shareInfo");
        stlib.data.set("title", document.title, "shareInfo");
        stlib.data.set("counter", stLight.counter++, "shareInfo");
        stlib.data.setSource(e);
        if (typeof (a) != "undefined") {
            stlib.data.set("destination", a, "shareInfo")
        }
        if (typeof (b) != "undefined") {
            stlib.data.set("buttonType", b, "shareInfo")
        }
        stlib.logger.log(d);
        if (d == "pview") {
            stLight.createSegmentFrame()
        }
    };
    stLight._stFpc = function () {
        if (!document.domain || document.domain.search(/\.gov/) > 0) {
            return false
        }
        var h = stLight._stGetFpc("__unam");
        if (h == false) {
            var d = Math.round(Math.random() * 2147483647);
            d = d.toString(16);
            var j = (new Date()).getTime();
            j = j.toString(16);
            var f = "";
            var a = stLight._stGetD();
            a = a.split(/\./)[1];
            if (!a) {
                return false
            }
            f = stLight._stdHash(a) + "-" + j + "-" + d + "-1";
            h = f;
            stLight._stSetFpc(h)
        } else {
            var b = h;
            var g = b.split(/\-/);
            if (g.length == 4) {
                var e = Number(g[3]);
                e++;
                b = g[0] + "-" + g[1] + "-" + g[2] + "-" + e;
                h = b;
                stLight._stSetFpc(h)
            }
        }
        return h
    };
    stLight._stSetFpc = function (h) {
        var a = "__unam";
        var d = new Date;
        var k = d.getFullYear();
        var g = d.getMonth() + 9;
        var j = d.getDate();
        var e = a + "=" + escape(h);
        if (k) {
            var b = new Date(k, g, j);
            e += "; expires=" + b.toGMTString()
        }
        var f = stLight._stGetD();
        e += "; domain=" + escape(f) + ";path=/";
        document.cookie = e
    };
    stLight._stGetD = function () {
        var b = document.domain.split(/\./);
        var a = "";
        if (b.length > 1) {
            a = "." + b[b.length - 2] + "." + b[b.length - 1]
        }
        return a
    };
    stLight._stGetFpc = function (b) {
        var a = document.cookie.match("(^|;) ?" + b + "=([^;]*)(;|$)");
        if (a) {
            return (unescape(a[2]))
        } else {
            return false
        }
    };
    stLight._stdHash = function (a) {
        var f = 0,
            e = 0;
        for (var d = a.length - 1; d >= 0; d--) {
            var b = parseInt(a.charCodeAt(d));
            f = ((f << 8) & 268435455) + b + (b << 12);
            if ((e = f & 161119850) != 0) {
                f = (f ^ (e >> 20))
            }
        }
        return f.toString(16)
    };
    stLight._thisScript = null;
    stLight.getShareThisLightScript = function () {
        var e = document.getElementsByTagName("script");
        var d = null;
        for (var b = 0; b < e.length; b++) {
            var a = e[b].src;
            if (a.search(/.*sharethis.*\/button\/light.*/) >= 0) {
                d = e[b]
            }
        }
        return d
    };
    stLight.dbrInfo = function () {
        var k = document.referrer;
        if (k && k.length > 0) {
            var h = /\/\/.*?\//;
            var e = k.match(h);
            if (typeof (e) !== "undefined" && typeof (e[0]) !== "undefined") {
                var b = new RegExp(document.domain, "gi");
                if (b.test(e[0]) == true) {
                    return false
                }
            }
            var g = /(http:\/\/)(.*?)\/.*/i;
            var f = /(^.*\?)(.*)/ig;
            var a = "";
            var d = k.replace(g, "$2");
            var b = new RegExp(d, "gi");
            if (d.length > 0) {
                a += "&refDomain=" + d
            } else {
                return false
            }
            var j = k.replace(f, "$2");
            if (j.length > 0) {
                a += "&refQuery=" + encodeURIComponent(j)
            }
            return a
        } else {
            return false
        }
    };
    stLight.odjs = function (a, b) {
        this.head = document.getElementsByTagName("head")[0];
        this.scriptSrc = a;
        this.script = document.createElement("script");
        this.script.setAttribute("type", "text/javascript");
        this.script.setAttribute("src", this.scriptSrc);
        this.script.onload = b;
        this.script.onreadystatechange = function () {
            if (this.readyState == "complete" || (a.indexOf("checkOAuth.esi") != -1 && this.readyState == "loaded")) {
                b()
            }
        };
        this.head.appendChild(this.script)
    };
    stLight.loadServicesLoggedIn = function (b) {
        if (useFastShare && esiLoaded == false) {
            try {
                stLight.odjs((("https:" == document.location.protocol) ? "https://wd-edge.sharethis.com/button/checkOAuth.esi" : "http://wd-edge.sharethis.com/button/checkOAuth.esi"), function () {
                    if (typeof (userDetails) !== "undefined") {
                        stIsLoggedIn = true;
                        if (userDetails !== "null") {
                            servicesLoggedIn = userDetails
                        }
                    }
                    esiLoaded = true;
                    if (b != null) {
                        b()
                    }
                })
            } catch (a) {}
        } else {
            if (b != null) {
                b()
            }
        }
    };
    if (window.document.readyState == "completed") {
        stLight.onReady()
    } else {
        if (typeof (window.addEventListener) != "undefined") {
            window.addEventListener("load", stLight.onReady, false)
        } else {
            if (typeof (document.addEventListener) != "undefined") {
                document.addEventListener("load", stLight.onReady, false)
            } else {
                if (typeof window.attachEvent != "undefined") {
                    window.attachEvent("onload", stLight.onReady)
                }
            }
        }
    }
    stLight.createSegmentFrame = function () {
        try {
            stLight.segmentframe = document.createElement('<iframe name="stframe" allowTransparency="true" style="body{background:transparent;}" ></iframe>')
        } catch (b) {
            stLight.segmentframe = document.createElement("iframe")
        }
        stLight.segmentframe.id = "stSegmentFrame";
        stLight.segmentframe.name = "stSegmentFrame";
        var d = document.body;
        var a = (("https:" == document.location.protocol) ? "https://seg." : "http://seg.") + "sharethis.com/getSegment.php?purl=" + encodeURIComponent(document.location.href) + "&jsref=" + encodeURIComponent(document.referrer) + "&rnd=" + (new Date()).getTime();
        stLight.segmentframe.src = a;
        stLight.segmentframe.frameBorder = "0";
        stLight.segmentframe.scrolling = "no";
        stLight.segmentframe.width = "0px";
        stLight.segmentframe.height = "0px";
        stLight.segmentframe.setAttribute("style", "display:none;");
        d.appendChild(stLight.segmentframe)
    };
    stLight.options = function (a) {
        if (a && a.publisher) {
            stlib.data.setPublisher(a.publisher);
            stLight.publisher = a.publisher
        }
        if (a && a.loadedFromBar) {
            stLight.loadedFromBar = a.loadedFromBar
        }
        if (a && a.clickCallBack && typeof (a.clickCallBack) == "function") {
            stLight.clickCallBack = a.clickCallBack
        }
        if (a && typeof (a.hashAddressBar) != "undefined") {
            stlib.hash.hashAddressBar = a.hashAddressBar
        }
        if (a && typeof (a.doNotHash) != "undefined") {
            stlib.hash.doNotHash = a.doNotHash
        }
        if (a && typeof (a.doNotCopy) != "undefined") {
            stlib.hash.doNotCopy = a.doNotCopy
        }
        for (var b in a) {
            if (b == "shorten") {
                stFastShareObj.shorten = a[b]
            }
            if (stWidget.options.hasOwnProperty(b) && a[b] !== null) {
                stWidget.options[b] = a[b]
            }
        }
    };
    stLight.hasButtonOnPage = function () {
        var e = document.getElementsByTagName("*");
        var d = new RegExp(/^st_(.*?)$/);
        var a = e.length;
        for (var b = 0; b < a; b++) {
            if (typeof (e[b].className) == "string" && e[b].className != "") {
                if (e[b].className.match(d) && e[b].className.match(d).length >= 2 && e[b].className.match(d)[1]) {
                    return true
                }
            }
        }
        return false
    }
}
var stButtons = {};
stButtons.smartifyButtons = function (a) {
    if (typeof (a) != "undefined" && a != "undefined") {
        stRecentServices = a;
        for (var b in stRecentServices) {
            stRecentServices[b].processed = false
        }
    }
    stButtons.completeInit()
};
stButtons.makeButton = function (x) {
    var g = x.service;
    var J = x.text;
    var Z = "";
    if (typeof (stWidget.options.shorten) != "undefined") {
        Z = stWidget.options.shorten
    }
    if (J == null && (x.type == "vcount" || x.type == "hcount")) {
        J = "Share";
        if (g == "email") {
            J = "Mail"
        }
    }
    if (g == "fb_like") {
        g = "fblike"
    } else {
        if (g == "fblike_fbLong") {
            g = "fblike";
            x.type = "fbLong"
        }
    }
    var h = stWidget.ogurl ? stWidget.ogurl : (stWidget.twitterurl ? stWidget.twitterurl : document.location.href);
    h = x.url ? x.url : h;
    var V = h;
    if (!stlib.hash.doNotHash) {
        V = stlib.hash.appendHash(h);
        h = V
    }
    stlib.data.set("url", V, "shareInfo");
    var M = stWidget.ogtitle ? stWidget.ogtitle : (stWidget.twittertitle ? stWidget.twittert