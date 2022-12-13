// Here we have true facts about the confetti bits javascript shenanigans

jQuery( document ).ready( function( $ ) {

	var requestAmount = $('#cb_request_option'),
		memberSelect = $('.memberSelect'),
		memberName = $('.memberName'),
		memberAvatar = $('.cb-search-results-avatar'),
		submitMessage = $('.submission-message-popup'),
		//		requestSubmitConfirm = $('#send_bits_request'),
		requestSubmitConfirm = $('#cb_request_form'),

		transferToID = document.querySelector("#transfer_user_id"),
		sendToID = document.querySelector("#recipient_id"),
		transferToName = document.querySelector("#transfer_member_display_name"),
		sendToName = document.querySelector("#recipient_name"),
		sendToAmount = document.querySelector("#cb_request_amount"),
		closeNoticeContainer = $('.cb-close-notice-container');

	let activeTab = window.location.hash;

	const $hubNav			= $('.cb-hub-nav-container');

	if ( activeTab ) {

		let $tab	= $($hubNav).find('div.cb-hub-nav-item.active');
		let $link	= $tab.find('a');
		let $module	= $($link.attr('href'));
		let $activeModule	= $('.cb-container.active');

		$tab.removeClass('active');
		$activeModule.removeClass('active');
		
		$module = $(activeTab).addClass('active');
		$tab	= $("a[href='" + activeTab + "']").parent().addClass('active');
		
	}

	$($hubNav).each( function() {

		let $this	= $(this);									
		let $tab	= $this.find('div.cb-hub-nav-item.active');	
		let $link	= $tab.find('a');
		let $module	= $($link.attr('href'));

		$this.on('click', '.cb-hub-nav-link', function ( e ) {
			e.preventDefault();
			let $link	= $(this);
			let id		= this.hash;

			if ( id && ! $link.is('.active') ) {

				$module.removeClass('active');	
				$tab.removeClass('active');

				$module = $(id).addClass('active');
				$tab	= $link.parent().addClass('active');

			}

		});

	});


	closeNoticeContainer.click( function() {
		closeNoticeContainer.parents('.cb-notice').slideUp( function(){
			closeNoticeContainer.parents('.cb-notice').remove();
			return false;
		});
	});

	requestSubmitConfirm.submit( function() {

		if ( confirm("Are you sure you want to spend " + sendToAmount.value + " Confetti Bits? They will be deducted from your total balance and will no longer count toward future purchases.") ) {

			return true;

		} else {

			return false;

		}

	});	

	submitMessage.ready().fadeIn();

	memberSelect.ready().delay().slideDown( function(){

		memberSelect.css({'display':'flex','transition':'.25s ease-in-out'});

		memberAvatar.ready().delay().fadeIn( function(){
			memberAvatar.css({'display':'flex','transition':'.25s ease-in-out'});
		});

		memberName.ready().delay().fadeIn( function(){
			memberName.css({'display':'flex','transition':'.25s ease-in-out'});
		});

	});

	memberSelect.click(function () {

		var memberData = jQuery(this).data('member-id');
		var memberNameData = jQuery(this).data('member-display-name');
		var that = jQuery('.memberSelect').not( this );

		switch ( true ) {

			case that.hasClass('isSelected'):

				jQuery('.memberSelect').removeClass('isSelected');
				jQuery(this).addClass('isSelected');

				if ( jQuery(this).hasClass('send-bits') ) {
					sendToID.value = memberData;
					sendToName.value = memberNameData;
				} else if ( jQuery(this).hasClass('transfer-member') ) {
					transferToID.value = memberData;
					transferToName.value = memberNameData;
				} else {
					return false;
				}


				break;

			case jQuery(this).hasClass('isSelected'):
				jQuery(this).removeClass('isSelected');
				sendToID.value = '';
				sendToName.value = '';
				transferToID.value = '';
				transferToName.value = '';

				break;

			default:

				jQuery(this).addClass('isSelected');

				if ( jQuery(this).hasClass('send-bits') ) {
					sendToID.value = memberData;
					sendToName.value = memberNameData;

					console.log(sendToName.value);
				} else if ( jQuery(this).hasClass('transfer-member') ) {
					transferToID.value = memberData;
					transferToName.value = memberNameData;
				} else {
					return false;
				}

				break;
		}
	});

	function unReadNotifications () {
		var notification_queue = [];
		$( document ).on(
			"click",
			".cb-read-all-notifications",
			function ( e ) {
				var data = {
					'action': 'buddyboss_theme_unread_notification',
					'notification_id': $( this ).data( 'notification-id' )
				};
				if ( notification_queue.indexOf( $( this ).data( 'notification-id' ) ) !== -1 ) {
					return false;
				}
				notification_queue.push( $( this ).data( 'notification-id' ) );
				var notifs = $( '.bb-icon-bell' );
				var notif_icons = $( notifs ).parent().children( '.count' );
				if ( notif_icons.length > 0 ) {
					if ( $( this ).data( 'notification-id' ) !== 'all' ) {
						notif_icons.html( parseInt( notif_icons.html() ) - 1 );
					} else {
						if ( parseInt( $( '#header-notifications-dropdown-elem ul.notification-list li' ).length ) < 25 ) {
							notif_icons.fadeOut();
						} else {
							notif_icons.html( parseInt( notif_icons.html() ) - parseInt( $( '#header-notifications-dropdown-elem ul.notification-list li' ).length ) );
						}
					}
				}
				if ( $( '.notification-wrap.menu-item-has-children.selected ul.notification-list li' ).length !== 'undefined' && $( '.notification-wrap.menu-item-has-children.selected ul.notification-list li' ).length == 1 || $( this ).data( 'notification-id' ) === 'all' ) {
					$( '#header-notifications-dropdown-elem ul.notification-list' ).html( '<p class="bb-header-loader"><i class="bb-icon-loader animate-spin"></i></p>' );
				}
				if ( $( this ).data( 'notification-id' ) !== 'all' ) {
					$( this ).parent().parent().fadeOut();
					$( this ).parent().parent().remove();
				}
				$.post(
					ajaxurl,
					data,
					function ( response ) {
						var notifs = $( '.bb-icon-bell' );
						var notif_icons = $( notifs ).parent().children( '.count' );
						if ( notification_queue.length === 1 && response.success && typeof response.data !== 'undefined' && typeof response.data.contents !== 'undefined' && $( '#header-notifications-dropdown-elem ul.notification-list' ).length ) {
							$( '#header-notifications-dropdown-elem ul.notification-list' ).html( response.data.contents );
						}
						if ( typeof response.data.total_notifications !== 'undefined' && response.data.total_notifications > 0 && notif_icons.length > 0 ) {
							$( notif_icons ).text( response.data.total_notifications );
							$( '.notification-header .cb-read-all-notifications' ).show();
						} else {
							$( notif_icons ).remove();
							$( '.notification-header .cb-read-all-notifications' ).fadeOut();
						}
						var index = notification_queue.indexOf( $( this ).data( 'notification-id' ) );
						notification_queue.splice( index, 1 );
					}
				);
			}
		);
	}

	unReadNotifications();

	requestAmount.change(function() {

		var requestData = jQuery(this).find(':selected').data('request-value');

		sendToAmount.value = requestData;

	});



});