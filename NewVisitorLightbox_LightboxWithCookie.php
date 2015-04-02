<?php function lightbox($id) { ?>
    <html>
      <head>
        <?php wp_enqueue_script('jquery'); ?>
        <script>
          var popupName = 'avaazVisitor';
          var daysToExpiry = 44734; //The number of days the longest-lived person ever, Jeanne Calment, lived.
        </script>
        <style type="text/css">
          /* ------------------- All Screensizes as Base CSS, from Large -> Mobile ------------------- */
          #lightbox-elements {
            display: none;
          }
          #back-overlay {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
            background: #000000;
            opacity: .7;
            filter:alpha(opacity=70);
            -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
            z-index: 50;
          }
          #close {
            margin-right: 6px;
            cursor: pointer;
            position: relative;
            font-weight: normal;
            font-size: 10px;
            text-transform: uppercase;
            margin: 5px;
            width: 98%;
            display: block;
            text-align: right;
            position: absolute;
            top: 0;
            right: 0;
          }
          #close span.x {
            display: block;
            float: right;
            font-size: 11px;
            background: #ffffff;
            border-radius: 5px;
            -moz-border-radius: 5px;
            -webkit-border-radius: 5px;
            padding: 1px 3px;
            font-weight: bold;
            font-size: 8px;
            margin-left: 3px;
          }
          #content-box {
            font-family: 'Europa', Helvetica, Arial, sans-serif;
            position: absolute;
            top: 15%;
            left: 20%;
            right: 20%;
            color: #343434;
            z-index: 51;
            -moz-box-shadow: 0px 0px 5px #444444;
            -webkit-box-shadow: 0px 0px 5px #444444;
            box-shadow: 0px 0px 5px #444444;
            background: #d7d7d7;
            padding: 30px 10px 10px 10px;
            min-height: 100px;
          }
          #content-box img {
            display: block;
            width: 100%;
          }
          #content-box form {
            background: #ffffff;
            width: 100%;
            text-align: center;
            font-size: 14px;
            padding: 9px 0px;
            margin: 0px;
          }
          #content-box label {
            font-weight: bold;
          }
          #content-box input[type="number"] {
            border: 1px solid #7d7d7d;
            color: #7d7d7d;
            padding: 8px;
            width: 70px;
            height: 30px;
            background: #ebebeb;
          }
          #content-box input[type="submit"] {
            margin-left: 5px;
            font-size: 16px;
            border: 1px solid #ffad41;
            padding: 5px 20px; 
            text-decoration: none; 
            display: inline-block;
            color: #ffffff;
            background-color: #ffc579; background-image: -webkit-gradient(linear, left top, left bottom, from(#ffc579), to(#fb9d23));
            background-image: -webkit-linear-gradient(top, #ffc579, #fb9d23);
            background-image: -moz-linear-gradient(top, #ffc579, #fb9d23);
            background-image: -ms-linear-gradient(top, #ffc579, #fb9d23);
            background-image: -o-linear-gradient(top, #ffc579, #fb9d23);
            background-image: linear-gradient(to bottom, #ffc579, #fb9d23);
            filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#ffc579, endColorstr=#fb9d23);
          }
          #content-box input[type="submit"]:hover {
            border: 1px solid #ff9913;
            background-color: #ffaf46; background-image: -webkit-gradient(linear, left top, left bottom, from(#ffaf46), to(#e78404));
            background-image: -webkit-linear-gradient(top, #ffaf46, #e78404);
            background-image: -moz-linear-gradient(top, #ffaf46, #e78404);
            background-image: -ms-linear-gradient(top, #ffaf46, #e78404);
            background-image: -o-linear-gradient(top, #ffaf46, #e78404);
            background-image: linear-gradient(to bottom, #ffaf46, #e78404);
            filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#ffaf46, endColorstr=#e78404);
          }

          /* --------------------- 600 X 800 Custom Breakpoint -------------------- */
          @media only screen and (max-width: 600px) {
            #content-box {
              left: 0.75em;
              right: 0.75em;
            }
            #content-box label {
              font-size: 1.25em;
            }
          }

          /* --------------- General Smartphones landscape  ----------- */
          @media only screen and (max-width: 768px) {
            #content-box {
              left: 5px;
              right: 5px;
            }
            #content-box form {
              font-size: 15px;
            }
          }

          /* ------------------- General Smartphones portrait -------------------- */
          @media only screen and (max-width: 321px) {
            #content-box label {
              font-size: 1.25em;
            }
            #content-box input[type="number"] {
              border: 2px solid #7d7d7d;
              width: 14em;
              height: 3.5em;
              text-align: center;
              }

            #content-box input[type="submit"] {
              margin: 0.5em;
              font-size: 1.5em;
              border: 2px solid #ffad41;
              padding: 0.15em 0.15em;
              text-align: center;
            }
        </style>
      </head>
      <body>
        <div id="lightbox-elements">
          <div id="back-overlay"></div>
          <div id="content-box">
            <div id="close">Close <span class="x">x</span></div>
            <?php echo get_page_content(); ?>
          </div>
        </div>

        <!-- <a href="javascript:eraseCookie(popupName);">Delete the cookie</div> -->

        <script>
          jQuery(document).ready(function(){
            if(!readCookie(popupName) && !<?php echo js_is_user_logged_in(); ?>) {     //if the 'popup' cookie does not exist and the user is not logged in, create a cookie and show the lightbox.
              createCookie(popupName, true, daysToExpiry);
              jQuery('#lightbox-elements').fadeIn("fast");
            }
          });
          jQuery('#back-overlay, #close').click(function() {  //Click the back-overlay (anywhere outside the form) div to hide the page content
            exitLightbox();
          });
          jQuery(document).on('keydown', function(e) {
            if(e.keyCode == 27) exitLightbox();
          });
          jQuery('#lightbox-elements form').submit(function() {
            createCookie(popupName, true, daysToExpiry);
          });
          jQuery('#lightbox-elements .set-cookie').click(function() {
            createCookie(popupName, true, daysToExpiry);
          });

          function exitLightbox() {
            jQuery('#lightbox-elements').fadeOut("fast");   // other options include .slideUp("fast");
          }

          function createCookie(name, value, days) {
            var expires;

            if (days) {
              var date = new Date();
              date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            } else {
              expires = "";
            }
            document.cookie = name + '=' + value +';path=/'+ ';expires=' + date.toUTCString();
          }

          function readCookie(name) {
            var nameEQ = escape(name) + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
              var c = ca[i];
              while (c.charAt(0) === ' ') c = c.substring(1, c.length);
              if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
            }
            return false;
          }

          function eraseCookie(name) {
            createCookie(name, "", -1);
          }
        </script>
      </body>
    </html>

<?php }

//This function checks the WordPress is_user_logged_in function and output true or false as is appropriate.
function js_is_user_logged_in() {
  if(is_user_logged_in()) return 'true';
  return 'false';
}

function get_page_content() {
  $page = get_post($_GET['id']);
  if(isset($page)) return $page->post_content;  
  return 'Hello and welcome to our site!';
}

