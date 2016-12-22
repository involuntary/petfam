// Prevents from HTML injection.
function escape_html (str)
{
	if (!str) return '';

	return jQuery('<span/>').text(str).html();
}

/////////////////////
// Main Chat class //
/////////////////////

var Chat =
{
	
	_already_inited: false,
	_username: null,
	_prelogin: [],
	_last_message_date: 0,
	_last_sent_message_date: 0,

	// Returns current SQLite date
	get_date: function()
	{
		var timestamp = new Date().getTime();
		jQuery.get(server_path+'ajax/chat.php', {'action': 'get_date', time: timestamp}, function(date)
		{
			Chat._last_message_date = date;
			Chat.prelogin('get_date');
		});
	},

	// Loads users list
	load_users: function()
	{
		var timestamp = new Date().getTime();
		jQuery.get(server_path+'ajax/chat.php', {'action': 'get_users', time: timestamp}, function(users)
		{
			if (users == '' || users == '0')
			{
				// No users yet.
				Chat.prelogin('load_users');
				return;
			}

			users = users.split("\t\t").sort();
			var user;
			for (var i in users)
			{
				user = users[i].split("\t");
				Chat._show_new_user(user[0], user[1], user[2], user[3]);
			}
			Chat.prelogin('load_users');
		});
	},

	// Updated users list
	update_users_list: function()
	{
		var timestamp = new Date().getTime();
		jQuery.get(server_path+'ajax/chat.php', {'action': 'get_users', time: timestamp}, function(users)
		{
			users = users.split("\t\t").sort();
			var user;
			jQuery('#users-list ul').html('');
			for (var i in users)
			{
				user = users[i].split("\t");
				Chat._show_new_user(user[0], user[1], user[2], user[3]);
			}
		});
	},

	// Pings server (used very often)
	ping: function()
	{
		var timestamp = new Date().getTime();
		jQuery.get(server_path+'ajax/chat.php', {'action': 'ping', 'last_message_date': Chat._last_message_date, 'username': Chat._username, time: timestamp}, function(messages)
		{
			if (messages == '' || messages == '0')
			{
				// No new messages.
				return;
			}

			if (messages == '-1')
			{
				// User has been kicked.
				window.location.reload();
				return;
			}

			if (/^kicked/.test(messages))
			{
				messages = messages.replace(/^kicked/, '');
				alert('You have been kicked for 1 hour! Reason:' + "\n" + messages);
				window.location.reload();
				return;
			}

			if (/^banned/.test(messages))
			{
				messages = messages.replace(/^banned/, '');
				alert('You have been banned for 1 week! Reason:' + "\n" + messages);
				window.location.reload();
				return;
			}

			messages = messages.split("\t\t");
			var message;
			for (var i in messages)
			{
				if (!messages[i]) break;
				message = messages[i].split("\t");
				Chat._show_new_message(message[0], message[1], escape_html(message[2]), escape_html(message[3]), message[4], message[5], message[6]);
			}
			//Chat._last_message_date = message[0];
			Chat.get_date();
		});
	},

	// Decides if current user should be logged in
	prelogin: function(event)
	{
		this._prelogin.push(event);
		if (this._prelogin.length == 2)
		{
			this.login();
		}
		/**/
		
		//this.login();
	},

	// Logs current user in
	login: function ()
	{
		var timestamp = new Date().getTime();		 
		jQuery.post(server_path+'ajax/chat.php', {'action': 'login', 'username': Chat._username, time: timestamp}, function(response)
		{
			if (response === '-1')
			{
				// User is banned.
				return false;
			}

			if (response === '1')
			{
				Chat._show_new_user ('', Chat._username,'','');
				Chat._show_new_message (false, '', '', 'Welcome, <strong>'+Chat._username+'</strong>!', '', '', 'system');
			}
		});
	},

	// Sends chat message to everyone
	send_message: function()
	{
		var timestamp = new Date().getTime();

		// flood control
		if (timestamp < (this._last_sent_message_date + 1200))
		{
			return;
		}

		this._last_sent_message_date = timestamp;

		var username = this._username;
		var message = jQuery('#message').val();
		if (parseInt(message.length) > 2000)
		{
			alert('Your message is too long.');
			return;
		}

		if (/^\s*$/.test(message))
		{
			return;
		}

		jQuery('#message').val('').focus();

		jQuery.post(server_path+'ajax/chat.php', {'action': 'send_message', 'message': message, 'username': username, time: timestamp}, function() {});
	},

	// Shows new user on the list
	_show_new_user: function(photo, username, ulink, uid)
	{
		 	 
		jQuery('#users-list li.empty').remove();
		jQuery('#users-list ul').append('<li class="user_'+ uid +'"></li>');
		jQuery('#users-list li:last-child')
			.html( "<div class='col-md-3'><a href='"+ulink+"'>" + photo + "</a></div><div class='col-md-8'><span class='username'>" +  escape_html(username) + '</span>' +
			     
				  (is_admin ? ' <div class="adminoptions"><a href="javascript:void(0);" onclick="Chat.kick(\''+escape_html(username) + '\',\''+uid+'\');" class="admin kick"><i class="fa fa-thumbs-down"></i> Kick for 1 hour</a> <a href="javascript:void(0);" onclick="Chat.ban(\''+escape_html(username) + '\',\''+uid+'\');" class="admin ban"><i class="fa fa-minus-circle"></i> Ban for 1 week</a></div>'  : '')
				  
				  + '</div><div class="clearfix"></div>'
			);
 
	},

	// Shows new message in chat window
	_show_new_message: function(date, photo, username, message, datetext, mycss, system)
	{
		// DONT SHOW IF DATE IS INVALUD // ERRORNOUS MSG
		if (typeof datetext === "undefined") {
			return;
		}  
 
		/* message body replacements */
		// clickable urls
		message = message.replace(
			/((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/,
			"<a href=\"$1\">$1</a>"
		);

		// clickable emails
		message = message.replace(
			/(([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?))/i,
			"<a href=\"mailto:$1\">$1</a>"
		);


		var content = '';

		if (!system)
		{
		 
			 
			content += '<p class="commentInfo">'+photo+' </p>';
		
			content += '<div class="comment"><p>' + message + '</p></div> <div class="bottombit"><span class="chat_username">'+username+'</span> <i class="fa fa-clock-o"></i> <span class="chat_date">'+datetext+'</span></div>';
			
		} else {
			
		content += '<span class="message">'+message+'</span>';	
		}
		
 		
		jQuery('#chat-window li.empty').remove();
		jQuery('#chat-window ul').append( (username == this._username) ? '<li class="'+mycss+'"></li>' : '<li></li>');
		jQuery('#chat-window li:last-child').html(content);

		if (system)
		{
			jQuery('#chat-window li:last-child').attr('class', 'system');
		}

		jQuery('#chat-window ul').scrollTop(jQuery('#chat-window ul')[0].scrollHeight);
	},

	// function scales #messages-list and #users-list
	// to fit the window height perfectly
	scale_window: function()
	{
		var window_h = jQuery(window).height();
		var new_h = window_h - jQuery('#header').height() - jQuery('#send-message').height() - 1;

		jQuery('#chat-window ul, #users-list ul').css('height', new_h + 'px');
		jQuery('#chat-window ul').scrollTop(jQuery('#chat-window ul')[0].scrollHeight);
	},

	// Kicks the user
	kick: function(username, uid)
	{
		if (is_admin == false) return false;
	 
		if (!confirm('Do you really want to kick: '+username+'?')) return false;

		var message = prompt('Kick reason (visible to the kicked user):');
		if (!message) return false;

		jQuery('#users-list li span:contains("'+username+'")').each(function()
		{
			if (jQuery(this).text() === username)
			{
				// kick the user.
				var el = jQuery(this);
				var timestamp = new Date().getTime();
				jQuery.post(server_path+'ajax/chat.php', {'action': 'kick', 'message': message, 'username': username, 'password': '', time: timestamp}, function(response)
				{
					if (response == '1')
					{
						el.parent().fadeOut();
						Chat._show_new_message (false, '', '', '<strong>'+username+'</strong> has been kicked.', '', '', 'system');
					}
				});
			}
		});
	},

	// Bans the user
	ban: function(username, uid)
	{
		if (is_admin == false) return false;
		 
		if (!confirm('Do you really want to ban: '+username+'?')) return false;

		var message = prompt('Ban reason (visible to the banned user):');
		if (!message) return false;

		jQuery('#users-list li span:contains("'+username+'")').each(function()
		{
			if (jQuery(this).text() === username)
			{
				// ban the user.
				var el = jQuery(this);
				var timestamp = new Date().getTime();
				jQuery.post(server_path+'ajax/chat.php', {'action': 'ban', 'message': message, 'username': username, 'password': '', time: timestamp, userid: uid}, function(response)
				{
					if (response == '1')
					{
						el.parent().fadeOut();
						Chat._show_new_message (false, '', '', '<strong>'+username+'</strong> has been banned for 1 week.', '',  '', 'system');
					}
				});
			}
		});
	},

	// Starts the chat
	init: function(username)
	{
	 	  
		if (this._already_inited) return false;
		if (/^\s*$/.test(username)) return false;

		var timestamp = new Date().getTime();
		jQuery.post(server_path+'ajax/chat.php', {'action': 'check_username', 'username': username, time: timestamp}, function(username_available)
		{
			if (username_available == '0')
			{
				jQuery('#error').text('Username already exists. Please wait 30 seconds and try again.').hide().fadeIn();
				return;
			}
 
				var timestamp = new Date().getTime();
				jQuery('#wlt_chatwindow').load(server_path+'chat_window.html?time='+timestamp, function()
				{
					this._already_inited = true;
					Chat._username = username;

					jQuery(window).bind('resize', function()
					{
						Chat.scale_window();
					});
					setTimeout(function(){Chat.scale_window();}, 200);

					// scale window few times due to IE bug
					if (jQuery.browser.msie && parseInt(jQuery.browser.version) <= 7)
					{
						var scale_counter = 8;
						while (--scale_counter) Chat.scale_window();
					} 

					// focus message input
					// setTimeout used because of IE7 bug
					setTimeout(function(){jQuery('#message').focus();}, 500);

					jQuery('#send-message button').click(function()
					{					 
						Chat.send_message();
					});
					jQuery('#message').keydown(function(e)
					{
						var key = e.charCode || e.keyCode || 0;

						if (key === 13)
						{
							Chat.send_message();
						}
					});

					Chat.get_date();
					Chat.load_users();

					setInterval(function() { Chat.ping(); }, 1500);
					setInterval(function() { Chat.update_users_list(); }, 5000);
				});
			 
		});
	}
};