var pusher = new Pusher('682ff0901a6765cc1e50');

PNotify.prototype.options.styling = "fontawesome";

$(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(':checkbox, :radio').iCheck({
    checkboxClass: 'icheckbox_square-yellow',
    radioClass: 'iradio_flat-yellow',
        increaseArea: '20%' // optional
  });

  $('#delete').click(function() {
    if ($('#delete-id').val() != '') {
      $('#delete-form').submit();
    } else {
      var data = {
        type:'failed',
        name:$(this).attr('data-name'),
        kind:'no-data',
        message:'Não foram selecionados registros'
      }

      $.ajax({
        url: '/general/createMessageJSON',
        data: data,
        type: "GET",
        success: function(data) {
          $('#messages').html(throwMessage(data));
        }
      });
    }
  });

  $("select").select2();

  function throwMessage(data) {
    html = '<div class="alert alert-' + data.class + ' alert-dismissable">';
    html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    html += '<h4>    <i class="icon fa fa-' + data.faicon + '"></i> ' + data.status + '</h4>';
    html += data.message;
    html += '</div>';

    return html;
  }
  
  $('#search').on('focus', function() {
    $('#search-form').addClass('animate-search');
  });
  $('table, .box-header').on('click', function() {
    $('#search-form').removeClass('animate-search');
  });

  /*if ($.fn.DataTable) {
    if ($(".table").length > 0) {
      var table = $(".table").not('.permission').DataTable({
        language: {
          processing:     dataTableLang.processing,
          search:         dataTableLang.search,
          lengthMenu:     dataTableLang.lengthMenu,
          info:           dataTableLang.info,
          infoEmpty:      dataTableLang.infoEmpty,
          infoFiltered:   dataTableLang.infoFiltered,
          infoPostFix:    dataTableLang.infoPostFix,
          loadingRecords: dataTableLang.loadingRecords,
          zeroRecords:    dataTableLang.zeroRecords,
          emptyTable:     dataTableLang.emptyTable,
          paginate: {
            first:      dataTableLang.paginate_first,
            previous:   dataTableLang.paginate_previous,
            next:       dataTableLang.paginate_next,
            last:       dataTableLang.paginate_last,
          }
        }
      });
    }
  }*/

  var deselect = true;
  var delete_id = [];

  $('.select-all').on('ifChecked ifUnchecked', function(event) {
    if (event.type == 'ifChecked') {
      $(".delete").iCheck('check');
      deselect = true;
    } else {
      if(deselect){
        deselect = true;
        $(".delete").iCheck('uncheck');
      } else {
        deselect = true;
      }
    }
  });

  $('.delete').on('ifChecked ifUnchecked', function(event) {
    if (event.type == 'ifUnchecked') {
      if ($('.select-all').iCheck('ifChecked')) {
        deselect = false;
        $('.select-all').iCheck('uncheck');
      }

      var index = delete_id.indexOf($(this).attr('data-value'));
      delete_id.splice(index, 1);
    } else {
      if ($('table :checkbox').length == ($('table :checkbox:checked').length + 1))
        $('.select-all').iCheck('check');

      if (delete_id.indexOf($(this).attr('data-value')) == -1)
        delete_id.push($(this).attr('data-value'));
    }

    $('#delete-id').val(delete_id.join(','))
  });

  if (typeof inputmask !== 'undefined' && $.isFunction(inputmask)) {
    $('.input-mask').inputmask();
  }

    // console.log($.isFunction(datepicker));

    if ($('.date').length > 0) {
      $('.date').datepicker({
        format: 'dd/mm/yyyy'
      });
    }

    if ($(".permission-check").length > 0) {
      $(".permission-check").iCheck('destroy');
      $(".permission-check").bootstrapSwitch();
    }
  });

// check for Geolocation support
if (navigator.geolocation) {
  console.log('Geolocation is supported!');
} else {
  console.log('Geolocation is not supported for this Browser/OS version yet.');
}

function responsive_filemanager_callback(field_id) {
  var url = $('#'+field_id).val();
  var url_web = location.origin;

  if ($('#file-name').length > 0) {
    $('#'+field_id).val(url.replace(url_web, ''));

    $('#file-name').val(url.replace(url_web, ''));
  }
  
  if (field_id == 'photo') {
    $('.avatar-wrapper img').remove();
    $('.avatar-wrapper .cropper-container').remove();
    $('.avatar-wrapper').append($('<img>').attr('src', url.replace('../', '/')));
    
    setTimeout(function() {
      cropStart($('.avatar-wrapper img'));
      $('#md-crop').modal('show');
    }, 1000);
    // $('#image').attr('src', url.replace('../', '/'));
  }
}

// function to start the crop
function cropStart(image) {
  setTimeout(function() {
    image.cropper({
      aspectRatio: 1,
      preview: '.avatar-preview',
      crop: function (e) {
        var json = [
          '{"x":' + e.x,
          '"y":' + e.y,
          '"height":' + e.height,
          '"width":' + e.width,
          '"rotate":' + e.rotate + '}'
        ].join();
      },
      dragend: function(data) {
        originalData = image.cropper("getCroppedCanvas");
        console.log(originalData.toDataURL());
      }
    });
  }, 100);

  $('.avatar-btns button').each(function () {
    console.log($(this));
    $(this).click(function (e) {
        data = $(e.target).data();
        image.cropper(data.method, data.option);
    });
  }).tooltip({
    placement: 'bottom'
  });

  $('.avatar-save').click(function() {
    var data = {};
    originalData = image.cropper("getCroppedCanvas");
    data.image = originalData.toDataURL();

    console.log(data);

    $.ajax({
      url: '/general/saveImages',
      data: data,
      type: "POST",
      success: function(data) {
        console.log(data);
        if (!data.error) {
          $('#image').attr('src', data);
          $('#photo').val(data);
          $('#md-crop').modal('hide');
        } else {

        }
      }
    });
  });
}

//subscribe to our private channel
var PresenceChannel = pusher.subscribe("presence-user-" + user.id);

//do something with our new information
PresenceChannel.bind ('new_notification', function(notification) {
  // assign the notification's message to a <div></div>notification
  $('li.notifications-menu .dropdown-menu .menu').prepend(createNotification(notification));

  titleCounter(true);
});

//subscribe to our notifications channel
var notificationsChannel = pusher.subscribe('notifications');

//do something with our new information
notificationsChannel.bind ('new_notification', function(notification) {
  // assign the notification's message to a <div></div>notification
  $('li.notifications-menu .dropdown-menu .menu').prepend(createNotification(notification));

  titleCounter(true);
});

function createNotification(notification) {
  var count = $('.notification-count').html();
  if (count == '') {
    $('#counter').html(1);
    $('.notification-count').html(1);
  } else {
    $('#counter').html(parseInt($('#counter').html()) + 1);
    $('.notification-count').html(parseInt($('.notification-count').html()) + 1);
  }

  var new_message = '';

  new_message += '<li>';
  new_message += '    <a href="' + notification.href + '">';
  new_message += '        <i class="fa fa-' + notification.faicon + ' text-aqua"></i> ' + notification.message.substring(0, 40);;
  new_message += '    </a>';
  new_message += '</li>';

  return new_message;
}

var original_title = document.title;

function titleCounter(sound) {
  notification = parseInt($('.notification-count').html());
  message = parseInt($('.message-count').html());
  tasks = parseInt($('.tasks-count').html());

  update_count = ($.isNumeric(notification) ? notification : 0) + ($.isNumeric(message) ? message : 0) + ($.isNumeric(tasks) ? tasks : 0);    

  document.title = "(" + update_count + ") " + original_title;

  if (sound)
    $.playSound('library/adminLTE/sounds/alert');
}

function savePosition(latitude, longitude) {
  $.ajax({
    url: '/general/saveLocalization',
    data: { user_id:user.id, latitude: latitude, longitude: longitude },
    type: "GET",
    success: function(data) {
      var settings = data;

      if (settings.error) {
        alert(error);
      } else {
        $('#client_group_id').prop( "disabled", true ).val($("#target option:first").val());
        $('#client_group_id').find('option[value!=""]').remove();
      }
    }
  });
}

titleCounter(false);

/*$(function() {
    var chatWidget = new PusherChatWidget(pusher, {
    channelName: 'presence-chat-1-2',
    appendTo: '#chat-line',
    debug: false
  });
    var chatWidget1 = new PusherChatWidget(pusher, {
    channelName: 'presence-chat-1-3',
    appendTo: '#chat-line',
    debug: false
  });
    var chatWidget2 = new PusherChatWidget(pusher, {
    channelName: 'presence-chat-1-4',
    appendTo: '#chat-line',
    debug: false
  });
    var chatWidget3 = new PusherChatWidget(pusher, {
    channelName: 'presence-chat-1-5',
    appendTo: '#chat-line',
    debug: false
  });
    var chatWidget4 = new PusherChatWidget(pusher, {
    channelName: 'presence-chat-1-6',
    appendTo: '#chat-line',
    debug: false
  });
});*/

$('#notification').click(function() {
  var data = {};
  $('#notify-content').html('');

  $.ajax({
    url: '/general/getAllNotifications',
    data: data,
    type: "GET",
    success: function(data) {
      $('#notify-content').html('');
      $('#notify-content').html($(data));
    }
  });
});