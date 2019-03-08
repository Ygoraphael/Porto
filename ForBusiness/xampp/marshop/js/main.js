function isNull(variable) {
    if(variable !== null && variable !== undefined) {
		return variable;
	}
	else {
		return '';
	}
}

function toggleWiggle(classNm, idNm) {
	if(isNull(classNm).length) {
		if(jQuery("." + classNm).hasClass("wiggle")) {
			jQuery("." + classNm).removeClass("wiggle");
		}
		else {
			jQuery("." + classNm).addClass("wiggle");
		}
	}
	if(isNull(idNm).length) {
		if(jQuery("#" + idNm).hasClass("wiggle")) {
			jQuery("#" + idNm).removeClass("wiggle");
		}
		else {
			jQuery("#" + idNm).addClass("wiggle");
		}
	}
}

function replaceAll(str, find, replace) {
	return str.replace(new RegExp(find, 'g'), replace);
}