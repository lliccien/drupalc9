/**
* @file
*/

(function ($, Drupal) {
Drupal.AjaxCommands.prototype.example = function (ajax, response, status) {
  $('#myUsersModal').modal('show');
  $('#modalMessage').text(`The ${response.name} was saved with the Id: ${response.id}`)
}

})(jQuery, Drupal);
