<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>Formulario</title>
</head>
<body>
    <header class="py-5 bg-dark">
        <nav class="text-white container">
            menu
        </nav>
    </header>
    <main class="container py-3">
        <h1>Formulario de envío</h1>

        <div class="alert shadow col-8 mx-auto">
            <form action="/procesa" method="post">
            @csrf
                <input type="text" name="nombre" class="form-control">
                <button class="btn btn-dark">enviar</button>
            </form>
        </div>

    </main>
    <footer class="fixed-bottom bg-light text-center py-5">
        leyenda de copyright
    </footer>
    
</body>
</html>