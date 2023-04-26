<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
</head>
<body id="body">
    <div class="container-fluid menu_logo">
        <div class="container logo">
            <img src="img/logo1.png" id="meu-logo" alt="">
        </div>
    </div>
    <div class="container menu-form">
            <form action="login.php" method="post">
                <h3>Login</h3>
                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" class="form-control" name="usuario">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Senha</label>
                    <input type="password" class="form-control" name="senha">
                </div>
                <button type="submit" class="btn btn-primary btn-sm" name="login">Login</button>
                <?php
                if(isset($_GET['msg'])){
                ?>
                    <div class="alert alert-danger alerta_senha" role="alert">
                    Senha ou Usuário inválido.
                    </div>
                <?php
                }
                else{
                }
                ?>
            </form>
            <!---------Desativado temporario no css-------------->
            <div class="esqueci-senha">
                <a href="">Esqueci a senha</a>
            </div>
    </div>
</body>

    <?php
    //// incluindo o rodape
            include('footer.php');
    ?>
</html>