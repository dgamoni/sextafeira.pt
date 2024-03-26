jQuery( document ).ready(function() {
	jQuery('.main__menu .main__menu__navbar li.logout a').click(function(){
		if ( false == confirm('Are you sure you want to log out?')){
			return false;
		}
	});
});