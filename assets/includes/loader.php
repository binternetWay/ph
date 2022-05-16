
<div id="loader" class="loader">
  <i class="fa-solid fa-circle-notch"></i>
</div>

<style>
/* Visual para loader page */
.loader {
  display: flex;
  align-items: center;
  justify-content: center;

  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9998;
  background: var(--bg1-contracts);
  background-size: 100px;
}

.loader i {
  font-size: 60px;
  color: var(--bg1-default);
  z-index: 9999;
  animation: loading 2s linear infinite;  
}

  
  @keyframes loading {
      0% {
      transform: rotate(0);
    }
    100% {
      transform: rotate(360deg);
    }
  }
</style>

<?php include_once './assets/config/jsPadrao.php'?>
<script>
    jQuery(window).load(function () {
      $(".loader").delay(1500).fadeOut("slow");
    $("#tudo_page").toggle("fast");
});
</script>