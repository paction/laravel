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
                color: #464e52;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }
            
            strong {
                font-weight: 700;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
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
            
            .requirements {
                width: 100%;
                text-align: left;
                margin: 30px 0;
                padding: 20px;
                border: 1px dashed #AAA;
                border-right: none;
                border-left: none;
                border-bottom: none;
            }
            
            .description {
                margin: 30px 0;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

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
                    <h4>Env setup</h4>
                    <p>* Laravel Framework 5
                    <p>* use Homestead Vagrant for your development environment
                    <p>* use bootstrap for front end, and mysql for database
                    <h4>Feature</h4>
                    <p>* create a page to display a list of products with title, images, price, description
                    <p>* allow user to buy different options of a product. ie. size, color
                    <p>* allow user to buy a bundle of products at a discounted price
                    <p>* send email notification whenever a user purchase something
                    <p>* write tests to make sure the above features work
                    <h4>Bonus</h4>
                    <p>* use event/listener architecture to send email asynchronously
                    <p>* design a coupon module where we can offer a coupon for a specific product, or a bundle</p>
                </div>
            </div>
        </div>
    </body>
</html>
