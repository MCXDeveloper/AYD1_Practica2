<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"><img height="30" alt="Brand" src="<?php echo base_url('assets/img/logo.jpg'); ?>"></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active">
                    <a class="activateModal" data-titulo="Inicio de sesión" data-action="<?php echo base_url('login'); ?>" data-color="success" data-btn="Login" style="cursor:pointer;">Inicia sesión</a>
                </li>
                <li>
                    <a class="activateModal" data-titulo="Registro de usuario" data-action="<?php echo base_url('registro'); ?>" data-color="primary" data-btn="Registrar" style="cursor:pointer;">Registro</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="modalDatos" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Registro de usuario</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-1">
                            <form role="form">
                                <div class="form-group">
                                    <label class="control-label">Correo electrónico</label>
                                    <input class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico" type="email">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Contraseña</label>
                                    <input class="form-control" id="password" name="password" placeholder="Contraseña" type="password">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" data-dismiss="modal">Iniciar sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function(){

        $('.activateModal').on('click', function(){

            var titulo = $(this).attr('data-titulo');
            var action = $(this).attr('data-action');
            var color = $(this).attr('data-color');
            var texto_boton = $(this).attr('data-btn');

            $('#modalDatos').find('.modal-title').html(titulo);
            $('#modalDatos').find('button[type="submit"]').attr('class', 'btn btn-' + color).attr('data-action', action).html(texto_boton);
            $('#modalDatos').modal('show');

        });

    });

</script>
