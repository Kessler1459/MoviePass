<?php session_start();?>
<section class="shopping-cart dark">
        <div class="container" id="container">
          <div class="block-heading">
            <h2>Shopping Cart</h2>
            <p>Compra de tickets</p>
          </div>
        <form action="<?php FRONT_ROOT?>Compras/showCreditCard" method="post">
          <div class="content">
            <div class="row">
              <div class="col-md-12 col-lg-8">
                <div class="items">
                  <div class="product">
                    <div class="info">
                      <div class="product-details">
                        <div class="row justify-content-md-center">
                          <div class="col-md-3">
                            <img class="img-fluid mx-auto d-block image" src="https://image.tmdb.org/t/p/original<?php echo $_SESSION['selecteddProjection']['movie']->getPoster() ?>">
                          </div>
                          <div class="col-md-4 product-detail">
                            <h5>Pelicula</h5>
                            <div class="product-info">
                              <p><b>Nombre </b><span id="product-description"><?php $_SESSION["selectedProjection"]["movie"]->getTitle() ?></span><br>
                              <b>Cinema </b><span><?php $_SESSION["selectedProjection"]["cinema"]->getName() ?></span><br>
                              <b>Sala</b><span><?php $_SESSION["selectedProjection"]["room"]->getDescription() ?></span><br><br>
                              <b>Price:</b> $ <span id="unit-price"><?php $_SESSION["selectedProjection"]["room"]->getTicketPrice() ?></span></p>
                            </div>
                          </div>
                          <div class="col-md-3 product-detail">
                            <label for="quantity"><h5>Quantity</h5></label>
                            <input type="number" id="quantity" value="1" onUpdate="actualizarPrecio()" class="form-control">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 col-lg-4">
                <div class="summary">
                  <h3>Cart</h3>
                  <div class="summary-item"><span class="text">Subtotal</span><span class="price" id="cart-total"></span></div>
                  <button class="btn btn-primary btn-lg btn-block" id="checkout-btn">Checkout</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        </div>
      </section>

<script>
    function actualizarPrecio()
    {
        var cantidad = document.getElementById("quantity").value;
        var precioUnitario = document.getElementById("unit-price").innerHTML;
        document.getElementById("cart-total").innerHTML = precioUnitario * cantidad;
    }
</script>