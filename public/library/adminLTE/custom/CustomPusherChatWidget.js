/**
 * Creates an instance of a PusherChatWidget, binds to a chat channel on the pusher instance and
 * and creates the UI for the chat widget.
 *
 * @param {Pusher} pusher The Pusher object used for the chat widget.
 * @param {Map} options A hash of key value options for the widget.
 */
function PusherChatWidget(pusher, options) {
  PusherChatWidget.instances.push(this);
  var self = this;
  
  this._pusher = pusher;
  this._autoScroll = true;
  
  options = options || {};
  this.settings = $.extend({
    maxItems: 50, // max items to show in the UI. Items beyond this limit will be removed as new ones come in.
    chatEndPoint: 'pusher/chat', // the end point where chat messages should be sanitized and then triggered
    channelName: document.location.href, // the name of the channel the chat will take place on
    appendTo: document.body, // A jQuery selector or object. Defines where the element should be appended to
    debug: true
  }, options);
  
  if(this.settings.debug && !Pusher.log) {
    Pusher.log = function(msg) {
      if(console && console.log) {
        console.log(msg);
      }
    }
  }
  
  // remove any unsupported characters from the chat channel name
  // see: http://pusher.com/docs/client_api_guide/client_channels#naming-channels
  this.settings.channelName = PusherChatWidget.getValidChannelName(this.settings.channelName);
  
  this._chatChannel = this._pusher.subscribe(this.settings.channelName);

  this._chatChannel.bind('chat_message', function(data) {
    self._chatMessageReceived(data);
  })
    
  this._itemCount = 0;
  
  this._widget = PusherChatWidget._createHTML(this.settings.appendTo);
  this._nicknameEl = user.username;
  this._emailEl = user.email;  
  this._messageInputEl = this._widget.find('input[type="text"]');
  this._messagesEl = this._widget.find('div.direct-chat-messages');

  this._widget.find('button.pusher-chat-widget-send-btn').click(function() {
    self._sendChatButtonClicked();
  })
  
  var messageEl = this._messagesEl;
  messageEl.scroll(function() {
    var el = messageEl.get(0);
    var scrollableHeight = (el.scrollHeight - messageEl.height());
    self._autoScroll = ( scrollableHeight === messageEl.scrollTop() );
  });
  
  this._startTimeMonitor();
};
PusherChatWidget.instances = [];

/* @private */
PusherChatWidget.prototype._chatMessageReceived = function(data) {
  var self = this;
  
  if(this._itemCount === 0) {
    this._messagesEl.html('');
  }
  
  var messageEl = PusherChatWidget._buildListItem(data, this._chatChannel);
  console.log(messageEl);
  messageEl.hide();
  this._messagesEl.append(messageEl);
  messageEl.slideDown(function() {
    if(self._autoScroll) {
      var messageEl = self._messagesEl.get(0);
      var scrollableHeight = (messageEl.scrollHeight - self._messagesEl.height());
      self._messagesEl.scrollTop(messageEl.scrollHeight);
    }
  });
  
  ++this._itemCount;
  
  if(this._itemCount > this.settings.maxItems) {
    /* get first li of list */
    this._messagesEl.children(':first').slideUp(function() {
      $(this).remove();
    });
  }
};

/* @private */
PusherChatWidget.prototype._sendChatButtonClicked = function() {
  var nickname = user.username; // optional
  var email = user.email; // optional
  if(!nickname) {
    alert('please supply a nickname');
    return;
  }
  var message = $.trim(this._messageInputEl.val());
  if(!message) {
    alert('please supply a chat message');
    return;
  }

  var chatInfo = {
    nickname: nickname,
    email: email,
    text: message,
    channel_name: this.settings.channelName
  };
  this._sendChatMessage(chatInfo);
};

/* @private */
PusherChatWidget.prototype._sendChatMessage = function(data) {
  var self = this;
  
  this._messageInputEl.attr('readonly', 'readonly');
  $.ajax({
    url: this.settings.chatEndPoint,
    type: 'post',
    dataType: 'json',
    data: {
      'chat_info': data
    },
    complete: function(xhr, status) {
      // Pusher.log('Chat message sent. Result: ' + status + ' : ' + xhr.responseText);
      if(xhr.status === 200) {
        self._messageInputEl.val('');
      }
      self._messageInputEl.removeAttr('readonly');
    },
    success: function(result) {
      // console.log(result);
    }
  })
};

/* @private */
PusherChatWidget.prototype._startTimeMonitor = function() {
  var self = this;
  
  setInterval(function() {
    self._messagesEl.children('.activity').each(function(i, el) {
      var timeEl = $(el).find('a.timestamp span[data-activity-published]');
      var time = timeEl.attr('data-activity-published');
      var newDesc = PusherChatWidget.timeToDescription(time);
      timeEl.text(newDesc);
    });
  }, 10 * 1000)
};

/* @private */
PusherChatWidget._createHTML = function(appendTo) {
  var html = '' +
  '<div class="chat-block">' +
    '<div class="col-md-2">' +
      '<!-- DIRECT CHAT PRIMARY -->' +
      '<div class="box box-primary direct-chat direct-chat-primary">' +
        '<div class="box-header with-border">' +
          '<h3 class="box-title">Direct Chat</h3>' +
          '<div class="box-tools pull-right">' +
            '<span data-toggle="tooltip" title="3 New Messages" class="badge bg-light-blue">3</span>' +
            '<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>' +
            '<button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>' +
            '<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>' +
          '</div>' +
        '</div><!-- /.box-header -->' +
        '<div class="box-body chat-body">' +
          '<!-- Contacts are loaded here -->' +
          '<!-- Conversations are loaded here -->' +
          '<div class="direct-chat-messages">' +
          '</div>' +
          '<div class="direct-chat-contacts">' +
            '<ul class="contacts-list">' +
              '<li>' +
                '<a href="#">' +
                  '<img class="contacts-list-img" src="../dist/img/user1-128x128.jpg">' +
                  '<div class="contacts-list-info">' +
                    '<span class="contacts-list-name">' +
                      'Count Dracula' +
                      '<small class="contacts-list-date pull-right">2/28/2015</small>' +
                    '</span>' +
                    '<span class="contacts-list-msg">How have you been? I was...</span>' +
                  '</div><!-- /.contacts-list-info -->' +
                '</a>' +
              '</li><!-- End Contact Item -->' +
            '</ul><!-- /.contatcts-list -->' +
          '</div><!-- /.direct-chat-pane -->' +
        '</div><!-- /.box-body -->' +
        '<div class="box-footer">' +
          '<form action="#" method="post">' +
            '<div class="input-group">' +
              '<input name="message" placeholder="Type Message ..." class="form-control" type="text">' +
              '<span class="input-group-btn">' +
                '<button type="button" class="btn btn-primary btn-flat pusher-chat-widget-send-btn"></button>' +
              '</span>' +
            '</div>' +
          '</form>' +
        '</div><!-- /.box-footer-->' +
      '</div><!--/.direct-chat -->' +
    '</div>';
  '</div>';
  var widget = $(html);
  $(appendTo).append(widget);
  return widget;
};

/* @private */
PusherChatWidget._buildListItem = function(activity, channel) {
  var message = '';

  console.log(channel);

  if (channel.members.me.id != activity.actor.id){
    message += '<!-- Message. Default to the left -->';
    message += '<div class="direct-chat-msg">';
  } else {
    message += '<!-- Message to the right -->';
    message += '<div class="direct-chat-msg right">';
  }
  message += '  <div class="direct-chat-info clearfix">';
  message += '    <span class="direct-chat-name pull-left">' + activity.actor.displayName.replace(/\\'/g, "'") + '</span>';
  message += '    <span class="direct-chat-timestamp pull-right" title="' + activity.published + '" data-activity-published="' + activity.published + '">' + PusherChatWidget.timeToDescription(activity.published) + '</span>';
  message += '  </div><!-- /.direct-chat-info -->';
  message += '  <img class="direct-chat-img" src="' + activity.actor.image.url + '" alt="message user image"><!-- /.direct-chat-img -->';
  message += '  <div class="direct-chat-text">';
  message +=      activity.body.replace(/\\('|&quot;)/g, '$1');
  message += '  </div><!-- /.direct-chat-text -->';
  message += '</div><!-- /.direct-chat-msg -->';                
  
  return $(message);
};

/**
 * converts a string into something which can be used as a valid channel name in Pusher.
 * @param {String} from The string to be converted.
 *
 * @see http://pusher.com/docs/client_api_guide/client_channels#naming-channels
 */
PusherChatWidget.getValidChannelName = function(from) {
  var pattern = /(\W)+/g;
  return from.replace(pattern, '-');
}

/**
 * converts a string or date parameter into a 'social media style'
 * time description.
 */
PusherChatWidget.timeToDescription = function(time) {
  if(time instanceof Date === false) {
    time = new Date(Date.parse(time));
  }
  var desc = "dunno";
  var now = new Date();
  var howLongAgo = (now - time);
  var seconds = Math.round(howLongAgo/1000);
  var minutes = Math.round(seconds/60);
  var hours = Math.round(minutes/60);
  if(seconds === 0) {
    desc = "just now";
  }
  else if(minutes < 1) {
    desc = seconds + " second" + (seconds !== 1?"s":"") + " ago";
  }
  else if(minutes < 60) {
    desc = "about " + minutes + " minute" + (minutes !== 1?"s":"") + " ago";
  }
  else if(hours < 24) {
    desc = "about " + hours + " hour"  + (hours !== 1?"s":"") + " ago";
  }
  else {
    desc = time.getDay() + " " + ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"][time.getMonth()]
  }
  return desc;
};
