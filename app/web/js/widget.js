$(function() {
  calendar = {};
  calendar.events = {}
  calendar.eventDates = [];
  
  calendar.init = function() {
    calendar.processEvents();
    calendar.initTooltips();
  }  
  
  calendar.processEvents = function() {
    for (var i in calendar.events) {
      calendar.eventDates.push(i) ;
    }
  }  
   
  calendar.initTooltips = function() {
    $(".date-tooltip").cluetip('destroy');
  
    $(".date-tooltip").cluetip({
      splitTitle: "|", 
      dropShadow: false, 
      sticky: true,
      mouseOutClose: true,
      cursor: "pointer",
      closeText: "",
      arrows: true
    });
  };
  
  calendar.draw = function() {
    $("#datepicker" ).datepicker({
      beforeShowDay: function(date) {
        var tooltip = {};
        var className = "";
        var monthRepresentation = date.getMonth() < 9 ? ("0" + (date.getMonth() +1)) : (date.getMonth() +1);
        var dayRepresentation = date.getDate() < 10 ? ("0" + date.getDate()) : date.getDate();
        var dateRepresentation = date.getFullYear() + "-" + monthRepresentation + "-" + dayRepresentation;
        var eventPosition = $.inArray(dateRepresentation, calendar.eventDates);
    
        if (eventPosition != -1) {
          className = "date-tooltip";
          var dayEvents = calendar.events[dateRepresentation];
            tooltip.title = "Events";
            tooltip.description = "<ul>";
            for (var i in dayEvents) {
              tooltip.description += "<li>" + dayEvents[i].title + ": " + dayEvents[i].description + "</li>";
            }
            tooltip.description += "</ul>";
            tooltip.description = tooltip.description.replace(/'/g, '&#039;').replace(/"/g, '&quot;');
        }
        return [true, className, tooltip.title + "|" + tooltip.description];
      },
      onChangeMonthYear: function(year, month, inst) { 
        setTimeout("calendar.initTooltips()", 200);
      }
    });
  }
   
//$.when($.get("wp-content/plugins/wpEventsCalendarWidget/mock.php")).done(function(response) {
  $.when($.get("wp-content/plugins/wpEventsCalendarWidget/events.php")).done(function(response) {
    calendar.events = response;
    calendar.processEvents();
    calendar.draw();
    calendar.initTooltips();
  });

});
