<div id="notification-panel">
  <div class="preview col-md-3">
    <ul class="notification notification-inverse">
      @foreach ($data['notifications'] as $notification)
      <li>
        <a class="notification-select" href="#" data-object='{!! $notification !!}'>
          <i class="fa fa-{!! $notification->faicon !!} text-aqua"></i> {!! $notification->message !!}
        </a>
      </li>
      @endforeach
    </ul>
  </div>
  <div class="notification-view col-md-9">
    <h4>Clique em uma notificação ao lado</h4>
  </div>
</div>

<script type="text/javascript" charset="utf-8" async defer>
  $('.notification-select').each(function() {
    $(this).click(function() {
      var html = '';
      html += '<h4>Sistema Informa</h4>';
      html += '<p>' + $(this).data('object').message + '</p>';

      $('.notification-view').html('');
      $('.notification-view').html(html);
    });
  });
  $('.notification-inverse').slimScroll({
      height: '400px',
      alwaysVisible: false,
  }).css("width", "100%");
</script>