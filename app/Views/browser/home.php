<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        echo '<pre>';
        echo isset($_SESSION['message']) ? $_SESSION['message'] : '';
        echo $this->data['grid'];
        echo '</pre>';
        ?>
        <form name="input" action="hit" method="POST">
            Enter coordinates (row, col), e.g. A5 <input type="input" size="5" name="coord" autocomplete="off" autofocus="">
            <input type="submit" name="submit">
        </form>
    </body>
</html>