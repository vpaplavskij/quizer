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
            <h2 style="text-align: center">Paldies, <?php echo ucfirst($username) ?>!</h2>
            <img src="https://www.seekpng.com/png/detail/327-3279196_finger-up-emoji-clipart-gold-thumbs-up-emoji.png"
                 class="rounded mx-auto d-block" alt="..." style="width: 220px; height: 160px">
            <h3 style="text-align: center" class="mt-3">
                <?php
                echo "Tu atbildēji pareizi uz <span class='badge rounded-pill bg-info text-dark'>" . $correctAns .
                    "</span> no <span class='badge rounded-pill bg-info text-dark'>". $totalAns . "</span> jautājumiem."
                ?>
            </h3>
        </div>
    </div>
</div>

</body>

</html>