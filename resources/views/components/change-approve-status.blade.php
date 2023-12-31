@props(['url',
'selectorBtn'=>".is_approve"]
)
@isset($url)
<script>
    // change approve status
    $('body').on('change', '{{$selectorBtn}}', function () {
        let status = $(this).val();
        let id = $(this).data('id');

        $.ajax({
            url: "{{$url}}",
            method: 'PUT',
            data: {
                status: status,
                id: id
            },
            success: function (data) {
                Swal.fire(
                    'Updated!',
                    data.message,
                    'success'
                )
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        })

    })
</script>
@endisset
