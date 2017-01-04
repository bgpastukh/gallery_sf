//    Delete image
$('body').on('click', '.delete-btn', function () {
    var toDel = $(this).closest('.image');
    var src = $(this).data('url');
    $.post(
        src
    ).done(function (data) {
        toDel.remove();
        if (data.status){
            $('.message').removeClass('bg-danger');
            $('.message').addClass('bg-success');
        } else {
            $('.message').removeClass('bg-success');
            $('.message').addClass('bg-danger');
        }
        $('.message').text(data.message);
    });
});

//    Edit comment
$('body').on('click', '.edit-btn', function () {
//        Get id and comment
    var info = $(this).parent();
    var comment = info.find('.comment').val();
    var src = $(this).data('url');

//        Sending
    $.post( src, {'comment': comment}
    ).done(function (data) {
        if (data.status){
            $('.message').removeClass('bg-danger');
            $('.message').addClass('bg-success');
        }
        $('.message').text(data.message);
    });
});

var files;
var comment;

// Get files data
$('#gallery_file').change(function () {
    files = this.files;
});

//    Upload new image
$('.submit').click(function (event) {
    event.stopPropagation();
    event.preventDefault();
    var src = $(this).data('url');

// //    Check empty fields, format and file size
//     var form = $('.panel');
//     var maxsize = 1024 * 1024;
//     var allowedFormats = /\.(png|jpe?g)$/i;
//
//     form.find('.rf').each(function () {
//         if ($(this).val()) {
//             $(this).removeClass('empty_field');
//         } else {
//             $(this).addClass('empty_field');
//         }
//     });
//
//     form.find('.empty_field').css({'border-color': '#d8512d'});
//     // Через полсекунды удаляем подсветку
//     setTimeout(function () {
//         form.find('.empty_field').removeAttr('style');
//     }, 800);
//
//
//     var emptyFields = $('.empty_field');
//     if (emptyFields[0]) {
//         $('.message').addClass('bg-danger');
//         $('.message').text('All fields required!');
//         return;
//     }
//     var fileSize = files[0].size;
//
//     if (fileSize > maxsize) {
//         $('.message').addClass('bg-danger');
//         $('.message').text('Image is to big!');
//         return;
//     }
//
//     var status = allowedFormats.test(files[0].name);
//     if (!status){
//         $('.message').addClass('bg-danger');
//         $('.message').text('Not allowed format!');
//         return;
//     }

    // Make data to send
    var data = new FormData();
    $.each(files, function (key, value) {
        data.append("gallery[file]", value);
    });

    comment = $('#gallery_comment').val();
    data.append('gallery[comment]', comment);

    // Sending
    $.post({
        url: src,
        data: data,
        cache: false,
        dataType: 'json',
        processData: false, // Don't process the files
        contentType: false
    }).done(function (data) {
        $('.gallery').append(data.html);
        if (data.status){
            $('.message').removeClass('bg-danger');
            $('.message').addClass('bg-success');
            $('.panel')[0].reset();
        } else {
            $('.message').removeClass('bg-success');
            $('.message').addClass('bg-danger');
        }
        $('.message').text(data.message);
    });
});

//  Sort by date
$('.sort').click(function () {
    if($(this).hasClass('asc')){
        var src = $(this).data('url-asc');
        $('.sort').removeClass('asc').removeClass('desc');
        $(this).addClass('desc');
    } else {
        var src = $(this).data('url-desc');
        $('.sort').removeClass('asc').removeClass('desc');
        $(this).addClass('asc');
    }
    $.post(src).done(function (data) {
        $('.gallery').html(data.html);
    })

});

