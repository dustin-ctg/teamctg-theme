// Here we have true facts about the confetti bits javascript shenanigans

jQuery(document).ready(function($){

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


	// Member search module

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

	requestAmount.change(function() {

		var requestData = jQuery(this).find(':selected').data('request-value');

		sendToAmount.value = requestData;

	});
});