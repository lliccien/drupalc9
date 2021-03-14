/**
* @file
*/

(function ($, Drupal) {
Drupal.AjaxCommands.prototype.example = function (ajax, response, status) {
  // alert(`el Id ${id} el name ${name}`)
  console.log(status)
  console.log(response)
  $('#myUsersModal').modal('show');
  $('#modalMessage').text(`The ${response.name} was saved with the Id: ${response.id}`)
}

})(jQuery, Drupal);
