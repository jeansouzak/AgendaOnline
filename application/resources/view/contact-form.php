{% extends 'template.php' %}

{% block body %}
<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/contact">Agenda Online</a>
        </div>

    </div>
</nav>

<div class="container" role="main">

    <h1>Formulário de Contato</h1>
    {% if status %}
    <div class="alert alert-{{ status }}" role="alert">{{ message }}</div>
    {% endif %}
    <form action="/contact/save" method="POST">
        <input type="hidden" name="_method" value="{{ method }}"/>
        <input type="hidden" value="{{ contact.id }}" name="id">

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="create-name">Nome*</label>
                <input type="text" required class="form-control" value="{{ contact.name }}" name="name" id="create-name"
                       placeholder="Digite seu nome">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="create-password">Telefone*</label>
                <input type="tel" name="number" id="phone-number" required class="form-control"
                       value="{{ contact.number }}"
                       placeholder="Digite o telefone"/>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="born-day">Dia de Aniversário</label>
                <select class="form-control" id="born-day" name="born_day">
                    <option value="">Selecione...</option>
                    {% for i in 1..31 %}
                    <option value="{{ i }}" {{ contact.bornDay== i ?
                    'selected' : '' }} >{{ i }}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="born-month">Mês de Aniversário</label>
                <select class="form-control" id="born-month" name="born_month">
                    <option value="">Selecione...</option>
                    {% for i in 1..12 %}
                    <option value="{{ i }}" {{ contact.bornMonth== i ?
                    'selected' : '' }}>{{ i }}</option>
                    {% endfor %}
                </select>
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="create-email">Email</label>
                <input type="email" class="form-control" value="{{ contact.email }}" name="email"
                       id="create-email"
                       placeholder="Digite seu e-mail">
            </div>
        </div>
        <div class="clearfix"></div>
        <input type="submit" class="btn btn-success align-right" value="Enviar"/>
    </form>
</div>
<!-- /container -->


{% endblock %}