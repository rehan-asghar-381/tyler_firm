<!-- All Javascript Plugin File here -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/validate.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/jquery.uploader.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<script type="application/javascript">
    $(document).ready(function(){
        $('.flatpickr').flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d h:i",
        });

        function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
            $('#previewHolder').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            alert('select a file to see preview');
            $('#previewHolder').attr('src', '');
        }
        }

        $("#filePhoto").change(function() {
        readURL(this);
        });

        // let ajaxConfig = {
        //     ajaxRequester: function (config, uploadFile, pCall, sCall, eCall) {
        //         let progress = 0
        //         let interval = setInterval(() => {
        //             progress += 10;
        //             pCall(progress)
        //             if (progress >= 100) {
        //                 clearInterval(interval)
        //                 const windowURL = window.URL || window.webkitURL;
        //                 sCall({
        //                     data: windowURL.createObjectURL(uploadFile.file)
        //                 })
        //             }
        //         }, 300)
        //     }
        // }

        // $("#demo2").uploader({ajaxConfig: ajaxConfig});

        
    });
    
</script>