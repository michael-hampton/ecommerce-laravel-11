/**
 * selectImages
 * menuleft
 * tabs
 * progresslevel
 * collapse_menu
 * fullcheckbox
 * showpass
 * gallery
 * coppy
 * select_colors_theme
 * icon_function
 * box_search
 * preloader
 */

;(function ($) {

    "use strict";

    var selectImages = function () {
        if ($(".image-select").length > 0) {
            const selectIMG = $(".image-select");
            selectIMG.find("option").each((idx, elem) => {
                const selectOption = $(elem);
                const imgURL = selectOption.attr("data-thumbnail");
                if (imgURL) {
                    selectOption.attr(
                        "data-content",
                        "<img src='%i'/> %s"
                            .replace(/%i/, imgURL)
                            .replace(/%s/, selectOption.text())
                    );
                }
            });
            selectIMG.selectpicker();
        }
    };

    var menuleft = function () {
        if ($('div').hasClass('section-menu-left')) {
            var bt = $(".section-menu-left").find(".has-children");
            bt.on("click", function () {
                var args = {duration: 200};
                if ($(this).hasClass("active")) {
                    $(this).children(".sub-menu").slideUp(args);
                    $(this).removeClass("active");
                } else {
                    $(".sub-menu").slideUp(args);
                    $(this).children(".sub-menu").slideDown(args);
                    $(".menu-item.has-children").removeClass("active");
                    $(this).addClass("active");
                }
            });
            $('.sub-menu-item').on('click', function (event) {
                event.stopPropagation();
            });
        }
    };

    var tabs = function () {
        $('.widget-tabs').each(function () {
            $(this).find('.widget-content-tab').children().hide();
            $(this).find('.widget-content-tab').children(".active").show();
            $(this).find('.widget-menu-tab').find('li').on('click', function () {
                var liActive = $(this).index();
                var contentActive = $(this).siblings().removeClass('active').parents('.widget-tabs').find('.widget-content-tab').children().eq(liActive);
                contentActive.addClass('active').fadeIn("slow");
                contentActive.siblings().removeClass('active');
                $(this).addClass('active').parents('.widget-tabs').find('.widget-content-tab').children().eq(liActive).siblings().hide();
            });
        });
    };

    $('ul.dropdown-menu.has-content').on('click', function (event) {
        event.stopPropagation();
    });
    $('.button-close-dropdown').on('click', function () {
        $(this).closest('.dropdown').find('.dropdown-toggle').removeClass('show');
        $(this).closest('.dropdown').find('.dropdown-menu').removeClass('show');
    });

    var progresslevel = function () {
        if ($('div').hasClass('progress-level-bar')) {
            var bars = document.querySelectorAll('.progress-level-bar > span');
            setInterval(function () {
                bars.forEach(function (bar) {
                    var t1 = parseFloat(bar.dataset.progress);
                    var t2 = parseFloat(bar.dataset.max);
                    var getWidth = (t1 / t2) * 100;
                    bar.style.width = getWidth + '%';
                });
            }, 500);
        }
    }

    var collapse_menu = function () {
        $(".button-show-hide").on("click", function () {
            $('.layout-wrap').toggleClass('full-width');
        })
    }

    var fullcheckbox = function () {
        $('.total-checkbox').on('click', function () {
            if ($(this).is(':checked')) {
                $(this).closest('.wrap-checkbox').find('.checkbox-item').prop('checked', true);
            } else {
                $(this).closest('.wrap-checkbox').find('.checkbox-item').prop('checked', false);
            }
        });
    };

    var showpass = function () {
        $(".show-pass").on("click", function () {
            $(this).toggleClass("active");
            var input = $(this).parents(".password").find(".password-input");

            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else if (input.attr("type") === "text") {
                input.attr("type", "password");
            }
        });
    }

    var gallery = function () {
        $(".button-list-style").on("click", function () {
            $(".wrap-gallery-item").addClass("list");
        });
        $(".button-grid-style").on("click", function () {
            $(".wrap-gallery-item").removeClass("list");
        });
    }

    var coppy = function () {
        $(".button-coppy").on("click", function () {
            myFunction()
        });

        function myFunction() {
            var copyText = document.getElementsByClassName("coppy-content");
            navigator.clipboard.writeText(copyText.text);
        }
    }

    var select_colors_theme = function () {
        if ($('div').hasClass("select-colors-theme")) {
            $(".select-colors-theme .item").on("click", function (e) {
                $(this).parents(".select-colors-theme").find(".active").removeClass("active");
                $(this).toggleClass("active");
            })
        }
    }

    var icon_function = function () {
        if ($('div').hasClass("list-icon-function")) {
            $(".list-icon-function .trash").on("click", function (e) {
                $(this).parents(".product-item").remove();
                $(this).parents(".attribute-item").remove();
                $(this).parents(".countries-item").remove();
                $(this).parents(".user-item").remove();
                $(this).parents(".roles-item").remove();
            })
        }
    }

    var box_search = function () {

        $(document).on('click', function (e) {
            var clickID = e.target.id;
            if ((clickID !== 's')) {
                $('.box-content-search').removeClass('active');
            }
        });
        $(document).on('click', function (e) {
            var clickID = e.target.class;
            if ((clickID !== 'a111')) {
                $('.show-search').removeClass('active');
            }
        });

        $('.show-search').on('click', function (event) {
                event.stopPropagation();
            }
        );
        $('.search-form').on('click', function (event) {
                event.stopPropagation();
            }
        );
        var input = $('.header-dashboard').find('.form-search').find('input');
        input.on('input', function () {
            if ($(this).val().trim() !== '') {
                $('.box-content-search').addClass('active');
            } else {
                $('.box-content-search').removeClass('active');
            }
        });

    }

    var retinaLogos = function () {
        var retina = window.devicePixelRatio > 1 ? true : false;
        if (retina) {
            if ($(".dark-theme").length > 0) {
                $('#logo_header').attr({src: 'images/logo/logo.png', width: '154px', height: '52px'});
            } else {
                $('#logo_header').attr({src: 'images/logo/logo.png', width: '154px', height: '52px'});
            }
        }
    };

    var preloader = function () {
        setTimeout(function () {
            $("#preload").fadeOut("slow", function () {
                $(this).remove();
            });
        }, 1000);
    };

    $(document).off('.edit');
    $(document).on('click', '.edit', function (event) {
        event.preventDefault();
        const id = $(this).data('id');
        const url = $(this).data('url');
        const route = url.replace('test', id)
        $.ajax({
            url: route,
            type: 'get',
            success: function (response) {
                $('#editModal .modal-body').html(response)
                $('#editModal').modal('show')
            }
        });
    });

    $('.add').on('click', function (event) {
        event.preventDefault();
        const route = $(this).attr('href')
        alert(route)
        $.ajax({
            url: route,
            type: 'get',
            success: function (response) {
                $('#addModal .modal-body').html(response)
                $('#addModal').modal('show')
            }
        });

    });

    $('.confirm-edit').on('click', function () {
        var form = $('#editModal .modal-body form')
        var formData = new FormData(document.querySelector('#editModal .modal-body form'))
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: formData,  // CSRF token for security
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                alert(response.success);
                $('#admin-table').DataTable().draw();
                $('#editModal').modal('hide')
            }
        });
    });

    $('input[type="search"]').on('keyup', function () {
        if($(this).val().length < 3) return
        $('#admin-table').DataTable().draw();
    })

    $('input[type="search"]').on("search", function() {
        $('#admin-table').DataTable().draw();
    });

    $('.confirm-add').on('click', function () {
        var form = $('#addModal .modal-body form')
        var formData = new FormData(document.querySelector('#addModal .modal-body form'))
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: formData,  // CSRF token for security
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#admin-table').DataTable().draw();
                $('#addModal').modal('hide')
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $('.invalid-feedback').remove();
                $.each(errors.errors, function (key, value) {
                    var error = '<span class="invalid-feedback">'+value[0]+'</span>'
                    var element = $('[name="'+key+'"]')
                    element.parent().append(error)
                    $('#' + key).parent().addClass('error');
                });
            }
        });
    });

    $(document).off('.delete');
    $(document).on('click', '.delete', function (event) {
        event.preventDefault();
        //var selectedForm = $(this).closest('form');
        const id = $(this).data('id');
        const url = $(this).data('url');
        swal({
            title: "Are you sure?",
            text: "You want to delete this record?",
            type: "warning",
            buttons: ["No!", "Yes!"],
            confirmButtonColor: '#dc3545'
        }).then(function (result) {
            if (result) {
                const route = url.replace('test', id)
                $.ajax({
                    url: route,
                    type: 'post',
                    data: {"_token": $('meta[name="csrf-token"]').attr('content'), '_method': 'DELETE'},  // CSRF token for security
                    success: function (response) {
                        $('#admin-table').DataTable().draw();
                    }
                });
            }
        });
    });


    // Dom Ready
    $(function () {
        selectImages();
        menuleft();
        tabs();
        progresslevel();
        collapse_menu();
        fullcheckbox();
        showpass();
        gallery();
        coppy();
        select_colors_theme();
        icon_function();
        box_search();
        retinaLogos();
        preloader();

    });

})(jQuery);
