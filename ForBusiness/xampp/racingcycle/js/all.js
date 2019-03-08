function showOverlayOnElement(element) {
    element = $(element);
    if(!element) return;
    if(!element.id) element.identify();
    overlayElement = Element.clone($('wc-overlay'), true);
    overlayElement.setAttribute('id', element.id+'-wc-overlay');
    overlayElement.setStyle({
        display:'block', 
        top: element.cumulativeOffset().top+'px', 
        width: element.getWidth()+'px', 
        height: element.getHeight()+'px', 
        left: element.cumulativeOffset().left+'px'
    });
    $$('body')[0].insert(overlayElement);
}
function hideOverlayOnElement(element) { 
    $(element.id+'-wc-overlay').remove();
}
function showOverlayOnElements(elements) {
    for(var i=0; i<elements.lenght; i++) {
        showOverlayOnElement(elements[i]);
    }
}
function hideOverlayOnElements(elements) {
    for(var i=0; i<elements.lenght; i++) {
        hideOverlayOnElement(elements[i]);
    }
}