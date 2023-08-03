<?php

$alertaLogin     = strlen($alertaLogin) ? '<div class="alert alert-danger">' . $alertaLogin . '</div>' : '';
$alertaCadastro  = strlen($alertaCadastro) ? '<div class="alert alert-danger">' . $alertaCadastro . '</div>' : '';

?>
<div class="card card-outline card-primary">
    <div class="card-header text-center">
        <img src="assets/dist/img/sm-fundo.png" style="width:200px; height:70px">
    </div>
    <div class="card-body">
        <p class="login-box-msg">Faça login para iniciar sua sessão</p>
        <?= $alertaLogin  ?>

        <form action="" method="post">
            <div class="input-group mb-3">
                <input type="email" class="form-control" placeholder="Email" name="email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password" name="senha">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Lembre-me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block" name="acao" value="logar">Entrar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <div class="social-auth-links text-center mt-2 mb-3">
            <a href="#" class="btn btn-block btn-info">
                <i class="fab fa-facebook mr-2"></i> Entrar usando Facebook
            </a>
            <a href="#" class="btn btn-block btn-danger">
                <i class="fab fa-google-plus mr-2"></i> Entrar usando Google+
            </a>
        </div>
        <!-- /.social-auth-links -->

        <p class="mb-1">
            <a href="forgot-password.html">Esqueci a minha senha</a>
        </p>
        <p class="mb-0">
            <a href="register.html" class="text-center">Registerar novo usuário</a>
        </p>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
</div>