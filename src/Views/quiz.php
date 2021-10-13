<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <title>Quiz</title>

</head>
<body>
<div class="container">
    <div class="row justify-content-center" style="height: 600px; margin-top: 100px">
        <div class="col-6">
            <h2 style="text-align: center"><?php echo $question['text'] ?></h2>
            <form method="POST" action="/answer">
                <div class="row justify-content-center mt-4">
                    <?php foreach ($answers as $answer) {
                        echo '<div class="col-6 p-2 border border-5 answer" 
                          style="background-color: whitesmoke; text-align: center;"
                          onclick="answer(' . $answer['answer_id'] . ')"' . 'id=answer[' . $answer['answer_id'] . ']>';
                        echo "<p>" . $answer['text'] . "</p>";
                        echo "</div>";
                    }
                    echo '<input hidden value="0" id="uInput"  name="uInput">';
                    echo '<input hidden value="' . $question['id'] . '" name="question_id">';
                    echo '<input hidden value="' . $userId . '" name="user_id">';
                    ?>
                    <div class="progress m-3">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                             style="width: <?php echo $progressBar ?>%"
                             aria-valuenow="<?php echo $progressBar ?>"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <button type="submit" class="btn btn-success m-3 col-6" disabled id="submit-button">Atbildēt</button>


                </div>
            </form>


        </div>

    </div>
</div>

<script type="text/javascript" src="/public/script.js"></script>

</body>

</html>