//
// $(function() {
//     // access Dropzone here
// // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
// var previewNode = document.querySelector("#template");
// previewNode.id = "";
// var previewTemplate = previewNode.parentNode.innerHTML;
// previewNode.parentNode.removeChild(previewNode);
//
// var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
//     url: "/path-to-action", // Set the url
//     thumbnailWidth: 80,
//     thumbnailHeight: 80,
//     parallelUploads: 20,
//     previewTemplate: previewTemplate,
//     autoQueue: false, // Make sure the files aren't queued until manually added
//     previewsContainer: "#previews", // Define the container to display the previews
//     clickable: true//".start"//".fileinput-button" // Define the element that should be used as click trigger to select files.
// });
//
// myDropzone.on("addedfile", function(file) {
//     // Hookup the start button
//     file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file); };
// });
//
// // Update the total progress bar
// myDropzone.on("totaluploadprogress", function(progress) {
//     document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
// });
//
// myDropzone.on("sending", function(file) {
//     // Show the total progress bar when upload starts
//     document.querySelector("#total-progress").style.opacity = "1";
//     // And disable the start button
//     file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
// });
//
// // Hide the total progress bar when nothing's uploading anymore
// myDropzone.on("queuecomplete", function(progress) {
//     document.querySelector("#total-progress").style.opacity = "0";
// });
//
// // Setup the buttons for all transfers
// // The "add files" button doesn't need to be setup because the config
// // `clickable` has already been specified.
// document.querySelector("#actions .start").onclick = function() {
//     myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
// };
// document.querySelector("#actions .cancel").onclick = function() {
//     myDropzone.removeAllFiles(true);
// };
//
// });
$(function() {
    $( document ).ready(function() {
        var previewNode = document.querySelector("#template");
        if (previewNode) {
            previewNode.id = "";
            var previewTemplate = previewNode.parentNode.innerHTML;
            previewNode.parentNode.removeChild(previewNode);
            var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
                url: "/", // Set the url
                thumbnailWidth: 80,
                thumbnailHeight: 80,
                parallelUploads: 10,
                previewTemplate: previewTemplate,
                autoQueue: false, // Make sure the files aren't queued until manually added
                previewsContainer: "#previews", // Define the container to display the previews
                clickable: ".fileinput-button",// Define the element that should be used as click trigger to select files.

            });
            //myDropzone.options.uploadDropzone = false;

            // myDropzone.on("success", function(file) {
            //
            //  });
            // $('#fileupload').bind('fileuploadsubmit', function (e, data) {
            //     data.formData = {
            //         typeexam: $('#ben_test_typeexam').val(),
            //         lieu: $('#ben_test_lieu').val(),
            //         conclusion: $('#ben_test_conclusion').val(),
            //         date: $('#ben_test_date').val()
            //     };
            //     console.log(data);
            // });
            // myDropzone.on("complete", function(files) {
            //
            //     $.each(files, function (index,value) {
            //         $.ajax({
            //             type: 'POST',
            //             url: "http://localhost:8000/examen/create/",
            //             success: function () {
            //
            //
            //
            //                 myDropzone.removeFile(value);
            //             }
            //         });
            //     });
            // });

            // $.ajaxSetup({
            //     beforeSend: function (jqXHR, settings) {
            //         if(settings.type === "POST")
            //             console.log("salem");
            //     }
            // });


            // myDropzone.on("addedfiles", function (file) {
            //     console.log(file.name);
            // });
            // Update the total progress bar
            // myDropzone.on("totaluploadprogress", function (progress) {
            //     document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
            // });

            // myDropzone.on("sending", function (file) {
            //     // Show the total progress bar when upload starts
            //     // document.querySelector("#total-progress").style.opacity = "1";
            //     //alert(file.fullPath);
            //
            //     // And disable the start button
            //     //file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
            //     console.log(file.name);
            // });

            // Hide the total progress bar when nothing's uploading anymore
            myDropzone.on("queuecomplete", function (progress) {
                // document.querySelector("#total-progress").style.opacity = "0";
            });

            // Setup the buttons for all transfers
            // The "add files" button doesn't need to be setup because the config
            // `clickable` has already been specified.
            document.querySelector("#actions .start").onclick = function () {
                myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
            };
            document.querySelector("#actions .cancel").onclick = function () {
                myDropzone.removeAllFiles(true);
            };
            if(!myDropzone.previewsContainer){
                document.querySelector('#actions .previews').remove();
            }
            $(document).on('click','#addFiles', function (data) {
                var formData={
                    typeexam: $('.ben_test_typeexam').val(),
                    lieu: $('.ben_test_lieu').val(),
                    conclusion:$('.ben_test_conclusion').val(),
                    date:$('.ben_test_date').val(),
                    files:[]
                };
                var files = myDropzone.getAcceptedFiles();

                $.each(files, function (index,value) {
                    // formData.files.push(value.name);
                    // myDropzone.removeFile(value);
                    var name = $('.name');
                    $('\<input type="hidden" name ="file'+index+'" value="'+value.name+'"\>').appendTo(name);
                    // alert(value.fullPath);
                });
                // alert(formData.files.length);
                    $.ajax({
                        type: 'POST',
                        url: "http://localhost:8000/examen/create/",
                        data:formData,
                        success: function (data) {
                            //     console.log(val);
                            // });
                            // $('#fileupload').bind('fileuploadsubmit', function (e, data) {
                            //     data.formData = {
                            //         typeexam: $('.ben_test_typeexam').val(),
                            //         lieu: $('.ben_test_lieu').val(),
                            //         conclusion:$('.ben_test_conclusion').val(),
                            //         date:$('.ben_test_date').val()
                            //     };
                            // });
                            // $.ajaxSetup({
                            //     beforeSend: function (jqXHR, settings) {
                            //         if(settings.type === "POST")
                            //             console.log("salem");
                            //     }
                            // });
                            // myDropzone.removeFile(value);
                        }
                    });
                      // console.log(value.name);
                 });
            // });

            // $(document).on('show','#previews', function (file) {
            //    console.log(file);
            // });
            /*$( ).onclick = function () {
             console.log( 2 );
             };*/
            // document.querySelector("#template > div > div > button").onclick = function () {
            //     console.log( 1 );
            // };
            // $( " #template div #addFile  " ).onclick = function () {
            //     console.log( 2 );
            // };


        }
    });

});