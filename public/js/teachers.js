/******/ (() => { // webpackBootstrap
/*!**********************************!*\
  !*** ./resources/js/teachers.js ***!
  \**********************************/
// resources/js/teachers.js

// English comment: Listen for clicks on any "save" button in the edit-modal
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.save-teacher-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = btn.dataset.id;
      var form = document.getElementById("teacher-edit-form-".concat(id));
      var first = document.getElementById("teacher-edit-first-".concat(id)).value;
      var last = document.getElementById("teacher-edit-last-".concat(id)).value;
      var mail = document.getElementById("teacher-edit-email-".concat(id)).value;
      fetch(form.action, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          first_name: first,
          last_name: last,
          email: mail
        })
      }).then(function (r) {
        return r.json();
      }).then(function () {
        return window.location.reload();
      })["catch"](console.error);
    });
  });
});
/******/ })()
;