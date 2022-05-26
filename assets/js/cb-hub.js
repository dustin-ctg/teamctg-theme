// Here we have true facts about the confetti bits javascript shenanigans

jQuery(document).ready(function(){
	
	var requestAmount = jQuery('#cb_request_option');
	var memberSelect = jQuery('.memberSelect');
	var memberName = jQuery('.memberName');
	var memberAvatar = jQuery('.cb-search-results-avatar');
	var submitMessage = jQuery('.submission-message-popup');

	var transferToID = document.querySelector("#transfer_user_id");
	var sendToID = document.querySelector("#recipient_id");
	var transferToName = document.querySelector("#transfer_member_display_name");
	var sendToName = document.querySelector("#recipient_name");
	var sendToAmount = document.querySelector("#cb_request_amount");

	
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