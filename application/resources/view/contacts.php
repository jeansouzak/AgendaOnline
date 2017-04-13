{% extends 'template.php' %}

{% block body %}

<div class="container" role="main">

    <h1>Contatos</h1>
    <hr>
    <a class="btn btn-success" href="/contact/create"> Novo Contato </a>
    <br/>
    {% for contact in contacts %}
    <div class="media">
        <div class="media-left">
            <a href="#">
                <img class="media-object" src="{{ asset('img/user.svg') }}" alt="...">
            </a>
        </div>
        <div class="media-body">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <h4 class="media-heading">{{ contact.name }}
                    {% for notification in contact.notifications %}                    |
                        <span class="label label-warning">{{ notification }}</span>
                    {% endfor %}
                </h4>
                <b>Número:</b> {{ contact.number }}
                <br/>
                <b>E-mail:</b> {{ contact.email }}
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a href="/contact/edit/{{ contact.id }}"> Editar </a> <br/>
                <a href="/contact/delete/{{ contact.id }}" class="remove-lnk"> Excluir </a> <br/>

            </div>
        </div>
    </div>
    <hr>
    {% endfor %}
</div>
{% endblock %}