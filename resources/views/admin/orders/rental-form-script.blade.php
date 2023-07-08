<script>
    $("#product_ids").select2();
    $('.flatpickr').flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d H:i",
    });
    $("#product_ids").on("select2:select", function (e){
        var product_id      = e.params.data.id;
        if(product_id != ""){
            $.ajax({
                url: "{{ route('admin.order.product') }}",
                type: "GET",
                data: {
                    product_id      : product_id
                },
                success: function(data) {
                    $('.accordion').append(data);   
                },
                beforeSend: function() {
                    $('.page-loader-wrapper').show();
                },
                complete: function(){
                    $('.page-loader-wrapper').hide();
                }
            });
        } 
    });
    $('#product_ids').on('select2:unselect', function (e) {
        var p_id        = "#product-detail-"+e.params.data.id;
        $(p_id).remove();
    });
    function required(seletor=""){

        $('.product-detail').find('.card').removeClass('has-error');
        let validated           = true;
        let flag                = 0;
        var flag_ids            = [];
        var order_type          = $('#order_type').val();
        if(order_type == ""){

            alert('Please select Order Type fisrt.');
            $('#order_type').addClass('has-error');
            if($('#order_type').hasClass('select2-hidden-accessible')){
                $('#order_type').closest('.p-div').find('.select2-selection--single').addClass('has-error');
            }
            validated   = false;

        }else{
            $('#order_type').removeClass('has-error');
            if($('#order_type').hasClass('select2-hidden-accessible')){
                $('#order_type').closest('.p-div').find('.select2-selection--single').removeClass('has-error');
            }
            
            $(".require").each(function(key, value){

                var value       = $(this).val();

                if(value == "" || value == null){
                    if($(this).hasClass('select2-hidden-accessible')){
                            $(this).closest('.p-div').find('.select2-selection--single').addClass('has-error');
                    }
                    if($(this).closest('.product-detail').length){
                        flag            = 1;
                        flag_ids.push($(this).closest('.product-detail').attr('id'));
                    }
                    $(this).addClass('has-error');
                    validated   = false;
                }else{

                    if($(this).hasClass('select2-hidden-accessible')){
                        $(this).closest('.p-div').find('.select2-selection--single').removeClass('has-error');
                    }
                    $(this).removeClass('has-error');
                        
                 }
            });
        }

        if(flag == 1){
            $.each(flag_ids, function(index, name){
                $('#'+name).find('.card').addClass('has-error');
            });
        }
        return validated;
    }

    $('#submit-form').click(function(event) {
        var validate = required();
        if (validate) {
            return true;
        }else{
            event.preventDefault();
        }

    });
    $(document).on('change', '.selling_price, .deposit', function(){

        var selling_price               = parseInt($(this).closest('.product-detail').find('.selling_price').val());
        var deposit                     = parseInt($(this).closest('.product-detail').find('.deposit').val());
        var balance                     = 0;

        balance                         = deposit-selling_price;

        $(this).closest('.product-detail').find('.balance').val(balance);

    });
    $(document).on('change', '.quantity', function(){

        var quantity                    = parseInt($(this).val());
        var price                       = parseInt($(this).closest('.product-detail').find('.inc-lusive-price').val());
        var new_price                   = quantity*price;

        $(this).closest('.product-detail').find('.price').val(new_price);

    });
</script>