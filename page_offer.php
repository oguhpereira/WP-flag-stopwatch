

<section class="container container-product-list " style="margin-top:30px;">
    <div class="row">
        <div class="text-center ">
            <?php if(strtotime(esc_attr( get_option('date_stop'))) > strtotime(date("Y-m-d h:i:sa"))):?>
            <div class="flag-stopwatch ">
                <div class="banner hidden-xs">
                    <img id='image-preview' src='<?php echo wp_get_attachment_url( get_option( ' image_attachment_id ' ) ); ?>' height='100'>
                </div>

                <div id="clockdiv">
                    <div>
                        <span class="days"></span>
                        <div class="smalltext">Dias</div>
                    </div>
                    <div>
                        <span class="hours"></span>
                        <div class="smalltext">Horas</div>
                    </div>
                    <div>
                        <span class="minutes"></span>
                        <div class="smalltext">Minutos</div>
                    </div>
                    <div>
                        <span class="seconds"></span>
                        <div class="smalltext">Segundos</div>
                    </div>
                </div>
            </div>
                <script>function getTimeRemaining(e){var n=Date.parse(e)-Date.parse(new Date),t=Math.floor(n/1e3%60),r=Math.floor(n/1e3/60%60),o=Math.floor(n/36e5%24);return{total:n,days:Math.floor(n/864e5),hours:o,minutes:r,seconds:t}}function initializeClock(e,n){var t=document.getElementById(e),r=t.querySelector(".days"),o=t.querySelector(".hours"),a=t.querySelector(".minutes"),i=t.querySelector(".seconds");function s(){var e=getTimeRemaining(n);r.innerHTML=e.days,o.innerHTML=("0"+e.hours).slice(-2),a.innerHTML=("0"+e.minutes).slice(-2),i.innerHTML=("0"+e.seconds).slice(-2),e.total<=0&&clearInterval(l)}s();var l=setInterval(s,1e3)}</script>
                initializeClock('clockdiv', new Date("<?php echo esc_attr( get_option('date_stop') ); ?>"));
            </script>
            <?php endif;?>

        </div>
    </div>
</section>

