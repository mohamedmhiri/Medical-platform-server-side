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

            /*myDropzone.on("complete", function(file) {
             console.log( file.fullPath );
             });*/


            // Update the total progress bar
            myDropzone.on("totaluploadprogress", function (progress) {
                document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
            });

            myDropzone.on("sending", function (file) {
                // Show the total progress bar when upload starts
                document.querySelector("#total-progress").style.opacity = "1";
                //alert(file.fullPath);

                // And disable the start button
                //file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
            });

            // Hide the total progress bar when nothing's uploading anymore
            myDropzone.on("queuecomplete", function (progress) {
                document.querySelector("#total-progress").style.opacity = "0";
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
            $(document).on('click','#addFiles', function () {
                var files = myDropzone.getAcceptedFiles();

                $.each(files, function (index,value) {
                    $.ajax({
                        type: 'POST',
                        url: "http://localhost:8000/examen/add_image/"+value.name+"/1",
                        success: function () {
                            $.each(value, function (i, val) {
                                console.log(val);
                            });

                            myDropzone.removeFile(value);
                        }
                    });
                });

            });
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