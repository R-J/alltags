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
        <?php
        echo anchor(
            sprintf(
                $format,
                Gdn_Format::plainText($tag['FullName']),
                $tag['CountDiscussions']
            ),
            '/discussions/tagged/'.Gdn_Format::plainText($tag['Name'])
        );
        ?>
        </li>
    <?php endforeach ?>
    </ul>
</div>