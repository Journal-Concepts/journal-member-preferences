!function($){"use strict";$((function(){$(".putter-type-preference").submit((function(e){e.preventDefault();var t=$("[name='putter-type']:checked").val();!function(e,t){HoldOn.open({message:"Setting your putter type preference"});var n={action:"jc_set_putter_type",putter_type:t,nonce:e};$.post(jc_member_preferences.ajaxurl,n,(function(e){var t=$(e).find("response_data").text(),n=$(e).find("supplemental message").text(),s=$(".message");"success"===t?(s.removeClass("alert").addClass("success"),s.html(n).slideDown(),$(".putter-type-preference").hide(),HoldOn.close()):(s.html(n).slideDown(),HoldOn.close())}))}($("#_wpnonce").val(),t)})),$(".headcover-preference").submit((function(e){e.preventDefault();var t=$("[name='headcover']:checked").val();!function(e,t){HoldOn.open({message:"Setting your headcover preference"});var n={action:"jc_set_headcover",headcover:t,nonce:e};$.post(jc_member_preferences.ajaxurl,n,(function(e){var t=$(e).find("response_data").text(),n=$(e).find("supplemental message").text(),s=$(".message");"success"===t?(s.removeClass("alert").addClass("success"),s.html(n).slideDown(),$(".headcover-preference").hide(),HoldOn.close()):(s.html(n).slideDown(),HoldOn.close())}))}($("#_wpnonce").val(),t)}))}))}(jQuery);