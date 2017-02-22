
gqAus.directive("datepicker", function ($compile) {

        function link(scope, element, attrs) {

			var compiledTemplate = '';
			var template = '<div class="popover compressed" role="tooltip">' +
								'<div class="arrow"/>' +
								'<h3 class="popover-title"/>' +
								'<div class="popover-content"/>'+
								'<button type="button" class="btn btn-primary btn-block btn-sm text-uppercase btn-add-task" ng-click="addreminder('+attrs.id+')"><strong>Add task</strong></button>'+
							'</div>';

			var title = '<span class="taskTitle">Task for today</span> '+
						'<button type="button" class="btn btn-transparent btn-xs btn-set-date"><i class="zmdi zmdi-calendar zmdi-hc-lg zmdi-hc-fw"></i> EDIT</button>';

			var content =   '<div class="task-controls">' +
								'<textarea name="remcontent-'+attrs.id+'" id="remcontent-'+attrs.id+'" rows="4" class="form-control" placeholder="Enter your task"></textarea>' +
								'<div data-init="datepicker"></div>' +
							'</div>';
			var compiledTemplate = $compile(template)(scope);
            // CALL THE "datepicker()" METHOD USING THE "element" OBJECT.
            element.popover({ html : true,  animation: false, template: compiledTemplate, content: content, title: title, viewport: '.main-content-gqa' })
                .on('shown.bs.popover', function(e){
                    $(this).next().velocity({scaleX: [1,0], scaleY: [1,0]} , { easing: [ 250, 20 ], duration: 800 });
                    init_buttons();
                    init_datepicker();
                });
        }

        return {
            link: link
        };
		
		function init_datepicker() {
            $('[data-init="datepicker"]').datetimepicker({
                'format' : 'DD/MM/YYYY',
                'inline' : true,
                'useCurrent' : true,
                'showTodayButton': true,
                'minDate' : new Date()
            }).on('dp.change', function(e){
                var parent = $(this).closest('.popover').find('.taskTitle');
                var date = $(this).data("DateTimePicker").date().format('DD/MM/YYYY');
                var dateToDB = $(this).data("DateTimePicker").date().format('YYYY-MM-DD');

                parent.html('Task set on ' + date + '<input type="hidden" name="datetodb" id="datetodb" value="'+dateToDB+'" /> ');
            });
        }

        function init_buttons() {
            $(document).on('click', '.btn-set-date', function(event) {
                $(this).closest('.popover').toggleClass('show-date');
                $(this).find('i').toggleClass('zmdi-calendar').toggleClass('zmdi-arrow-left');
            });
        }
});	