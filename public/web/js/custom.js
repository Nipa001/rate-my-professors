// function LoadPageContent(url) {
//     var conVar = url; 
//     $.ajax({
//         mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
//         url: url,
//         type: "GET",
//         dataType: "html",
//         success: function (data) {
//             if (parseInt(data) === 0) {
//                 //location.replace('');
//             } 
//             else {
//                 $('.preloader').hide();
//                 $('#profile_content').html(data);
//             }
//         }
//     });
// }