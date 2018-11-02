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
                <li>
                    <a id="carrito_compras" style="cursor:pointer;"><span class="badge badge_carrito">0</span><i class="fa fa-fw fa-lg fa-shopping-cart"></i></a>
                </li>
                <li>
                    <a id="editar_datos" style="cursor:pointer;">Editar datos</a>
                </li>
                <li class="active">
                    <a id="cerrar_sesion" style="cursor:pointer;">Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div id="modalDetalleCarrito" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detalle de pedido</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button id="btn_registrar_pedido" type="button" class="btn btn-success">Registrar pedido</button>
            </div>
        </div>
    </div>
</div>
<div id="modalEditarInfo" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar información</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-md-offset-1">
                            <form role="form" class="datos_form">
                                <div class="form-group">
                                    <label class="control-label">Dirección de entrega</label>
                                    <input class="form-control" id="direccion" name="direccion" placeholder="Ingrese su correo electrónico" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">No. de tarjeta de credito</label>
                                    <input class="form-control" id="tarjeta_credito" name="tarjeta_credito" placeholder="Contraseña" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button id="btnActualizarData" type="button" class="btn-accion btn btn-info">Actualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--NUEVO MODAL PARA EDITAR INFORMACION DEL USUARIO-->
<div id="modalEditarUsuario" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function(){

        $('#carrito_compras').on('click', function(){

            updateProductArray();

            if(countProperties() != 0) {

                $('#modalDetalleCarrito').find('.modal-body').empty();

                var table = $('<table>').attr('class', 'table');

                $.each(prod_sel, function(k, v){

                    if(k == 0){
                        var row = $('<tr>').append(
                            $('<td>').html('Imagen')
                        ).append(
                            $('<td>').html('Nombre')
                        ).append(
                            $('<td>').html('Cantidad')
                        ).append(
                            $('<td>').html('Precio')
                        )
                        table.append(row);
                    }

                    var row = $('<tr>').append(
                        $('<td>').append(
                            $('<img>').attr('class', 'img-responsive').attr('style', 'height:5%;').attr('src', v.imagen)
                        )
                    ).append(
                        $('<td>').html(v.nombre)
                    ).append(
                        $('<td>').html(v.cantidad)
                    ).append(
                        $('<td>').html('Q.' + v.precio)
                    )

                    table.append(row);

                });

                $('#modalDetalleCarrito').find('.modal-body').append(table);
                $('#modalDetalleCarrito').modal('show');

            }else{
                alert('No hay productos en el carrito.')
            }

        });

    });

</script>

<script type="text/javascript">

    $(document).ready(function(){

        $('#editar_datos').on('click', function(){

            $.ajax({

                type: 'POST',
                url:  '<?php echo base_url('home/obtener_datos_extra'); ?>',
                timeout: 5000,

                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Ocurrió un error');
                },

                success: function(data) {

                    var obj = $.parseJSON(data);

                    if(obj.code == 1) {

                        $('#modalEditarInfo').find('#direccion').val(obj.message.direccion);
                        $('#modalEditarInfo').find('#tarjeta_credito').val(obj.message.tarjeta_credito);

                        $('#modalEditarInfo').modal('show');

                    }else if(obj.code == 2) {
                        window.location.href = "<?php echo base_url(); ?>";
                    }else{
                        alert(obj.message);
                    }

                }

            });

        });

    });

</script>

<script type="text/javascript">

    $(document).on('click', '#btn_registrar_pedido', function(){

        updateProductArray();

        var datos = JSON.stringify(prod_sel);

        $.ajax({

            type: 'POST',
            url:  '<?php echo base_url('home/registrar_pedido'); ?>',
            data: { datos : datos },
            timeout: 5000,

            error: function(jqXHR, textStatus, errorThrown) {
                alert('Ocurrió un error');
            },

            success: function(data) {

                var obj = $.parseJSON(data);

                alert(obj.message);

                if(obj.code == 1) {

                    cleanCookieJar();
                    $('.badge_carrito').html(countProperties());
                    $('#modalDetalleCarrito').modal('hide');

                }else if(obj.code == 2) {
                    window.location.href = "<?php echo base_url(); ?>";
                }

            }

        });

    });

</script>

<script type="text/javascript">

    $(document).ready(function(){

        $('#cerrar_sesion').on('click', function(){

            $.ajax({

                type: 'POST',
                url:  '<?php echo base_url('home/cerrar_sesion'); ?>',
                timeout: 5000,

                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Ocurrió un error');
                },

                success: function(data) {

                    var obj = $.parseJSON(data);

                    if(obj.code == 1) {

                        window.location.href = "<?php echo base_url(); ?>";

                    }

                }

            });

        });

    });

</script>

<script type="text/javascript">

    $(document).ready(function(){

        $('#btnActualizarData').on('click', function(){

            var direccion = $('#direccion').val();
            var tarjeta_credito = $('#tarjeta_credito').val();

            $.ajax({

                type: 'POST',
                url:  '<?php echo base_url('home/actualizar_data_usuario'); ?>',
                data: { direccion: direccion, tarjeta_credito: tarjeta_credito},
                timeout: 5000,

                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Ocurrió un error');
                },

                success: function(data) {

                    var obj = $.parseJSON(data);

                    alert(obj.message);

                    if(obj.code == 1) {
                        $('#modalEditarInfo').modal('hide');
                    }else if(obj.code == 2) {
                        window.location.href = "<?php echo base_url(); ?>";
                    }

                }

            });

        });

    });

</script>
