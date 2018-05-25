<?php

class AllTagsPlugin extends Gdn_Plugin {
    public function vanillaController_allTags_create($sender, $args) {
        $sender->masterView();
        // $sender->SelfUrl = self::SHORT_ROUTE;
        foreach (c('Modules.Vanilla.Panel') as $module) {
            if ($module != 'MeModule') {
                $sender->addModule($module);
            }
        }

        $sender->title(t('All Tags'));

        // This sets the breadcrumb to our current page.
        $sender->setData(
            'Breadcrumbs',
            [['Name' => t('All Tags'), 'Url' => 'vanilla/alltags']]
        );

        $sender->render('alltags', '', 'plugins/alltags');
    }
}
