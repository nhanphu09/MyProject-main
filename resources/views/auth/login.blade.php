<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"  href="{{ asset('css/login.css') }}">
    <title>Login</title>
</head>
<body>
    <section>
        <div class="box">
            <h1>Sign In</h1>

            <form action="{{route('login.action')}}" method="post" class="box-log">
                @csrf
                <div class="box-log-lbl">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" required="">
                </div>
                
                <div class="box-log-lbl">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required="">
                    @if (session('error'))
                        <span class="error-message">{{ session('error') }}</span>
                    @endif
                </div>

                <div class="box-check">
                    <div class="checkbox">
                        <div>
                            <input type="checkbox" name="remember" id="remember">
                        </div>
                        <div>
                            <label for="remember">Remember me</label>
                        </div>
                    </div>
                    <a href="#">Forget password?</a>
                </div>
                <button>Sign In</button>
                <p>Don't have an account yet? <a href="{{route('register')}}">Sign up</a></p>
            </form>
        </div>
    </section>

   
</body>
</html>
