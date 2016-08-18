/*!
 * Function: flyToElement
 * Author: CodexWorld
 * Author URI: http://www.codexworld.com  
 * Author Email: contact@codexworld.com
 * Description: This function is used for adding flying effect to the element.
 */
function flyToElement(flyer, flyingTo,reqStPos) {
    var $func = $(this);
    var divider = 3;
    var flyerClone = $(flyer).clone();
    $(flyerClone).css({position: 'absolute', top: reqStPos.topPos + "px", left: reqStPos.leftPos + "px", opacity: 1, 'z-index': 1000, overflow: "hidden"});
    $('.todo-list').append($(flyerClone));
    var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
    var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;

    $(flyerClone).animate({
        opacity: 0.4,
        left: gotoX,
        top: gotoY
    }, 1000,
    function () {
        $(flyingTo).fadeOut('100', function () {
            $(flyingTo).fadeIn('20', function () {
                $(flyerClone).fadeOut('20', function () {
                    $(flyerClone).remove();
                });
            });
        });
    });
}