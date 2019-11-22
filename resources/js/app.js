
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

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

import { getSchedules } from './utils/backend';

/* Show schedules details */
$(document).on('click', '.details', function () {

    $('.temporary').remove();

    const $field = $('#field');
    var date_entry = $(this).data('date_entry');
    var user_id = $(this).data('user_id');

    if (!date_entry) {
        return;
    }

    getSchedules(date_entry, user_id).then((points) => {

        points.forEach((schedule) => {
            const $tr = $('<tr class="temporary" />');
            $tr.append('<td><input class="form-control" name="point[' + schedule.id + '][started]" value="' + schedule.started.replace(/^.+ ([\d:]+)$/, '$1') + '"></td>')
            $tr.append('<td><input class="form-control" name="point[' + schedule.id + '][finished]" value="' + schedule.finished.replace(/^.+ ([\d:]+)$/, '$1') + '"></td>')
            $field.append($tr);
        });

        $('#schedules').modal('show');
    }).catch(console.error);
});

/* Function show tasks per project */
function showTasks($select) {
    var projectId = $select.val();
    var $form = $select.parents('form');

    $('[name=task_id]', $form).find('option[data-project_id]').hide().filter('[data-project_id="' + projectId + '"]').show();

    var $selected = $('[name=task_id]', $form).find('option:selected');

    if ($selected.css('display') === 'none') {
        $selected.removeAttr('selected');
    };
};

$('[name=project_id]').on('change', function () {
    showTasks($(this));
});

$('[name=project_id]').each(function () {
    showTasks($(this));
});

/* Function action */
function action(url, method) {

    let token = document.head.querySelector('meta[name="csrf-token"]');

    const $form = $('#form_action');

    $form.attr('action', url);
    $form.attr('method', method);

    if (method === 'post') {
        $form.prepend('<input type="hidden" name="_token" value="' + token.content + '">');
    }

    $form.submit();

    setTimeout(() => {
        $form.attr('action', '/report');
        $form.attr('method', 'get');
    }, 1000);
}
$('#btn_share').on('click', function () {
    action('/report', 'post');
});
$('#btn_export').on('click', function () {
    action('/report/csv', 'get');
});

/* Function toApply */
function toApply() {

    var valuetask = $('[name=task_id]').val();
    var valueactivity = $('[name=activity_id]').val();

    /* Loop with all the checked */
     $(':checked').each(function() {
         var index = $(this).data('index');

         /* If the value is not empty */
         if (valuetask !== '') {
             var name = 'time[' + index + '][task_id]';
             $('[name="' + name + '"]').val(valuetask);

             /* Back to the default text "select" */
             $('[name=task_id]').val('');

         }if (valueactivity !== '') {
             var name = 'time[' + index + '][activity_id]';
             $('[name="' + name + '"]').val(valueactivity);
             $('[name=activity_id]').val('');
         }
     });
};
$('[name=apply]').on('click', function () {
    toApply();
});

/* Function select all, with shift and alt */
$('.select-all').click(function(e) {
  var checked = e.currentTarget.checked;
  $('.list-item-checkbox').prop('checked', checked);
});

var lastChecked = null;

$('.list-item-checkbox').click(function(e) {

    /* Select with shift */
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
  /* Select with alt */
  if(e.altKey){

    $('.list-item-checkbox')
      .filter(':not(:disabled)')
      .each(function () {
      var $checkbox = $(this);
      $checkbox.prop('checked', !$checkbox.is(':checked'));
    });
  }
});

/* Confirmation to delete */
function Delete(selector) {
    if (window.confirm("Do you want to delete this item?")) {
        $(selector).submit();
    }
};
$('.btn-delete-time').on('click', function () {
    var id = $(this).data('time');
    Delete('#time_delete-' + id);
});
$('.btn-delete-activity').on('click', function () {
    var id = $(this).data('activity');
    Delete('#activity_delete-' + id);
});

/* Function is performed by loading the page */
$(function () {
    $('#datepickerstarted').datetimepicker({
        useCurrent: false,
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

/* Back to the default text "select" */
function clean() {

    $('[name=project_id]').val('');
    $('[name=task_id]').val('');
    $('[name=user_id]').val('');
    $('[name=activity_id]').val('');
    $('[name=started]').val('');
    $('[name=finished]').val('');
}
$('[name=clean]').on('click', function () {
    clean();
});

/* Modal with error */
function modalError() {
    $('.modal:has(.is-invalid)').modal('show');
};
modalError();



/**
 * Attach a function to update the time counter in the time tracking view.
 *
 * The counter is only applied to a time that is running. In this case, all the
 * buttons to start a time for other projects are replaced with a `-` (dash) to
 * avoid two times running in parallel.
 *
 * This functions exits if there is no time running.
 *
 * This is a self invoked function.
 *
 * @param  {Function}
 * @return {void}
 * @author Lucas Cardoso <lucas@straube.co>
 * @author Gustavo Straube <gustavo@straube.co>
 */
(() => {

    /**
     * A jQuery object containing a reference to the form used to stop a current
     * time.
     *
     * @type {jQuery}
     */
    const $form = $('.time-stop');

    /*
     * There is no time to stop, so we simply return without even setting the
     * interval.
     */
    if ($form.length === 0) {
        return;
    }

    /**
     * A jQuery object containing a reference to the button inside `$form`.
     *
     * @type {jQuery}
     */
    const $button = $form.find('button');

    /*
     * Update heading of time column and remove start time buttons.
     */
    $('.stop_time').text('Stop');
    $('.time_stop').text('-');

    /**
     * Convert a time string in the `d h:m:s` format to seconds.
     *
     * @param  {String} time
     * @return {Number}
     */
    const timeToSecs = (time) => {
        const parts = time.replace(' day(s) and ', ' ').trim().split(/[ :]+/g).map(part => parseInt(part, 10));
        parts.reverse();

        // Seconds
        let secs = parts[0];

        // Minutes
        let multiplier = 60;
        if (parts[1]) {
            secs += parts[1] * multiplier;
        }

        // Hours
        multiplier *= 60;
        if (parts[2]) {
            secs += parts[2] * multiplier;
        }

        // Days
        multiplier *= 24;
        if (parts[3]) {
            secs += parts[3] * multiplier;
        }

        return secs;
    };

    /**
     * Format the given interval (seconds) in the `d h:m:s` format.
     *
     * @param  {Number} secs
     * @return {String}
     */
    const secsToTime = (secs) => {
        let divider = 86400; // 60 * 60 * 24

        const days = Math.floor(secs / divider);
        secs = secs % divider;

        divider /= 24;
        const hours = Math.floor(secs / divider);
        secs = secs % divider;

        divider /= 60;
        const minutes = Math.floor(secs / divider);
        secs = secs % divider;

        divider /= 60;
        const seconds = Math.floor(secs / divider);

        let time = [ hours, minutes, seconds ].map(part => part < 10 ? '0' + part : part).join(':');

        if (days > 0) {
            time = days + ' day(s) and ' + time;
        }

        return time;
    };

    /**
     * The interval callback to update the time.
     *
     * @return {void}
     */
    const updater = () => {
        const diff = Math.round((Date.now() - CURRENT_TIMESTAMP) / 1000);
        const started = $button.data('started');
        $button.text(secsToTime(timeToSecs(started) + diff));
    };

    setInterval(updater, 1000);

})();
