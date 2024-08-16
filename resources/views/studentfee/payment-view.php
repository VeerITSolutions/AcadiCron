
<div class="content-wrapper" style="min-height: 946px;">

    <title>Atom Paynetz</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style type="text/css">
        ::selection {
            background-color: #E13300;
            color: white;
        }

        ::-moz-selection {
            background-color: #E13300;
            color: white;
        }
    </style>


    <div class="container my-5">
        <h3 class="">Student Pay</h3>
       
        <p>Pay Rs. <input class="form-control col-md-3" type="number" name="price"></p><br>
        
        <a name="" id="" class="btn btn-primary" href="javascript:openPay()" role="button">Pay Now</a>
    </div>

    
    <!--Atom payment cdn-->
    <script src="https://pgtest.atomtech.in/staticdata/ots/js/atomcheckout.js"></script>
    
    <script>
        function openPay() {
        	
        

            const options = {
                "atomTokenId": "<?= $atomTokenId ?>",
                "merchId": "8952",
                "custEmail": "test@gmail.com",
                "custMobile": "8976286911",
                "returnUrl": "<?= base_url(); ?>/studentfee/confirm"
            }
            let atom = new AtomPaynetz(options, 'uat');
        }
    </script>
</div>


