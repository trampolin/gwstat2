<div class="wrapper wrapper-content">
    <form method="post" action="<?= base_url() ?>highscore/parseHtml">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Highscore parsen
            </div>

            <div class="panel-body">

                <label for="parse-html">Hier HTML Code eingeben</label>
                <textarea name="html" id="parse-html" class="parse-text-html"></textarea>

            </div>

        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <button class="btn btn-success">Submit</button>
            </div>
        </div>

    </form>

<?php if(isset($parsedHighscore)) : ?>

    <div class="panel panel-info">
        <div class="panel-heading">
            Ergebnis
        </div>

        <div class="panel-body">
            <span><?= count($parsedHighscore) ?> Einträge geparst</span>
            <br></br>
            <span><?php var_dump($highscoreProcessResult)  ?></span>

            <?php //var_dump($parsedHighscore) ?>
        </div>
    </div>
<?php endif ?>
</div>