<?php
include "conexao.php";
include "verifica_login.php";

////usuario logado
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="painel.css">
  <title>PAINEL</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
  
</head>
<body id="body">
  <div class="container-fluid principal">
    <div class="d-flex flex-column flex-shrink-0 p-2 bg-light menu-lateral">
      <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a href="painel.php" class="nav-link  btn-sm active" aria-current="page">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
            Home
          </a>
        </li>
        <li class="nav-item dropdown">
          <div class="dropdown mt-3">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">Cadastros</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <li><a class="dropdown-item btn-sm" data-bs-toggle="offcanvas" data-bs-target="#produto" role="button" >Produto</a></li>
              <li><a class="dropdown-item btn-sm" data-bs-toggle="offcanvas" data-bs-target="#categoria" role="button" >Categoria</a></li>
              <li><a class="dropdown-item btn-sm" data-bs-toggle="offcanvas" href="#usuario" role="button">Usuário</a></li>
            </ul>
          </div>
        </li>
        <li>
          <div class="dropdown mt-3">
            <button class="btn btn-secondary  btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">Relátorios</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <form action="#" method="post">
                <li><button type="submit" class="dropdown-item btn-sm" name="relatorio_recebimento">Recebimento</button></li>
                <li><button type="submit" class="dropdown-item btn-sm" name="relatorio_estoque">Balanço de Estoque</button></li>
                <li><button type="submit" class="dropdown-item btn-sm" name="relatorio_valores">Levantamento de valores</button></li>
              </form>
            </ul>
          </div>
        </li>
        <li>
          <div class="dropdown mt-3">
            <button class="btn btn-secondary  btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">Consulta</button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <form action="#" method="post">
                <li><button class="dropdown-item btn-sm" type="submit" name="produto">Produto</button></li>
                <li><button class="dropdown-item btn-sm" type="submit" name="entrada">Entradas</button></li>
                <li><button class="dropdown-item btn-sm" type="submit" name="categoria">Categoria</button></li>
                <li><button class="dropdown-item btn-sm" type="submit" name="usuario">Usuário</button></li>
              </form>
            </ul>
          </div>
        </li>
      </ul>
      <hr>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"  data-bs-toggle="dropdown" aria-expanded="false">
          <strong><?php echo $usuario?></strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
          <li><a class="dropdown-item btn-sm" href="logout.php">Deslogar</a></li>
        </ul>
      </div>
    </div>

    
    <?php

    if(isset($_POST["produto"])){
      include "produto.php";
    }
    elseif(isset($_POST["categoria"])){
      include "categoria.php";
    }
    elseif(isset($_POST["usuario"])){
      include "usuario.php";
    }
    elseif(isset($_POST["entrada"])){
      include "entrada.php";
    }
    else{
      include "venda.php";
    }

    //// incluindo rodape
    include "footer.php";
    ?>  


  </div>
    


  </div>

      <!---CADASTRO CATEGORIA DE PRODUTO---->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="categoria" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Cadastrar Categoria</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
      <form action="ac_categoria.php" method="post">
            <div class="col">
              <div class="col">
                <p>Descrição Categoria</p>
                <input type="text" class="form-control" name="descricao_categoria" placeholder="Descrição Categoria" required>
              </div>

              <br>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-sm" name="btn-cadastrar">Cadastrar</button>
          </form>

      </div>
    </div>

    
    <!---CADASTRO USUARIO---->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="usuario" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Cadastrar Usuário</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
      <form action="ac_usuario.php" method="post">
            <div class="col">
              <div class="col">
                <p>Nome</p>
                <input type="text" class="form-control" name="nome" placeholder="Primeiro nome do usuário" required title="Código em branco">
              </div>

              <br>
              <div class="col">
                <p>Sobrenome</p>
                <input type="text" class="form-control" name="sobrenome" placeholder="Sobrenome nome do usuário"  required title="Nome em branco">
              </div>
              <br>

              <div class="col">
                <p>Senha</p>
                <input type="text" class="form-control" name="senha" placeholder="Defina a senha do usuário"  required>
              </div>

              <br> 

              <label for="">Nivel de acesso</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="nivel" value="padrao" checked>
                <label class="form-check-label">
                  Padrão
                </label>
              </div>

              <div class="form-check">
                  <input class="form-check-input" type="radio" name="nivel" value="master">
                  <label class="form-check-label">
                    Master
                  </label>
              </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </form>

      </div>
    </div>

        <!---CADASTRO Fornecedor---->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="fornecedor" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Cadastrar Fornecedor</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
      <form action="ac_fornecedor.php" method="post">
            <div class="col">
              <div class="col">
                <p>Nome Fornecedor</p>
                <input type="text" class="form-control" name="nome" placeholder="Nome do fornecedor" required>
              </div>

              <br>
              <div class="col">
                <p>Nome Fantasia</p>
                <input type="text" class="form-control" name="nome_fantasia" placeholder="Fantasia do fornecedor"  required>
              </div>
              <br>

              <div class="col">
                <p>CNPJ</p>
                <input type="text" class="form-control" name="cnpj" placeholder="CNPJ do fornecedor"  required>
              </div>

              <br> 

              <div class="col">
                <p>Email</p>
                <input type="email" class="form-control" name="email" placeholder="Email do fornecedor"  required>
              </div>

              <br>

              <div class="col">
                <p>Telefone/Celular</p>
                <input type="number" class="form-control" name="telefone" placeholder="Contato do fornecedor"  required>
              </div>

              <br>

              <div class="col">
                <p>CEP</p>
                <input type="text" class="form-control" name="cep"  id="cep" value="" size="10" maxlength="9" placeholder="Contato do fornecedor" onblur="pesquisacep(this.value);" required>
              </div>

              <br>
              
              <div class="col">
                <p>Endereço</p>
                <input class="form-control" name="rua" type="text" id="rua" placeholder="Endereço do fornecedor"  required>
              </div>

              <br>

              <div class="col">
                <p>Numero</p>
                <input class="form-control" name="numero" type="text" id="numero" placeholder="Numero do endereço do fornecedor"  required>
              </div>

              <br>

              <div class="col">
                <p>Bairro</p>
                <input class="form-control" name="bairro" type="text" id="bairro" placeholder="Bairo do fornecedor"  required>
              </div>

              <br>

              <div class="col">
                <p>Cidade</p>
                <input class="form-control" name="cidade" type="text" id="cidade" placeholder="Cidade do fornecedor"  required>
              </div>
              
              <br>

              <div class="col">
                <p>Estado</p>
                <input class="form-control" name="uf" type="text" id="uf" size="2" placeholder="Uf do fornecedor"   required>
              </div>

            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </form>

      </div>
    </div>
    
    <!---CADASTRO Produto---->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="produto" aria-labelledby="offcanvasExampleLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Cadastrar Produto</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div>
          <form action="ac_produto.php" method="post">
            <div class="col">
              <div class="col">
                <p>Descrição do Produto</p>
                <input type="hidden" value="<?php echo $usuario ?>" name="usuario">
                <input type="text" class="form-control" name="descricao_produto" placeholder="Descrição do produto"  required>
              </div>
              <br>
              <div class="col">
                <p>Categoria de Produto</p>
                <select name="id_categoria" class="form-control">
                  <?php
                  $sql = "SELECT * FROM tb_categoria";
                    $result = mysqli_query($conexao, $sql);
                    while($row = mysqli_fetch_row($result))
                    { 
                        $id_categoria=$row[0];   
                        $descricao_categoria=$row[1]; 
                        echo "<option value='$id_categoria'>$descricao_categoria</option>";
                      }
                  ?>
                </select>
              </div>
              <br> 
              <div class="col">
                <p>Quantidade Minima</p>
                <input type="number" class="form-control" name="minimo" placeholder="Quantidade minima do Produto"  required>
              </div>
              <br> 
              <div class="col">
                <p>Quantidade de Entrada</p>
                <input type="number" class="form-control" name="quantidade" placeholder="Quantidade de entrada do Produto"  >
              </div>
              <br>
              <div class="col">
                <p>Valor Unitário</p>
                <input type="number" class="form-control" name="valor_unitario" placeholder="Valor unitário do Produto"  >
              </div>
              <br> 
            </div>
            <hr>
            <button type="submit" class="btn btn-primary btn-sm" name="btn-cadastrar">Cadastrar</button>
          </form>
        </div>
      </div>

    </div>

        <!---CADASTRO Unidade---->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="unidade" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Cadastrar Unidade</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div>
          <form action="ac_unidade.php" method="post">
            <div class="col">
              <div class="col">
                <p>Descrição da Unidade</p>
                <input type="text" name="descricao" class="form-control" placeholder="Descrição da unidade"  required> 
              </div>

              <br>
              <div class="col">
                <p>Unidade</p>
                <input type="text" name="unidade" class="form-control" placeholder="Unidade"  required>
              </div>
              <br>

            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
          </form>
        </div>
      </div>
  
</div>    
</body>
</html>