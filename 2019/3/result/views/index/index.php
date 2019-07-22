<?php
use app\models\Link;

/**
 * @var string|null $link
 */
?>

<form action="/" method="POST">
    <div class="row">
        <div class="col col-md-9">
            <input type="url"
                   class="form-control"
                   placeholder="https://example.com"
                   required
                   name="link"
                   max="<?= Link::LINK_LENGTH ?>"
            >
        </div>
        <div class="col col-md-3">
            <button class="btn btn-primary" type="submit">
                Создать
            </button>
        </div>
    </div>
</form>

<?php if (!empty($link)): ?>
<p class="text-center">
    <?= $link ?>
</p>
<?php endif; ?>

