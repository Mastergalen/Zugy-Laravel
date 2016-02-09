<script>
    if (document.cookie.indexOf("postcode") < 0) {
        swal({
            title: "{!! trans('forms.prompts.postcode') !!}",
            text: '{!! trans('forms.prompts.postcode.desc') !!}',
            type: 'input',
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function (input) {
            if (input == '') {
                swal.showInputError('{!! trans('forms.prompts.postcode') !!}');
                return false;
            }

            postcode.check(input, false);
        });
    }
</script>