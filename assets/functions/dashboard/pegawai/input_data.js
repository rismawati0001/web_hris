function save_data_pegawai() {

    $('#loader_process').show();
    var url = baseURL + "pegawai_save_data";

    $.ajax({
        url: url,
        type: "POST",
        data: { ajaxSrcInput: $("#txt_nama_pegawai").val(),
                ajaxSrcInput: $("#txt_nama_pegawai").val()
         },
        async: true,
        dataType: "JSON",
        success: function (data) {
            $('#loader_process').hide();
            if (data['status_field_old'] != "") {
                $('#name-error-old-pass').css('display', 'block');
                $('#name-error-old-pass').html(data['status_field_old']);
            } else {
                $('#name-error-old-pass').css('display', 'none');
            }

            if (data['status_field_new'] != "") {
                $('#name-error-new-pass').css('display', 'block');
                $('#name-error-new-pass').html(data['status_field_new']);
            } else {
                $('#name-error-new-pass').css('display', 'none');
            }

            if (data['status_field_conf'] != "") {
                $('#name-error-conf-pass').css('display', 'block');
                $('#name-error-conf-pass').html(data['status_field_conf']);
            } else {
                $('#name-error-conf-pass').css('display', 'none');
            }
            if (data['status_field'] == "success") {
                $('#modal_form_change_password').modal('hide');
                showSuccessMessageX();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
            $('#loader_process').hide();
        }
    });
}