<?php

class AllTagsPlugin extends Gdn_Plugin {
    public function vanillaController_allTags_create($sender, $args) {
saveToCOnfig('alltags.SortOrder', 'Name');
        // Prepare Vanilla page.
        $sender->masterView();
        foreach (c('Modules.Vanilla.Panel') as $module) {
            if ($module != 'MeModule') {
                $sender->addModule($module);
            }
        }
        $sender->title(t('All Tags'));
        $sender->setData(
            'Breadcrumbs',
            [['Name' => t('All Tags'), 'Url' => 'vanilla/alltags']]
        );

        if (c('alltags.SortOrder', 'Name') == 'Name') {
            $orderBy = 'FullName';
            $orderDirection = 'asc';
        } else {
            $orderBy = 'CountDiscussions';
            $orderDirection = 'desc';
        }
        $tags = TagModel::instance()->get($orderBy, $orderDirection)->resultArray();

        $sender->setData([
            'OrderBy' => $orderBy,
            'Tags' => $tags
        ]);

        $sender->render('alltags', '', 'plugins/alltags');
    }

    public function base_afterDiscussionFilters_handler($sender) {
        if ($sender->SelfUrl == 'vanilla/alltags') {
            $css = ' class="Active"';
        } else {
            $css = '';
        }
        echo "<li{$css}>".anchor(sprite('SpAllTags').' '.t('All Tags'), '/vanilla/alltags').'</li>';
    }
}
