function isNull(variable) {
    if (variable !== null && variable !== undefined) {
        return variable;
    } else {
        return '';
    }
}

function toggleWiggle(classNm, idNm) {
    if (isNull(classNm).length) {
        if (jQuery("." + classNm).hasClass("wiggle")) {
            jQuery("." + classNm).removeClass("wiggle");
        } else {
            jQuery("." + classNm).addClass("wiggle");
        }
    }
    if (isNull(idNm).length) {
        if (jQuery("#" + idNm).hasClass("wiggle")) {
            jQuery("#" + idNm).removeClass("wiggle");
        } else {
            jQuery("#" + idNm).addClass("wiggle");
        }
    }
}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}

function secondsToTime(secs)
{
    secs = secs * 60 * 60;

    var hours = Math.floor(secs / (60 * 60));

    var divisor_for_minutes = secs % (60 * 60);
    var minutes = Math.floor(divisor_for_minutes / 60);

    var divisor_for_seconds = divisor_for_minutes % 60;
    var seconds = Math.ceil(divisor_for_seconds);

    var obj = {
        "h": hours,
        "m": minutes,
        "s": seconds
    };
    return obj;
}

function leftPad(number, targetLength) {
    var output = number + '';
    while (output.length < targetLength) {
        output = '0' + output;
    }
    return output;
}

function dateToLog(d) {
    var today = d;
    var dd = today.getDate();
    var mm = today.getMonth() + 1;

    var yyyy = today.getFullYear();
    if (dd < 10) {
        dd = '0' + dd
    }
    if (mm < 10) {
        mm = '0' + mm
    }
    var today = yyyy + '-' + mm + '-' + dd + ' ' + d.toLocaleTimeString();
    return today;
}

function boolToInt(result) {
    var i = result ? 1 : 0;
    return i;
}