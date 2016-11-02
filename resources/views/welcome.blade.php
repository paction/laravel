<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>
                <div class="description">
                    A coding assignment task
                </div>

                <div class="links">
                    <a href="/products">Products List</a>
                    <a href="/cart">Cart</a>
                </div>
                
                <div class="requirements">
                    <p><strong>Env setup</strong></p>
                    <p>* Laravel Framework 5
                    <p>* use Homestead Vagrant for your development environment
                    <p>* use bootstrap for front end, and mysql for database
                    <hr>
                    <p><strong>Feature</strong>
                    <p>* create a page to display a list of products with title, images, price, description
                    <p>* allow user to buy different options of a product. ie. size, color
                    <p>* allow user to buy a bundle of products at a discounted price
                    <p>* send email notification whenever a user purchase something
                    <p>* write tests to make sure the above features work
                    <hr>
                    <p><strong>Bonus</strong>
                    <p>* use event/listener architecture to send email asynchronously
                    <p>* design a coupon module where we can offer a coupon for a specific product, or a bundle</p>
                </div>
            </div>
        </div>
    </body>
</html>
