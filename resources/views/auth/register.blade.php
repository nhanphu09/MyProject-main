<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"  href="{{ asset('css/register.css') }}">
    <title>Register</title>
</head>
<body>
    <section>
        <div class="box">
            <h1>Register</h1>
            <form action="{{ route('register.save') }}" method="POST" class="box-regis">
                @csrf
                <div class="box-regis-lbl">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required="">
                    @error('name')
                    <span class="text-red-200"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="box-regis-lbl">
                    <label for="email">Your email</label>
                    <input type="email" name="email" id="email" required="">
                    @error('email')
                    <span class="text-red-200"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="box-regis-lbl">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="" required="">
                    @error('password')
                        <span class="text-red-200"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="box-regis-lbl">
                    <label for="confirm-password">Confirm-password</label>
                    <input type="confirm-password" name="password_confirmation" id="password_confirmation" required="" >
                    @error('password_confirmation')
                    <span class="text-red-200"> {{ $message }}</span>
                    @enderror
                </div>
                <div class="checkbox">
                    <div class="checkbox1">
                        <input type="checkbox" aria-describedby="terms" id="checkbox"> 
                    </div>
                    <div class="checkbox2">
                        <label for="terms">I accept the Terms and Conditions</label>
                    </div>

                </div>
                <button type="submit">Create an account</button>
                <p>Already have an account? <a href="{{route('login')}}">Login</a></p>
            </form>
        </div>
    </section>

  


  
</body>
</html>