$(document).ready(function() {
  console.log(3333);
  $('form[data-ajax=true]').submit(function(e) {
    e.preventDefault();

    var form = $(this);
    var url = form.attr('action');
    var method = form.attr('method');
    var success = $('.data-success-wrapper');
    var errors = $('.errors-wrapper');

    errors.hide();
    success.hide();

    $.ajax({
      dataType: 'json',
      type: method,
      url: url,
      data: form.serialize(), // serializes the form's elements.
      success: function(data) {
        console.log(data);
        success.html('');
        success.hide();
        if (data.hideForm) {
          form.hide();
          success.html('<p>' + data.message + '</p>').show();
        } else {
          success.html(data.message);
          success.show();
          location.href = refOnsuccess.val();
        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });

  $('#file_subscribe').on("change", function() { 
    uploadFile(this); 
  });
});

function uploadFile(elem) {
  var fs = require("fs");
  var text = fs.readFileSync("./dancers.txt");
  var textByLine = text.split("\n")
}