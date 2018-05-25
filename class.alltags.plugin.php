<?php

class AllTagsPlugin extends Gdn_Plugin {
    public function vanillaController_allTags_create($sender, $args) {
saveToCOnfig('alltags.SortOrder', 'Count');
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
}
