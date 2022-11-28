<head>
    <style>
        body{background-color: black; }
        .form-control{
            border-radius: 5px;
            font-size: 14px !important;
            padding: 10px 5px;
            border: 1px solid rgba(0,0,0,0.3);
            margin-bottom: 0.7em;
        }
        .form-control:focus{
            font-size: 14px !important;
            border: 1px solid rgba(0,0,0,0.3);
            outline: none;
        }
        .container{
            width: 70vw;
            max-width: 500px;
            background-color: white;
            border-radius: 5px;
            padding: 10px ;
            margin:auto;
            margin-top: 5vh;
            height: 80vh;
            position: relative;
        }
        .f{width:70vw; max-width: fit-content; margin:  auto; text-align: center}
        .btnlogindef {
            padding: 8px 80px;
            font-family: 'open_sans_semibold';
            background: #021019;
            border-color: #137993;
            -webkit-transition: all .4s ease-in-out;
            -moz-transition: all .4s ease-in-out;
            -o-transition: all .4s ease-in-out;
            transition: all .4s ease-in-out;
            box-shadow: 1px 1px 12px rgb(204 204 204 / 10%);
            color: white;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .f>img{max-width: 50%;}
        .container>p{
            position: absolute;
            bottom: 0;
            font-size: 0.8rem;
            color: grey;
            text-align: center;
            max-width: calc(100% - 20px);
        }
        #error-message{color:red; font-style: italic;}
    </style>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="f" id="f-form">
            <img src="{{asset('assets/images/logodost2.png')}}" alt="">
            <h3 style="margin-top:0">DRRMIS Login</h3>
            <p id="error-message"></p>
            <form id="lcf" action="{{route('c-login')}}" method="POST">
                <input class="form-control" id="lc_username" type="text" name="login" placeholder="Username" required><br>
                <input class="form-control" id="lc_password" type="password" name="password" placeholder="Password" required><br>
                <button type="submit" id="sub" class="btn btnlogindef">Submit</button>
            </form>
        </div>
        <div class="f" id="f-response" style="display: none">
            <img style="margin-top: 30%" src="{{asset('assets/images/check.png')}}" alt="" id="response-img-1">
            <h1 id="response"></h1>
        </div>
        <div class="f" id="f-over" style="display: none">
            <h4>Account already logged in on another device.</h4>
            <p>If you wish to continue, you will be logged out of other devices.</p>
            <button class="btn btnlogindef" id="btn-over">Continue</button>
        </div>
        <p>Note: You need an official DRRMIS - CAR account in order to upload CLEARS data.</p>
    </div>
    
</body>



<script>
    $(document).on('submit','#lcf',function(e){
        e.preventDefault();
        let form = $('#lcf')[0];
        let fd = new FormData(form);
        let url = $(this).attr('action');
        $.ajax({
            type:"POST",
            url: url,
            data: fd,
            contentType: false,
            processData: false,
            headers: {"Authorization":"27153b832d91f0d214ba110e0edbaf7004151923c66daabdd0bf308496c450e6"},
            success: (response,status,xhr) => {
                if(response.error != null || response.error != undefined){
                    if(response.error == 1){ // already logged in
                        $('.f:not(#f-response)').hide();
                        $('#f-over').show();
                    }else if(response.error == 2){ // invalid log in
                        $('#error-message').text(response.message)
                    }else{

                    }
                }else{
                    $('.f:not(#f-response)').hide();
                    $('#response').text(response.message);
                    $('#f-response').show();
                }
                


            }
        })
    }).on('click','#btn-over',function(e){
        $('#lcf').append('<input type="hidden" name="overwrite" value="true">');
        $('#lcf').submit();
    })
    
</script>