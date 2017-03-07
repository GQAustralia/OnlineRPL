var UNITS = {
    display_search: function(elem) {
        $(elem).parent().addClass('focused');
    },
    hide_search: function(elem) {
        if ($(elem).val() === '') {
            $(elem).parent().removeClass('focused');
        }
    },
    unselect: function() {
        
    },
    animate_zerostate: function() {
        var list = $('#animatedChecklist i'),
            cursor = $('#animatedChecklist .cursor'),
            easing = [0.550, 0.085, 0.000, 0.960];

        var t, index = 0, top = 14, duration = 300;

        cursor.velocity({scale: [1,0], opacity: [0.6,0] }, { 
            delay: 500, 
            display: 'block', 
            duration: 200, 
            easing: 'swing',
            complete: function() { highlight(); }
        });

        function highlight() {
            t = setTimeout(function() {
                cursor.velocity({top: top + 'px', right: '-10px' }, { duration: duration, delay: 300, easing: easing,
                    complete: function() {
                        list.eq(index).addClass('active');
                        clearTimeout(t);

                        top = top + 40;
                        index = index + 1;

                        if (index > 2) { 
                            cursor.velocity({opacity: 0}, { delay: 500, duration: duration, display: 'none', easing: easing });
                        }
                        else { highlight(); }
                    }
                });
            },duration);
        }
    },
    toggle_details: function() {
        var parent = $('[data-panel-parent="two-column-split"]'),
            lpanel =  parent.find('[data-panel="left"]'),
            rpanel =  parent.find('[data-panel="right"]');

        lpanel.toggleClass('col-section-10').toggleClass('col-section-5');
        rpanel.toggleClass('col-section-0').toggleClass('col-section-5');
    },
    toggle_selection: function() {
        var parent = $('[data-panel-parent="two-column-split"]'),
            lpanel =  parent.find('[data-panel="left"]'),
            rpanel =  parent.find('[data-panel="right"]');

            lpanel.toggle();
            rpanel.toggle();
    }
}

$(document).ready(function() {
    FILE_THUMBNAIL.build();
});