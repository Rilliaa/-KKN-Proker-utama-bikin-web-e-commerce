$(document).ready(function() {
    $('#myModal').on('shown.bs.modal', function () {
        $('#jam_ke').focus();
    });

    $('#myModal').on('hidden.bs.modal', function () {
        $(this).find('form').trigger('reset');
    });

    $('#saveChangesBtn').click(function() {
        var hari = $('#hari_modal').val();
        var jamKe = $('#jam_ke').val();
        var jamMulai = $('#jam_mulai').val();
        var jamSelesai = $('#jam_selesai').val();
        var keterangan = $('#keterangan').val();

        $.ajax({
            url: '{{ route("jam.store") }}',
            type: 'POST',
            data: {
                jam_ke: jamKe,
                jam_mulai: jamMulai,
                jam_selesai: jamSelesai,
                keterangan: keterangan,
                hari: hari,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // var tambahBarisButton = document.getElementById("tambahBarisButton");
    // tambahBarisButton.addEventListener("click", TambahBaris, false);
    // function TambahBaris(hari) {
    //     if (!hari) {
    //         console.error("Hari tidak valid.");
    //         return;
    //     }

    //     $('#hari_modal').val(hari);
    //     $('#tambah-jam-form').trigger('reset');

    //     var table = document.getElementById("example2").getElementsByTagName('tbody')[0];
    //     var newRow = table.insertRow(table.rows.length);

    //     if (table.rows.length % 2 === 0) {
    //         var cellNo = newRow.insertCell(0);
    //         cellNo.textContent = table.rows.length / 2;
    //     }

    //     if (table.rows.length % 2 === 0) {
    //         var cellHari = newRow.insertCell(1);
    //         cellHari.textContent = hari;
    //     }

    //     var cellJamKe = newRow.insertCell(-1);
    //     cellJamKe.innerHTML = '<input type="text" class="form-control" name="jam_ke[]">';

    //     var cellJamMulai = newRow.insertCell(-1);
    //     cellJamMulai.innerHTML = '<input type="time" class="form-control" name="jam_mulai[]">';

    //     var cellJamSelesai = newRow.insertCell(-1);
    //     cellJamSelesai.innerHTML = '<input type="time" class="form-control" name="jam_selesai[]">';

    //     var cellKeterangan = newRow.insertCell(-1);
    //     cellKeterangan.innerHTML = '<input type="text" class="form-control" name="keterangan[]">';
    // }
   
});