jQuery(document).ready(function ($) {
    //
    // Homepage start
    //
    $("#shorten_url_form").submit(function (e) {
        e.preventDefault()
        var form_data = $(this).serialize()
        $("#shorten-btn").addClass("animated loading u-center loading-white hide-text")

        $.post(
            '/api/addlink',
            form_data,
            function (data) {
                data = JSON.parse(data)
                if (data.success) {
                    $("#shortened_link").text(data.full_link)
                    $("#open_in_new_tab").attr("href", data.full_link)
                    $(".result").fadeIn(10)
                } else {
                    $(".shorten-error").show();
                    $(".error-warning").text(data.message).fadeIn(10)
                }
            })
    })

    $(document).ajaxStop(function () {
        $("#shorten-btn").removeClass("animated loading u-center loading-white hide-text")
    })

    $(".copy").click(function (e) {
        e.preventDefault()
        navigator.clipboard.writeText($("#shortened_link").text());
        $(".copy").text("Copied!")
        setTimeout(() => {
            $(".copy").text("Copy")
        }, 4000)
    })

    $(document).on("click", ".btn-close", function (e) {
        $(this).parent().hide();
    })
    //
    // Homepage End
    //


    //
    // Login & register start
    //

    $("#login-form").submit(function (e) {
        e.preventDefault()
        var form_data = $(this).serialize()
        $("#login-btn").addClass("animated loading u-center loading-white hide-text")

        $.post(
            '/accounts/login',
            form_data,
            function (data) {
                data = JSON.parse(data)
                if (data.success) {
                    location.reload()
                } else {
                    $(".login-result").text(data.message).fadeIn(10)
                }
            })
    })

    $("#register-form").submit(function (e) {
        e.preventDefault()
        var form_data = $(this).serialize()
        $("#register-btn").addClass("animated loading u-center loading-white hide-text")

        $.post(
            '/accounts/register',
            form_data,
            function (data) {
                data = JSON.parse(data)
                if (data.success) {
                    location.reload()
                } else {
                    $(".register-result").text(data.message).fadeIn(10)
                }
            })
    })

    $("#logout-btn").click(function (e) {
        e.preventDefault()
        $.post(
            '/accounts/logout',
            {},
            function (data) {
                data = JSON.parse(data)
                if (data.success) {
                    location.reload()
                }
            })
    })

    $(document).ajaxStop(function () {
        $("#login-btn").removeClass("animated loading u-center loading-white hide-text")
    })


    //
    // Login & register end
    //


    //
    // Links start
    //
    $(".copy-link").click(function (e) {
        e.preventDefault()
        navigator.clipboard.writeText($(this).parent().find('.copy-this').val());
        $(".copy-link").removeClass('btn-success')
        $(this).attr('data-tooltip', 'Copied!')
        $(this).addClass('btn-success')

        setTimeout(() => {
            $(this).attr('data-tooltip', 'Copy')
            $(this).removeClass('btn-success')
        }, 2000)
    })

    $(".delete-link-btn").click(function (e) {
        var row = $(this).closest("tr")
        var hash_id = row.data("hash-id")
        var link = row.find(".shortened-link").val()
        if (!hash_id) return
        $("#link-to-be-deleted").text(link)
        $("#confirm-delete-link-btn").data("hash-id", hash_id)
    })

    $("#confirm-delete-link-btn").click(function (e) {
        var hash_id = $("#confirm-delete-link-btn").data("hash-id")
        var api_key = $("#api-key").val()
        if (!hash_id || !api_key) return
        $.post(
            '/api/deletelink',
            {
                api_key: api_key,
                link_hash_id: hash_id
            },
            function (data) {
                data = JSON.parse(data)
                if (data.success) {
                    closeModals()
                    $(`tr[data-hash-id=${hash_id}]`).remove()
                }
            })
    })



    //
    // Links end
    //

    function closeModals() {
        for (const modal of $('.modal-overlay')) {
            modal.click()
        }
    }
})