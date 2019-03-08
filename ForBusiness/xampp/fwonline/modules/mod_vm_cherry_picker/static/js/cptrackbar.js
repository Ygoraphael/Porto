function cpTrackbar(_1) {
    var _2 = 0;
    var _3 = 1;
    var _4 = 2;
    var _5 = 0;
    var _6 = 1;
    var _7 = -1;
    var _8 = "above";
    var _9 = "below";
    var _a = "above";
    var _b = "below";
    var _c = {
        element: null,
        range: false,
        fullRangeSelected: false,
        limitRange: [],
        selectedRange: [],
        availableRange: [],
        valuesList: [],
        selectedValue: null,
        track: {},
        decimals: 0,
        step: null,
        knobTransforms: [-0.5, -0.5],
        hoverKnobs: null,
        tickMarks: null,
        deferInitialization: false,
        onValueChange: null,
        onReady: null
    };
    var _d = {
        isInitialized: 0,
        trackbarIsTracking: false,
        track: {
            element: null,
            width: 0
        },
        knobs: [],
        tickMarks: [],
        selectedRangeValue: _7,
        limitRange: null,
        selectedRange: null,
        availableRange: null,
        availableSelectedRange: null,
        trackingEvent: {
            knob: null,
            beganOrigin: {
                x: 0
            }
        }
    };

    function _e(_f) {
        var _10 = document.createElement("div");
        _10.style.zIndex = 1;
        if (_c.hoverKnobs) {
            _10.className = _c.hoverKnobs.position == _a ? "cptrackbar-hover-knob-above" : "cptrackbar-hover-knob";
            var _11 = document.createElement("span");
            _11.className = "cptrackbar-hover-knob-label";
            _11.appendChild(document.createTextNode("CP"));
            _10.appendChild(_11);
        } else {
            _10.className = "cptrackbar-knob";
        }
        return {
            element: _10,
            size: {
                width: 0
            },
            value: 0,
            preTrackingValue: 0,
            setLabelValue: function(_12, _13) {
                if (_c.hoverKnobs) {
                    var _14 = _c.hoverKnobs.labels;
                    if (_14 && _14.length) {
                        if (_13 == _6) {
                            _11.innerHTML = (_14.length > 1) ? _14[1].replace(/\{value\}/g, _12) : _12;
                        } else {
                            _11.innerHTML = _14[0].replace(/\{value\}/g, _12);
                        }
                    } else {
                        _11.firstChild.nodeValue = _12;
                    }
                    this.size.width = this.element.offsetWidth;
                }
            }
        };
    };

    function _15(_16) {
        var _17 = _16.hasDisplay == false ? null : document.createElement("div");
        var _18 = {
            element: _17,
            relative: {
                start: 0,
                size: 0
            },
            min: _7,
            max: _7,
            hasDisplay: true,
            updateDisplay: function() {
                console.log("udpate display!!");
            },
            createDisplay: function() {
                console.log("creating display for: ");
                console.log(this);
                this.element = document.createElement("div");
                if (_16.className) {
                    this.element.className = _16.className;
                }
                this.hasDisplay = true;
                return this.element;
            },
            deleteDisplay: function() {
                if (this.hasDisplay) {
                    this.element.parentNode.removeChild(this.element);
                    this.element = null;
                    this.hasDisplay = false;
                }
            }
        };
        if (typeof _16 != "undefined") {
            if (_17 && _16.className) {
                _17.className = _16.className;
            }
            if (_16.min != null) {
                _18.min = _16.min;
            }
            if (_16.max != null) {
                _18.max = _16.max;
            }
            if (_16.hasDisplay == false) {
                _18.hasDisplay = false;
            }
            if (typeof _16.updateDisplay === "function") {
                _18.updateDisplay = _16.updateDisplay;
            }
        }
        return _18;
    };

    function _19(min, max) {
        var _1a = {};
        var _1b = (_c.availableRange && _c.availableRange.length);
        var _1c = (_c.valuesList && _c.valuesList.length);
        _1a.className = (_1b) ? "cptrackbar-selected-range" : "cptrackbar-available-selected-range";
        _1a.hasDisplay = _c.track.selected;
        if (_c.range == false) {
            selectedValue = min;
            if (selectedValue != _7) {
                if (_1c) {
                    var i = _c.valuesList.indexOf(selectedValue);
                    if (i == -1) {
                        console.error("selectedValue \"" + selectedValue + "\" not found");
                        return;
                    }
                    _d.selectedRangeValue = i;
                } else {
                    if (selectedValue < _d.limitRange.min) {
                        _d.selectedRangeValue = _d.limitRange.min;
                    } else {
                        if (selectedValue > _d.limitRange.min) {
                            _d.selectedRangeValue = _d.limitRange.max;
                        } else {
                            _d.selectedRangeValue = selectedValue;
                        }
                    }
                }
            } else {
                _d.selectedRangeValue = _7;
            }
        } else {
            if (_1c) {
                if (min == _7) {
                    _1a.min = _7;
                } else {
                    var i = _c.valuesList.indexOf(min);
                    if (i == -1) {
                        console.error("selectedRange MIN value \"" + min + "\" not found");
                        return;
                    }
                    _1a.min = i;
                }
                if (max == _7) {
                    _1a.max = _7;
                } else {
                    var i = _c.valuesList.indexOf(max);
                    if (i == -1) {
                        console.error("selectedRange MAX value \"" + max + "\" not found");
                        return;
                    }
                    _1a.max = i;
                }
            } else {
                _1a.min = min;
                _1a.max = max;
            }
        }
        _1a.updateDisplay = function() {
            if (_1a.hasDisplay == false) {
                return;
            }
            if (_c.range == false) {
                if (_c.fullRangeSelected) {
                    this.relative.start = 0;
                    this.relative.size = 1;
                } else {
                    this.relative.start = 0;
                    this.relative.size = _d.knobs[0].value;
                }
                this.element.style.left = this.relative.start * 100 + "%";
                this.element.style.width = this.relative.size * 100 + "%";
            } else {
                this.element.style.left = _d.knobs[0].value * 100 + "%";
                this.element.style.width = (_d.knobs[1].value - _d.knobs[0].value) * 100 + "%";
            }
        };
        return _15(_1a);
    };

    function _1d(min, max) {
        var _1e = _1f(min, max);
        var _20 = _1e ? true : false;
        var _21 = {
            className: "cptrackbar-available-range",
            hasDisplay: _20
        };
        if (_20) {
            _21.min = _1e[0];
            _21.max = _1e[1];
        }
        _21.updateDisplay = function() {
            if (this.hasDisplay) {
                if (this.min == this.max) {
                    var _22 = _23(3);
                    this.relative.start = _24(this.min) - _22;
                    this.relative.size = _22 * 2;
                } else {
                    this.relative.start = _24(this.min);
                    this.relative.size = _25(this.max - this.min);
                }
                this.element.style.left = this.relative.start * 100 + "%";
                this.element.style.width = this.relative.size * 100 + "%";
            }
        };
        return _15(_21);
    };

    function _1f(min, max) {
        var _26 = [];
        var _27 = false;
        if (min == null && max == null) {
            return false;
        }
        if (_c.valuesList && _c.valuesList.length) {
            var i;
            i = _c.valuesList.indexOf(min);
            if (i == -1) {
                console.error("availableRange MIN value \"" + min + "\" not found");
                _27 = true;
            }
            _26[0] = i;
            i = _c.valuesList.indexOf(max);
            if (i == -1) {
                console.error("availableRange MAX value \"" + max + "\" not found");
                _27 = true;
            }
            _26[1] = i;
        } else {
            if (min < _d.limitRange.min || max > _d.limitRange.max || min > max) {
                console.error("Bad availableRange MIN and MAX values: " + min + ", " + max);
                _27 = true;
            }
            _26 = [min, max];
        }
        return (_27 ? false : _26);
    };

    function _28() {
        var _29 = {
            className: "cptrackbar-available-selected-range",
            hasDisplay: _d.availableRange.hasDisplay
        };
        _29.updateDisplay = function() {
            if (this.hasDisplay) {
                if (_c.range == false) {
                    if (_c.fullRangeSelected) {
                        this.relative.start = _d.availableRange.relative.start;
                        this.relative.size = _d.availableRange.relative.size;
                        this.element.style.left = this.relative.start * 100 + "%";
                        this.element.style.width = this.relative.size * 100 + "%";
                    } else {
                        if (_d.knobs[0].value <= _d.availableRange.relative.start) {
                            this.element.style.display = "none";
                        } else {
                            var _2a = (_d.knobs[0].value < _d.availableRange.relative.start + _d.availableRange.relative.size);
                            this.relative.start = _d.availableRange.relative.start;
                            this.relative.size = (_2a) ? _d.knobs[0].value - _d.availableRange.relative.start : _d.availableRange.relative.size;
                            this.element.style.left = this.relative.start * 100 + "%";
                            this.element.style.width = this.relative.size * 100 + "%";
                            this.element.style.display = "block";
                        }
                    }
                } else {
                    if (_d.knobs[0].value >= _d.availableRange.relative.start + _d.availableRange.relative.size || _d.knobs[1].value <= _d.availableRange.relative.start) {
                        this.element.style.display = "none";
                    } else {
                        var _2b = (_d.knobs[0].value > _d.availableRange.relative.start);
                        var _2c = (_d.knobs[1].value < _d.availableRange.relative.start + _d.availableRange.relative.size);
                        var _2d, _2e;
                        if (_2b) {
                            _2d = _d.knobs[0].value;
                            _2e = (_2c) ? _d.knobs[1].value - _d.knobs[0].value : _d.availableRange.relative.start + _d.availableRange.relative.size - _d.knobs[0].value;
                        } else {
                            _2d = _d.availableRange.relative.start;
                            _2e = (_2c) ? _d.knobs[1].value - _d.availableRange.relative.start : _d.availableRange.relative.size;
                        }
                        this.element.style.left = _2d * 100 + "%";
                        this.element.style.width = _2e * 100 + "%";
                        this.element.style.display = "block";
                    }
                }
            }
        };
        return _15(_29);
    };

    function _2f(_30) {
        var _31 = 1;
        var _32 = _31 / _c.element.firstChild.offsetWidth;
        var _33 = document.createElement("div");
        _33.className = "cptrackbar-tick-mark";
        _33.style.left = (_30 == 0) ? 0 : (_30 - _32) * 100 + "%";
        return _33;
    };

    function _34() {
        _35();
        var _36 = _c.element;
        if (!_36) {
            console.error("Element must be a valid HTML element.");
            return;
        }
        var _37 = (_c.valuesList && _c.valuesList.length);
        if (_37 > 0 && _c.valuesList.length < 2) {
            console.error("Bad parameter 'Value'. Must provide at least two values.");
            return;
        }
        if (_c.limitRange && _c.limitRange.length && _c.limitRange.length < 2) {
            console.error("Bad parameter 'limitRange'. Range must have MIN and MAX.");
            return;
        }
        if (_c.selectedRange && _c.selectedRange.length && _c.selectedRange.length < 2) {
            console.error("Bad parameter 'selectedRange'. Range must have MIN and MAX.");
            return;
        }
        var _38 = (_c.availableRange && _c.availableRange.length);
        if (_38 && _c.availableRange.length < 2) {
            console.error("Bad parameter 'availableRange'. Range must have MIN and MAX.");
            return;
        }
        _36.className = "cptrackbar-outer-container";
        _36.style.position = "relative";
        var _39 = document.createElement("div");
        _39.className = "cptrackbar-inner-container";
        _36.appendChild(_39);
        var _3a = {
            className: "cptrackbar-limit-range"
        };
        if (_c.limitRange && _c.limitRange.length) {
            _3a.min = parseFloat(_c.limitRange[0]);
            _3a.max = parseFloat(_c.limitRange[1]);
        } else {
            if (_37) {
                _3a.min = 0;
                _3a.max = _c.valuesList.length - 1;
            }
        }
        _d.limitRange = _15(_3a);
        _39.appendChild(_d.limitRange.element);
        var _3b = document.createElement("div");
        _3b.className = "cptrackbar-track";
        _39.appendChild(_3b);
        _d.track.element = _3b;
        if (_c.range) {
            var min = _c.selectedRange[0] ? _c.selectedRange[0] : _7;
            var max = _c.selectedRange[1] ? _c.selectedRange[1] : _7;
            _d.selectedRange = _19(min, max);
        } else {
            var _3c = _c.selectedValue ? _c.selectedValue : _7;
            _d.selectedRange = _19(_3c);
        }
        if (_d.selectedRange.hasDisplay) {
            if (_c.track.insetRanges == false) {
                _39.insertBefore(_d.selectedRange.element, _3b);
            } else {
                _3b.appendChild(_d.selectedRange.element);
            }
        }
        _d.availableRange = _1d(_c.availableRange[0], _c.availableRange[1]);
        if (_d.availableRange.hasDisplay) {
            if (_c.track.insetRanges == false) {
                _39.insertBefore(_d.availableRange.element, _3b);
            } else {
                _3b.appendChild(_d.availableRange.element);
            }
        }
        _d.availableSelectedRange = _28();
        if (_d.availableSelectedRange.hasDisplay) {
            if (_c.track.insetRanges == false) {
                _39.insertBefore(_d.availableSelectedRange.element, _3b);
            } else {
                _3b.appendChild(_d.availableSelectedRange.element);
            }
        }
        _d.knobs[0] = _e();
        _3b.appendChild(_d.knobs[0].element);
        if (_c.range) {
            _d.knobs[1] = _e();
            _3b.appendChild(_d.knobs[1].element);
        }
        if (!_c.deferInitialization && _39.offsetWidth) {
            _3d();
        }
    };

    function _35() {
        for (option in _c) {
            if (_1[option] != null) {
                _c[option] = _1[option];
            }
        }
    };
    this.initialize = function() {
        _3d();
    };
    this.isInitialized = function() {
        return _d.isInitialized;
    };
    this.setAvailableRange = function(min, max) {
        if (!min || !max) {
            if (_d.availableRange.hasDisplay) {
                _d.availableRange.deleteDisplay();
            }
            if (_d.availableSelectedRange.hasDisplay) {
                _d.availableSelectedRange.deleteDisplay();
            }
            return false;
        }
        if (_d.availableRange.hasDisplay == false) {
            var _3e = _d.availableRange.createDisplay();
            console.log(_3e);
            var _3f = _c.element.firstChild;
            if (_c.track.insetRanges == false) {
                _3f.insertBefore(_d.availableRange.element, _d.track.element);
            } else {
                _d.track.element.insertBefore(_3e, _d.knobs[0].element);
            }
            _3e = _d.availableSelectedRange.createDisplay();
            if (_c.track.insetRanges == false) {
                _3f.insertBefore(_d.availableSelectedRange.element, _d.track.element);
            } else {
                _d.track.element.insertBefore(_3e, _d.knobs[0].element);
            }
            if (_d.selectedRange.hasDisplay) {
                _d.selectedRange.element.className = "cptrackbar-selected-range";
            }
        }
        var _40 = _1f(min, max);
        if (!_40) {
            return false;
        }
        _d.availableRange.min = _40[0];
        _d.availableRange.max = _40[1];
        _d.availableRange.updateDisplay();
        _d.availableSelectedRange.updateDisplay();
        return true;
    };
    this.setSelectedValueMin = function(_41) {
        if (_c.range == false) {
            console.error("Not a range trackbar.");
            return;
        }
        if (!_41) {
            console.error("Bad value provided: '" + _41 + "'");
            return;
        }
        if (_c.valuesList && _c.valuesList.length) {
            var i = _c.valuesList.indexOf(_41);
            if (i == -1) {
                console.error("Bad value provided: '" + _41 + "'");
                return;
            }
            _42(i, _5);
        } else {
            if (isNaN(_41)) {
                console.error("Bad value provided: '" + _41 + "'");
                return;
            }
            _42(parseFloat(_41), _5);
        }
        _d.selectedRange.updateDisplay();
        _d.availableSelectedRange.updateDisplay();
    };
    this.setSelectedValueMax = function(_43) {
        if (_c.range == false) {
            console.error("Not a range trackbar.");
            return;
        }
        if (!_43) {
            console.error("Bad value provided: '" + _43 + "'");
            return;
        }
        if (_c.valuesList && _c.valuesList.length) {
            var i = _c.valuesList.indexOf(_43);
            if (i == -1) {
                console.error("Bad value provided: '" + _43 + "'");
                return;
            }
            _42(i, _6);
        } else {
            if (isNaN(_43)) {
                console.error("Bad value provided: '" + _43 + "'");
                return;
            }
            _42(parseFloat(_43), _6);
        }
        _d.selectedRange.updateDisplay();
        _d.availableSelectedRange.updateDisplay();
    };
    this.setSelectedValue = function(_44) {
        if (_c.range) {
            console.error("It is a range trackbar. Specific MIN or MAX setter should be used.");
            return;
        }
        if (!_44) {
            console.error("Bad value provided: '" + _44 + "'");
            return;
        }
        if (_c.valuesList && _c.valuesList.length) {
            var i = _c.valuesList.indexOf(_44);
            if (i == -1) {
                console.error("Bad value provided: '" + _44 + "'");
                return;
            }
            _42(i);
        } else {
            if (isNaN(_44)) {
                console.error("Bad value provided: '" + _44 + "'");
                return;
            }
            _42(parseFloat(_44));
        }
        if (!_c.fullRangeSelected) {
            _d.selectedRange.updateDisplay();
            _d.availableSelectedRange.updateDisplay();
        }
    };
    this.limitMin = function() {
        return _45(_d.limitRange.min);
    };
    this.limitMax = function() {
        return _45(_d.limitRange.max);
    };
    this.selectedValueMin = function() {
        if (_c.range == false) {
            console.error("Not a range trackbar");
            return null;
        }
        return _45(_d.selectedRange.min);
    };
    this.selectedValueMax = function() {
        if (_c.range == false) {
            console.error("Not a range trackbar");
            return null;
        }
        return _45(_d.selectedRange.max);
    };
    this.selectedValue = function() {
        if (_c.range) {
            console.error("It is a range trackbar. Specific MIN or MAX getter should be used.");
            return null;
        }
        return _45(_d.selectedRangeValue);
    };
    this.availableValueMin = function() {
        return (_d.availableRange ? _45(_d.availableRange.min) : null);
    };
    this.availableValueMax = function() {
        return (_d.availableRange ? _45(_d.availableRange.max) : null);
    };
    this.positionOfTickMarkAtIndex = function(_46) {
        if (isNaN(_46)) {
            console.error("Bad tick mark index: " + _46);
            return;
        }
        if (_46 >= _d.tickMarks.length) {
            console.error("Tick mark index is greater then the number of tick marks: " + _d.tickMarks.length);
            return;
        }
        var _47 = _d.tickMarks[_46];
        var _48 = 0;
        do {
            _48 += _47.offsetLeft;
            _47 = _47.parentNode;
        } while (_47 != _c.element);
        return _48;
    };
    this.numberOfTickMarks = function() {
        return (_c.tickMarks && _c.tickMarks.number) ? _c.tickMarks.number : 0;
    };
    this.printOptions = function() {
        console.log(_c);
    };
    this.printStats = function() {
        console.log("- LIMIT RANGE -");
        console.log(_d.limitRange);
        console.log("- SELECTED RANGE -");
        console.log(_d.selectedRange);
        console.log("- AVAILABLE RANGE -");
        console.log(_d.availableRange);
        console.log("- AVAILABLE SELECTED RANGE -");
        console.log(_d.availableSelectedRange);
        console.log("- KNOBS -");
        for (var i in _d.knobs) {
            if (_d.knobs.hasOwnProperty(i)) {
                console.log(_d.knobs[i]);
            }
        }
    };
    var _49 = {
        "instance": this,
        "beginTracking": _4a.bind(this),
        "continueTracking": _4b.bind(this),
        "endTracking": _4c.bind(this)
    };

    function _3d() {
        _c.element.firstChild.addEventListener("mousedown", _49.beginTracking, false);
        _d.knobs[0].element.addEventListener("mousedown", _49.beginTracking, false);
        _d.knobs[0].element.addEventListener("touchstart", _49.beginTracking, false);
        _d.knobs[0].size.width = _d.knobs[0].element.offsetWidth;
        if (_c.range) {
            _d.knobs[1].element.addEventListener("mousedown", _49.beginTracking, false);
            _d.knobs[1].element.addEventListener("touchstart", _49.beginTracking, false);
            _d.knobs[1].size.width = _d.knobs[1].element.offsetWidth;
        }
        if (_c.track.inset) {
            _d.track.element.style.left = Math.floor(_d.knobs[0].size.width / 2) + "px";
            _d.track.element.style.right = Math.floor(_d.knobs[0].size.width / 2) + "px";
        }
        if (_c.tickMarks && _c.tickMarks.number > 0) {
            var _4d = document.createElement("div");
            _4d.className = "cptrackbar-tick-marks";
            _4d.style.top = (_c.tickMarks.position && _c.tickMarks.position == _8) ? "2px" : "21px";
            _d.track.element.appendChild(_4d);
            var _4e = [];
            if (_c.tickMarks.number == 1) {
                var _4f = _2f(0.5);
                _4e.push(_4f);
                _4d.appendChild(_4f);
            } else {
                var _4f = _2f(0);
                _4e.push(_4f);
                _4d.appendChild(_4f);
                var gap = 1 / (_c.tickMarks.number - 1);
                for (var i = 0, len = _c.tickMarks.number - 2; i < len; ++i) {
                    _4f = _2f((i + 1) * gap);
                    _4e.push(_4f);
                    _4d.appendChild(_4f);
                }
                _4f = _2f(1);
                _4e.push(_4f);
                _4d.appendChild(_4f);
            }
            _d.tickMarks = _4e;
        }
        if (_c.range) {
            _42(_d.selectedRange.min, _5);
            _42(_d.selectedRange.max, _6);
        } else {
            _42(_d.selectedRangeValue);
        }
        _d.selectedRange.updateDisplay();
        if (_d.availableRange) {
            _d.availableRange.updateDisplay();
            _d.availableSelectedRange.updateDisplay();
        }
        _d.isInitialized = true;
        if (typeof _c.onReady === "function") {
            _c.onReady(_49.instance);
        }
    };

    function _4a(_50) {
        var _51 = false;
        var _52 = 0;
        _d.trackbarIsTracking = true;
        _d.track.width = _d.track.element.offsetWidth;
        var _53 = _50.target;
        if (_c.hoverKnobs && _53.className != "cptrackbar-hover-knob") {
            _53 = _54(_53, "cptrackbar-hover-knob");
        }
        var _55 = false;
        for (var i in _d.knobs) {
            if (_d.knobs.hasOwnProperty(i) && _53 == _d.knobs[i].element) {
                _d.trackingEvent.knob = _d.knobs[i];
                _d.trackingEvent.beganOrigin.x = _50.clientX || _50.pageX;
                _55 = true;
                break;
            }
        }
        if (!_55) {
            _51 = true;
            var _56 = _50.clientX || _50.pageX;
            if (_c.range == false) {
                _d.trackingEvent.knob = _d.knobs[0];
                var _57 = _58(_d.knobs[0].element);
                if (_c.knobTransforms && _c.knobTransforms.length) {
                    _57 -= _d.knobs[0].size.width * _c.knobTransforms[0];
                }
                _d.trackingEvent.beganOrigin.x = _57;
                _52 = _56 - _57;
            } else {
                var _59 = _58(_d.knobs[0].element);
                var _5a = _58(_d.knobs[1].element);
                if (_c.knobTransforms && _c.knobTransforms.length > 1) {
                    _59 -= _d.knobs[0].size.width * _c.knobTransforms[0];
                    _5a -= _d.knobs[1].size.width * _c.knobTransforms[1];
                }
                var _5b = (_5a + _59) / 2;
                if (_56 < _59 || _56 < _5b) {
                    _d.trackingEvent.knob = _d.knobs[0];
                    _d.trackingEvent.beganOrigin.x = _59;
                    _52 = _56 - _59;
                } else {
                    _d.trackingEvent.knob = _d.knobs[1];
                    _d.trackingEvent.beganOrigin.x = _5a;
                    _52 = _56 - _5a;
                }
            }
        }
        _d.trackingEvent.knob.preTrackingValue = _d.trackingEvent.knob.value;
        for (var i in _d.knobs) {
            if (_d.knobs.hasOwnProperty(i)) {
                if (_d.knobs[i] == _d.trackingEvent.knob) {
                    _d.knobs[i].element.style.zIndex = 2;
                } else {
                    _d.knobs[i].element.style.zIndex = 1;
                }
            }
        }
        document.addEventListener("mousewheel", _5c, false);
        if (window.addEventListener) {
            window.addEventListener("DOMMouseScroll", _5c, true);
        }
        document.addEventListener("mousemove", _49.continueTracking, false);
        document.addEventListener("mouseup", _49.endTracking, false);
        document.addEventListener("touchmove", _49.continueTracking, false);
        document.addEventListener("touchend", _49.endTracking, false);
        document.addEventListener("touchcancel", _49.endTracking, false);
        _50.preventDefault();
        if (_51) {
            _5d(_52);
        }
    };

    function _4b(_5e) {
        var x = _5e.clientX || _5e.pageX;
        var _5f = x - _d.trackingEvent.beganOrigin.x;
        _5d(_5f);
        _5e.preventDefault();
    };

    function _5d(_60) {
        var _61 = _d.limitRange.max - _d.limitRange.min;
        var _62 = (_d.trackingEvent.knob.preTrackingValue + _23(_60)) * _61 + _d.limitRange.min;
        if (_c.valuesList && _c.valuesList.length) {
            _62 = Math.round(_62);
        } else {
            _62 = _62.toFixed(_c.decimals).toFloat();
            if (_c.step) {
                _62 = _62 / _c.step;
                _62 = Math.round(_62) * _c.step;
            }
        }
        if (_c.range) {
            if (_d.trackingEvent.knob == _d.knobs[0]) {
                if ((_62 < _d.limitRange.min && _d.selectedRange.min == _d.limitRange.min) || ((_62 > _d.limitRange.max || _62 > _d.selectedRange.max) && (_d.selectedRange.min == _d.limitRange.max || _d.selectedRange.min == _d.selectedRange.max)) || _62 == _d.selectedRange.min) {
                    return;
                }
                _42(_62, _5);
            } else {
                if ((_62 > _d.limitRange.max && _d.selectedRange.max == _d.limitRange.max) || ((_62 < _d.limitRange.min || _62 < _d.selectedRange.min) && (_d.selectedRange.max == _d.limitRange.min || _d.selectedRange.max == _d.selectedRange.min)) || _62 == _d.selectedRange.max) {
                    return;
                }
                _42(_62, _6);
            }
            _d.selectedRange.updateDisplay();
            _d.availableSelectedRange.updateDisplay();
        } else {
            if ((_62 > _d.limitRange.max && _d.selectedRangeValue == _d.limitRange.max) || (_62 < _d.limitRange.min && _d.selectedRangeValue == _d.limitRange.min) || _62 == _d.selectedRangeValue) {
                return;
            }
            _42(_62);
            if (!_c.fullRangeSelected) {
                _d.selectedRange.updateDisplay();
                _d.availableSelectedRange.updateDisplay();
            }
        }
    };

    function _4c(_63) {
        _d.trackbarIsTracking = false;
        _63 = new Event(_63);
        document.removeEventListener("mousemove", _49.continueTracking, false);
        document.removeEventListener("mouseup", _49.endTracking, false);
        document.removeEventListener("touchmove", _49.continueTracking, false);
        document.removeEventListener("touchend", _49.endTracking, false);
        document.removeEventListener("touchcancel", _49.endTracking, false);
        _d.trackingEvent.knob = null;
        document.removeEventListener("mousewheel", _5c, false);
        if (window.removeEventListener) {
            window.removeEventListener("DOMMouseScroll", _5c, true);
        }
    };

    function _42(_64, _65) {
        _64 = _66(_64, _65);
        if (_c.range == false) {
            _d.selectedRangeValue = _64;
            _d.knobs[0].setLabelValue(_45(_64));
            _67(_64);
            if (typeof _c.onValueChange === "function") {
                _c.onValueChange(_49.instance);
            }
        } else {
            if (_65 == _5) {
                _d.selectedRange.min = _64;
                _d.knobs[0].setLabelValue(_45(_64), _65);
            } else {
                _d.selectedRange.max = _64;
                _d.knobs[1].setLabelValue(_45(_64), _65);
            }
            _67(_64, _65);
            if (typeof _c.onValueChange === "function") {
                _c.onValueChange(_49.instance);
            }
        }
    };

    function _67(_68, _69) {
        var _6a = _24(_68);
        if (_69 == _6) {
            var _6b = (_c.knobTransforms && _c.knobTransforms.length > 1) ? _23(_d.knobs[1].size.width * _c.knobTransforms[1]) : 0;
            _d.knobs[1].value = _6a;
            _d.knobs[1].element.style.left = _6a * 100 + "%";
            if (_c.knobTransforms && _c.knobTransforms.length > 1) {
                _d.knobs[1].element.style.marginLeft = _d.knobs[1].size.width * _c.knobTransforms[1] + "px";
            }
        } else {
            var _6b = (_c.knobTransforms && _c.knobTransforms.length) ? _23(_d.knobs[0].size.width * _c.knobTransforms[0]) : 0;
            _d.knobs[0].value = _6a;
            _d.knobs[0].element.style.left = _6a * 100 + "%";
            if (_c.knobTransforms && _c.knobTransforms.length) {
                _d.knobs[0].element.style.marginLeft = _d.knobs[0].size.width * _c.knobTransforms[0] + "px";
            }
        }
    };

    function _66(_6c, _6d) {
        var l = _d.limitRange.min;
        var r = _d.limitRange.max;
        if (_6c == _7) {
            if (_c.range == false) {
                return l;
            } else {
                return _6d == _5 ? l : r;
            }
        }
        if (_6d == _5) {
            var _6e = (_d.selectedRange.max == _7) ? r : _d.selectedRange.max;
            _6c = _6c < l ? l : (_6c < _6e ? _6c : _6e);
        } else {
            if (_6d == _6) {
                var _6e = (_d.selectedRange.min == _7) ? l : _d.selectedRange.min;
                _6c = _6c > r ? r : (_6c > _6e ? _6c : _6e);
            } else {
                _6c = _6c < l ? l : (_6c > r ? r : _6c);
            }
        }
        return _6c;
    };

    function _24(_6f) {
        var r = (_6f - _d.limitRange.min) / (_d.limitRange.max - _d.limitRange.min);
        return r;
    };

    function _45(_70) {
        if (_c.valuesList && _c.valuesList.length) {
            return _c.valuesList[_70];
        } else {
            return _70;
        }
    };

    function _25(_71) {
        return _71 / (_d.limitRange.max - _d.limitRange.min);
    };

    function _23(_72) {
        if (_d.track.width == 0) {
            _d.track.width = _d.track.element.offsetWidth;
        }
        return _72 / _d.track.width;
    };

    function _73() {
        if (!_d.selectedRange.element) {
            return;
        }
        _d.selectedRange.updateDisplay();
        if (_c.range == false) {
            if (_c.fullRangeSelected) {
                _d.selectedRange.relative.start = 0;
                _d.selectedRange.relative.size = 1;
            } else {
                _d.selectedRange.relative.start = 0;
                _d.selectedRange.relative.size = _d.knobs[0].value;
            }
            _d.selectedRange.element.style.left = _d.selectedRange.relative.start * 100 + "%";
            _d.selectedRange.element.style.width = _d.selectedRange.relative.size * 100 + "%";
        } else {
            _d.selectedRange.element.style.left = _d.knobs[0].value * 100 + "%";
            _d.selectedRange.element.style.width = (_d.knobs[1].value - _d.knobs[0].value) * 100 + "%";
        }
    };

    function _74() {
        if (_d.availableRange) {
            _d.availableRange.updateDisplay();
            _d.availableRange.relative.start = _24(_d.availableRange.min);
            _d.availableRange.relative.size = _25(_d.availableRange.max - _d.availableRange.min);
            _d.availableRange.element.style.left = _d.availableRange.relative.start * 100 + "%";
            _d.availableRange.element.style.width = _d.availableRange.relative.size * 100 + "%";
        }
    };

    function _75() {
        if (_d.availableRange) {
            if (_c.range == false) {
                if (_c.fullRangeSelected) {
                    _d.availableSelectedRange.relative.start = _d.availableRange.relative.start;
                    _d.availableSelectedRange.relative.size = _d.availableRange.relative.size;
                    _d.availableSelectedRange.element.style.left = _d.availableSelectedRange.relative.start * 100 + "%";
                    _d.availableSelectedRange.element.style.width = _d.availableSelectedRange.relative.size * 100 + "%";
                } else {
                    if (_d.knobs[0].value <= _d.availableRange.relative.start) {
                        _d.availableSelectedRange.element.style.display = "none";
                    } else {
                        var _76 = (_d.knobs[0].value < _d.availableRange.relative.start + _d.availableRange.relative.size);
                        _d.availableSelectedRange.relative.start = _d.availableRange.relative.start;
                        _d.availableSelectedRange.relative.size = (_76) ? _d.knobs[0].value - _d.availableRange.relative.start : _d.availableRange.relative.size;
                        _d.availableSelectedRange.element.style.left = _d.availableSelectedRange.relative.start * 100 + "%";
                        _d.availableSelectedRange.element.style.width = _d.availableSelectedRange.relative.size * 100 + "%";
                        _d.availableSelectedRange.element.style.display = "block";
                    }
                }
            } else {
                if (_d.knobs[0].value >= _d.availableRange.relative.start + _d.availableRange.relative.size || _d.knobs[1].value <= _d.availableRange.relative.start) {
                    _d.availableSelectedRange.element.style.display = "none";
                } else {
                    var _77 = (_d.knobs[0].value > _d.availableRange.relative.start);
                    var _78 = (_d.knobs[1].value < _d.availableRange.relative.start + _d.availableRange.relative.size);
                    var _79, _7a;
                    if (_77) {
                        _79 = _d.knobs[0].value;
                        _7a = (_78) ? _d.knobs[1].value - _d.knobs[0].value : _d.availableRange.relative.start + _d.availableRange.relative.size - _d.knobs[0].value;
                    } else {
                        _79 = _d.availableRange.relative.start;
                        _7a = (_78) ? _d.knobs[1].value - _d.availableRange.relative.start : _d.availableRange.relative.size;
                    }
                    _d.availableSelectedRange.element.style.left = _79 * 100 + "%";
                    _d.availableSelectedRange.element.style.width = _7a * 100 + "%";
                    _d.availableSelectedRange.element.style.display = "block";
                }
            }
        }
    };

    function _5c(_7b) {
        var e = new Event(_7b);
        e.preventDefault();
        return false;
    };

    function _7c(el) {
        var top = 0;
        do {
            top += el.offsetTop || 0;
            el = el.offsetParent;
        } while (el);
        return top;
    };

    function _58(el) {
        var _7d = 0;
        do {
            _7d += el.offsetLeft || 0;
            el = el.offsetParent;
        } while (el);
        return _7d;
    };

    function _54(el, _7e) {
        do {
            if (el.className == _7e) {
                return el;
            }
            el = el.parentNode;
        } while (el);
        return null;
    };
    _34();
};