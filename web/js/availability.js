/*
 jQuery document ready
 */

$(document).ready(function () {
    /*
     date store today date.
     d store today date.
     m store current month.
     y store current year.
     */
    // $.ajax({ url: 'http://localhost:8000/ben_availability/retrieve',type: 'GET',success: function(data){console.log(data.availabilities[0].id);}});
    /*
     Initialize fullCalendar and store into variable.
     Why in variable?
     Because doing so we can use it inside other function.
     In order to modify its option later.
     */
    // var avas = {
    //     availabilities:  {
    //         url: 'http://localhost:8000/ben_availability/',
    //         type: 'GET',
    //         error: function () {
    //             alert('there was an error while fetching events!');
    //         },
    //         color: '#866667',   // a non-ajax option
    //         textColor: 'black' // a non-ajax option
    //     }
    // };

    // console.log(avas.availabilities);
    var calendar = $('#calendar').fullCalendar({
        /*
         header option will define our calendar header.
         left define what will be at left position in calendar
         center define what will be at center position in calendar
         right define what will be at right position in calendar
         */
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        /*
         defaultView option used to define which view to show by default,
         for example we have used agendaWeek.
         */
        defaultView: 'agendaWeek',
        /*
         selectable:true will enable user to select datetime slot
         selectHelper will add helpers for selectable.
         */
        selectable: true,
        selectHelper: false,
        eventDrop: function (event) {
            var response = confirm('Are you sure you want to update this availability');
            if (response) {
                $.ajax({
                    type: 'PUT',
                    url: "http://localhost:8000/ben_availability/" + event.id + "/update/" + event.start.format('YYYYMMDDHHmmss') + "/" + event.end.format('YYYYMMDDHHmmss'),
                    success: function () {
                        if (response === true) {
                            $('#calendar').fullCalendar('refetchEvents', {
                                url: 'http://localhost:8000/ben_availability/',
                                type: 'GET',
                                error: function () {
                                    alert('there was an error while fetching events! 1');
                                },
                                color: '#866667',   // a non-ajax option
                                textColor: 'black' // a non-ajax option
                            });
                        }
                        else {
                            alert('Error, could not delete availability!');
                        }
                    }
                });
            }
            else {
                $('#calendar').fullCalendar('refetchEvents', {
                    url: 'http://localhost:8000/ben_availability/',
                    type: 'GET',
                    error: function () {
                        alert('there was an error while fetching events! 2');
                    },
                    color: '#866667',   // a non-ajax option
                    textColor: 'black' // a non-ajax option
                });
            }
        },
        eventResize: function (event) {
            var response = confirm('Are you sure you want to update this availability');
            if (response) {
                $.ajax({
                    type: 'PUT',
                    url: "http://localhost:8000/ben_availability/" + event.id + "/update/" + event.start.format('YYYYMMDDHHmmss') + "/" + event.end.format('YYYYMMDDHHmmss'),
                    success: function () {
                        if (response === true) {
                            $('#calendar').fullCalendar('refetchEvents', {
                                url: 'http://localhost:8000/ben_availability/',
                                type: 'GET',
                                error: function () {
                                    alert('there was an error while fetching events! 3');
                                },
                                color: '#866667',   // a non-ajax option
                                textColor: 'black' // a non-ajax option
                            });
                        }
                        else {
                            alert('Error, could not delete availability!');
                        }
                    }
                });
            } else {
                $('#calendar').fullCalendar('refetchEvents', {
                    url: 'http://localhost:8000/ben_availability/',
                    type: 'GET',
                    error: function () {
                        alert('there was an error while fetching events! 4');
                    },
                    color: '#866667',   // a non-ajax option
                    textColor: 'black' // a non-ajax option
                });
            }

        },
        eventClick: function (event) {
            var response = confirm('Are you sure you want to delete this availability');
            if (response) {
                $.ajax({
                    type: 'DELETE',
                    url: "http://localhost:8000/ben_availability/" + event.id + "/delete",
                    success: function () {
                        if (response === true) {
                            $('#calendar').fullCalendar('refetchEvents', {
                                url: 'http://localhost:8000/ben_availability/',
                                type: 'GET',
                                error: function () {
                                    alert('there was an error while fetching events! 5');
                                },
                                color: '#866667',   // a non-ajax option
                                textColor: 'black' // a non-ajax option
                            });
                        }
                        else {
                            alert('Error, could not delete availability!');
                        }
                    }
                });
            }
        },
        /*
         when user select timeslot this option code will execute.
         It has three arguments. Start,end and allDay.
         Start means starting time of event.
         End means ending time of event.
         allDay means if events is for entire day or not.
         */
        eventSources: [
            {
                url: 'http://localhost:8000/ben_availability/',
                type: 'GET',
                error: function () {
                    alert('there was an error while fetching events! 6');
                },
                color: '#866667',   // a non-ajax option
                textColor: 'black' // a non-ajax option
            },
            {
                url: 'http://localhost:8000/ben_appointment/',
                type: 'GET',
                error: function () {
                    alert('there was an error while fetching events! 7');
                },
                color: '#e25d6e',   // a non-ajax option
                textColor: 'black' // a non-ajax option

            }

        ],
        select: function (start, end) {
            var eventmerge = false;
            // for(var eventitem in Object.keys(avas).map(function (key) { return avas[key]; })[16]){
            //     console.log(eventitem.start);
            // }
            // var avs = Object.keys(avas).map(function (key) {
            //     return avas[key];
            // })[16];
            // console.log(avas);
            var response = confirm('Are you sure you want to add an availability');
            if (response) {
                var d=start.format('YYYY-MM-DDTHH:mm:ss');
                var t=end.format('YYYY-MM-DDTHH:mm:ss');
                $.ajax({
                    type: 'GET',
                    url: "http://localhost:8000/ben_availability/",
                    dataType: 'json',
                    success: function (data) {
                        $.each(data, function (index, value) {
                            if (new Date(parseInt(d.substring(0,4),10),parseInt(d.substring(5,7),10),parseInt(d.substring(8,10),10),parseInt(d.substring(11,13),10),parseInt(d.substring(14,16),10),parseInt(d.substring(17,19),10)).getTime()===new Date(parseInt(value.end.substring(0,4),10),parseInt(value.end.substring(5,7),10),parseInt(value.end.substring(8,10),10),parseInt(value.end.substring(11,13),10),parseInt(value.end.substring(14,16),10),parseInt(value.end.substring(17,19),10)).getTime()) {
                                $.ajax({
                                    type: 'PUT',
                                    url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + value.start.substring(0,3)+value.start.substring(5,6)+value.start.substring(8,9)+value.start.substring(11,12)+value.start.substring(14,15)+value.start.substring(16,17) + "/" + end.format('YYYYMMDDHHmmss'),
                                    success: function () {
                                        if (response === true) {
                                            $('#calendar').fullCalendar('refetchEvents', {
                                                url: 'http://localhost:8000/ben_availability/',
                                                type: 'GET',
                                                error: function () {
                                                    alert('there was an error while fetching events! 5');
                                                },
                                                color: '#866667',   // a non-ajax option
                                                textColor: 'black' // a non-ajax option
                                            });
                                        }
                                        else {
                                            alert('Error, could not delete availability!');
                                        }
                                    }
                                });
                                return "1";
                            }
                            else if (new Date(parseInt(t.substring(0,4),10),parseInt(t.substring(5,7),10),parseInt(t.substring(8,10),10),parseInt(t.substring(11,13),10),parseInt(t.substring(14,16),10),parseInt(t.substring(17,19),10)).getTime()===new Date(parseInt(value.start.substring(0,4),10),parseInt(value.start.substring(5,7),10),parseInt(value.start.substring(8,10),10),parseInt(value.start.substring(11,13),10),parseInt(value.start.substring(14,16),10),parseInt(value.start.substring(17,19),10)).getTime()) {
                                $.ajax({
                                    type: 'PUT',
                                    url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + start.format('YYYYMMDDHHmmss') + "/" + value.end.substring(0,4)+value.end.substring(5,7)+value.end.substring(8,10)+value.end.substring(11,13)+value.end.substring(14,16)+value.end.substring(17,19),
                                    success: function () {
                                        if (response === true) {
                                            $('#calendar').fullCalendar('refetchEvents', {
                                                url: 'http://localhost:8000/ben_availability/',
                                                type: 'GET',
                                                error: function () {
                                                    alert('there was an error while fetching events! 5');
                                                },
                                                color: '#866667',   // a non-ajax option
                                                textColor: 'black' // a non-ajax option
                                            });
                                        }
                                        else {
                                            alert('Error, could not delete availability!');
                                        }
                                    }
                                });
                                return "2";
                            } else if (new Date(parseInt(d.substring(0,4),10),parseInt(d.substring(5,7),10),parseInt(d.substring(8,10),10),parseInt(d.substring(11,13),10),parseInt(d.substring(14,16),10),parseInt(d.substring(17,19),10)).getTime()<=new Date(parseInt(value.start.substring(0,4),10),parseInt(value.start.substring(5,7),10),parseInt(value.start.substring(8,10),10),parseInt(value.start.substring(11,13),10),parseInt(value.start.substring(14,16),10),parseInt(value.start.substring(17,19),10)).getTime() && new Date(parseInt(t.substring(0,4),10),parseInt(t.substring(5,7),10),parseInt(t.substring(8,10),10),parseInt(t.substring(11,13),10),parseInt(t.substring(14,16),10),parseInt(t.substring(17,19),10)).getTime()>=new Date(parseInt(value.end.substring(0,4),10),parseInt(value.end.substring(5,7),10),parseInt(value.end.substring(8,10),10),parseInt(value.end.substring(11,13),10),parseInt(value.end.substring(14,16),10),parseInt(value.end.substring(17,19),10)).getTime()) {
                                $.ajax({
                                    type: 'PUT',
                                    url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + d.substring(0,4)+d.substring(5,7)+d.substring(8,10)+d.substring(11,13)+d.substring(14,16)+d.substring(17,19)+ "/" + t.substring(0,4)+t.substring(5,7)+t.substring(8,10)+t.substring(11,13)+t.substring(14,16)+t.substring(17,19),
                                    success: function () {
                                        if (response === true) {
                                            $('#calendar').fullCalendar('refetchEvents', {
                                                url: 'http://localhost:8000/ben_availability/',
                                                type: 'GET',
                                                error: function () {
                                                    alert('there was an error while fetching events! 5');
                                                },
                                                color: '#866667',   // a non-ajax option
                                                textColor: 'black' // a non-ajax option
                                            });
                                        }
                                        else {
                                            alert('Error, could not delete availability!');
                                        }
                                    }
                                });
                                return "3";
                            } else if ((index + 1 === data.length) && (start.format('YYYY-MM-DD HH:mm:ss') !== value.end) && (end.format('YYYY-MM-DD HH:mm:ss') !== value.start) && !(start.format('YYYY-MM-DD HH:mm:ss') <= value.start && end.format('YYYY-MM-DD HH:mm:ss') >= value.end)) {
                                $.ajax({
                                    type: 'POST',
                                    url: "http://localhost:8000/ben_availability/create/" + start.format('YYYYMMDDHHmmss') + "/" + end.format('YYYYMMDDHHmmss'),
                                    success: function () {
                                        if (response === true) {
                                            $('#calendar').fullCalendar('refetchEvents', {
                                                url: 'http://localhost:8000/ben_availability/',
                                                type: 'GET',
                                                error: function () {
                                                    alert('there was an error while fetching events! 9');
                                                },
                                                color: '#866667',   // a non-ajax option
                                                textColor: 'black' // a non-ajax option
                                            });
                                        }
                                        else {
                                            alert('Error, could not add this availability!');
                                        }
                                    }
                                });
                            }
                        });
                    }
                });

                //     avails().done(function(result){
                //         $.each(result, function (index, value) {
                //             if (start.format('YYYY-MM-DD HH:mm:ss') === value.end) {
                //                 // $.ajax({
                //                 //     type: 'PUT',
                //                 //     url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + value.start.format('YYYYMMDDHHmmss') + "/" + end.format('YYYYMMDDHHmmss'),
                //                 //
                //                 // });
                //                 // return "1";
                //                 console.log("1");
                //             } else if (end.format('YYYY-MM-DD HH:mm:ss') === value.start) {
                //                 $.ajax({
                //                     type: 'PUT',
                //                     url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + start.format('YYYYMMDDHHmmss') + "/" + value.end.format('YYYYMMDDHHmmss'),
                //
                //                 });
                //                 return "2";
                //                 console.log("2");
                //
                //             }else if (start.format('YYYY-MM-DD HH:mm:ss') < value.start && end.format('YYYY-MM-DD HH:mm:ss') > value.end) {
                //                 $.ajax({
                //                     type: 'PUT',
                //                     url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + start.format('YYYYMMDDHHmmss') + "/" + end.format('YYYYMMDDHHmmss'),
                //
                //                 });
                //                 return "3";
                //                 console.log("3");
                //
                //             }else if ((index + 1 === avails.length))
                //                 console.log("salem");
                //
                //         });
                //     }).fail(function(){console.log("error");});
                //
                //
                //
                // }
                // // $.each(data, function (index, value) {
                // //     if (start.format('YYYY-MM-DD HH:mm:ss') === value.end) {
                // //         // $.ajax({
                // //         //     type: 'PUT',
                // //         //     url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + value.start.format('YYYYMMDDHHmmss') + "/" + end.format('YYYYMMDDHHmmss'),
                // //         //
                // //         // });
                // //         // return "1";
                // //         console.log("1");
                // //     } else if (end.format('YYYY-MM-DD HH:mm:ss') === value.start) {
                // //         // $.ajax({
                // //         //     type: 'PUT',
                // //         //     url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + start.format('YYYYMMDDHHmmss') + "/" + value.end.format('YYYYMMDDHHmmss'),
                // //         //
                // //         // });
                // //         // return "2";
                // //         console.log("2");
                // //
                // //     }else if (start.format('YYYY-MM-DD HH:mm:ss') < value.start && end.format('YYYY-MM-DD HH:mm:ss') > value.end) {
                // //         // $.ajax({
                // //         //     type: 'PUT',
                // //         //     url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + start.format('YYYYMMDDHHmmss') + "/" + end.format('YYYYMMDDHHmmss'),
                // //         //
                // //         // });
                // //         // return "3";
                // //         console.log("3");
                // //
                // //     }else if ((index + 1 === avails.length))
                // //         console.log("salem");
                // // });
                //
                //
                // // console.log(avails);
                // // $.each(avails, function (index, value) {
                // //     if (start.format('YYYY-MM-DD HH:mm:ss') === value.end ) {
                // //         // $.ajax({
                // //         //     type: 'PUT',
                // //         //     url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + value.start.format('YYYYMMDDHHmmss') + "/" + end.format('YYYYMMDDHHmmss'),
                // //         //
                // //         // });
                // //         // return "1";
                // //         console.log("1");
                // //     }else if(end.format('YYYY-MM-DD HH:mm:ss') === value.start) {
                // //         // $.ajax({
                // //         //     type: 'PUT',
                // //         //     url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + start.format('YYYYMMDDHHmmss') + "/" + value.end.format('YYYYMMDDHHmmss'),
                // //         //
                // //         // });
                // //         // return "2";
                // //         console.log("2");
                // //
                // //     }
                // //     else if(start.format('YYYY-MM-DD HH:mm:ss') < value.start && end.format('YYYY-MM-DD HH:mm:ss') > value.end) {
                // //         // $.ajax({
                // //         //     type: 'PUT',
                // //         //     url: "http://localhost:8000/ben_availability/" + value.id + "/update/" + start.format('YYYYMMDDHHmmss') + "/" + end.format('YYYYMMDDHHmmss'),
                // //         //
                // //         // });
                // //         // return "3";
                // //         console.log("3");
                // //
                // //     }
                //     if((index+1===avails.length))
                //         console.log( "salem");
                //         &&(start.format('YYYY-MM-DD HH:mm:ss') !== value.end)&&(end.format('YYYY-MM-DD HH:mm:ss') !== value.start)&&!(start.format('YYYY-MM-DD HH:mm:ss') < value.start && end.format('YYYY-MM-DD HH:mm:ss') > value.end)){
                //         $.ajax({
                //             type: 'POST',
                //             url: "http://localhost:8000/ben_availability/create/" + start.format('YYYYMMDDHHmmss') + "/" + end.format('YYYYMMDDHHmmss'),
                //             success: function () {
                //                 if (response === true) {
                //                     $('#calendar').fullCalendar('refetchEvents', {
                //                         url: 'http://localhost:8000/ben_availability/',
                //                         type: 'GET',
                //                         error: function () {
                //                             alert('there was an error while fetching events! 9');
                //                         },
                //                         color: '#866667',   // a non-ajax option
                //                         textColor: 'black' // a non-ajax option
                //                     });
                //                 }
                //                 else {
                //                     alert('Error, could not add this availability!');
                //                 }
                //             }
                //         });
                //     }
                // });

            }
        },

        //     $.each({
        //         url: 'http://localhost:8000/ben_availability/retrieve',
        //         type: 'GET',
        //         success: function(data){
        //             console.log(data.availabilities);
        //         },
        //         error: function () {
        //             alert('there was an error while fetching events!');
        //         },
        //         color: '#866667',   // a non-ajax option
        //         textColor: 'black' // a non-ajax option
        //     });
        // } else {
        //     $('#calendar').fullCalendar('refetchEvents', {
        //         url: 'http://localhost:8000/ben_availability/',
        //         type: 'GET',
        //         error: function () {
        //             alert('there was an error while fetching events! 8');
        //         },
        //         color: '#866667',   // a non-ajax option
        //         textColor: 'black' // a non-ajax option
        //     });
        // }

        // select: function (start, end) {
        //     var diffmin = (new Date(end).getTime() / 1000 - new Date(start).getTime() / 1000) / 60;
        //     var title = diffmin + ' min';
        //     var eventData;
        //     // some users click 1 slot, then the following, so we have 2 events each 30 min instead of 60 min
        //     // merge both events into one
        //     var eventmerge = false;
        //     $.each({
        //         url: 'http://localhost:8000/ben_availability/retrieve',
        //         type: 'GET',
        //            success: function(data){
        //                console.log(data.availabilities);
        //            },
        //         error: function () {
        //             alert('there was an error while fetching events!');
        //         },
        //         color: '#866667',   // a non-ajax option
        //         textColor: 'black' // a non-ajax option
        //     },
        // function (index, eventitem) {
        //         if (eventitem !== null && typeof eventitem != 'undefined') {
        //             // if start time of new event (2nd slot) is end time of existing event (1st slot)
        //             if (moment(start).format('YYYY-MM-DD HH:mm') == moment(eventitem.end).format('YYYY-MM-DD HH:mm')) {
        //                 eventmerge = true;
        //                 // existing event gets end data of new merging event
        //                 eventitem.end = end;
        //             }
        //             // if end time of new event (1st slot) is start time of existing event (2nd slot)
        //             else if (moment(end).format('YYYY-MM-DD HH:mm') == moment(eventitem.start).format('YYYY-MM-DD HH:mm')) {
        //                 eventmerge = true;
        //                 // existing event gets start data of new merging event
        //                 eventitem.start = start;
        //             }
        //
        //             if (eventmerge) {
        //                 // recalculate
        //                 var diffmin = (new Date(eventitem.end).getTime() / 1000 - new Date(eventitem.start).getTime() / 1000) / 60;
        //                 eventitem.title = diffmin + ' min';
        //
        //                 // copy to eventData
        //                 eventData = eventitem;
        //
        //                 // find event object in calendar
        //                 var eventsarr = $('#calendar').fullCalendar('clientEvents');
        //                 $.each(eventsarr, function (key, eventobj) {
        //                     if (eventobj._id == eventitem.id) {
        //                         console.log('merging events');
        //                         eventobj.start = eventitem.start;
        //                         eventobj.end = eventitem.end;
        //                         eventobj.title = eventitem.title;
        //                         $('#calendar').fullCalendar('updateEvent', eventobj);
        //                     }
        //                 });
        //
        //                 // break each loop
        //                 return false;
        //             }
        //         }
        //     });
        //
        //     // console.log(start, end);
        //     setTimePrice(eventData);
        //
        //     $('#calendar').fullCalendar('unselect');
        // },
        // // user choses event
        // select: function (start, end, jsEvent, view)
        // {
        //     var diffmin = (new Date(end).getTime()/1000 - new Date(start).getTime()/1000)/60;
        //     var title = diffmin+' min';
        //     var eventData;
        //     // some users click 1 slot, then the following, so we have 2 events each 30 min instead of 60 min
        //     // merge both events into one
        //     var eventmerge = false;
        //     $.each(allevents, function( index, eventitem )
        //     {
        //         if(eventitem!==null && typeof eventitem != 'undefined')
        //         {
        //             // if start time of new event (2nd slot) is end time of existing event (1st slot)
        //             if( moment(start).format('YYYY-MM-DD HH:mm') == moment(eventitem.end).format('YYYY-MM-DD HH:mm') )
        //             {
        //                 eventmerge = true;
        //                 // existing event gets end data of new merging event
        //                 eventitem.end = end;
        //             }
        //             // if end time of new event (1st slot) is start time of existing event (2nd slot)
        //             else if( moment(end).format('YYYY-MM-DD HH:mm') == moment(eventitem.start).format('YYYY-MM-DD HH:mm') )
        //             {
        //                 eventmerge = true;
        //                 // existing event gets start data of new merging event
        //                 eventitem.start = start;
        //             }
        //
        //             if(eventmerge)
        //             {
        //                 // recalculate
        //                 var diffmin = (new Date(eventitem.end).getTime()/1000 - new Date(eventitem.start).getTime()/1000)/60;
        //                 eventitem.title = diffmin+' min';
        //
        //                 // copy to eventData
        //                 eventData = eventitem;
        //
        //                 // find event object in calendar
        //                 var eventsarr = $('#calendar').fullCalendar('clientEvents');
        //                 $.each(eventsarr, function(key, eventobj) {
        //                     if(eventobj._id == eventitem.id) {
        //                         console.log('merging events');
        //                         eventobj.start = eventitem.start;
        //                         eventobj.end = eventitem.end;
        //                         eventobj.title = eventitem.title;
        //                         $('#calendar').fullCalendar('updateEvent', eventobj);
        //                     }
        //                 });
        //
        //                 // break each loop
        //                 return false;
        //             }
        //         }
        //     });
        //     if(!eventmerge)
        //     {
        //         // console.log('adding event id: '+eventcount);
        //         eventData = {
        //             id: eventcount, // identifier
        //             title: title,
        //             start: start,
        //             end: end,
        //             color: '#00AA00',
        //             editable: true,
        //             eventDurationEditable: true,
        //         };
        //
        //         // register event in array
        //         allevents[eventcount] = eventData;
        //         eventcount++;
        //
        //         $('#calendar').fullCalendar('renderEvent', eventData, true);
        //     }
        //
        //     // console.log(start, end);
        //     setTimePrice(eventData);
        //
        //     $('#calendar').fullCalendar('unselect');
        // },
        /*
         editable: true allow user to edit events.
         */
            editable: true,
            /*
             events is the main option for calendar.
             for demo we have added predefined events in json object.
             */


        })
        ;

});
