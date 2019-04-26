
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.moment = require('moment');
require('tempusdominus-bootstrap-4');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

//show tasks per project {
function showTasks(projectId) {
    $('[name=task_id]').find('option[data-project_id]').hide().filter('[data-project_id="' + projectId + '"]').show();
    var $selected = $('[name=task_id]').find('option:selected');
    if ($selected.css('display') === 'none') {
        $selected.removeAttr('selected');
    }
}

$('[name=project_id]').on('change', function () {
    showTasks($(this).val());
});

showTasks($('[name=project_id]').val());

//end }

//action {
function action() {
    //
    let token = document.head.querySelector('meta[name="csrf-token"]');

    //
    const $form = $('#form_action');

    //
    $form.attr('action', '/report');
    $form.attr('method', 'post');

    //
    $form.prepend('<input type="hidden" name="_token" value="' + token.content + '">');

    $form.submit();
}
// click of button
$('#btn_share').on('click', function () {
    action();
});

// end }

//function toApply {
function toApply() {
    //
    var valuetask = $('[name=task_id]').val();
    var valueactivity = $('[name=activity_id]').val();

    //loop with all the checked
     $(':checked').each(function() {
         var index = $(this).data('index');

         //if the value is not empty
         if(valuetask !== '') {
             var name = 'time[' + index + '][task_id]';
             $('[name="' + name + '"]').val(valuetask);

             //back to the default text "select"
             $('[name=task_id]').val('');

         }if(valueactivity !== '') {
             var name = 'time[' + index + '][activity_id]';
             $('[name="' + name + '"]').val(valueactivity);
             $('[name=activity_id]').val('');
         }
     });
};
// click of button
$('[name=apply]').on('click', function () {
    toApply();
});

//end }

var counter;
//function time tracker {
function updateTime() {

    var time = $('[name=update_time]').text();

    //stop the function every 1 second if you have no start time
    if(!time) {
        clearInterval(counter);
        return;
    }

    //map executa uma função em todos as posicoes do array: Nesse caso, em cada "part/parte" ele faz um parseInt com base10 e retorna para o array.
    var hms = time.trim().split(/[ :]/g).map(part => parseInt(part, 10));

    hms[3]++;

    if(hms[3] === 60) {
        hms[3] = 0;
        hms[2]++;

    }if(hms[2] === 60) {
        hms[2] = 0;
        hms[1]++;

    }if(hms[1] === 24) {
        hms[1] = 0;
        hms[0]++;
    }

    var result = hms.map(part => part < 10 ? '0' + part : part).join(':');

    $('[name=update_time]').text(result);

    //receive the value of class
    var stop = $('.update_time').text();

    //if a time is started, it edits the text of the edit table to stop
    if(!stop) {
        $('.stop_time').text('Stop');
        $('.time_stop').text('-');
    }
}
//calls the function in a time interval
counter = setInterval(updateTime, 1000);

//end }

//function select all, with shift and alt {
$('.select-all').click(function(e) {
  var checked = e.currentTarget.checked;
  $('.list-item-checkbox').prop('checked', checked);
});

var lastChecked = null;

$('.list-item-checkbox').click(function(e) {

    //select with shift
    if(e.shiftKey) {
        var from = $('.list-item-checkbox').index(this);
        var to = $('.list-item-checkbox').index(lastChecked);

        var start = Math.min(from, to);
        var end = Math.max(from, to) + 1;

    $('.list-item-checkbox').slice(start, end)
      .filter(':not(:disabled)')
      .prop('checked', lastChecked.checked);
  }

  lastChecked = this;

  //select with alt
  if(e.altKey){

    $('.list-item-checkbox')
      .filter(':not(:disabled)')
      .each(function () {
      var $checkbox = $(this);
      $checkbox.prop('checked', !$checkbox.is(':checked'));
    });
  }
});
//end }

//function is performed by loading the page {
$(function () {
    $('#datepickerstarted').datetimepicker({
        format:"Y-MM-DD HH:mm:ss"
    });
    $('#datepickerfinished').datetimepicker({
        useCurrent: false,
        format:"Y-MM-DD HH:mm:ss"
    });
    $("#datepickerstarted").on("change.datetimepicker", function (e) {
        $('#datepickerfinished').datetimepicker('minDate', e.date);
    });
    $("#datepickerfinished").on("change.datetimepicker", function (e) {
        $('#datepickerstarted').datetimepicker('maxDate', e.date);
    });
});

//end }

//back to the default text "select" {
function clean() {

    $('[name=project_id]').val('');
    $('[name=task_id]').val('');
    $('[name=user_id]').val('');
    $('[name=activity_id]').val('');
    $('[name=started]').val('');
    $('[name=finished]').val('');
}
// end }

// click of button
$('[name=clean]').on('click', function () {
    clean();
});
