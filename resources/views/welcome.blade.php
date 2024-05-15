<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">
</head>
<body>
<div class="row">
    <div class="span6">
        <input type="text" class="emojionearea1">
        <textarea name="emojionearea1" class="emojionearea1" id="emojionearea1" cols="30" rows="10"></textarea>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://rawgit.com/mervick/emojionearea/master/dist/emojionearea.js"></script>
<script>
    $(document).ready(function () {
        $(".emojionearea1").emojioneArea({
            pickerPosition: "bottom",
            tonesStyle: "bullet",
        });
    });
</script>
</body>
</html>
