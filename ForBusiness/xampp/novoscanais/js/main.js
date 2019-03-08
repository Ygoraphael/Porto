jQuery(function ($) {
    'use strict',
            //#main-slider
            $(function () {
                $('#main-slider.carousel').carousel({
                    interval: 8000
                });
            });
    // accordian
    $('.accordion-toggle').on('click', function () {
        $(this).closest('.panel-group').children().each(function () {
            $(this).find('>.panel-heading').removeClass('active');
        });

        $(this).closest('.panel-heading').toggleClass('active');
    });

    //Initiat WOW JS
    new WOW().init();

    // portfolio filter
    $(window).load(function () {
        'use strict';
        var $portfolio_selectors = $('.portfolio-filter >li>a');
        var $portfolio = $('.portfolio-items');
        $portfolio.isotope({
            itemSelector: '.portfolio-item',
            layoutMode: 'fitRows'
        });

        $portfolio_selectors.on('click', function () {
            $portfolio_selectors.removeClass('active');
            $(this).addClass('active');
            var selector = $(this).attr('data-filter');
            $portfolio.isotope({filter: selector});
            return false;
        });
    });


    // drivefx filter
    $(window).load(function () {
        'use strict';
        var $drivefx_selectors = $('.drivefx-filter >li>a');
        var $drivefx = $('.drivefx-items');
        $drivefx.isotope({
            itemSelector: '.drivefx-item',
            layoutMode: 'fitRows'
        });

        $drivefx_selectors.on('click', function () {
            $drivefx_selectors.removeClass('active');
            $("div").removeClass('hidden3');
            $(this).addClass('active');
            var selector = $(this).attr('data-filter');
            $drivefx.isotope({filter: selector});
            return false;
        });
    });
    // pagamento filter
    $(window).load(function () {
        'use strict';
        var $pagamento_selectors = $('.pagamento-filter >li>a');
        var $pagamento = $('.pagamento-items');
        $pagamento.isotope({
            itemSelector: '.pagamento-item',
            layoutMode: 'fitRows'
        });
        $pagamento_selectors.on('click', function () {
            $pagamento_selectors.removeClass('active');
            $("div").removeClass('hidden3');
            $(this).addClass('active');
            var selector = $(this).attr('data-filter');
            $pagamento.isotope({filter: selector});
            return false;
        });
    });
    // Contact form
    var form = $('#main-contact-form');
    form.submit(function (event) {
        event.preventDefault();
        var form_status = $('<div class="form_status"></div>');
        $.ajax({
            url: $(this).attr('action'),

            beforeSend: function () {
                form.prepend(form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Email is sending...</p>').fadeIn());
            }
        }).done(function (data) {
            form_status.html('<p class="text-success">' + data.message + '</p>').delay(3000).fadeOut();
        });
    });

    $("#gototop").click(function() {
      $("html, body").animate({ scrollTop: 0 }, 1500);
    });

    //Pretty Photo
    $("a[rel^='prettyPhoto']").prettyPhoto({
        social_tools: false
    });
});

$(function () {
    $("#gotofunc").click(function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: $(".get-started").offset().top -100
        }, 1000);
    });
})
$(function () {
    $("#gotocont").click(function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: $("#contact-page").offset().top - 100
        }, 1000);
    });
})
$(function () {
    $("#gotodfx").click(function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: $("#drivefx").offset().top - 100
        }, 1000);
    });
})
$(function () {
      $("#down2").click(function (e) {
          e.preventDefault();
          $('html,body').animate({
              scrollTop: $(".pricing-page").offset().top - 100
          }, 1000);
      });
  })
  $(function () {
      $("#gotodrvfx").click(function (e) {
          e.preventDefault();
          $('html,body').animate({
              scrollTop: $(".get-started").offset().top - 100
          }, 1000);
      });
  })
  $(function () {
        $("#gotopagamento").click(function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: $("#drivefx").offset().top - 130
            }, 1000);
        });
    })
$(function () {
      $("#gotoerp").click(function (e) {
          e.preventDefault();
          $('html,body').animate({
              scrollTop: $("#erp").offset().top - 100
          }, 1000);
      });
  })
  $(function () {
        $("#gotofinan").click(function (e) {
            e.preventDefault();
            $('html,body').animate({
                scrollTop: $("#finan").offset().top - 100
            }, 1000);
        });
    })
    $(function () {
          $("#gotorh").click(function (e) {
              e.preventDefault();
              $('html,body').animate({
                  scrollTop: $("#rh").offset().top - 100
              }, 1000);
          });
      })
      $(function () {
            $("#gotosuporte").click(function (e) {
                e.preventDefault();
                $('html,body').animate({
                    scrollTop: $("#suporte").offset().top - 100
                }, 1000);
            });
        })
        $(function () {
              $("#gotocrm").click(function (e) {
                  e.preventDefault();
                  $('html,body').animate({
                      scrollTop: $("#crm").offset().top - 100
                  }, 1000);
              });
          })
          $(function () {
                $("#gotoproj").click(function (e) {
                    e.preventDefault();
                    $('html,body').animate({
                        scrollTop: $("#proj").offset().top - 100
                    }, 1000);
                });
            })
            $(function () {
                  $("#gotofrot").click(function (e) {
                      e.preventDefault();
                      $('html,body').animate({
                          scrollTop: $("#frot").offset().top - 100
                      }, 1000);
                  });
              })
              $(function () {
                    $("#gotoind").click(function (e) {
                        e.preventDefault();
                        $('html,body').animate({
                            scrollTop: $("#ind").offset().top - 100
                        }, 1000);
                    });
                })
                $(function () {
                      $("#gotologis").click(function (e) {
                          e.preventDefault();
                          $('html,body').animate({
                              scrollTop: $("#logis").offset().top - 100
                          }, 1000);
                      });
                  })
                  $(function () {
                        $("#gotorest").click(function (e) {
                            e.preventDefault();
                            $('html,body').animate({
                                scrollTop: $("#rest").offset().top - 100
                            }, 1000);
                        });
                    })
                    $(function () {
                          $("#gotoreta").click(function (e) {
                              e.preventDefault();
                              $('html,body').animate({
                                  scrollTop: $("#reta").offset().top - 100
                              }, 1000);
                          });
                      })
                      $(function () {
                            $("#gotoconst").click(function (e) {
                                e.preventDefault();
                                $('html,body').animate({
                                    scrollTop: $("#const").offset().top - 100
                                }, 1000);
                            });
                        })
                        $(function () {
                              $("#gotoclinica").click(function (e) {
                                  e.preventDefault();
                                  $('html,body').animate({
                                      scrollTop: $("#clinica").offset().top - 100
                                  }, 1000);
                              });
                          })
