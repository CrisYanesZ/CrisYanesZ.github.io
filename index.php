<!DOCTYPE html>
<html lang="es">
<head>
    <title>Bella Cosmetics | Lo mejor en Cosmeticos</title>
    <?php include './inc/link.php'; ?>
    <link rel="icon" href="nuevologo.png">
    <link rel="stylesheet" href="css/est.css">
    <link rel="stylesheet" href="css/estilo-banner.css">
</head>
<body id="container-page-index">

<div id="banner" width="500"; height="500">
  <video loop muted autoplay preload="auto">
    <source src="./assets/video.mp4" >
</div>
    <?php include './inc/navbar.php'; ?>
    
    <section id="new-prod-index">    
         <div class="container">
            <div class="page-header">
                <h1>Últimos <small>productos agregados</small></h1>
            </div>
            <div class="row">
              	<?php
                  include 'library/configServer.php';
                  include 'library/consulSQL.php';
                  $consulta= ejecutarSQL::consultar("SELECT * FROM producto WHERE Stock > 0 AND Estado='Activo' ORDER BY id DESC LIMIT 7");
                  $totalproductos = mysqli_num_rows($consulta);
                  if($totalproductos>0){
                      while($fila=mysqli_fetch_array($consulta, MYSQLI_ASSOC)){
                ?>
                <div class="col-xs-12 col-sm-6 col-md-4">
                     <div class="thumbnail">
                       <img class="img-product" src="assets/img-products/<?php if($fila['Imagen']!="" && is_file("./assets/img-products/".$fila['Imagen'])){ echo $fila['Imagen']; }else{ echo "default.png"; } ?>">
                       <div class="caption">
                       		<h3><?php echo $fila['Marca']; ?></h3>
                            <p><?php echo $fila['NombreProd']; ?></p>
                            <?php if($fila['Descuento']>0): ?>
                             <p>
                             <?php
                             $pref=number_format($fila['Precio']-($fila['Precio']*($fila['Descuento']/100)), 2, '.', '');
                             echo $fila['Descuento']."% descuento: $".$pref; 
                             ?>
                             </p>
                             <?php else: ?>
                              <p>$<?php echo $fila['Precio']; ?></p>
                             <?php endif; ?>
                        <p class="text-center">
                            <a href="infoProd.php?CodigoProd=<?php echo $fila['CodigoProd']; ?>" class="btn btn-primary btn-sm btn-raised btn-block" style="background-color:#EF0D5F"><i class="fa fa-plus"></i>&nbsp; Detalles</a>
                        </p>
                       </div>
                     </div>
                </div>     
                <?php
                     }   
                  }else{
                      echo '<h2>No hay productos registrados en la tienda</h2>';
                  }  
              	?>  
            </div>
         </div>
    </section>
    <section id="reg-info-index">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 text-center">
                   <article style="margin-top:5%;">
                        <p><i class="fa fa-users fa-4x"></i></p>
                        <h3>Registrate</h3>
                        <p>Registrate como cliente de <span class="tittles-pages-logo">Bella Cosmetics</span> en un sencillo formulario para poder completar tus pedidos</p>
                        <p><a href="registration.php" class="btn btn-info btn-raised btn-block" style="background-color:#EF0D5F">Registrarse</a></p>   
                   </article>
                </div>

                <div class="col-xs-12 col-sm-6">
                    <img src="assets/img/labia.png" alt="Smart-TV" class="img-responsive" style="width: 70%; display: block; margin: 0 auto;">
                </div>
            </div>
        </div>
    </section>
    <footer class="pie-pagina">
        <div class="grupo-1" style="background-color: #1E1B1C; border:0;">
            <div class="box" style="background-color: #1E1B1C; border:0;">
                <figure style="background-color: #1E1B1C; border:0;">
                    <a href="#">
                        <img src="nuevologo.png" alt="Logo de SLee Dw">
                    </a>
                </figure>
            </div>
            <div class="box" style="background-color: #1E1B1C; border:0;">
                <h2 style="color: #fff;
    margin-bottom: 25px;
    font-size: 20px;"><b>SOBRE NOSOTROS</b></h2>
                <p>Bella Cosmetics | Lo mejor en Cosmeticos</p>
                <p>Contactanos:+504 2772-0090 </p>
                <p>Dirección: Comayagua </p>
            </div>
            <div class="box" style="background-color: #1E1B1C;border:0;">
                <h2 style="color: #fff;
    margin-bottom: 25px;
    font-size: 20px;"><b>SIGUENOS</b></h2>
                <div class="red-social">
                    <a class="btn btn-default" type= "button" style="font-size:25px;color:white" href="#"><i class="fa fa-facebook"></i> </a>
                    <a class="btn btn-default" type= "button" style="font-size:25px;color:white" href="#"><i class="fa fa-instagram"></i> </a>
                    <a class="btn btn-default" type= "button" style="font-size:25px;color:white" href="#"><i class="fa fa-twitter"></i> </a>
                    <a class="btn btn-default" type= "button" style="font-size:25px;color:white" href="#"><i class="fa fa-whatsapp"></i> </a>
                    <a class="btn btn-default" type= "button" style="font-size:25px;color:white" href="#"><i class="fa fa-youtube"></i> </a>
                </div>
            </div>
        </div>
        <div class="grupo-2" style="background-color: #1E1B1C">
            <small>&copy; 2021 <b>Bella Cosmetics</b> - Todos los Derechos Reservados.</small>
        </div>
    </footer>
</body>
</html>