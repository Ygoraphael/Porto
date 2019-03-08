/* Menu Pegajoso*/
var menu = document.getElementById('menu');
var alt = menu.offsetTop;
window.addEventListener('scroll', function(){
	if(window.pageYOffset > alt){
		menu.classList.add('fussion');
	}else{
		menu.classList.remove('fussion');
	}
})

    $(function () {
        $("#bempresa").click(function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: $("#empresa").offset().top + 300
            }, 1000);
        });
    })
     $(function () {
        $("#bserviço").click(function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: $("#servicos_home").offset().top - 200
            }, 1000);
        });
    })
    $(function () {
        $("#home").click(function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: $("#header").offset().top
            }, 1000);
        });
    })

	$(function () {
        $("#down").click(function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: $("#header").offset().top + 450
            }, 1000);
        });
    })




		    $(function () {
        $("#gototop2").click(function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: $("#header").offset().top
            }, 1000);
        });
    })

	    $(function () {
        $("#home2").click(function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: $("#header").offset().top
            }, 1000);
        });
    })
