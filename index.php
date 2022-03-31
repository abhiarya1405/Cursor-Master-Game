<?php
    
    $hs_file = "highscore.txt";
    $file_open = fopen($hs_file, "r");
    $highscore = fread($file_open,1000);

    if(isset($_POST['score'])){
        $score = $_POST['score'];
        if($score > $highscore){
            $file_open = fopen($hs_file, "w+");
            fwrite($file_open, $score);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="favicon.png" type="image/png">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Cursor Master</title>
    <style>

    </style>
</head>
<body>
    <div class="display_error">
        <div class="display_error_msg">Display Size is short for game.<br>
            Please use bigger screens or zoom out page, then reload.
        </div>
    </div>
    <div class="first_window">
        <div class="first_window_content">
            <div class="game_name">Cursor Master</div>
            <div class="play_button" onclick="togleFullScreen()">PLAY</div><br>
            <div class="rules">
                How to Play :<br>
                Rapidly click on the circles.<br>
                Larger the circle becomes its point value drops.<br>
                1000 points will be deducted if failed to click on circles.
            </div>
        </div>
        <div class="highscore">Highscore: <?php echo $highscore; ?></div>
    </div>

    <div class="game_base">
        <div class="timer"></div>
        <div class="total_points"></div>
        <div class="ball_1"></div>
        <div class="ball_2"></div>
        <div class="ball_3"></div>
        <div class="ball_4"></div>
        <div class="ball_5"></div>
    </div>
    <div class="game_over_window">
        <div class="game_over">
            <div class="game_over_head">GAME OVER</div>
            <div class="your_score">Your Score: <b></b></div>
            <div class="play_again">PLAY AGAIN</div>
        </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

<script>
    var audio1 = new Audio("home_bg_music.mp3");
    window.onload = function() {
        audio1.play();
    };
    var audio2 = new Audio("bg_music.mp3");
    var audio3 = new Audio("gameover_music.wav");
    var audio4 = new Audio("click_circle.wav");
    var ball1Points = 2000;
    var ball2Points = 2000;
    var ball3Points = 2000;
    var ball4Points = 2000;
    var ball5Points = 2000;
    var timer = 30;
    var totalPoints = 0;
    
    var docHeight = $(document).height();
    var docWidth = $(document).width();
    if(docWidth < 1200 && docHeight < 600){
        $('.first_window').css("display", "none");
        $('.display_error').css("display", "block");
    }

    $('.play_button').click(function(){
        docHeight = $(document).height();
        docWidth = $(document).width();
        if(docWidth >= 1200 && docHeight >= 600){
            $('.first_window').css("display", "none");
            $('.timer').text("30");
            audio1.pause();
            audio2.play();
            $('.total_points').text(totalPoints);
            $('.ball_1').css("display", "block");
            $('.ball_2').css("display", "block");
            $('.ball_3').css("display", "block");
            $('.ball_4').css("display", "block");
            $('.ball_5').css("display", "block");
            $ball1 = $('.ball_1'),
            ball1Width = $ball1.width(),
            ball1Height = $ball1.height(),
            ball1HeightMax = docHeight - ball1Height - 100,
            ball1WidthMax = docWidth - ball1Width - 100;

            $ball2 = $('.ball_2'),
            ball2Width = $ball2.width(),
            ball2Height = $ball2.height(),
            ball2HeightMax = docHeight - ball2Height - 100,
            ball2WidthMax = docWidth - ball2Width - 100;

            $ball3 = $('.ball_3'),
            ball3Width = $ball3.width(),
            ball3Height = $ball3.height(),
            ball3HeightMax = docHeight - ball3Height - 100,
            ball3WidthMax = docWidth - ball3Width - 100;

            $ball4 = $('.ball_4'),
            ball4Width = $ball4.width(),
            ball4Height = $ball4.height(),
            ball4HeightMax = docHeight - ball4Height - 100,
            ball4WidthMax = docWidth - ball4Width - 100;

            $ball5 = $('.ball_5'),
            ball5Width = $ball5.width(),
            ball5Height = $ball5.height(),
            ball5HeightMax = docHeight - ball5Height - 100,
            ball5WidthMax = docWidth - ball5Width - 100;

            $ball1.css({
                left: Math.floor( Math.random() * ball1WidthMax ),
                top: Math.floor( Math.random() * ball1HeightMax )
            });
            $ball2.css({
                left: Math.floor( Math.random() * ball2WidthMax ),
                top: Math.floor( Math.random() * ball2HeightMax )
            });
            $ball3.css({
                left: Math.floor( Math.random() * ball3WidthMax ),
                top: Math.floor( Math.random() * ball3HeightMax )
            });
            $ball4.css({
                left: Math.floor( Math.random() * ball4WidthMax ),
                top: Math.floor( Math.random() * ball4HeightMax )
            });
            $ball5.css({
                left: Math.floor( Math.random() * ball5WidthMax ),
                top: Math.floor( Math.random() * ball5HeightMax )
            });

            pointsInterval_1 = setInterval(ball1_Points, 15);
            pointsInterval_2 = setInterval(ball2_Points, 15);
            pointsInterval_3 = setInterval(ball3_Points, 15);
            pointsInterval_4 = setInterval(ball4_Points, 15);
            pointsInterval_5 = setInterval(ball5_Points, 15);

            timer_func();

            setTimeout(function(){
                audio2.pause();
                audio3.play();
                $('.game_base').css("display", "none");
                $('.game_over_window').css("display", "block");
                $('.your_score').children().text(totalPoints);
                var score = totalPoints
                console.log(score)
                $.ajax({
                    type: "post",
                    url: "index.php",
                    data: {
                        score: score,
                    },
                    success: function (response) {} });

            },30000)
        }
        else{
            $('.first_window').css("display", "none");
            $('.display_error').css("display", "block");
        }
    })

    $(".game_base").click(function (e) {
    if (!event.target.matches(".ball_1, .ball_2, .ball_3, .ball_4, .ball_5")) {
        console.log("first")
      if(totalPoints > 1000){
          totalPoints = totalPoints - 1000;
          $('.total_points').text(totalPoints);
        }
      else{
          totalPoints = 0;
          $('.total_points').text(totalPoints);
      }
    }
    });

    $('.ball_1').click(function() {
        audio4.play();
        clearInterval(pointsInterval_1);
        $ball1 = $('.ball_1'),
        $ball1.css({"height" : "0", "width" : "0"});
        if (ball1Points > 100){
            totalPoints = totalPoints + ball1Points;
        }
        else{
            totalPoints = totalPoints + 100;
        }
        $('.total_points').text(totalPoints);
        ball1Points = 2000;
        var docHeight = $(document).height(),
        docWidth = $(document).width(),
        ball1Width = $ball1.width(),
        ball1Height = $ball1.height(),
        ball1HeightMax = docHeight - ball1Height - 100,
        ball1WidthMax = docWidth - ball1Width - 100;

        $ball1.css({
            left: Math.floor( Math.random() * ball1WidthMax ),
            top: Math.floor( Math.random() * ball1HeightMax )
        });

        pointsInterval_1 = setInterval(ball1_Points, 15);

    });

    $('.ball_2').click(function() {
        audio4.play();
        clearInterval(pointsInterval_2);
        $ball2 = $('.ball_2'),
        $ball2.css({"height" : "0", "width" : "0"});
        if (ball2Points > 100){
            totalPoints = totalPoints + ball2Points;
        }
        else{
            totalPoints = totalPoints + 100;
        }
        $('.total_points').text(totalPoints);
        ball2Points = 2000;
        var docHeight = $(document).height(),
        docWidth = $(document).width(),
        $ball2 = $('.ball_2'),
        ball2Width = $ball2.width(),
        ball2Height = $ball2.height(),
        ball2HeightMax = docHeight - ball2Height - 100,
        ball2WidthMax = docWidth - ball2Width - 100;

        $ball2.css({
            left: Math.floor( Math.random() * ball2WidthMax ),
            top: Math.floor( Math.random() * ball2HeightMax )
        });
        pointsInterval_2 = setInterval(ball2_Points, 15);
    });

    $('.ball_3').click(function() {
        audio4.play();
        clearInterval(pointsInterval_3);
        $ball3 = $('.ball_3'),
        $ball3.css({"height" : "0", "width" : "0"});
        if (ball3Points > 100){
            totalPoints = totalPoints + ball3Points;
        }
        else{
            totalPoints = totalPoints + 100;
        }
        $('.total_points').text(totalPoints);
        ball3Points = 2000;
        var docHeight = $(document).height(),
        docWidth = $(document).width(),
        $ball3 = $('.ball_3'),
        ball3Width = $ball3.width(),
        ball3Height = $ball3.height(),
        ball3HeightMax = docHeight - ball3Height - 100,
        ball3WidthMax = docWidth - ball3Width - 100;

        $ball3.css({
            left: Math.floor( Math.random() * ball3WidthMax ),
            top: Math.floor( Math.random() * ball3HeightMax )
        });
        pointsInterval_3 = setInterval(ball3_Points, 15);
    });

    $('.ball_4').click(function() {
        audio4.play();
        clearInterval(pointsInterval_4);
        $ball4 = $('.ball_4'),
        $ball4.css({"height" : "0", "width" : "0"});
        if (ball4Points > 100){
            totalPoints = totalPoints + ball4Points;
        }
        else{
            totalPoints = totalPoints + 100;
        }
        $('.total_points').text(totalPoints);
        ball4Points = 2000;
        var docHeight = $(document).height(),
        docWidth = $(document).width(),
        $ball4 = $('.ball_4'),
        ball4Width = $ball4.width(),
        ball4Height = $ball4.height(),
        ball4HeightMax = docHeight - ball4Height - 100,
        ball4WidthMax = docWidth - ball4Width - 100;

        $ball4.css({
            left: Math.floor( Math.random() * ball4WidthMax ),
            top: Math.floor( Math.random() * ball4HeightMax )
        });
        pointsInterval_4 = setInterval(ball4_Points, 15);
    });

    $('.ball_5').click(function() {
        audio4.play();
        clearInterval(pointsInterval_5);
        $ball5 = $('.ball_5'),
        $ball5.css({"height" : "0", "width" : "0"});
        if (ball5Points > 100){
            totalPoints = totalPoints + ball5Points;
        }
        else{
            totalPoints = totalPoints + 100;
        }
        $('.total_points').text(totalPoints);
        ball5Points = 2000;
        var docHeight = $(document).height(),
        docWidth = $(document).width(),
        $ball5 = $('.ball_5'),
        ball5Width = $ball5.width(),
        ball5Height = $ball5.height(),
        ball5HeightMax = docHeight - ball5Height - 100,
        ball5WidthMax = docWidth - ball5Width - 100;

        $ball5.css({
            left: Math.floor( Math.random() * ball5WidthMax ),
            top: Math.floor( Math.random() * ball5HeightMax )
        });
        pointsInterval_5 = setInterval(ball5_Points, 15);
    });

    function ball1_Points(){
        $('.ball_1').height("+=0.5")
        $('.ball_1').width("+=0.5")
        ball1Points = ball1Points - 2;
    }
    function ball2_Points(){
        $('.ball_2').height("+=0.5")
        $('.ball_2').width("+=0.5")
        ball2Points = ball2Points - 2;
    }
    function ball3_Points(){
        $('.ball_3').height("+=0.5")
        $('.ball_3').width("+=0.5")
        ball3Points = ball3Points - 2;
    }
    function ball4_Points(){
        $('.ball_4').height("+=0.5")
        $('.ball_4').width("+=0.5")
        ball4Points = ball4Points - 2;
    }
    function ball5_Points(){
        $('.ball_5').height("+=0.5")
        $('.ball_5').width("+=0.5")
        ball5Points = ball5Points - 2;
    }
    
    function timer_func(){
        setInterval(function(){
            timer = timer - 1;
            if(timer < 11){
                $('.timer').css("color", "red");
            }
            $('.timer').text(timer);
        },1000)
    }

    $('.play_again').click(function() { 
        location.reload();
    });
</script>

<script>
    function toggleFullScreen() {
  if (!document.fullscreenElement &&    // alternative standard method
      !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
    if (document.documentElement.requestFullscreen) {
      document.documentElement.requestFullscreen();
    } else if (document.documentElement.msRequestFullscreen) {
      document.documentElement.msRequestFullscreen();
    } else if (document.documentElement.mozRequestFullScreen) {
      document.documentElement.mozRequestFullScreen();
    } else if (document.documentElement.webkitRequestFullscreen) {
      document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
    }
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    } else if (document.msExitFullscreen) {
      document.msExitFullscreen();
    } else if (document.mozCancelFullScreen) {
      document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) {
      document.webkitExitFullscreen();
    }
  }
}
</script>

</html>