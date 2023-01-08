<section class="newsletter">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="content">
          <h2>INSCREVA EM NOSSO NEWSLETTER</h2>
          <div class="input-group">
            <input type="email" class="form-control" placeholder="Enter your email">
            <span class="input-group-btn">
              <button class="btn" type="submit">Inscrever agora</button>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="container">
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="./index.php" class="nav-link px-2 text-dark fw-bold ">Home</a></li>
      <li class="nav-item"><a href="./projecto.php" class="nav-link px-2 fw-bold text-dark">Projetos</a></li>
      <li class="nav-item"><a href="./noticias.php" class="nav-link px-2 text-dark fw-bold">Noticias</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-dark fw-bold">FAQs</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-dark fw-bold">Sobre</a></li>
    </ul>
    <p class="text-center ">© 2022 Adyjael neto, Inc</p>
  </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="js/jquery.js"></script>
<script src="js/sweetealert2.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<script src="js/Ajax.js"></script>
<script>
  $(document).ready(function() {
    // jQuery code

    ///////////////// fixed menu on scroll for desctop
    if ($(window).width() > 992) {

      var navbar_height = $('.navbar').outerHeight();

      $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
          $('.navbar-wrap').css('height', navbar_height + 'px');
          $('#navbar_top').addClass("fixed-top");

        } else {
          $('#navbar_top').removeClass("fixed-top");
          $('.navbar-wrap').css('height', 'auto');
        }
      });
    } // end if


  }); // jquery end
</script>
</body>

</html>