<html>
    <head>
        <title>LAP-SALES | Venta de computadoras laptop</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/js/js.cookie.min.js'); ?>"></script>
        <link href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('assets/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css">

        <script type="text/javascript">

            // Variable para almacenamiento de cookies
            var prod_sel = [];

            function getProductCookie() {
                return Cookies.get('cookie_products');
            }

            function countProperties() {
                updateProductArray();
                return Object.keys(prod_sel).length;
            }

            function updateProductArray() {
                if(typeof getProductCookie() !== 'undefined') {
                    prod_sel = JSON.parse(getProductCookie());
                }
            }

            function validateProductCookie(value) {
                var response = false;
                updateProductArray();
                var result = prod_sel.find(function (obj) { return obj.id === value; });
                if(result){
                    response = true;
                }
                return response;
            }

            function cleanCookieJar() {
                prod_sel = [];
                Cookies.set('cookie_products', JSON.stringify(prod_sel), { expires: 180, path: '' });
            }

            function setProductCookie(value) {
                if(!validateProductCookie(value.id)){
                    prod_sel.push(value);
                }else{
                    var result = prod_sel.findIndex((obj => obj.id == value.id));
                    prod_sel[result] = value;
                }
                Cookies.set('cookie_products', JSON.stringify(prod_sel), { expires: 180, path: '' });
            }

        </script>

        <script type="text/javascript">

            $(document).ready(function(){

                //Actualizo el contador del carrito
                if(countProperties() != 0){
                    $('.badge_carrito').html(countProperties());
                }

                $.ajax({

                    type: 'POST',
                    url:  '<?php echo base_url('home/obtener_laptops'); ?>',
                    timeout: 5000,

                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Ocurrió un error');
                    },

                    success: function(data) {

                        var obj = $.parseJSON(data);

                        if(obj.code == 1){

                            console.log(obj.message);

                            var cnt = 0;
                            var row = $('<div>').addClass('row');
                            var contenido;

                            $.each(obj.datos, function(k, v){

                                cnt = cnt++;

                                if(cnt == 1){
                                    row = $('<div>').addClass('row');
                                }else if(cnt <= 4){

                                    var imagen = "<?php echo base_url('assets/img/laptops') ?>/" + v.imagen;

                                    contenido = $('<div>').attr('class', 'col-md-4').append(
                                        $('<img>').attr('class', 'img-responsive').attr('src', imagen)
                                    ).append(
                                        $('<h2>').html(v.nombre)
                                    ).append(
                                        $('<p>').html(v.descripcion)
                                    ).append(
                                        $('<button>').attr('class', 'btn btn-danger ver-detalle').attr('data-id', v.id_producto).attr('data-precio', v.precio).attr('data-nombre', v.nombre).attr('data-descripcion', v.descripcion).attr('data-specs', v.specs).attr('data-image', imagen).html('Ver detalle')
                                    );

                                }else if(cnt>=4){
                                   cnt = 0;
                                }

                                $('#laptop_container').append(row.append(contenido));

                            });

                        }else if(obj.code == 2){
                            alert(obj.message);
                            window.location.href = "<?php echo base_url(); ?>";
                        }else{
                            alert(obj.message);
                        }

                    }

                });

            });

        </script>

        <script type="text/javascript">

            $(document).on('click', '.ver-detalle', function(){

                var identificador = $(this).attr('data-id');
                var imagen = $(this).attr('data-image');
                var nombre = $(this).attr('data-nombre');
                var descripcion = $(this).attr('data-descripcion');
                var specs = $(this).attr('data-specs');
                var precio = $(this).attr('data-precio');

                $('#modalDetalle').find('.modal-body').empty().append(
                    $('<div>').attr('class', 'container').append(
                        $('<div>').attr('class', 'row').append(
                            $('<div>').attr('class', 'col-md-4 col-md-offset-1').append(
                                $('<img>').attr('class', 'img-responsive').attr('style', 'height:10%;').attr('src', imagen)
                            ).append(
                                $('<h2>').html(nombre)
                            ).append(
                                $('<p>').attr('style', 'font-weight:bold;').html(descripcion)
                            ).append(
                                $('<p>').html(specs)
                            ).append(
                                $('<h4>').html("Añadir al carrito")
                            ).append(
                                $('<div>').attr('class', 'col-md-6 select-container').append(
                                    $('<select>').attr('class', 'form-control cantidad_select').append(
                                        $('<option>').val(1).text(1)
                                    ).append(
                                        $('<option>').val(2).text(2)
                                    ).append(
                                        $('<option>').val(3).text(3)
                                    ).append(
                                        $('<option>').val(4).text(4)
                                    ).append(
                                        $('<option>').val(5).text(5)
                                    )
                                )
                            ).append(
                                $('<div>').attr('class', 'col-md-6').append(
                                    $('<button>').attr('data-id', identificador).attr('data-nombre', nombre).attr('data-imagen', imagen).attr('data-precio', precio).attr('class', 'btn btn-primary btn_add_cart').html('Añadir')
                                )
                            )
                        )
                    )
                );

                $('#modalDetalle').modal('show');

            });

        </script>

        <script type="text/javascript">

            $(document).on('click', '.btn_add_cart', function(){

                var id_producto = $(this).attr('data-id');
                var nombre = $(this).attr('data-nombre');
                var imagen = $(this).attr('data-imagen');
                var precio = $(this).attr('data-precio');
                var cantidad_seleccionada = $('#modalDetalle').find('.cantidad_select').val();

                var elemento = {id: id_producto, nombre: nombre, imagen: imagen, cantidad: cantidad_seleccionada, precio: precio};
                setProductCookie(elemento);

                alert('Producto añadido correctamente');

                if(countProperties() != 0){
                    $('.badge_carrito').html(countProperties());
                }

                $('#modalDetalle').modal('hide');

            });

        </script>

    </head>

    <body>

        <?php $this->load->view('log/elementos/menu'); ?>
        <br><br><br>
        <div class="section">
            <h1 style="text-align:center;">COMPUTADORAS EN STOCK</h1>
            <br>
            <div id="laptop_container" class="container"></div>
        </div>
        <br><br><br><br><br><br><br>
        <?php $this->load->view('no-log/elementos/footer'); ?>

        <div id="modalDetalle" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Detalle del producto</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </body>

</html>
