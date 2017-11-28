<?php
function _e(&$string)
{
    if (!empty($string)) {
        echo \htmlspecialchars($string, ENT_HTML5);
    }
}

function _b(&$reference)
{
    return isset($reference);
}

function _input($label, $name, &$value, $type, &$error) {
    $hasError = _b($error) ? $error : false;

    ?>
    <div class="form-group">
        <label for="<?php echo $name ?>"><?php echo $label ?></label>
        <input class="form-control" id="<?php echo $name ?>" type="<?php echo $type ?>" name="<?php echo $name ?>" value="<?php _e($value) ?>">
        <?php if ($hasError !== false): ?>
            <div class="invalid-feedback"><?php echo $error ?></div>
        <?php endif; ?>
    </div>
    <?php
}