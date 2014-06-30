/**
 * Unicorn Admin Template
 * Version 2.0.1
 * Diablo9983 -> diablo9983@gmail.com
**/

$(document).ready(function(){
	if($(window).width()<769){
            console.log("no ceu tem pao?");
           setTimeout(function(){
               $(".filters").hide();
               $(".tabletools").remove();
              // $(".btr").remove();
               $("#style-switcher").hide();
           },300);
               
        }
	var ul = $('#sidebar > ul');	
	var ul2 = $('#sidebar li.open ul');

	// === jPanelMenu === //
	var jPM = $.jPanelMenu({
	    menu: '#sidebar',
	    trigger: '#menu-trigger'
	});

	// === Resize window related === //
	$(window).resize(function()
	{
		if($(window).width() > 480 && $(window).width() < 769)
		{	
                    
			ul2.css({'display':'none'});
			ul.css({'display':'block'});		
		}
		
		if($(window).width() <= 480)
		{
			ul.css({'display':'none'});
                        
			ul2.css({'display':'block'});
			if(!$('html').hasClass('jPanelMenu')) {
				jPM.on();
			}

			if($(window).scrollTop() > 35) {
				$('body').addClass('fixed');
			} 
			$(window).scroll(function(){
				if($(window).scrollTop() > 35) {
					$('body').addClass('fixed');
				} else {
					$('body').removeClass('fixed');
				}
			});
		} else {
			jPM.off();
		}
		if($(window).width() > 768)
		{
			ul.css({'display':'block'});
			ul2.css({'display':'block'});
			$('#user-nav > ul').css({width:'auto',margin:'0'});		}

	});
	
	
	if($(window).width() <= 480)
	{
		if($(window).scrollTop() > 35) {
			$('body').addClass('fixed');
                        
		} 
		$(window).scroll(function(){
			if($(window).scrollTop() > 35) {
				$('body').addClass('fixed');
			} else {
				$('body').removeClass('fixed');
			}
		});
		jPM.on();
	}

	if($(window).width() > 480)
	{
		ul.css({'display':'block'});
		jPM.off();
	}
	if($(window).width() > 480 && $(window).width() < 769) {
            
		ul2.css({'display':'none'});
	}

	// === Sidebar navigation === //
	
	$('li.submenu > a').click(function(e)
	{
		e.preventDefault();
		var submenu = $(this).siblings('ul');
		var li = $(this).parents('li');
		if($(window).width() > 480) {
			var submenus = $('#sidebar li.submenu ul');
			var submenus_parents = $('#sidebar li.submenu');
		} else {
			var submenus = $('#jPanelMenu-menu li.submenu ul');
			var submenus_parents = $('#jPanelMenu-menu li.submenu');
		}
		
		if(li.hasClass('open'))
		{
			if(($(window).width() > 768) || ($(window).width() <= 480)) {
				submenu.slideUp();
			} else {
				submenu.fadeOut(250);
			}
			li.removeClass('open');
		} else 
		{
			if(($(window).width() > 768) || ($(window).width() <= 480)) {
				submenus.slideUp();			
				submenu.slideDown();
			} else {
				submenus.fadeOut(250);			
				submenu.fadeIn(250);
			}
			submenus_parents.removeClass('open');		
			li.addClass('open');	
		}
	});

	// === Tooltips === //
	$('.tip').tooltip();	
	$('.btn-group a').tooltip({ placement: 'bottom' });	
	$('.tip-left').tooltip({ placement: 'left' });	
	$('.tip-right').tooltip({ placement: 'right' });	
	$('.tip-top').tooltip({ placement: 'top' });	
	$('.tip-bottom').tooltip({ placement: 'bottom' });	
		
	// === Style switcher === //
	$('#style-switcher i').click(function()
	{
		if($(this).hasClass('open'))
		{
			$(this).parent().animate({right:'-=220'});
			$(this).removeClass('open');
		} else 
		{
			$(this).parent().animate({right:'+=220'});
			$(this).addClass('open');
		}
		$(this).toggleClass('glyphicon-arrow-left');
		$(this).toggleClass('glyphicon-arrow-right');
	});
	
	$('#style-switcher a').click(function()
	{
                
		var style = $(this).attr('href').replace('#','');
                $.cookie("spage", style); 
        var checkboxClass = 'icheckbox_flat-'+style;
	var radioClass = 'iradio_flat-'+style;
	$('input[type=checkbox],input[type=radio]').iCheck({
    	checkboxClass: checkboxClass,
    	radioClass: radioClass
	});
		$('.skin-color').attr('href','/css/cursos/unicorn.'+style+'.css');
		$('.icheck-color').attr('href','/css/cursos/icheck/flat/'+style+'.css');
		$(this).siblings('a').css({'border-color':'transparent'});
		$(this).css({'border-color':'#aaaaaa'});
                
	});
});