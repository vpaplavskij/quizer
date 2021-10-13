<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <title>Quiz app</title>
</head>
<body>
<div class="container">
    <div class="row justify-content-center align-content-end" style="height: 600px">
        <div class="col-4">
            <form method="post" action="/quiz">
                <h2 style="text-align: center">Pārbaudi sevi!</h2>
                <div class="mb-3">
                    <label for="name" class="form-label">Jūsu vārds:</label>
                    <input type="text" class="form-control" id="name" name="name">
                    <?php
                    if ($errors['name']) {
                        echo "<span style='color: red; margin: 5px' class='text-end'>" . $errors['name'] . "</span>";
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="quiz" class="form-label">Tests:</label>
                    <select class="form-select" id="quiz" name="quiz">
                        <option selected disabled hidden>Izvēlies testu:</option>
                        <?php
                        foreach ($tests as $test) {
                            echo "<option value='" . $test['id'] . "'>" . $test['name'] . "</option>";
                        }
                        ?>
                    </select>
                    <?php
                    if ($errors['quiz']) {
                        echo "<span style='color: red; margin: 5px' class='text-end'>" . $errors['quiz'] . "</span>";
                    }
                    ?>
                </div>
                <button type="submit" class="btn btn-primary">Iesniegt</button>
            </form>
        </div>
    </div>

</body>
</html>