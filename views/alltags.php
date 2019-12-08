<?php defined('APPLICATION') or die;
$format = Gdn::translate(
    'Alltags.Format',
    '%1$s<span class="Aside"><span class="Count">%2$d</span></span>'
);
?>
<style>
  .AllTagsList {width: 200px}
</style>
<h1><?= $this->title() ?></h1>
<h2 class="sr-only"><?= Gdn::translate('Tag List') ?></h2>
<div class="PanelColumn">
    <ul class="AllTagsList PanelInfo">
    <?php foreach ($this->data('Tags') as $tag): ?>
        <li>
        <?= anchor(
            sprintf(
                $format,
                Gdn::formatService()->renderPlainText($tag['FullName'], 'Html'),
                $tag['CountDiscussions']
            ),
            '/discussions/tagged/'.Gdn::formatService()->renderPlainText($tag['Name'], 'Html')
        ) ?>
        </li>
    <?php endforeach ?>
    </ul>
</div>