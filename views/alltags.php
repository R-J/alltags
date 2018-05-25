<?php defined('APPLICATION') or die;
$format = t(
    'Alltags.Format',
    '%1$s<span class="Aside"><span class="Count">%2$d</span></span>'
);
?>
<ul class="PanelInfo">
<?php foreach ($this->data('Tags') as $tag): ?>
    <li class="Item"><?php echo anchor(
        sprintf(
            $format,
            Gdn_Format::plainText($tag['FullName']),
            $tag['CountDiscussions']
        ),
        url('discussions/tagged/'.Gdn_Format::plainText($tag['Name']))
    ) ?></li>
<?php endforeach ?>
</ul>