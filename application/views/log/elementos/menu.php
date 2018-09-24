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
                    <a id="carrito_compras"><span class="badge badge_carrito">0</span><i class="fa fa-fw fa-lg fa-shopping-cart"></i></a>
                </li>
                <li class="active">
                    <a id="cerrar_sesion">Cerrar sesión</a>
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
<script type="text/javascript">

    $(document).ready(function(){

        $('#carrito_compras').on('click', function(){

            updateProductArray();

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

        });

    });

</script>
