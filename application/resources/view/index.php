{% extends 'template.php' %}

{% block body %}

<div class="container">
    <div class="jumbotron marketing-msg">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <img src="{{ asset('img/contact.png') }}" class="img-responsive" alt="contatos"/>

            <p class="align-center">Agenda Online</p>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <h4>Administre sua agenda de contatos online.</h4>
            {% if status %}
            <div class="alert alert-{{ status }}" role="alert">{{ message }}</div>
            {% endif %}
            <form class="login-form" action="/user/login" method="post">
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" class="form-control" id="login-email" name="email"
                           placeholder="Digite seu e-mail" required>
                </div>
                <div class="form-group">
                    <label for="login-password">Senha</label>
                    <input type="password" required class="form-control" name="password" id="login-password"
                           placeholder="Digite sua senha">
                </div>
                <small><a href="#" id="create-account">Criar uma conta</a></small>
                <input type="submit" class="btn btn-success align-right" value="Login"/>
            </form>
            <form class="create-form" action="/user/create" method="post">

                <div class="form-group">
                    <label for="create-name">Nome*</label>
                    <input type="text" class="form-control" name="name" id="create-name" placeholder="Digite seu nome">
                </div>
                <div class="form-group">
                    <label for="create-email">Email*</label>
                    <input type="email" class="form-control" name="email" id="create-email"
                           placeholder="Digite seu e-mail">
                </div>
                <div class="form-group">
                    <label for="create-password">Senha*</label>
                    <input type="password" class="form-control" name="password" id="create-password"
                           placeholder="Digite sua senha">
                </div>
                <small><a href="#" id="login-account">Já tenho uma conta</a></small>
                <input type="submit" class="btn btn-success align-right" value="Cadastrar"/>
            </form>
        </div>
    </div>

    <h1>Planos e Preços</h1>

    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">Gratuito</div>
            <div class="panel-body">
                20 Contatos
                <span class="label label-success right">Grátis</span>
            </div>

        </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="panel panel-warning">
            <div class="panel-heading">Tímido</div>
            <div class="panel-body">
                80 Contatos
                <span class="label label-success right">R$ 3,50 / mês</span>
            </div>
        </div>
    </div>
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
        <div class="panel panel-success">
            <div class="panel-heading">Popular</div>
            <div class="panel-body">
                Ilimitado
                <span class="label label-success right">R$ 5,00 / mês</span>
            </div>
        </div>
    </div>
</div>


</div>
{% endblock %}