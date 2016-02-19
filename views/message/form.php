<?php
$postdata = [];
if (isset($_SESSION['postdata'])) {
    $postdata = $_SESSION['postdata'];
    $_SESSION['postdata'] = [];
}
$errors = [];
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = [];
}
if (DEBUG) {

    echo('<pre>$errors ');
    print_r($errors);
    echo("</pre>");

    echo('<pre>$postdata ');
    print_r($postdata);
    echo("</pre>");

}

?>

<h1>formulaire de la win</h1>


<form method="post" action="message.php?action=save" enctype="multipart/form-data" id="message_form"
      class="form-horizontal">
    <div class="form-group has-feedback">
        <label for="id" class="col-xs-2 control-label">id</label>

        <div class="col-xs-6">
            <input type="text" id="id" name="id" class="form-control" readonly placeholder=""
                   value="<?php echo !empty($postdata['id']) ? ($postdata['id']) : '' ?>">
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="name" class="col-xs-2 control-label">name</label>

        <div class="col-xs-6">
            <input type="text" id="name" name="name" class="form-control" placeholder="i.e : Bob"
                   value="<?php echo !empty($postdata['name']) ? ($postdata['name']) : '' ?>">
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="email" class="col-xs-2 control-label">email</label>

        <div class="col-xs-6">
            <input type="text" autocomplete="0" id="email" name="email" class="form-control"
                   placeholder="i.e : toto@toto.com"
                   value="<?= !empty($postdata['email']) ? ($postdata['email']) : '' ?>">
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="message" class="col-xs-2 control-label">message</label>

        <div class="col-xs-6">
            <textarea id="message"
                      name="message"
                      class="form-control"
                      placeholder="un petit message ?"><?= !empty($postdata['message']) ? ($postdata['message']) : '' ?></textarea>
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="image" class="col-xs-2 control-label">image</label>

        <div class="col-xs-6">
            <input type="file" id="image" name="image" class="form-control"
                   placeholder="clic ici batard">
<?php
            if (!empty($postdata['thumb'])) {
?>
                <img src="<?php echo IMG_THUMBS_URI . $postdata['thumb'] ?>">
                <input type="hidden" name="hires" id="hires" value="<?php echo $postdata['hires'] ?>">
                <input type="hidden" name="thumb" id="thumb" value="<?php echo $postdata['thumb'] ?>">
<?php
            }
?>
        </div>
    </div>

    <input type="submit" id="ajax_form_check" class="btn btn-primary" value="click click">

</form>
<script>
    var phpErrors = <?php echo (count($errors)?json_encode($errors, JSON_FORCE_OBJECT):'{}') ?>;
</script>
<script>

    $(function () {

        // errors display function
        function showErrors(errors, inputName, showAsPopover) {
            var targetElt = $('#' + inputName);
            targetElt.closest('.form-group').find('[class*="text-"], .form-control-feedback').remove();
            if (!!errors[inputName]) {
                targetElt.closest('.form-group')
                    .removeClass('has-success')
                    .addClass('has-error');

                if (showAsPopover) {
                    targetElt
                        .after($('<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only">(success)</span>'))
                    if (targetElt.data('bs.popover')) {
                        targetElt.data('bs.popover').options.content = errors[inputName]

                    } else {
                        targetElt.popover({
                            content: errors[inputName]
                        })
                    }
                    targetElt.popover('show');
                } else {
                    targetElt
                        .after($('<p class="text-danger">' + errors[inputName] + '</p>'))
                        .after($('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only">(success)</span>'))
                        .popover('destroy');
                }
            } else {
                targetElt.closest('.form-group')
                    .removeClass('has-error')
                    .addClass('has-success')

                targetElt.after($('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only">(success)</span>'))
                    .popover('destroy');
            }
        }

        // on focus
        // do nothing, cleanup awaiting user input

        $('#message_form input, #message_form textarea').on('focus', function (e) {
            e.preventDefault() && e.stopPropagation();
            console.log('focus', this);
            var that = this;
            var targetElt = $(that);
            targetElt.closest('.form-group')
                .removeClass('has-error')
                .find('[class*="text-"], .form-control-feedback')
                .remove();
        });

        // on keyup
        // check if input is Ok via ajax, if not, display a warning in popover

        $('#message_form input, #message_form textarea').on('keyup', function (e) {
            e.preventDefault() && e.stopPropagation();
            console.log('keyup', this);
            var that = this;
            $.post(
                'message.php?action=check',
                $(that).serialize(),
                function (data) {
                    var inputName = $(that).attr('name');
                    var errors = data['errors'];
                    showErrors(errors, inputName, 1);
                }
            );
        });

        // on blur
        // check if input is Ok via ajax, if not, display a warning under field
        // remove previous popovers

        $('#message_form input, #message_form textarea').on('blur', function (e) {
            e.preventDefault() && e.stopPropagation();
            console.log('blur', this);
            var that = this;
            $.post(
                'message.php?action=check',
                $(that).serialize(),
                function (data) {
                    var inputName = $(that).attr('name');
                    var errors = data['errors'];
                    showErrors(errors, inputName, 0);
                }
            );
        });

        // display errors if errors retrieved from PHP form submit
        $('#message_form input, #message_form textarea').each(function () {
            var that = this;
            var inputName = $(that).attr('name');
            var errors = phpErrors;
            if(errors[inputName]) {
                showErrors(errors, inputName, 0);
            }
        });

    });

</script>
