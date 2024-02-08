<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BookHaven | {{ $title }}</title>
    <link href="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/bootstrap-icons/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

        body {
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
          margin: 0;
          font-family: 'Poppins', sans-serif;
        }

        .border-container {
            border: 2px solid #000000;
            padding: 60px;
            max-width: 500px;
            width: 100%;
            box-sizing: border-box;
        }
      </style>

  </head>
  <body>
    <div class="container">
        <div class="row justify-content-center align-items-center m-auto">
          <div class="col-lg-4">        
              <main class="form-signin w-100 m-auto">
                  @yield('container')
              </main>
          </div>
        </div>
    </div>

    <script src="{{ asset('/bootstrap/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    
  </body>
</html>