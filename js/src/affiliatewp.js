jQuery(document).ready(function($) {

	$('.scroll').click(function(event) {
		event.preventDefault();
		var offset = $($(this).attr('href')).offset().top;
		$('html, body').animate({scrollTop:offset}, 800);
	});


	// add loaded class
	jQuery('body').addClass('loaded');

    $( "#cta .button" ).hover(
      function() {
        $('body').addClass('cta');
      }, function() {
        $('body').removeClass('cta');
      }
    );

	// how it works
    $('#how-it-works').on( 'click', function(e) {
        e.preventDefault();

        $(this).next().fadeIn();
        $(this).remove();
    });

	// add class to imagess so we can open modal window
	$("a[href$='.jpg'], a[href$='.png'], a[href$='.gif']").addClass( 'enlarge' );

	// animates the affiliate header when the mouse enters the header
	$('.page-template-page-templatesaffiliates-php .affiliates-header').one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(e) {
		$(this).addClass( 'can-hover' );
	});

});
