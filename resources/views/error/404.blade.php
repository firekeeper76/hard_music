<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>404</title>
    <!-- Bootstrap core CSS -->
    <link href="/plugins/bootstrap3/css/bootstrap.css" rel="stylesheet">

    <!-- FONT AWESOME CSS -->
    <link href="/plugins/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" />
    <!--GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Nova+Flat' rel='stylesheet' type='text/css'>
    <!-- custom CSS here -->
    <style>
        body {
            font-family: 'Nova Flat', cursive;
            background-color: rgba(194,12,12,0.2);
            color: #fff;
            min-height:750px;
        }
        .pad-top {
            padding-top:60px;
        }
        .text-center {
            text-align:center;
        }
        #error-link {
            font-size:150px;
            padding:10px;
        }

    </style>
</head>
<body>


<div class="container">

    <div class="row pad-top text-center">
        <div class="col-md-6 col-md-offset-3 text-center">
            <h1>  ! 您要找的页面不存在!</h1>
            <h5> Cloud Music 404</h5>
            <span id="error-link"></span>
            <h2></h2>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-md-8 col-md-offset-2">

            <h3> <i  class="fa fa-lightbulb-o fa-5x"></i> </h3>
            <a href="/main" class="btn btn-danger">回到首页</a>

        </div>
    </div>

</div>


</div>
    <!-- /.container -->
  
  
    <!--Core JavaScript file  -->
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/basic.js"></script>
    <!--bootstrap JavaScript file  -->
    <script src="/plugins/bootstrap3/js/bootstrap.js"></script>

     <!--Count Number JavaScript file  -->
    {{--<script src="/js/countUp.js"></script>--}}
<script>
    (function ($) {
        "use strict";
        var mainApp = {

            main_fun: function () {

                var count = new countUp("error-link", 10, 404, 0, 5); //CHANGE 404 TO THE ERROR VALUE AS YOU WANT

                window.onload = function () {
                    count.start();
                }

                /*====================================
                WRITE YOUR SCRIPTS HERE
                ======================================*/
            },

            initialization: function () {
                mainApp.main_fun();

            }

        }
        // Initializing ///

        $(document).ready(function () {
            mainApp.main_fun();
        });

    }(jQuery));
</script>
<script>
    function countUp(target, startVal, endVal, decimals, duration, options) {

        // default options
        this.options = options || {
            useEasing : true, // toggle easing
            useGrouping : true, // 1,000,000 vs 1000000
            separator : ',', // character to use as a separator
            decimal : '.' // character to use as a decimal
        }

        // make sure requestAnimationFrame and cancelAnimationFrame are defined
        // polyfill for browsers without native support
        // by Opera engineer Erik Möller
        var lastTime = 0;
        var vendors = ['webkit', 'moz', 'ms'];
        for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
            window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
            window.cancelAnimationFrame =
                window[vendors[x]+'CancelAnimationFrame'] || window[vendors[x]+'CancelRequestAnimationFrame'];
        }
        if (!window.requestAnimationFrame) {
            window.requestAnimationFrame = function(callback, element) {
                var currTime = new Date().getTime();
                var timeToCall = Math.max(0, 16 - (currTime - lastTime));
                var id = window.setTimeout(function() { callback(currTime + timeToCall); },
                    timeToCall);
                lastTime = currTime + timeToCall;
                return id;
            }
        }
        if (!window.cancelAnimationFrame) {
            window.cancelAnimationFrame = function(id) {
                clearTimeout(id);
            }
        }

        var self = this;

        this.d = (typeof target === 'string') ? document.getElementById(target) : target;
        this.startVal = Number(startVal);
        this.endVal = Number(endVal);
        this.countDown = (this.startVal > this.endVal) ? true : false;
        this.startTime = null;
        this.timestamp = null;
        this.remaining = null;
        this.frameVal = this.startVal;
        this.rAF = null;
        this.decimals = Math.max(0, decimals || 0);
        this.dec = Math.pow(10, this.decimals);
        this.duration = duration * 1000 || 2000;

        // Robert Penner's easeOutExpo
        this.easeOutExpo = function(t, b, c, d) {
            return c * (-Math.pow(2, -10 * t / d) + 1) * 1024 / 1023 + b;
        }
        this.count = function(timestamp) {

            if (self.startTime === null) self.startTime = timestamp;

            self.timestamp = timestamp;

            var progress = timestamp - self.startTime;
            self.remaining = self.duration - progress;

            // to ease or not to ease
            if (self.options.useEasing) {
                if (self.countDown) {
                    var i = self.easeOutExpo(progress, 0, self.startVal - self.endVal, self.duration);
                    self.frameVal = self.startVal - i;
                } else {
                    self.frameVal = self.easeOutExpo(progress, self.startVal, self.endVal - self.startVal, self.duration);
                }
            } else {
                if (self.countDown) {
                    var i = (self.startVal - self.endVal) * (progress / self.duration);
                    self.frameVal = self.startVal - i;
                } else {
                    self.frameVal = self.startVal + (self.endVal - self.startVal) * (progress / self.duration);
                }
            }

            // decimal
            self.frameVal = Math.round(self.frameVal*self.dec)/self.dec;

            // don't go past endVal since progress can exceed duration in the last frame
            if (self.countDown) {
                self.frameVal = (self.frameVal < self.endVal) ? self.endVal : self.frameVal;
            } else {
                self.frameVal = (self.frameVal > self.endVal) ? self.endVal : self.frameVal;
            }

            // format and print value
            self.d.innerHTML = self.formatNumber(self.frameVal.toFixed(self.decimals));

            // whether to continue
            if (progress < self.duration) {
                self.rAF = requestAnimationFrame(self.count);
            } else {
                if (self.callback != null) self.callback();
            }
        }
        this.start = function(callback) {
            self.callback = callback;
            // make sure values are valid
            if (!isNaN(self.endVal) && !isNaN(self.startVal)) {
                self.rAF = requestAnimationFrame(self.count);
            } else {
                console.log('countUp error: startVal or endVal is not a number');
                self.d.innerHTML = '--';
            }
            return false;
        }
        this.stop = function() {
            cancelAnimationFrame(self.rAF);
        }
        this.reset = function() {
            self.startTime = null;
            cancelAnimationFrame(self.rAF);
            self.d.innerHTML = self.formatNumber(self.startVal.toFixed(self.decimals));
        }
        this.resume = function() {
            self.startTime = null;
            self.duration = self.remaining;
            self.startVal = self.frameVal;
            requestAnimationFrame(self.count);
        }
        this.formatNumber = function(nStr) {
            nStr += '';
            var x, x1, x2, rgx;
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? self.options.decimal + x[1] : '';
            rgx = /(\d+)(\d{3})/;
            if (self.options.useGrouping) {
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + self.options.separator + '$2');
                }
            }
            return x1 + x2;
        }

        // format startVal on initialization
        self.d.innerHTML = self.formatNumber(self.startVal.toFixed(self.decimals));
    }
</script>
</body>
</html>
