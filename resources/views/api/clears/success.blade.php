<style>
    .f{width:70vw; max-width: fit-content; margin:  auto; text-align: center}
    .f>img{max-width: 50%;}
    .container>p{
        position: absolute;
        bottom: 0;
        font-size: 0.8rem;
        color: grey;
        text-align: center;
        max-width: calc(100% - 20px);
    }
    body{background-color: black; }
</style>
<div>
    <div class="container">
        <div class="f">
            <img style="margin-top: 30%" src="{{asset('assets/images/check.png')}}" alt="">
            <h1>{{$message}}</h1>
        </div>
    </div>
    

</div>


