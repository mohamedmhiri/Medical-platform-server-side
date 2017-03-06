$(document).ready(function() {
    $('#fileupload').fileupload({
        dataType: 'json',
        autoUpload: true,
        progress: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        },
        add: function (e, data) {
            data.context = $('<button/>').text('Upload').addClass("btn btn-primary")
                .appendTo(document.body)
                .click(function () {
                    data.context = $('<p/>').text('Uploading...').replaceAll($(this));
                    data.submit();
                });
        },
        done: function (e, data) {
            $.each(data.files, function (index, file) {
                $('<p/>').text(file.result.name).appendTo(document.body);
            });
        },
        fail: function(e, data) {

        }


        /************************/
//
//         // The add callback is invoked as soon as files are added to the fileupload
//         // widget (via file input selection, drag & drop or add API call).
//         // See the basic file upload widget for more information:
//         add: function (e, data) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             var $this = $(this),
//                 that = $this.data('blueimp-fileupload') ||
//                     $this.data('fileupload'),
//                 options = that.options;
//             data.context = that._renderUpload(data.files)
//                 .data('data', data)
//                 .addClass('processing');
//             options.filesContainer[
//                 options.prependFiles ? 'prepend' : 'append'
//                 ](data.context);
//             that._forceReflow(data.context);
//             that._transition(data.context);
//             data.process(function () {
//                 return $this.fileupload('process', data);
//             }).always(function () {
//                 data.context.each(function (index) {
//                     $(this).find('.size').text(
//                         that._formatFileSize(data.files[index].size)
//                     );
//                 }).removeClass('processing');
//                 that._renderPreviews(data);
//             }).done(function () {
//                 data.context.find('.start').prop('disabled', false);
//                 if ((that._trigger('added', e, data) !== false) &&
//                     (options.autoUpload || data.autoUpload) &&
//                     data.autoUpload !== false) {
//                     data.submit();
//                 }
//             }).fail(function () {
//                 if (data.files.error) {
//                     data.context.each(function (index) {
//                         var error = data.files[index].error;
//                         if (error) {
//                             $(this).find('.error').text(error);
//                         }
//                     });
//                 }
//             });
//         },
//         // Callback for the start of each file upload request:
//         send: function (e, data) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             var that = $(this).data('blueimp-fileupload') ||
//                 $(this).data('fileupload');
//             if (data.context && data.dataType &&
//                 data.dataType.substr(0, 6) === 'iframe') {
//                 // Iframe Transport does not support progress events.
//                 // In lack of an indeterminate progress bar, we set
//                 // the progress to 100%, showing the full animated bar:
//                 data.context
//                     .find('.progress').addClass(
//                     !$.support.transition && 'progress-animated'
//                 )
//                     .attr('aria-valuenow', 100)
//                     .children().first().css(
//                     'width',
//                     '100%'
//                 );
//             }
//             return that._trigger('sent', e, data);
//         },
//         // Callback for successful uploads:
//         done: function (e, data) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             var that = $(this).data('blueimp-fileupload') ||
//                     $(this).data('fileupload'),
//                 getFilesFromResponse = data.getFilesFromResponse ||
//                     that.options.getFilesFromResponse,
//                 files = getFilesFromResponse(data),
//                 template,
//                 deferred;
//             if (data.context) {
//                 data.context.each(function (index) {
//                     var file = files[index] ||
//                         {error: 'Empty file upload result'};
//                     deferred = that._addFinishedDeferreds();
//                     that._transition($(this)).done(
//                         function () {
//                             var node = $(this);
//                             template = that._renderDownload([file])
//                                 .replaceAll(node);
//                             that._forceReflow(template);
//                             that._transition(template).done(
//                                 function () {
//                                     data.context = $(this);
//                                     that._trigger('completed', e, data);
//                                     that._trigger('finished', e, data);
//                                     deferred.resolve();
//                                 }
//                             );
//                         }
//                     );
//                 });
//             } else {
//                 template = that._renderDownload(files)[
//                     that.options.prependFiles ? 'prependTo' : 'appendTo'
//                     ](that.options.filesContainer);
//                 that._forceReflow(template);
//                 deferred = that._addFinishedDeferreds();
//                 that._transition(template).done(
//                     function () {
//                         data.context = $(this);
//                         that._trigger('completed', e, data);
//                         that._trigger('finished', e, data);
//                         deferred.resolve();
//                     }
//                 );
//             }
//         },
//         // Callback for failed (abort or error) uploads:
//         fail: function (e, data) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             var that = $(this).data('blueimp-fileupload') ||
//                     $(this).data('fileupload'),
//                 template,
//                 deferred;
//             if (data.context) {
//                 data.context.each(function (index) {
//                     if (data.errorThrown !== 'abort') {
//                         var file = data.files[index];
//                         file.error = file.error || data.errorThrown ||
//                             data.i18n('unknownError');
//                         deferred = that._addFinishedDeferreds();
//                         that._transition($(this)).done(
//                             function () {
//                                 var node = $(this);
//                                 template = that._renderDownload([file])
//                                     .replaceAll(node);
//                                 that._forceReflow(template);
//                                 that._transition(template).done(
//                                     function () {
//                                         data.context = $(this);
//                                         that._trigger('failed', e, data);
//                                         that._trigger('finished', e, data);
//                                         deferred.resolve();
//                                     }
//                                 );
//                             }
//                         );
//                     } else {
//                         deferred = that._addFinishedDeferreds();
//                         that._transition($(this)).done(
//                             function () {
//                                 $(this).remove();
//                                 that._trigger('failed', e, data);
//                                 that._trigger('finished', e, data);
//                                 deferred.resolve();
//                             }
//                         );
//                     }
//                 });
//             } else if (data.errorThrown !== 'abort') {
//                 data.context = that._renderUpload(data.files)[
//                     that.options.prependFiles ? 'prependTo' : 'appendTo'
//                     ](that.options.filesContainer)
//                     .data('data', data);
//                 that._forceReflow(data.context);
//                 deferred = that._addFinishedDeferreds();
//                 that._transition(data.context).done(
//                     function () {
//                         data.context = $(this);
//                         that._trigger('failed', e, data);
//                         that._trigger('finished', e, data);
//                         deferred.resolve();
//                     }
//                 );
//             } else {
//                 that._trigger('failed', e, data);
//                 that._trigger('finished', e, data);
//                 that._addFinishedDeferreds().resolve();
//             }
//         },
//         // Callback for upload progress events:
//         progress: function (e, data) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             var progress = Math.floor(data.loaded / data.total * 100);
//             if (data.context) {
//                 data.context.each(function () {
//                     $(this).find('.progress')
//                         .attr('aria-valuenow', progress)
//                         .children().first().css(
//                         'width',
//                         progress + '%'
//                     );
//                 });
//             }
//         },
//         // Callback for global upload progress events:
//         progressall: function (e, data) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             var $this = $(this),
//                 progress = Math.floor(data.loaded / data.total * 100),
//                 globalProgressNode = $this.find('.fileupload-progress'),
//                 extendedProgressNode = globalProgressNode
//                     .find('.progress-extended');
//             if (extendedProgressNode.length) {
//                 extendedProgressNode.html(
//                     ($this.data('blueimp-fileupload') || $this.data('fileupload'))
//                         ._renderExtendedProgress(data)
//                 );
//             }
//             globalProgressNode
//                 .find('.progress')
//                 .attr('aria-valuenow', progress)
//                 .children().first().css(
//                 'width',
//                 progress + '%'
//             );
//         },
//         // Callback for uploads start, equivalent to the global ajaxStart event:
//         start: function (e) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             var that = $(this).data('blueimp-fileupload') ||
//                 $(this).data('fileupload');
//             that._resetFinishedDeferreds();
//             that._transition($(this).find('.fileupload-progress')).done(
//                 function () {
//                     that._trigger('started', e);
//                 }
//             );
//         },
//         // Callback for uploads stop, equivalent to the global ajaxStop event:
//         stop: function (e) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             var that = $(this).data('blueimp-fileupload') ||
//                     $(this).data('fileupload'),
//                 deferred = that._addFinishedDeferreds();
//             $.when.apply($, that._getFinishedDeferreds())
//                 .done(function () {
//                     that._trigger('stopped', e);
//                 });
//             that._transition($(this).find('.fileupload-progress')).done(
//                 function () {
//                     $(this).find('.progress')
//                         .attr('aria-valuenow', '0')
//                         .children().first().css('width', '0%');
//                     $(this).find('.progress-extended').html('&nbsp;');
//                     deferred.resolve();
//                 }
//             );
//         },
//         processstart: function (e) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             $(this).addClass('fileupload-processing');
//         },
//         processstop: function (e) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             $(this).removeClass('fileupload-processing');
//         },
//         // Callback for file deletion:
//         destroy: function (e, data) {
//             if (e.isDefaultPrevented()) {
//                 return false;
//             }
//             var that = $(this).data('blueimp-fileupload') ||
//                     $(this).data('fileupload'),
//                 removeNode = function () {
//                     that._transition(data.context).done(
//                         function () {
//                             $(this).remove();
//                             that._trigger('destroyed', e, data);
//                         }
//                     );
//                 };
//         }
    });
});
// $(function () {
//     'use strict';
//     // Change this to the location of your server-side upload handler:
//     var url = window.location.hostname === 'blueimp.github.io' ?
//             '//jquery-file-upload.appspot.com/' : 'server/php/',
//         uploadButton = $('<button/>')
//             .addClass('btn btn-primary')
//             .prop('disabled', true)
//             .text('Processing...')
//             .on('click', function () {
//                 var $this = $(this),
//                     data = $this.data();
//                 $this
//                     .off('click')
//                     .text('Abort')
//                     .on('click', function () {
//                         $this.remove();
//                         data.abort();
//                     });
//                 data.submit().always(function () {
//                     $this.remove();
//                 });
//             });
//     $('#fileupload').fileupload({
//         url: url,
//         dataType: 'json',
//         autoUpload: false,
//         acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i,
//         maxFileSize: 999000,
//         // Enable image resizing, except for Android and Opera,
//         // which actually support image resizing, but fail to
//         // send Blob objects via XHR requests:
//         disableImageResize: /Android(?!.*Chrome)|Opera/
//             .test(window.navigator.userAgent),
//         previewMaxWidth: 100,
//         previewMaxHeight: 100,
//         previewCrop: true
//     }).on('fileuploadadd', function (e, data) {
//         data.context = $('<div/>').appendTo('#files');
//         $.each(data.files, function (index, file) {
//             var node = $('<p/>')
//                 .append($('<span/>').text(file.name));
//             if (!index) {
//                 node
//                     .append('<br>')
//                     .append(uploadButton.clone(true).data(data));
//             }
//             node.appendTo(data.context);
//         });
//     }).on('fileuploadprocessalways', function (e, data) {
//         var index = data.index,
//             file = data.files[index],
//             node = $(data.context.children()[index]);
//         if (file.preview) {
//             node
//                 .prepend('<br>')
//                 .prepend(file.preview);
//         }
//         if (file.error) {
//             node
//                 .append('<br>')
//                 .append($('<span class="text-danger"/>').text(file.error));
//         }
//         if (index + 1 === data.files.length) {
//             data.context.find('button')
//                 .text('Upload')
//                 .prop('disabled', !!data.files.error);
//         }
//     }).on('fileuploadprogressall', function (e, data) {
//         var progress = parseInt(data.loaded / data.total * 100, 10);
//         $('#progress .progress-bar').css(
//             'width',
//             progress + '%'
//         );
//     }).on('fileuploaddone', function (e, data) {
//         $.each(data.result.files, function (index, file) {
//             if (file.url) {
//                 var link = $('<a>')
//                     .attr('target', '_blank')
//                     .prop('href', file.url);
//                 $(data.context.children()[index])
//                     .wrap(link);
//             } else if (file.error) {
//                 var error = $('<span class="text-danger"/>').text(file.error);
//                 $(data.context.children()[index])
//                     .append('<br>')
//                     .append(error);
//             }
//         });
//     }).on('fileuploadfail', function (e, data) {
//         $.each(data.files, function (index) {
//             var error = $('<span class="text-danger"/>').text('File upload failed.');
//             $(data.context.children()[index])
//                 .append('<br>')
//                 .append(error);
//         });
//     }).prop('disabled', !$.support.fileInput)
//         .parent().addClass($.support.fileInput ? undefined : 'disabled');
// });