$(document).ready(function(){
  

  function hideEdit() {
    $("#formEdit").addClass("mask");
    $("#formEdit").hide();    
  }

  // Table filter
  $("#qTable").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#catTable  tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });

  // Show-hide system
  hideEdit();

  $("#linkEdit").on("click", function (){
    if ($("#formEdit").hasClass("mask")) {
      $("#formEdit").removeClass("mask");
      $("#formEdit").show();
    } else {
      hideEdit();
    }
  });

  // Materialize script
  $('select').formSelect();
  $('.modal').modal();
  $('.tabs').tabs();

});